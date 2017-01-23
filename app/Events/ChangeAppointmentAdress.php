<?php

namespace App\Events;

use App\Appointment;
use App\Member;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChangeAppointmentAdress
{
    use InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public $participant;
    public $oldadress;
    public $seminarappointment;

    public function __construct(Member $participant, $oldadress, Appointment $seminarappointment)
    {
        $this->participant = $participant;
        $this->oldadress = $oldadress;
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
