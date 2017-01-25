<?php

namespace App\Events;

use App\Appointment;
use App\Member;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;

class ChangeAppointmentAddress
{
    use InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public $participant;
    public $oldaddress;
    public $seminarappointment;

    public function __construct(Member $participant, $oldaddress, Appointment $seminarappointment)
    {
        $this->participant = $participant;
        $this->oldaddress = $oldaddress;
        $this->seminarappointment = $seminarappointment;
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
