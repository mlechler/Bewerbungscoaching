<?php

namespace App\Http\Controllers\Backend;

use App\Invoice;
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

    public function create()
    {
        //
    }

    public function store()
    {
        //
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
