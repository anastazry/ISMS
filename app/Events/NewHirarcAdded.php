<?php

namespace App\Events;
use App\Models\Hirarc;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewHirarcAdded implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     * 
     */
    public $hirarc;
    public function __construct(Hirarc $hirarc)
    {
        $this->hirarc = $hirarc;
    }
    public function broadcastOn()
    {
        return new Channel('new-hirarc-channel');
    }

    public function broadcastAs()
    {
        return new Channel('NewHirarcAdded');
    }


    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    // public function broadcastOn(): array
    // {
    //     return [
    //         new PrivateChannel('channel-name'),
    //     ];
    // }
}
