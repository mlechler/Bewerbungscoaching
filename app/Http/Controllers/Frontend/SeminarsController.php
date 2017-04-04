<?php

namespace App\Http\Controllers\Frontend;

use Anouar\Paypalpayment\Facades\PaypalPayment;
use App\Appointment;
use App\Booking;
use App\Discount;
use App\Events\MakeSeminarBooking;
use App\Invoice;
use App\Memberdiscount;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use PayPal\Api\PaymentExecution;
use PayPal\Exception\PayPalConnectionException;

class SeminarsController extends Controller
{
    protected $appointments;
    private $_apiContext;

    public function __construct(Appointment $appointments)
    {
        $this->appointments = $appointments;

        $this->_apiContext = PaypalPayment::apiContext(config('paypal_payment.Account.ClientId'), config('paypal_payment.Account.ClientSecret'));
    }

    public function index()
    {
        $appointments = Appointment::with('employee', 'seminar')->where('date', '>', Carbon::now())->get();

        return view('frontend.seminars', compact('appointments'));
//        return view('frontend.seminars', compact('appointments'))->with('map', new MapController);
    }

    public function makeBooking(Requests\Frontend\MakeBookingRequest $request, $appointment_id)
    {
        $member = Auth::guard('member')->user();

        $appointment = Appointment::findOrFail($appointment_id);

        $discount = Discount::where('code', '=', $request->code)->where('expired', '=', false)->first();

        $price_incl_discount = $appointment->seminar->price;

        if ($discount) {
            $price_incl_discount = $this->useDiscount($discount, $appointment);
        }

        $bookings = Booking::all();

        foreach ($bookings as $booking) {
            if ($booking->member_id == $member->id && $booking->appointment_id == $appointment_id) {
                return redirect(route('frontend.seminars.index'))->withErrors([
                    'error' => 'You have already booked this Appointment.'
                ]);
            }
        }

        $booking = Booking::create(array(
            'member_id' => $member->id,
            'appointment_id' => $appointment_id,
            'price_incl_discount' => $price_incl_discount,
            'paid' => $price_incl_discount == 0 ? true : false,
            'reminderSend' => false,
        ));

        $invoice = Invoice::create(array(
            'member_id' => $member->id,
            'individualcoaching_id' => null,
            'booking_id' => $booking->id,
            'packagepurchase_id' => null,
            'layoutpurchase_id' => null,
            'totalprice' => $price_incl_discount,
            'date' => Carbon::now(),
        ));

        event(new MakeSeminarBooking($booking, $invoice));

        if ($price_incl_discount == 0) {
            return redirect(route('frontend.seminars.index'))->with('status', 'Your Booking was successfully.');
        }
        if ($request->type == 'paypal') {
            $approvalLink = $this->payment($booking, $invoice);
            return redirect($approvalLink);
        } elseif ($request->type == 'transfer') {
            return redirect(route('frontend.bank.index', ['seminar', $booking]));
        }
    }

    public function useDiscount($discount, $appointment)
    {
        $used = Memberdiscount::where('discount_id', '=', $discount->id)->where('member_id', '=', Auth::guard('member')->id())->first();

        if (($discount->permanent || Carbon::parse($discount->startdate)->addDays($discount->validity) >= Carbon::now()) && !$used) {
            Memberdiscount::create(array(
                'member_id' => Auth::guard('member')->id(),
                'discount_id' => $discount->id
            ));

            if ($discount->service == 'Seminar' || $discount->service == 'Universal') {

                if ($discount->percentage) {
                    return $appointment->seminar->price * $discount->amount / 100;
                } else {
                    if ($appointment->seminar->price - $discount->amount < 0) {
                        return 0;
                    } else {
                        return $appointment->seminar->price - $discount->amount;
                    }
                }
            } else {
                return $appointment->seminar->price;
            }

        } else {
            return $appointment->seminar->price;
        }
    }

    public function payment($booking, $invoice)
    {
        $payer = Paypalpayment::payer();
        $payer->setPaymentMethod("paypal");

        $item = Paypalpayment::item();
        $item->setName($booking->appointment->seminar->title . ', ' . date_format($booking->appointment->date, 'd.m.Y') . ', ' . Carbon::parse($booking->appointment->time)->format('H:i') . ' - ' . Carbon::parse($booking->appointment->time)->addHours($booking->appointment->seminar->duration)->format('H:i'))
            ->setDescription('Seminar')
            ->setCurrency('EUR')
            ->setQuantity(1)
            ->setPrice($booking->price_incl_discount);

        $itemList = Paypalpayment::itemList();
        $itemList->setItems(array($item));

        $amount = Paypalpayment::amount();
        $amount->setCurrency("EUR")
            ->setTotal($booking->price_incl_discount);

        $transaction = Paypalpayment::transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Seminar Payment")
            ->setInvoiceNumber(uniqid()); //USE THE INVOICE ID IN LIVE

        $redirectUrls = Paypalpayment::redirectUrls();
        $redirectUrls->setReturnUrl(route('frontend.seminars.execute',$booking->appointment->id))
            ->setCancelUrl(route('frontend.seminars.execute',$booking->appointment->id));

        $payment = Paypalpayment::payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));

        try {
            $payment->create($this->_apiContext);
        } catch (PayPalConnectionException $ex) {
            return redirect(route('frontend.seminars.index'))->withErrors(['error' => 'Connection Error!']);
        }

        Session::put('paypal_payment_id', $payment->getId());

        $approvalUrl = $payment->getApprovalLink();

        return $approvalUrl;
    }

    public function executePayment($appointment_id)
    {
        $payment_id = Session::get('paypal_payment_id');

        Session::forget('paypal_payment_id');

        $payment = PaypalPayment::getById($payment_id, $this->_apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));

        $result = $payment->execute($execution, $this->_apiContext);

        if ($result->getState() == 'approved') {
            $booking = Booking::where('member_id','=', Auth::guard('member')->id())->where('appointment_id','=',$appointment_id)->first();

            $booking->fill(array(
                'paid' => true
            ))->save();

            return redirect(route('frontend.seminars.index'))->with('status', 'Successfully paid.');
        }
        return redirect(route('frontend.seminars.index'))->withErrors(['error' => 'Payment Failed.']);
    }
}
