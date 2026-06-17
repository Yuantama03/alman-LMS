<?php

namespace App\Events;

use App\Models\ChatMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(ChatMessage $message)
    {
        $this->message = $message->load('user');
    }

    public function broadcastOn()
    {
        return new Channel('mapel.' . $this->message->mapel_id);
    }

    public function broadcastWith()
    {
        return [
            'id'         => $this->message->id,
            'message'    => $this->message->message,
            'user_id'    => $this->message->user_id,
            'user_name'  => $this->message->user->name,
            'user_roles' => $this->message->user->roles,
            'created_at' => $this->message->created_at->format('H:i'),
        ];
    }
}