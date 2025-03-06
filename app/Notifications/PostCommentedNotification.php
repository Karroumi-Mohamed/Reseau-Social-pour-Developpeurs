<?php

namespace App\Notifications;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;

class PostCommentedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $comment;
    protected $user;

    public function __construct(Comment $comment, User $user)
    {
        $this->comment = $comment;
        $this->user = $user;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => $this->user->name . ' commented on your post',
            'post_id' => $this->comment->post_id,
            'user_id' => $this->user->id,
            'type' => 'post_commented',
            'comment_id' => $this->comment->id,
            'title' => $this->comment->post->title
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'message' => $this->user->name . ' commented on your post',
            'post_id' => $this->comment->post_id,
            'user_id' => $this->user->id,
            'type' => 'post_commented',
            'comment_id' => $this->comment->id,
            'title' => $this->comment->post->title
        ]);
    }


    public function broadcastType(): string
    {
        return 'post_commented';
    }
}