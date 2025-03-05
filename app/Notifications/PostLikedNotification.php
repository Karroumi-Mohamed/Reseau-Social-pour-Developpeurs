<?php

namespace App\Notifications;

use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class PostLikedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $post;
    protected $user;

    public function __construct(Post $post, User $user)
    {
        $this->post = $post;
        $this->user = $user;
        Log::info('Notification created', ['type' => 'post_liked', 'user' => $user->id, 'post' => $post->id]);
    }

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => $this->user->name . ' liked your post',
            'post_id' => $this->post->id,
            'user_id' => $this->user->id,
            'type' => 'post_liked',
            'title' => $this->post->title
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'message' => $this->user->name . ' liked your post',
            'post_id' => $this->post->id,
            'user_id' => $this->user->id,
            'type' => 'post_liked',
            'title' => $this->post->title
        ]);
    }

    public function broadcastType(): string
    {
        return 'post_liked';
    }
}
