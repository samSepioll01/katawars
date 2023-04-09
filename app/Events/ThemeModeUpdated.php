<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ThemeModeUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $theme;
    public $csrf_token;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(?User $user)
    {
        $this->user = $user;
        $this->theme = session('theme');
        $this->csrf_token = csrf_token();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        if (auth()->check()) {
            return new PrivateChannel('theme.user.' . $this->user->id);
        }

        return new Channel('theme.' . $this->csrf_token);

    }
}
