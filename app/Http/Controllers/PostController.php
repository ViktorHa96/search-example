<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
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
        $index = $client->index('posts'); // Použite názov vášho indexu
        $searchResults = $index->search($search, [
            'attributesToHighlight' => ['*'],
            'highlightPreTag' => '<em style="text-decoration: underline; color: red">',
            'highlightPostTag' => '</em>',
            'limit' => 50
        ]);

        // Spracovanie výsledkov
        $hits = $searchResults;

        $formattedPosts = [];
        foreach ($hits as $hit) {
            // Získanie zvýraznených výrazov z MeiliSearch výsledkov

            $formattedPosts[] = [
                'id' => $hit['id'],
                'title' => $hit['_formatted']['title'],
                'description' => $hit['_formatted']['description'],
                'tags' => $hit['_formatted']['tags'],
                'category' => $hit['_formatted']['category'],
            ];
        }
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
