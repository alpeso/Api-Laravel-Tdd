<?php

namespace Tests\Feature\Articles;

use Tests\TestCase;
use App\Models\Article;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SortArticlesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_sort_articles_by_title_asc()
    {
        Article::factory()->create(['title' => 'C title']);
        Article::factory()->create(['title' => 'A title']);
        Article::factory()->create(['title' => 'B title']);
        
        $url = route('api.v1.articles.index', ['sort' => 'title']);
        $this->jsonApi()->get($url)->assertSeeInOrder([            
            'A title',            
            'B title',
            'C title',
        ]);

    }

    /** @test */
    public function it_can_sort_articles_by_title_desc()
    {
        Article::factory()->create(['title' => 'C title']);
        Article::factory()->create(['title' => 'A title']);
        Article::factory()->create(['title' => 'B title']);
        
        $url = route('api.v1.articles.index', ['sort' => '-title']);
        $this->jsonApi()->get($url)->assertSeeInOrder([
            'C title',                      
            'B title',      
            'A title',  
        ]);

    }

    /** @test */
    public function it_can_sort_articles_by_title_and_content()
    {
        Article::factory()->create([
            'title' => 'C title',
            'content' => 'B content'
        ]);
        Article::factory()->create([
            'title' => 'A title',
            'content' => 'C content'
        ]);
        Article::factory()->create([
            'title' => 'B title',
            'content' => 'D content'
        ]);
        
        // DB::listen(function($db){
        //     dump($db->sql);
        // });
        
        $url = route('api.v1.articles.index').'?sort=-content,title';
        $this->jsonApi()->get($url)->assertSeeInOrder([
            'D content',                      
            'C content',      
            'B content',  
        ]);

    }

    /** @test */
    public function it_cannot_sort_articles_by_unknown_fields()
    {
        Article::factory()->times(3)->create();
        
        $url = route('api.v1.articles.index').'?sort=unknown';
        $this->jsonApi()->get($url)->assertStatus(400);

    }
}
