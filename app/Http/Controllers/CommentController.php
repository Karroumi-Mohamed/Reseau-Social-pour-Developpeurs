<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Notifications\PostCommentedNotification;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    public function store(Request $request, Post $post): JsonResponse
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment = $post->comments()->create([
            'content' => $validated['content'],
            'user_id' => auth()->id(),
        ]);

        $comment->load('user');

        // Send notification to post owner if the commenter is not the post owner
        if ($post->user_id !== auth()->id()) {
            $post->user->notify(new PostCommentedNotification($comment, auth()->user()));
        }

        $html = view('components.comment', ['comment' => $comment])->render();

        return response()->json([
            'message' => 'Comment added successfully',
            'comment' => $comment,
            'commentHtml' => $html,
            'commentsCount' => $post->comments()->count()
        ]);
    }

    public function update(Request $request, Comment $comment): JsonResponse
    {
        $this->authorize('update', $comment);

        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment->update($validated);

        return response()->json([
            'message' => 'Comment updated successfully',
            'comment' => $comment->fresh()
        ]);
    }

    public function destroy(Comment $comment): JsonResponse
    {
        $this->authorize('delete', $comment);
        
        $post = $comment->post;
        $comment->delete();

        return response()->json([
            'message' => 'Comment deleted successfully',
            'commentsCount' => $post->comments()->count()
        ]);
    }
}