<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $posts = Post::with(['user', 'likes', 'comments'])
            ->latest()
            ->get();

        return view('home', [
            'posts' => $posts
        ]);
    }
}