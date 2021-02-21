<?php

use CloudCreativity\LaravelJsonApi\Facades\JsonApi;
use App\Models\Article;


JsonApi::register('v1')->routes(function($api){
    // $article = Article::factory()->create();
    $api->resource('articles')->relationships(function ($api) {
        $api->hasOne('authors');
    });
    $api->resource('authors')->only('index', 'read');
});