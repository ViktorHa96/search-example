<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Str;
use Inertia\Inertia;

class PostController
{
    public function getPosts (Request $request) {
       $search = $request->query('search');

       $posts = Post::search($search)
       ->take(10)
       ->get();

        $formattedPosts = $posts->map(function ($post) {
            $tags = $post->tags->pluck('name')->all();
            $category = $post->category->name;

            return [
                'id' => $post->id,
                'title' => $post->title,
                'description' => Str::of($post->description)->words(5, ' ...'),
                'tags' => $tags,
                'category' => $category,
            ];
        });

       return response()->json([
            'posts' => $formattedPosts
       ]);
    }

    public function showPost ($post) {
        $post = Post::findOrFail($post);

        return Inertia::render('ShowPost', [
            'post'=> $post
        ]);
    }
}
