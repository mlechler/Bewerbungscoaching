<?php

namespace App\Http\Controllers\Frontend;

use App\ContactRequest;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function store(Requests\Frontend\StoreContactRequestRequest $request)
    {
        $user = Auth::guard('member')->user();

        ContactRequest::create(array(
            'name' => $request->name ? $request->name : $user->firstname . ' ' . $user->lastname,
            'email' => $request->email ? $request->email : $user->email,
            'message' => $request->message,
            'category' => $request->category,
            'processing' => false,
            'processedby' => null,
            'finished' => false,
        ));

        return redirect(route('frontend.contact.index'))->with('status', 'Your Contact Request has been sent to us.');
    }
}
