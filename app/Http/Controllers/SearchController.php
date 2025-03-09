<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function search(Request $request): View
    {
        $query = $request->input('q');

        if (empty($query)) {
            return view('search', [
                'users' => collect(),
                'posts' => collect(),
                'query' => ''
            ]);
        }

        $users = User::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->orWhere('bio', 'like', "%{$query}%")
            ->limit(10)
            ->get();

        $posts = Post::where('title', 'like', "%{$query}%")
            ->orWhereJsonContains('content', ['blocks' => [['data' => ['text' => $query]]]])
            ->with(['user', 'likes', 'comments'])
            ->latest()
            ->limit(10)
            ->get();

        return view('search', [
            'users' => $users,
            'posts' => $posts,
            'query' => $query
        ]);
    }
}