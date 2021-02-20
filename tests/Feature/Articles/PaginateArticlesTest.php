<?php

namespace Tests\Feature\Articles;

use Tests\TestCase;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaginateArticlesTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function can_fetch_paginated_articles()
    {
        $articles = Article::factory()->times(10)->create();

        $url = route('api.v1.articles.index', ['page[size]' => 2, 'page[number]' => 3]);

        $response = $this->jsonApi()->get($url);

        $response->assertJsonCount(2, 'data')
            ->assertDontSee($articles[0]->titile)
            ->assertDontSee($articles[1]->titile)
            ->assertDontSee($articles[2]->titile)
            ->assertDontSee($articles[3]->titile)
            ->assertSee($articles[4]->titile)
            ->assertSee($articles[5]->titile)
            ->assertDontSee($articles[6]->titile)
            ->assertDontSee($articles[7]->titile)
            ->assertDontSee($articles[8]->titile)
            ->assertDontSee($articles[9]->titile);
        
        // foreach($response->json('links') as $link){
        //     dump(urldecode($link));
        // }

        $response->assertJsonStructure([
            'links' => ['first', 'last', 'prev', 'next']
        ]);

        $response->assertJsonFragment([
            'first' => route('api.v1.articles.index', ['page[size]' => 2, 'page[number]' => 1]),
            'last' => route('api.v1.articles.index', ['page[size]' => 2, 'page[number]' => 5]),
            'prev' => route('api.v1.articles.index', ['page[size]' => 2, 'page[number]' => 2]),
            'next' => route('api.v1.articles.index', ['page[size]' => 2, 'page[number]' => 4]),
        ]);

    }
}
