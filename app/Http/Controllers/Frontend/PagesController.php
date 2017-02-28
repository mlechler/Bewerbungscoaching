<?php

namespace App\Http\Controllers\Frontend;

use App\Booking;
use App\Invoice;
use App\Page;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    public function show(Page $page, array $parameters)
    {
        return view('frontend.page', compact('page'));
    }

    public function bank($booking_id)
    {
        $booking = Booking::findOrFail($booking_id);
        $invoice = Invoice::where('booking_id','=',$booking_id)->first();

        if($booking->member_id == Auth::guard('member')->id()) {
            return view('frontend.bank', compact('booking','invoice'));
        } else {
            return redirect()->back();
        }
    }
}
