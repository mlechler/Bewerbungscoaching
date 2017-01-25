<?php

namespace App\Events;

use App\Invoice;
use App\LayoutPurchase;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;

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
    public function __construct(LayoutPurchase $layoutpurchase, Invoice $invoice)
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
