<?php

namespace App\Http\Controllers\Frontend;

use Anouar\Paypalpayment\Facades\PaypalPayment;
use App\ApplicationPackage;
use App\Discount;
use App\Events\MakePackagePurchase;
use App\Http\Requests;
use App\Invoice;
use App\Memberdiscount;
use App\PackagePurchase;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use PayPal\Api\PaymentExecution;
use PayPal\Exception\PayPalConnectionException;

class ApplicationPackagesController extends Controller
{
    protected $packages;
    private $_apiContext;

    public function __construct(ApplicationPackage $packages)
    {
        $this->packages = $packages;

        $this->_apiContext = PaypalPayment::apiContext(config('paypal_payment.Account.ClientId'), config('paypal_payment.Account.ClientSecret'));
    }

    public function index()
    {
        $applicationpackages = ApplicationPackage::all();

        foreach ($applicationpackages as $package) {
            $purchases[$package->id] = count(PackagePurchase::where('applicationpackage_id','=',$package->id)->get());
        }

        return view('frontend.applicationpackages', compact('applicationpackages', 'purchases'));
    }

    public function purchase(Requests\Frontend\PurchaseApplicationPackage $request, $package_id)
    {
        $member = Auth::guard('member')->user();

        $applicationpackage = ApplicationPackage::findOrFail($package_id);

        $discount = Discount::where('code', '=', $request->code)->where('expired', '=', false)->first();

        $price_incl_discount = $applicationpackage->price;

        if ($discount) {
            $price_incl_discount = $this->useDiscount($discount, $applicationpackage);
        }

        $purchases = PackagePurchase::all();

        foreach ($purchases as $purchase) {
            if ($purchase->member_id == $member->id && $purchase->applicationpackage_id == $package_id) {
                return redirect(route('frontend.applicationpackages.index'))->withErrors([
                    'error' => 'You have already purchased this Application Package.'
                ]);
            }
        }

        $purchase = PackagePurchase::create(array(
            'member_id' => $member->id,
            'applicationpackage_id' => $package_id,
            'price_incl_discount' => $price_incl_discount,
            'paid' => false,
            'path' => null
        ));

        $invoice = Invoice::create(array(
            'member_id' => $member->id,
            'individualcoaching_id' => null,
            'booking_id' => null,
            'packagepurchase_id' => $purchase->id,
            'layoutpurchase_id' => null,
            'totalprice' => $price_incl_discount,
            'date' => Carbon::now(),
        ));

        event(new MakePackagePurchase($purchase, $invoice));

        if ($price_incl_discount == 0) {
            return redirect(route('frontend.applicationpackages.index'))->with('status', 'Your Purchase was successfully.');
        }
        if ($request->type == 'paypal') {
            $approvalLink = $this->payment($purchase, $invoice);
            return redirect($approvalLink);
        } elseif ($request->type == 'transfer') {
            return redirect(route('frontend.bank.index', ['package', $purchase]));
        }
    }

    public function useDiscount($discount, $applicationpackage)
    {
        $used = Memberdiscount::where('discount_id', '=', $discount->id)->where('member_id', '=', Auth::guard('member')->id())->first();

        if (!$used) {

            Memberdiscount::create(array(
                'member_id' => Auth::guard('member')->id(),
                'discount_id' => $discount->id
            ));

            if ($discount->service == 'Application Package' || $discount->service == 'Universal') {

                if ($discount->percentage) {
                    return $applicationpackage->price * $discount->amount / 100;
                } else {
                    if ($applicationpackage->price - $discount->amount < 0) {
                        return 0;
                    } else {
                        return $applicationpackage->price - $discount->amount;
                    }
                }
            }
        } else {
            return $applicationpackage->price;
        }
    }

    public function payment($purchase, $invoice)
    {
        $payer = Paypalpayment::payer();
        $payer->setPaymentMethod("paypal");

        $item = Paypalpayment::item();
        $item->setName($purchase->applicationpackage->title)
            ->setDescription('Application Package')
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
            ->setDescription("Application Package Payment")
            ->setInvoiceNumber(uniqid()); //USE THE INVOICE ID IN LIVE

        $redirectUrls = Paypalpayment::redirectUrls();
        $redirectUrls->setReturnUrl(route('frontend.applicationpackages.execute', $purchase->applicationpackage->id))
            ->setCancelUrl(route('frontend.applicationpackages.execute', $purchase->applicationpackage->id));

        $payment = Paypalpayment::payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));

        try {
            $payment->create($this->_apiContext);
        } catch (PayPalConnectionException $ex) {
            return redirect(route('frontend.applicationpackages.index'))->withErrors(['error' => 'Connection Error!']);
        }

        Session::put('paypal_payment_id', $payment->getId());

        $approvalUrl = $payment->getApprovalLink();

        return $approvalUrl;
    }

    public function executePayment($applicationpackage_id)
    {
        $payment_id = Session::get('paypal_payment_id');

        Session::forget('paypal_payment_id');

        $payment = PaypalPayment::getById($payment_id, $this->_apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));

        $result = $payment->execute($execution, $this->_apiContext);

        if ($result->getState() == 'approved') {
            $purchase = PackagePurchase::where('member_id', '=', Auth::guard('member')->id())->where('applicationpackage_id', '=', $applicationpackage_id)->first();

            $purchase->fill(array(
                'paid' => true
            ))->save();

            return redirect(route('frontend.applicationpackages.index'))->with('status', 'Successfully paid.');
        }
        return redirect(route('frontend.applicationpackages.index'))->withErrors(['error' => 'Payment Failed.']);
    }
}
