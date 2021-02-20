<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArticleController;
use CloudCreativity\LaravelJsonApi\Facades\JsonApi;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::get('articles/{article}','ArticleController@show')->name('api.v1.articles.read');
// Route::get('articles','ArticleController@index')->name('api.v1.articles.index');

JsonApi::register('v1')->routes(function($api){
    $api->resource('articles');
});