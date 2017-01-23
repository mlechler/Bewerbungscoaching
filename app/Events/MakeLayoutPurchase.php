<?php

namespace App\Events;

use App\Invoice;
use App\Layoutpurchase;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MakeLayoutPurchase
{
    use InteractsWithSockets, SerializesModels;

    public $layoutpurchase;
    public $invoice;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Layoutpurchase $layoutpurchase, Invoice $invoice)
    {
        $this->layoutpurchase = $layoutpurchase;
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
