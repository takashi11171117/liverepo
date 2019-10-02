<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class FrontReportPostEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $params, $request, $images, $user_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($params, $request, $images, $user_id)
    {
        $this->params = $params;
        $this->request = $request;
        $this->images = $images;
        $this->user_id = $user_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
