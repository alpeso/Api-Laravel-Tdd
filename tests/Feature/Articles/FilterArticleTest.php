<?php

namespace Tests\Feature\Articles;

use Tests\TestCase;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FilterArticleTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function can_filter_by_title()
    {
        Article::factory()->create([
            'title' => 'Aprende Laravel Desde Cero'
        ]);

        Article::factory()->create([
            'title' => 'Other Article'
        ]);

        $url = route('api.v1.articles.index', ['filter[title]' => 'Laravel']);

        $this->getJson($url)
            ->assertJsonCount(1, 'data')
            ->assertSee('Aprende Laravel Desde Cero')
            ->assertDontSee('Other Article');
    }
    
    /** @test */
    public function can_filter_by_content()
    {
        Article::factory()->create([
            'content' => '<div>Aprende Laravel Desde Cero</div>'
        ]);

        Article::factory()->create([
            'content' => '<div>Other Article</div>'
        ]);

        $url = route('api.v1.articles.index', ['filter[content]' => 'Laravel']);

        $this->getJson($url)
            ->assertJsonCount(1, 'data')
            ->assertSee('Aprende Laravel Desde Cero')
            ->assertDontSee('Other Article');
    }

    /** @test */
    public function can_filter_by_year()
    {
        Article::factory()->create([
            'content' => 'Article from 2020',
            'created_at' => now()->year(2020)
        ]);

        Article::factory()->create([
            'content' => 'Article from 2021',
            'created_at' => now()->year(2021)
        ]);

        $url = route('api.v1.articles.index', ['filter[year]' => 2020]);

        $this->getJson($url)
            ->assertJsonCount(1, 'data')
            ->assertSee('Article from 2020')
            ->assertDontSee('Article from 2021');
    }

    /** @test */
    public function can_filter_by_month()
    {
        Article::factory()->create([
            'content' => 'Article from February',
            'created_at' => now()->month(2)
        ]);

        Article::factory()->create([
            'content' => 'Another Article from February',
            'created_at' => now()->month(2)
        ]);


        Article::factory()->create([
            'content' => 'Article from January',
            'created_at' => now()->month(1)
        ]);

        $url = route('api.v1.articles.index', ['filter[month]' => 2]);

        $this->getJson($url)
            ->assertJsonCount(2, 'data')
            ->assertSee('Article from February')
            ->assertSee('Another Article from February')
            ->assertDontSee('Article from January');
    }
}
