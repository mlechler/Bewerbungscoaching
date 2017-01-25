<?php

namespace App\Events;

use App\Individualcoaching;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChangeCoachingDateTime
{
    use InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $olddate;
    public $oldtime;
    public $coaching;

    public function __construct(Individualcoaching $coaching, $olddate, $oldtime)
    {
        $this->olddate = $olddate;
        $this->oldtime = $oldtime;
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
