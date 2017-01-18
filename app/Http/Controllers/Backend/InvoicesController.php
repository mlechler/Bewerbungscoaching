<?php

namespace App\Http\Controllers\Backend;

use App\Booking;
use App\Individualcoaching;
use App\Invoice;
use App\Member;
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
        $invoices = Invoice::with('member', 'individualcoaching', 'booking')->paginate(10);

        return view('backend.invoices.index', compact('invoices'));
    }

    public function create(Invoice $invoice)
    {
        $mem = Member::select('lastname', 'firstname')->get();
        $members = ['' => ''];
        foreach ($mem as $member) {
            array_push($members, $member->lastname.', '.$member->firstname);
        }
        array_unshift($members,'');
        unset($members[0]);

        return view('backend.invoices.form', compact('invoice', 'members'));
    }

    public function store()
    {
        dd($_REQUEST['selectBoxType']);
    }

    public function edit()
    {
        //
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
