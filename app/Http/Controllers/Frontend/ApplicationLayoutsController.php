<?php

namespace App\Http\Controllers\Frontend;


use Anouar\Paypalpayment\Facades\PaypalPayment;
use App\ApplicationLayout;
use App\Discount;
use App\Events\MakeLayoutPurchase;
use App\Http\Requests;
use App\Invoice;
use App\LayoutPurchase;
use App\Memberdiscount;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use PayPal\Api\PaymentExecution;
use PayPal\Exception\PayPalConnectionException;

class ApplicationLayoutsController extends Controller
{
    protected $layouts;
    private $_apiContext;

    public function __construct(ApplicationLayout $layouts)
    {
        $this->layouts = $layouts;

        $this->_apiContext = PaypalPayment::apiContext(config('paypal_payment.Account.ClientId'), config('paypal_payment.Account.ClientSecret'));
    }

    public function index()
    {
        $applicationlayouts = ApplicationLayout::all();

        foreach ($applicationlayouts as $layout) {
            $purchases[$layout->id] = count(LayoutPurchase::where('applicationlayout_id','=',$layout->id)->get());
        }

        return view('frontend.applicationlayouts', compact('applicationlayouts', 'purchases'));
    }

    public function purchase(Requests\Frontend\PurchaseApplicationLayout $request, $layout_id)
    {
        $member = Auth::guard('member')->user();

        $applicationlayout = ApplicationLayout::findOrFail($layout_id);

        $discount = Discount::where('code', '=', $request->code)->where('expired', '=', false)->first();

        $price_incl_discount = $applicationlayout->price;

        if ($discount) {
            $price_incl_discount = $this->useDiscount($discount, $applicationlayout);
        }

        $purchases = LayoutPurchase::all();

        foreach ($purchases as $purchase) {
            if ($purchase->member_id == $member->id && $purchase->applicationlayout_id == $layout_id) {
                return redirect(route('frontend.applicationlayouts.index'))->withErrors([
                    'error' => 'You have already purchased this Application Layout.'
                ]);
            }
        }

        $purchase = LayoutPurchase::create(array(
            'member_id' => $member->id,
            'applicationlayout_id' => $layout_id,
            'price_incl_discount' => $price_incl_discount,
            'paid' => false
        ));

        $invoice = Invoice::create(array(
            'member_id' => $member->id,
            'individualcoaching_id' => null,
            'booking_id' => null,
            'packagepurchase_id' => null,
            'layoutpurchase_id' => $purchase->id,
            'totalprice' => $price_incl_discount,
            'date' => Carbon::now(),
        ));

        event(new MakeLayoutPurchase($purchase, $invoice));

        if ($price_incl_discount == 0) {
            return redirect(route('frontend.applicationlayouts.index'))->with('status', 'Your Purchase was successfully.');
        }
        if ($request->type == 'paypal') {
            $approvalLink = $this->payment($purchase, $invoice);
            return redirect($approvalLink);
        } elseif ($request->type == 'transfer') {
            return redirect(route('frontend.bank.index', ['layout', $purchase]));
        }
    }

    public function useDiscount($discount, $applicationlayout)
    {
        $used = Memberdiscount::where('discount_id', '=', $discount->id)->where('member_id', '=', Auth::guard('member')->id())->first();

        if (!$used) {

            Memberdiscount::create(array(
                'member_id' => Auth::guard('member')->id(),
                'discount_id' => $discount->id
            ));

            if ($discount->service == 'Application Layout' || $discount->service == 'Universal') {

                if ($discount->percentage) {
                    return $applicationlayout->price * $discount->amount / 100;
                } else {
                    if ($applicationlayout->price - $discount->amount < 0) {
                        return 0;
                    } else {
                        return $applicationlayout->price - $discount->amount;
                    }
                }
            }
        } else {
            return $applicationlayout->price;
        }
    }

    public function payment($purchase, $invoice)
    {
        $payer = Paypalpayment::payer();
        $payer->setPaymentMethod("paypal");

        $item = Paypalpayment::item();
        $item->setName($purchase->applicationlayout->title)
            ->setDescription('Application Layout')
            ->setCurrency('EUR')
            ->setQuantity(1)
            ->setPrice($purchase->price_incl_discount);

        $itemList = Paypalpayment::itemList();
        $itemList->setItems(array($item));

        $amount = Paypalpayment::amount();
        $amount->setCurrency("EUR")
            ->setTotal($purchase->price_incl_discount);

        $transaction = Paypalpayment::transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Application Layout Payment")
            ->setInvoiceNumber(uniqid()); //USE THE INVOICE ID IN LIVE

        $redirectUrls = Paypalpayment::redirectUrls();
        $redirectUrls->setReturnUrl(route('frontend.applicationlayouts.execute', $purchase->applicationlayout->id))
            ->setCancelUrl(route('frontend.applicationlayouts.execute', $purchase->applicationlayout->id));

        $payment = Paypalpayment::payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));

        try {
            $payment->create($this->_apiContext);
        } catch (PayPalConnectionException $ex) {
            return redirect(route('frontend.applicationlayouts.index'))->withErrors(['error' => 'Connection Error!']);
        }

        Session::put('paypal_payment_id', $payment->getId());

        $approvalUrl = $payment->getApprovalLink();

        return $approvalUrl;
    }

    public function executePayment($applicationlayout_id)
    {
        $payment_id = Session::get('paypal_payment_id');

        Session::forget('paypal_payment_id');

        $payment = PaypalPayment::getById($payment_id, $this->_apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));

        $result = $payment->execute($execution, $this->_apiContext);

        if ($result->getState() == 'approved') {
            $purchase = LayoutPurchase::where('member_id', '=', Auth::guard('member')->id())->where('applicationlayout_id', '=', $applicationlayout_id)->first();

            $purchase->fill(array(
                'paid' => true
            ))->save();

            return redirect(route('frontend.applicationlayouts.index'))->with('status', 'Successfully paid.');
        }
        return redirect(route('frontend.applicationlayouts.index'))->withErrors(['error' => 'Payment Failed.']);
    }
}
