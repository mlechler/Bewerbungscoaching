<?php

namespace App\Http\Controllers\Frontend;

use App\Booking;
use App\IndividualCoaching;
use App\Invoice;
use App\LayoutPurchase;
use App\PackagePurchase;
use App\Page;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    public function show(Page $page, array $parameters)
    {
        return view('frontend.page', compact('page'));
    }

    public function bank($type, $id)
    {
        switch ($type) {
            case 'seminar':
                $booking = Booking::findOrFail($id);
                $invoice = Invoice::where('booking_id', '=', $id)->first();

                if ($booking->member_id == Auth::guard('member')->id()) {
                    $price_incl_discount = $booking->price_incl_discount;
                    $invoice_id = $invoice->id;
                    return view('frontend.bank', compact('price_incl_discount', 'invoice_id'));
                } else {
                    return redirect()->back();
                }
                break;
            case 'coaching':
                $coaching = IndividualCoaching::findOrFail($id);
                $invoice = Invoice::where('individualcoaching_id', '=', $id)->first();

                if ($coaching->member_id == Auth::guard('member')->id()) {
                    $price_incl_discount = $coaching->price_incl_discount;
                    $invoice_id = $invoice->id;
                    return view('frontend.bank', compact('price_incl_discount', 'invoice_id'));
                } else {
                    return redirect()->back();
                }
                break;
            case 'layout':
                $purchase = LayoutPurchase::findOrFail($id);
                $invoice = Invoice::where('layoutpurchase_id', '=', $id)->first();

                if ($purchase->member_id == Auth::guard('member')->id()) {
                    $price_incl_discount = $purchase->price_incl_discount;
                    $invoice_id = $invoice->id;
                    return view('frontend.bank', compact('price_incl_discount', 'invoice_id'));
                } else {
                    return redirect()->back();
                }
                break;
            case 'package':
                $purchase = PackagePurchase::findOrFail($id);
                $invoice = Invoice::where('packagepurchase_id', '=', $id)->first();

                if ($purchase->member_id == Auth::guard('member')->id()) {
                    $price_incl_discount = $purchase->price_incl_discount;
                    $invoice_id = $invoice->id;
                    return view('frontend.bank', compact('price_incl_discount', 'invoice_id'));
                } else {
                    return redirect()->back();
                }
                break;
        }
    }
}
