<?php

namespace App\Http\Controllers\Frontend;

use Anouar\Paypalpayment\Facades\PaypalPayment;
use App\Discount;
use App\Employee;
use App\EmployeeFreeTime;
use App\Events\MakeCoachingBooking;
use App\IndividualCoaching;
use App\Invoice;
use App\Memberdiscount;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;
use App\Http\Requests;
use PayPal\Api\PaymentExecution;
use PayPal\Exception\PayPalConnectionException;

class IndividualCoachingsController extends Controller
{
    protected $coachings;
    private $_apiContext;

    public function __construct(IndividualCoaching $coachings)
    {
        $this->coachings = $coachings;

        $this->_apiContext = PaypalPayment::apiContext(config('paypal_payment.Account.ClientId'), config('paypal_payment.Account.ClientSecret'));
    }

    public function index()
    {
        $calendar = null;

        $employees = Employee::all();

        $freetimes = EmployeeFreeTime::with('employee')->get();

        if (!$freetimes->isEmpty()) {
            foreach ($freetimes as $freetime) {
                $date = Carbon::createFromFormat('Y-m-d', $freetime->date);
                $starttime = Carbon::createFromFormat('H:i:s', $freetime->starttime);
                $endtime = Carbon::createFromFormat('H:i:s', $freetime->endtime);

                $start = $date->format('Y-m-d') . ' ' . $starttime->format('H:i:s');
                $end = $date->format('Y-m-d') . ' ' . $endtime->format('H:i:s');

                $event = Calendar::event(
                    $freetime->address->zip . ' ' . $freetime->address->city . ', ' .
                    $freetime->address->street . ' ' . $freetime->address->housenumber . ', Hourly Rate: ' .
                    $freetime->hourlyrate . ' €',
                    false,
                    $start,
                    $end
                );
                $calendar = Calendar::addEvent($event, [
                    'color' => $freetime->employee->color,
                    'disableResizing' => true,
                    'url' => route('frontend.individualcoachings.detail', $freetime->id)
                ]);
            }
        }

        $calendar = Calendar::setOptions([
            'weekends' => false,
            'navLinks' => true
        ]);

        return view('frontend.individualcoachings.index', compact('calendar', 'employees'));
    }

    public function detail($id)
    {
        $freetime = EmployeeFreeTime::with('employee')->findOrFail($id);

        return view('frontend.individualcoachings.detail', compact('freetime'));
    }

    public function makeBooking(Requests\Frontend\MakeBookingRequest $request, $freetime_id)
    {
        $member = Auth::guard('member')->user();

        $freetime = EmployeeFreeTime::findOrFail($freetime_id);

        $discount = Discount::where('code', '=', $request->code)->where('expired', '=', false)->first();

        $starttime = explode(':', $request->starttime);
        $endtime = explode(':', $request->endtime);

        $hours = $endtime[0] - $starttime[0];
        $minutes = $endtime[1] - $starttime[1];

        if ($minutes < 0) {
            $hours = $hours - 1;
            $minutes = 60 + $minutes;
        }

        $price_incl_discount = $freetime->hourlyrate * $hours + $freetime->hourlyrate * $minutes / 60;

        if ($discount) {
            $price_incl_discount = $this->useDiscount($discount, $price_incl_discount);
        }

        $coaching = IndividualCoaching::create(array(
            'services' => 'test',
            'member_id' => $member->id,
            'employee_id' => $freetime->employee->id,
            'address_id' => $freetime->address_id,
            'date' => $freetime->date,
            'time' => $request->starttime,
            'duration' => $hours . '.' . $minutes,
            'price_incl_discount' => $price_incl_discount,
            'trial' => false,
            'paid' => false,
            'reminderSend' => false,
        ));

        $invoice = Invoice::create(array(
            'member_id' => $member->id,
            'individualcoaching_id' => $coaching->id,
            'booking_id' => null,
            'packagepurchase_id' => null,
            'layoutpurchase_id' => null,
            'totalprice' => $price_incl_discount,
            'date' => Carbon::now(),
        ));

        EmployeeFreeTime::destroy($freetime_id);

        event(new MakeCoachingBooking($coaching, $invoice));

        if ($price_incl_discount == 0) {
            return redirect(route('frontend.individualcoachings.index'))->with('status', 'Your Booking was successfully.');
        }
        if ($request->type == 'paypal') {
            $approvalLink = $this->payment($coaching, $invoice);
            return redirect($approvalLink);
        } elseif ($request->type == 'transfer') {
            return redirect(route('frontend.bank.index', ['coaching', $coaching]));
        }
    }

    public function useDiscount($discount, $price)
    {
        $used = Memberdiscount::where('discount_id', '=', $discount->id)->where('member_id', '=', Auth::guard('member')->id())->first();

        if (!$used) {

            Memberdiscount::create(array(
                'member_id' => Auth::guard('member')->id(),
                'discount_id' => $discount->id
            ));

            if ($discount->service == 'Individual Coaching' || $discount->service == 'Universal') {

                if ($discount->percentage) {
                    return $price * $discount->amount / 100;
                } else {
                    if ($price - $discount->amount < 0) {
                        return 0;
                    } else {
                        return $price - $discount->amount;
                    }
                }
            }
        } else {
            return $price;
        }
    }

    public function payment($coaching, $invoice)
    {
        $payer = PaypalPayment::payer();
        $payer->setPaymentMethod("paypal");

        $item = Paypalpayment::item();
        $item->setName('Individual Coaching, ' . date_format($coaching->date, 'd.m.Y') . ', ' . Carbon::parse($coaching->time)->format('H:i') . ' - ' . Carbon::parse($coaching->time)->addHours($coaching->duration)->format('H:i'))
            ->setDescription('Individual Coaching')
            ->setCurrency('EUR')
            ->setQuantity(1)
            ->setPrice($coaching->price_incl_discount);

        $itemList = Paypalpayment::itemList();
        $itemList->setItems(array($item));

        $amount = Paypalpayment::amount();
        $amount->setCurrency("EUR")
            ->setTotal($coaching->price_incl_discount);

        $transaction = Paypalpayment::transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Individual Coaching Payment")
            ->setInvoiceNumber(uniqid()); //USE THE INVOICE ID IN LIVE

        $redirectUrls = Paypalpayment::redirectUrls();
        $redirectUrls->setReturnUrl(route('frontend.individualcoachings.execute',$coaching->id))
            ->setCancelUrl(route('frontend.individualcoachings.execute',$coaching->id));

        $payment = Paypalpayment::payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));

        try {
            $payment->create($this->_apiContext);
        } catch (PayPalConnectionException $ex) {
            return redirect(route('frontend.individualcoachings.index'))->withErrors(['error' => 'Connection Error!']);
        }

        Session::put('paypal_payment_id', $payment->getId());

        $approvalUrl = $payment->getApprovalLink();

        return $approvalUrl;
    }

    public function executePayment($coaching_id)
    {
        $payment_id = Session::get('paypal_payment_id');

        Session::forget('paypal_payment_id');

        $payment = PaypalPayment::getById($payment_id, $this->_apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));

        $result = $payment->execute($execution, $this->_apiContext);

        if ($result->getState() == 'approved') {
            $coaching = IndividualCoaching::findOrFail($coaching_id);

            $coaching->fill(array(
                'paid' => true
            ))->save();

            return redirect(route('frontend.individualcoachings.index'))->with('status', 'Successfully paid.');
        }
        return redirect(route('frontend.individualcoachings.index'))->withErrors(['error' => 'Payment Failed.']);
    }
}
