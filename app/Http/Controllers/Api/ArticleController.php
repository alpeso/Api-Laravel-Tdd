<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\ArticleCollection;

class ArticleController extends Controller
{
    public function index()
    {
        $sortFields = Str::of(request('sort'))->explode(',');
        $articleQuery = Article::query();

        foreach($sortFields as $sortField){
            $direction = 'asc';
            if(Str::of($sortField)->startsWith('-')){
                $direction = 'desc';
                $sortField = Str::of($sortField)->substr(1);
            }
            $articleQuery->orderBy($sortField, $direction);
        }

        
        if (request()->missing('sort')) {
            return ArticleCollection::make(Article::all());
        }else{
            return ArticleCollection::make($articleQuery->get());
        }

        // $articles = Article::applySorts(request('sort'))->get();
        // return ArticleCollection::make($articles);
    }

    public function show(Article $article)
    {
        return ArticleResource::make($article);
    }

}
