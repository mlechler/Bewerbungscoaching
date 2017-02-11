<?php

namespace App\Http\Controllers\Frontend;

use App\ContactRequest;
use App\Http\Requests;

class ContactController extends Controller
{
    public function store(Requests\Frontend\StoreContactRequestRequest $request)
    {
        ContactRequest::create(array(
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'processing' => false,
            'processedby' => null,
            'finished' => false,
        ));

        return redirect(route('frontend.contact'))->with('status', 'Your Contact Request has been sent to us.');
    }
}
