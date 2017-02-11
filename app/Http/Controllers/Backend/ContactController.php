<?php

namespace App\Http\Controllers\Backend;

use App\ContactRequest;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    protected $contactrequests;

    public function __construct(ContactRequest $contactrequests)
    {
        $this->contactrequests = $contactrequests;

        parent::__construct();
    }
    public function index()
    {
        $contactrequests = ContactRequest::orderBy('finished')->orderBy('processing')->paginate(10);

        return view('backend.contact.index', compact('contactrequests'));
    }

    public function confirm($id)
    {
        $contactrequest = ContactRequest::findOrFail($id);

        return view('backend.contact.confirm', compact('contactrequest'));
    }

    public function destroy($id)
    {
        ContactRequest::destroy($id);

        return redirect(route('contact.index'))->with('status', 'Contact Request has been deleted.');
    }

    public function detail($id)
    {
        $contactrequest = ContactRequest::with('processor')->findOrFail($id);

        return view('backend.contact.detail', compact('contactrequest'));
    }

    public function requestFinished($id)
    {
        $contactrequest = ContactRequest::findOrFail($id);

        if((Auth::guard('employee')->user()->isAdmin() || $contactrequest->processedby == Auth::guard('employee')->id()) && !$contactrequest->finished) {
            $contactrequest->fill(array(
                'processing' => false,
                'finished' => true
            ))->save();

            return redirect()->back()->with('status', 'Contact Request has been closed.');
        }
        return redirect()->back();
    }

    public function requestProcessing($id)
    {
        $contactrequest = ContactRequest::findOrFail($id);

        if((Auth::guard('employee')->user()->isAdmin() || !$contactrequest->processing) && !$contactrequest->finished) {
            $contactrequest->fill(array(
                'processing' => true,
                'processedby' => Auth::guard('employee')->id()
            ))->save();

            return redirect()->back()->with('status', 'Contact Request is now in your processing.');
        }
        return redirect()->back();
    }

    public function deleteAllFinishedRequests()
    {
        $contactrequests = ContactRequest::all()->where('finished', '=', true);

        if (!$contactrequests->isEmpty()) {
            foreach ($contactrequests as $request) {
                ContactRequest::destroy($request->id);
            }

            return redirect(route('contact.index'))->with('status', 'Contact Requests have been deleted.');

        } else {
            return redirect(route('contact.index'))->withErrors([
                'error' => 'No finished Contact Requests.'
            ]);
        }

    }
}
