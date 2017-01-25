<?php

namespace App\Events;

use App\Invoice;
use App\PackagePurchase;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;

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

    public function __construct(PackagePurchase $packagepurchase, Invoice $invoice)
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
