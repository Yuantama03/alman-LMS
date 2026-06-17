<?php

namespace App\Events;

use App\Models\ChatGroupMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GroupMessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(ChatGroupMessage $message)
    {
        $this->message = $message->load('user');
    }

    public function broadcastOn()
    {
        return new Channel('chat-group.' . $this->message->chat_group_id);
    }

    public function broadcastWith()
    {
        return [
            'id'         => $this->message->id,
            'message'    => $this->message->message,
            'user_id'    => $this->message->user_id,
            'user_name'  => $this->message->user->name,
            'created_at' => $this->message->created_at->format('H:i'),
        ];
    }
}