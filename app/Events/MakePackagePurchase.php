<?php

namespace App\Events;

use App\Invoice;
use App\Packagepurchase;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MakePackagePurchase
{
    use InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $packagepurchase;
    public $invoice;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Packagepurchase $packagepurchase, Invoice $invoice)
    {
        $this->packagepurchase = $packagepurchase;
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
