<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Notifications\PostLikedNotification;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use function Pest\Laravel\post;

class PostController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|json', // Editor.js outputs JSON
            'post_image' => 'nullable|image|max:5120', // 5MB max
        ]);

        $post = new Post();
        $post->title = $validated['title'];
        $post->content = $validated['content']; // This will be JSON from Editor.js
        $post->user_id = $request->user()->id;

        // Handle image upload if present
        if ($request->hasFile('post_image')) {
            $path = $request->file('post_image')->store('post-images', 'public');
            $post->image = $path;
        }

        $post->save();

        return redirect()->route('home')->with('success', 'Post created successfully!');
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        // Add authorization check here if needed
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|json', // Editor.js outputs JSON
            'post_image' => 'nullable|image|max:5120',
        ]);

        $post->title = $validated['title'];
        $post->content = $validated['content'];

        if ($request->hasFile('post_image')) {
            // Delete old image if exists
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $path = $request->file('post_image')->store('post-images', 'public');
            $post->image = $path;
        }

        $post->save();

        return redirect()->route('home')->with('success', 'Post updated successfully!');
    }

    public function toggleLike(Post $post): JsonResponse
    {
        $like = $post->likes()->where('user_id', auth()->id())->first();

        if ($like) {
            $like->delete();
            $isLiked = false;
        } else {
            $post->likes()->create([
                'user_id' => auth()->id(),
            ]);
            
            // Send notification to post owner if the liker is not the post owner
            if ($post->user_id !== auth()->id()) {
                $post->user->notify(new PostLikedNotification($post, auth()->user()));
            }
            
            $isLiked = true;
        }

        return response()->json([
            'success' => true,
            'likesCount' => $post->likes()->count(),
            'isLiked' => $isLiked
        ]);
    }

    public function checkLiked(Post $post){
        return response()->json([
            'isLiked' =>  $post->likes()->where('user_id',auth()->id())->exists(),
        ]);
    }

    public function destroy(Post $post): JsonResponse
    {
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        // Delete post image if exists
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return response()->json([
            'message' => 'Post deleted successfully'
        ]);
    }
}
