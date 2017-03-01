<?php

namespace App\Http\Controllers\Frontend;

use App\Booking;
use App\Invoice;
use App\LayoutPurchase;
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
        }
    }
}
