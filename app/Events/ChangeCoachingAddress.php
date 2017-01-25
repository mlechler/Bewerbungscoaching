<?php

namespace App\Events;

use App\IndividualCoaching;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;

class ChangeCoachingAddress
{
    use InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $oldaddress;
    public $coaching;

    public function __construct(IndividualCoaching $coaching, $oldaddress)
    {
        $this->oldaddress = $oldaddress;
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
