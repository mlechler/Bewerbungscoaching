<?php

namespace App\Events;

use App\IndividualCoaching;
use App\Invoice;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;

class MakeCoachingBooking
{
    use InteractsWithSockets, SerializesModels;

    public $coaching;
    public $invoice;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(IndividualCoaching $coaching, Invoice $invoice)
    {
        $this->coaching = $coaching;
        $this->invoice = $invoice;
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
