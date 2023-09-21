<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Str;
use Inertia\Inertia;
use MeiliSearch\Client;
use MeiliSearch\Exceptions\HTTPRequestException;

class PostController
{
    public function getPosts (Request $request) {
        $search = $request->query('search');

        // Inicializácia klienta pre MeiliSearch
        $client = new Client('http://meilisearch:7700', 'masterKey');

        // Vykonanie vyhľadávania v MeiliSearch
        $indexPost = $client->index('posts'); // Použite názov vášho indexu
        $indexTag = $client->index('tags');
        $indexCategory = $client->index('categories');

        $searchResultsPost = $indexPost->search($search, [
            'attributesToHighlight' => ['*'],
            'highlightPreTag' => '<em style="text-decoration: underline; color: red">',
            'highlightPostTag' => '</em>',
            'limit' => 50
        ]);
        $searchResultsTag = $indexTag->search($search, [
            'attributesToHighlight' => ['*'],
            'highlightPreTag' => '<em style="text-decoration: underline; color: red">',
            'highlightPostTag' => '</em>',
            'limit' => 50
        ]);
        $searchResultsCategory = $indexCategory->search($search, [
            'attributesToHighlight' => ['*'],
            'highlightPreTag' => '<em style="text-decoration: underline; color: red">',
            'highlightPostTag' => '</em>',
            'limit' => 50
        ]);

        // Spracovanie výsledkov

        $formattedPosts = [];
        foreach ($searchResultsPost as $hit) {

            $formattedPosts[] = [
                'id' => $hit['id'],
                'name' => $hit['_formatted']['title'],
                'type' => 'príspevok',
            ];
        }
        $formattedTags = [];
        foreach ($searchResultsTag as $hit) {
            // Spracovanie výsledku z indexu 'tags'
            $formattedTags[] = [
                'id' => $hit['id'],
                'name' => $hit['_formatted']['name'],
                'type' => 'tag',
            ];
        }
        $formattedCategories = [];
        foreach ($searchResultsCategory as $hit) {
            // Spracovanie výsledku z indexu 'categories'
            $formattedCategories[] = [
                'id' => $hit['id'],
                'name' => $hit['_formatted']['name'],
                'type' => 'kategória',
            ];
        }

        $formattedResults = array_merge($formattedCategories, $formattedTags, $formattedPosts);
        return response()->json([
                'posts' => $formattedResults
        ]);
    }

    public function showPosts ($type, $id) {
        $posts[] = null;
        if ($type === 'príspevok') {
            $post = Post::findOrFail($id);
            $posts = [
                'post' => $post,
                'category' => $post->category->name,
                'tags' => $post->tags->map(function ($tag) {
                    return $tag->name;
                }),
            ];
        } else if ($type === 'tag') {
            $tag = Tag::findOrFail($id);
            $posts = $tag->posts->map(function ($post) {
                return [
                    'post' => $post,
                    'category' => $post->category->name,
                    'tags' => $post->tags->map(function ($tag) {
                        return $tag->name;
                    }),
                ];
            }); // Získaj príspevky pre daný tag
        } else if ($type === 'kategória') {
            $category = Category::findOrFail($id);
            $posts = $category->posts->map(function ($post) {
                return [
                    'post' => $post,
                    'category' => $post->category->name,
                    'tags' => $post->tags->map(function ($tag) {
                        return $tag->name;
                    }),
                ];
            }); // Získaj príspevky pre danú kategóriu
        } else {
            return null; // Neznámy typ
        }

        return Inertia::render('ShowPost', [
            'type' => $type,
            'posts'=> $posts
        ]);
    }
}
