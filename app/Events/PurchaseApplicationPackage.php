<?php

namespace App\Events;

use App\PackagePurchase;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;

class PurchaseApplicationPackage
{
    use InteractsWithSockets, SerializesModels;

    public $purchase;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(PackagePurchase $purchase)
    {
        $this->purchase = $purchase;
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
