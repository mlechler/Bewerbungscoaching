<?php

namespace App\Listeners;

use App\Events\UploadMemberFile;
use App\Task;

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
     * @param  UploadMemberFile $event
     * @return void
     */
    public function handle(UploadMemberFile $event)
    {
        $task = Task::where('title', '=', 'Check Files of ' . $event->member->lastname . ', ' . $event->member->firstname)->where('processing', '=', false)->where('finished', '=', false)->first();

        if (!$task) {
            Task::create(array(
                'title' => 'Check Files of ' . $event->member->lastname . ', ' . $event->member->firstname,
                'description' => '[' . $event->member->firstname . ' ' . $event->member->lastname . '](http://localhost:8000/backend/members/'
                    . $event->member->id . '/detail) uploaded new Files. Check these on mistakes and upload an improved version if necessary.',
                'creator_id' => null,
                'processing' => 0,
                'processedby' => null,
                'finished' => false
            ));
        }
    }
}
