<?php

namespace App\Http\Controllers\Frontend;

use App\Appointment;
use App\Booking;
use App\Discount;
use App\Events\MakeSeminarBooking;
use App\Invoice;
use App\Memberdiscount;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Netshell\Paypal\Facades\Paypal;

class SeminarsController extends Controller
{
    protected $appointments;
    private $_apiContext;

    public function __construct(Appointment $appointments)
    {
        $this->appointments = $appointments;

        $this->_apiContext = Paypal::ApiContext(
            config('services.paypal.client_id'),
            config('services.paypal.secret'));

        $this->_apiContext->setConfig(array(
            'mode' => 'sandbox',
            'service.EndPoint' => 'https://api.sandbox.paypal.com',
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => true,
            'log.FileName' => storage_path('logs/paypal.log'),
            'log.LogLevel' => 'FINE'
        ));
    }

    public function index()
    {
        $appointments = Appointment::with('employee', 'seminar')->where('date', '>', Carbon::now())->get();

        return view('frontend.seminars', compact('appointments'));
//        return view('frontend.seminars', compact('appointments'))->with('map', new MapController);
    }

    public function makeBooking(Requests\Frontend\MakeBookingRequest $request, $appointmentId)
    {
        $member = Auth::guard('member')->user();

        $appointment = Appointment::findOrFail($appointmentId);

        $discount = Discount::where('code', '=', $request->code)->where('expired', '=', false)->first();

        $price_incl_discount = $appointment->seminar->price;

        if ($discount) {
            $price_incl_discount = $this->useDiscount($discount, $appointment);
        }

        $bookings = Booking::all();

        foreach ($bookings as $booking) {
            if ($booking->member_id == $member->id && $booking->appointment_id == $appointmentId) {
                return redirect(route('frontend.seminars.index'))->withErrors([
                    'error' => 'You have already booked this Appointment.'
                ]);
            }
        }

        $booking = Booking::create(array(
            'member_id' => $member->id,
            'appointment_id' => $appointmentId,
            'price_incl_discount' => $price_incl_discount,
            'paid' => false,
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
        //Redirect je nach dem zu PayPal oder zur Bankseite
        if($request->type == 'paypal') {
            $this->payment($booking);
        } elseif ($request->type == 'transfer') {
            return redirect(route('frontend.bank.index'));
        }
    }

    public function useDiscount($discount, $appointment)
    {
        $used = Memberdiscount::where('discount_id', '=', $discount->id)->where('member_id', '=', Auth::guard('member')->id())->first();

        if (!$used) {

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
            }
        }  else {
            return $appointment->seminar->price;
        }
    }

    public function payment($booking)
    {
        $payer = PayPal::Payer();
        $payer->setPaymentMethod('paypal');

        $amount = PayPal:: Amount();
        $amount->setCurrency('EUR');
        $amount->setTotal($booking->price_incl_discount);

        $transaction = PayPal::Transaction();
        $transaction->setAmount($amount);
        $transaction->setDescription($booking->appointment->seminar->title);

        $redirectUrls = PayPal::RedirectUrls();
        $redirectUrls->setReturnUrl(action(SeminarsController::getDone()));
        $redirectUrls->setCancelUrl(action(SeminarsController::getCancel()));

        $payment = PayPal::Payment();
        $payment->setIntent('sale');
        $payment->setPayer($payer);
        $payment->setRedirectUrls($redirectUrls);
        $payment->setTransactions(array($transaction));

        $response = $payment->create($this->_apiContext);
        $redirectUrl = $response->links[1]->href;

        return redirect($redirectUrl);
    }

    public function getDone()
    {
//        $id = $request->get('paymentId');
//        $token = $request->get('token');
//        $payer_id = $request->get('PayerID');
//
//        $payment = PayPal::getById($id, $this->_apiContext);
//
//        $paymentExecution = PayPal::PaymentExecution();
//
//        $paymentExecution->setPayerId($payer_id);
//        $executePayment = $payment->execute($paymentExecution, $this->_apiContext);

        dd('done');
    }

    public function getCancel()
    {
        dd('cancel');
    }
}
