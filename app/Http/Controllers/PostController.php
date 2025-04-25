<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $elencoPost = Post::published()
            ->orderBy('published_at', 'desc')
            ->get();

        return view('posts.index', ['posts' => $elencoPost]);
    }

    public function show(Post $post)
    {
        $contents = $post->content;

        return view('posts.show', [
            'contents' => $contents
            ]);
    }
}
