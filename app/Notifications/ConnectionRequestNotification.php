<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ConnectionRequestNotification extends Notification
{
    use Queueable;

    protected $sender;

    public function __construct(User $sender)
    {
        $this->sender = $sender;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'connection_request',
            'message' => "{$this->sender->name} sent you a connection request",
            'sender_id' => $this->sender->id,
            'sender_name' => $this->sender->name,
        ];
    }
}