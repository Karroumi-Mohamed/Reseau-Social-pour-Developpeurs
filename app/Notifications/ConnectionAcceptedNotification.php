<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ConnectionAcceptedNotification extends Notification
{
    use Queueable;

    protected $receiver;

    public function __construct(User $receiver)
    {
        $this->receiver = $receiver;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'connection_accepted',
            'message' => "{$this->receiver->name} accepted your connection request",
            'receiver_id' => $this->receiver->id,
            'receiver_name' => $this->receiver->name,
        ];
    }
}