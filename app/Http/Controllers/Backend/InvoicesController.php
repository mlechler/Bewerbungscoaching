<?php

namespace App\Http\Controllers\Backend;

use App\ApplicationLayout;
use App\ApplicationPackage;
use App\Appointment;
use App\Booking;
use App\Events\CreateInvoice;
use App\IndividualCoaching;
use App\Invoice;
use App\LayoutPurchase;
use App\Member;
use App\Http\Requests;
use App\PackagePurchase;
use App\Seminar;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InvoicesController extends Controller
{
    protected $invoices;

    public function __construct(Invoice $invoices)
    {
        $this->invoices = $invoices;

        parent::__construct();
    }

    public function index()
    {
        $invoices = Invoice::with('member', 'individualcoaching', 'booking')->orderBy('created_at', 'desc')->paginate(10);

        return view('backend.invoices.index', compact('invoices'));
    }

    public function create(Invoice $invoice)
    {
        $mem = Member::select('id', 'lastname', 'firstname')->get();
        $members = ['' => ''];
        foreach ($mem as $member) {
            $members[$member->id] = $member->lastname . ', ' . $member->firstname;
        }

        return view('backend.invoices.form', compact('invoice', 'members'));
    }

    public function store(Requests\Backend\StoreInvoiceRequest $request)
    {
        $booking_id = null;
        $individualcoaching_id = null;
        $packagepurchase_id = null;
        $layoutpurchase_id = null;
        $totalprice = null;
        $type = null;

        if($request->individualcoaching == "" && $request->seminar == "" && $request->package == "" && $request->layout == "")
        {
            return redirect()->back()->withErrors([
                'error' => 'Select an Position'
            ]);
        }

        switch($request->type){
            case 'individualcoaching':
                $pieces = explode('; ', $request->individualcoaching);
                $individualcoaching = IndividualCoaching::where('member_id','=',$request->member_id)->where('services', '=', $pieces[0])->where('date', '=', date_format(Carbon::parse($pieces[1]),'Y-m-d'))->first();
                $individualcoaching_id = $individualcoaching->id;
                $totalprice = $individualcoaching->price_incl_discount;
                $type = 'coaching';
                break;
            case 'seminar':
                $pieces = explode('; ', $request->seminar);
                $seminar = Seminar::where('title','=', $pieces[0])->first();
                $appointment = Appointment::where('seminar_id','=',$seminar->id)->where('date', '=', date_format(Carbon::parse($pieces[1]),'Y-m-d'))->first();
                $booking = Booking::where('member_id','=',$request->member_id)->where('appointment_id', '=', $appointment->id)->first();
                $booking_id = $booking->id;
                $totalprice = $booking->price_incl_discount;
                $type = 'seminar';
                break;
            case 'package':
                $package = ApplicationPackage::where('title','=',$request->package)->first();
                $packagepurchase = PackagePurchase::where('member_id','=',$request->member_id)->where('applicationpackage_id', '=', $package->id)->first();
                $packagepurchase_id = $packagepurchase->id;
                $totalprice = $packagepurchase->price_incl_discount;
                $type = 'package';
                break;
            case 'layout':
                $layout = ApplicationLayout::where('title','=',$request->layout)->first();
                $layoutpurchase = LayoutPurchase::where('member_id','=',$request->member_id)->where('applicationlayout_id', '=', $layout->id)->first();
                $layoutpurchase_id = $layoutpurchase->id;
                $totalprice = $layoutpurchase->price_incl_discount;
                $type = 'layout';
                break;
            default:
                break;
        }

        $invoice = Invoice::create(array(
            'member_id' => $request->member_id,
            'individualcoaching_id' => $individualcoaching_id,
            'booking_id' => $booking_id,
            'packagepurchase_id' => $packagepurchase_id,
            'layoutpurchase_id' => $layoutpurchase_id,
            'totalprice' => $totalprice,
            'date' => Carbon::now()
        ));

        event(new CreateInvoice($invoice, $type));

        return redirect(route('invoices.index'))->with('status', 'Invoice has been created.');
    }

    public function edit($id)
    {
        $invoice = Invoice::findOrFail($id);

        $mem = Member::select('id', 'lastname', 'firstname')->get();
        $members = ['' => ''];
        foreach ($mem as $member) {
            $members[$member->id] = $member->lastname . ', ' . $member->firstname;
        }

        return view('backend.invoices.form', compact('invoice', 'members'));
    }

    public function update()
    {
        //
    }

    public function confirm($id)
    {
        $invoice = Invoice::findOrFail($id);

        return view('backend.invoices.confirm', compact('invoice'));
    }

    public function destroy($id)
    {
        Invoice::destroy($id);

        return redirect(route('invoices.index'))->with('status', 'Invoice has been deleted.');
    }

    public function detail($id)
    {
        $invoice = Invoice::with('member', 'booking', 'individualcoaching')->findOrFail($id);

        return view('backend.invoices.detail', compact('invoice'));
    }

    public function getMemberData()
    {
        $id = intval($_GET['id']);

        $individualcoachings = IndividualCoaching::select('id', 'services', 'date', 'time', 'duration')->where('member_id','=',$id)->get();
        $coachings = [];
        foreach ($individualcoachings as $individualcoaching) {
            $coachings[$individualcoaching->id] = $individualcoaching->services . '; '
                . date_format($individualcoaching->date, 'd.m.Y') . '; '
                . Carbon::parse($individualcoaching->time)->format('H:i') . ' - '
                . Carbon::parse($individualcoaching->time)->addHours($individualcoaching->duration)->format('H:i');
        }

        $seminarbookings = Booking::select('id', 'appointment_id')->where('member_id','=',$id)->get();
        $bookings = [];
        foreach ($seminarbookings as $seminarbooking) {
            $bookings[$seminarbooking->id] = $seminarbooking->appointment->seminar->title . '; '
                . date_format($seminarbooking->appointment->date, 'd.m.Y') . '; '
                . Carbon::parse($seminarbooking->appointment->time)->format('H:i') . ' - '
                . Carbon::parse($seminarbooking->appointment->time)->addHours($seminarbooking->appointment->seminar->duration)->format('H:i');
        }

        $purchases = PackagePurchase::select('id', 'applicationpackage_id')->where('member_id','=',$id)->get();
        $packagepurchases = [];
        foreach ($purchases as $purchase) {
            $packagepurchases[$purchase->id] = $purchase->applicationpackage->title;
        }

        $purchases = LayoutPurchase::select('id', 'applicationlayout_id')->where('member_id','=',$id)->get();
        $layoutpurchases = [];
        foreach ($purchases as $purchase) {
            $layoutpurchases[$purchase->id] = $purchase->applicationlayout->title;
        }

        return [$coachings, $bookings, $packagepurchases, $layoutpurchases];
    }
}
