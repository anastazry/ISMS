<?php

namespace App\Listeners;

use to;
use App\Models\User;
use App\Events\NewHirarcAdded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Redis;
class SendNewHirarcNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewHirarcAdded $event)
    {
        // Get all users except admins
        $users = User::where('role', '!=', 'Admin')->get();

        // Broadcast the notification using Laravel Echo to a common channel for all users
        // broadcast(new NewHirarcAdded($event->hirarc))->toOthers()->broadcastOn('new-hirarc-channel');
        broadcast(new NewHirarcAdded($event->hirarc));
    }
    
}
