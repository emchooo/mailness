<?php

namespace Tests\Feature;

use App\Lists;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ListTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function itIsPossibleToCreateNewList()
    {
        $list = factory(Lists::class)->create();
        
        $inserted_list = Lists::first();

        $this->assertEquals($list->name, $inserted_list->name);

    }

    /** @test */
    public function openListsPage()
    {
        $list = factory(Lists::class)->create();

        $response = $this->get('/lists');

        $response->assertSeeText($list->name);
    }

    /** @test */
    public function createNewList()
    {
        $name = 'My best list';
        $response = $this->post('/lists/store', [ 'name' => $name ]);

        $list = Lists::first();

        $this->assertEquals($list->name, $name);

    }
}
