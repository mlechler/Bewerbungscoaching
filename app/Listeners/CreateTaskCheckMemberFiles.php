<?php

namespace App\Listeners;

use App\Events\UploadMemberFile;
use App\Task;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateTaskCheckMemberFiles
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
     * @param  UploadMemberFile  $event
     * @return void
     */
    public function handle(UploadMemberFile $event)
    {
        Task::create(array(
            'title' => 'Check Files of ' . $event->member->lastname . ', ' . $event->member->firstname,
            'description' => '[' . $event->member->firstname . ' ' . $event->member->lastname . '](http://localhost:8000/backend/members/'
                . $event->member->id . '/detail) uploaded new Files. Check these on mistakes and upload a improved version if necessary.',
            'creator_id' => null,
            'finished' => false
        ));
    }
}
