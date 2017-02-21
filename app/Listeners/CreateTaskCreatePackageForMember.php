<?php

namespace App\Listeners;

use App\Events\MakePackagepurchase;
use App\Task;

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

    public function handle(MakePackagePurchase $event)
    {
        Task::create(array(
            'title' => 'Create Application Package for ' . $event->packagepurchase->member->lastname . ', ' . $event->packagepurchase->member->firstname,
            'description' => '[' . $event->packagepurchase->member->firstname . ' ' . $event->packagepurchase->member->lastname . '](http://localhost:8000/backend/members/'
                . $event->packagepurchase->member->id . '/detail) bought the Application Package [' . $event->packagepurchase->applicationpackage->title . '](http://localhost:8000/backend/applicationpackages/'
                . $event->packagepurchase->applicationpackage->id . '/detail). Communicate with the Member ([Mail](mailto:' . $event->packagepurchase->member->email . ')) to get an overview of the desired companies. After that create the package and assign it to ' . $event->packagepurchase->member->firstname . ' ' . $event->packagepurchase->member->lastname . ' [here](http://localhost:8000/backend/packagepurchases/'
                . $event->packagepurchase->id . '/detail).',
            'creator_id' => null,
            'processing' => 0,
            'processedby' => null,
            'finished' => false
        ));
    }
}
