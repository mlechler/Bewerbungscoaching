<?php

namespace App\Events;

use App\Invoice;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;

class CreateInvoice
{
    use InteractsWithSockets, SerializesModels;

    public $type;
    public $invoice;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice, $type)
    {
        $this->invoice = $invoice;
        $this->type = $type;
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
