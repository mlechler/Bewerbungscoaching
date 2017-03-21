<?php

namespace App\Widgets;

use App\ContactRequest;
use Arrilot\Widgets\AbstractWidget;

class ContactRequests extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $requests = ContactRequest::where('category','!=','feedback')->where('finished', '=', false)->where('processing','=',false)->orderBy('created_at')->take(5)->get();

        return view("backend.widgets.contact_requests", [
            'config' => [],
        ], compact('requests'));
    }
}