<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Article::all()->map(function ($article) {
                return [
                    'type' => 'articles',
                    'id' => (string)$article->getRouteKey(),
                    'attributes' => [
                        'title' => $article->title,
                        'slug' => $article->slug,
                        'content' => $article->content,
                    ],
                    'links' => [
                        'self' => route('api.v1.articles.show', $article)
                    ]
                ];
            })
        ]);
    }

    public function show(Article $article)
    {
        return response()->json([
            'data' => [
                'type' => 'articles',
                'id' => (string) $article->getRouteKey(),
                'attributes' =>[
                    'title' => $article->title,
                    'slug' => $article->slug,
                    'content' => $article->content,
                ],
                'links' => [
                    'self' => url('/api/v1/articles/'.$article->getRouteKey())
                ]
            ]
        ]);
    }

}
