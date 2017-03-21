<?php

namespace App\Http\Controllers\Backend;

use App\Appointment;
use App\Booking;
use App\IndividualCoaching;
use App\Invoice;
use App\LayoutPurchase;
use App\Member;
use App\Http\Requests;
use App\PackagePurchase;
use Carbon\Carbon;

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

        $individualcoachings = IndividualCoaching::select('id', 'services', 'date', 'time', 'duration', 'member_id')->get();
        $coachings = ['' => ''];
        foreach ($individualcoachings as $individualcoaching) {
            $coachings[$individualcoaching->id] = $individualcoaching->member->lastname . ' ' . $individualcoaching->member->firstname . ', '
                . $individualcoaching->services . ', '
                . date_format($individualcoaching->date, 'd.m.Y') . ', '
                . Carbon::parse($individualcoaching->time)->format('H:i') . ' - '
                . Carbon::parse($individualcoaching->time)->addHours($individualcoaching->duration)->format('H:i');
        }

        $seminarbookings = Booking::select('id', 'appointment_id', 'member_id')->get();
        $bookings = ['' => ''];
        foreach ($seminarbookings as $seminarbooking) {
            $bookings[$seminarbooking->id] = $seminarbooking->member->lastname . ' ' . $seminarbooking->member->firstname . ', '
                . $seminarbooking->appointment->seminar->title . ', '
                . date_format($seminarbooking->appointment->date, 'd.m.Y') . ', '
                . Carbon::parse($seminarbooking->appointment->time)->format('H:i') . ' - '
                . Carbon::parse($seminarbooking->appointment->time)->addHours($seminarbooking->appointment->seminar->duration)->format('H:i');
        }

        $purchases = PackagePurchase::select('id', 'applicationpackage_id', 'member_id')->get();
        $packagepurchases = ['' => ''];
        foreach ($purchases as $purchase) {
            $packagepurchases[$purchase->id] = $purchase->member->lastname . ' ' . $purchase->member->firstname . ', '
                . $purchase->applicationpackage->title;
        }

        $purchases = LayoutPurchase::select('id', 'applicationlayout_id', 'member_id')->get();
        $layoutpurchases = ['' => ''];
        foreach ($purchases as $purchase) {
            $layoutpurchases[$purchase->id] = $purchase->member->lastname . ' ' . $purchase->member->firstname . ', '
                . $purchase->applicationlayout->title;
        }

        return view('backend.invoices.form', compact('invoice', 'members', 'coachings', 'bookings', 'packagepurchases', 'layoutpurchases'));
    }

    public function store()
    {
        dd($_REQUEST['selectBoxType']);
    }

    public function edit($id)
    {
        $invoice = Invoice::findOrFail($id);

        $mem = Member::select('id', 'lastname', 'firstname')->get();
        $members = ['' => ''];
        foreach ($mem as $member) {
            $members[$member->id] = $member->lastname . ', ' . $member->firstname;
        }

        $individualcoachings = IndividualCoaching::select('id', 'services', 'date', 'time', 'duration', 'member_id')->get();
        $coachings = ['' => ''];
        foreach ($individualcoachings as $individualcoaching) {
            $coachings[$individualcoaching->id] = $individualcoaching->member->lastname . ' ' . $individualcoaching->member->firstname . ', '
                . $individualcoaching->services . ', '
                . date_format($individualcoaching->date, 'd.m.Y') . ', '
                . Carbon::parse($individualcoaching->time)->format('H:i') . ' - '
                . Carbon::parse($individualcoaching->time)->addHours($individualcoaching->duration)->format('H:i');
        }

        $seminarbookings = Booking::select('id', 'appointment_id', 'member_id')->get();
        $bookings = ['' => ''];
        foreach ($seminarbookings as $seminarbooking) {
            $bookings[$seminarbooking->id] = $seminarbooking->member->lastname . ' ' . $seminarbooking->member->firstname . ', '
                . $seminarbooking->appointment->seminar->title . ', '
                . date_format($seminarbooking->appointment->date, 'd.m.Y') . ', '
                . Carbon::parse($seminarbooking->appointment->time)->format('H:i') . ' - '
                . Carbon::parse($seminarbooking->appointment->time)->addHours($seminarbooking->appointment->seminar->duration)->format('H:i');
        }

        $purchases = PackagePurchase::select('id', 'applicationpackage_id', 'member_id')->get();
        $packagepurchases = ['' => ''];
        foreach ($purchases as $purchase) {
            $packagepurchases[$purchase->id] = $purchase->member->lastname . ' ' . $purchase->member->firstname . ', '
                . $purchase->applicationpackage->title;
        }

        $purchases = LayoutPurchase::select('id', 'applicationlayout_id', 'member_id')->get();
        $layoutpurchases = ['' => ''];
        foreach ($purchases as $purchase) {
            $layoutpurchases[$purchase->id] = $purchase->member->lastname . ' ' . $purchase->member->firstname . ', '
                . $purchase->applicationlayout->title;
        }

        return view('backend.invoices.form', compact('invoice', 'members', 'coachings', 'bookings', 'packagepurchases', 'layoutpurchases'));
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
}
