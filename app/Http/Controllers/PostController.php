<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

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

    public function toggleLike(Post $post)
    {
        $like = $post->likes()->where('user_id', auth()->id())->first();
        
        if ($like) {
            $like->delete();
            $isLiked = false;
        } else {
            $post->likes()->create([
                'user_id' => auth()->id()
            ]);
            $isLiked = true;
        }
        
        return response()->json([
            'success' => true,
            'likesCount' => $post->likes()->count(),
            'isLiked' => $isLiked
        ]);
    }

    // Method to check if user has liked a post
    public function checkLike(Post $post)
    {
        return response()->json([
            'isLiked' => $post->likes()->where('user_id', auth()->id())->exists()
        ]);
    }
}
