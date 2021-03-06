<?php

namespace App\Events;

use App\IndividualCoaching;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;

class RemindCoachingBooking
{
    use InteractsWithSockets, SerializesModels;

    public $coaching;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(IndividualCoaching $coaching)
    {
        $this->coaching = $coaching;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
