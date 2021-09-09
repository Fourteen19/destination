<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ClientVacancyHistory
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $vacancy;
    public $clientId;

    /**
     * Create a new vacancy instance.
     *
     * @return void
     */
    public function __construct($vacancy, $clientId)
    {
        $this->vacancy = $vacancy;
        $this->clientId = $clientId;
    }

    /**
     * Get the channels the vacancy should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
