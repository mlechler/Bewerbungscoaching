<?php

namespace App\Listeners;

use App\Events\PurchaseApplicationPackage;
use App\Task;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateTaskCreatePackageForMember
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PackagePurchased $event
     * @return void
     */
    public function handle(PurchaseApplicationPackage $event)
    {
        Task::create(array(
            'title' => 'Create Application Package for ' . $event->purchase->member->lastname . ', ' . $event->purchase->member->firstname,
            'description' => '[' . $event->purchase->member->firstname . ' ' . $event->purchase->member->lastname . '](http://localhost:8000/backend/members/'
                . $event->purchase->member->id . '/detail) bought the Application Package [' . $event->purchase->applicationpackage->title . '](http://localhost:8000/backend/applicationpackages/'
                . $event->purchase->applicationpackage->id . '/detail). Communicate with the Member ([Mail](mailto:' . $event->purchase->member->email . ')) to get an overview of the desired companies. After that create the Package and assign it to ' . $event->purchase->member->firstname . ' ' . $event->purchase->member->lastname . ' [here](http://localhost:8000/backend/packagepurchases/'
                . $event->purchase->id . '/detail).',
            'creator_id' => null,
            'finished' => false
        ));
    }
}
