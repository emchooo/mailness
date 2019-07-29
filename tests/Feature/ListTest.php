<?php

namespace Tests\Feature;

use App\Lists;
use App\Contact;
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

        $response = $this->get(route('lists.index'));

        $response->assertSeeText($list->name);
    }


    /** @test */
    public function createNewList()
    {
        $name = 'My best list';
        $response = $this->post(route('lists.store'), [ 'name' => $name ]);

        $list = Lists::first();

        $this->assertEquals($list->name, $name);

    }

    /** @test */
    public function createNewListCannotBeAddedWithoutName()
    {
        $response = $this->post(route('lists.store'));

        $response->assertSessionHasErrors();
    }

    /** @test */
    public function openSingleListPage()
    {
        $list = factory(Lists::class)->create();

        $response = $this->get(route('lists.show', $list->id));

        $response->assertSuccessful()->assertSeeText($list->name);
    }

    /** @test */
    public function ifListIdIsNotValidReturn404()
    {
        $response = $this->get(route('lists.show', 1));

        $response->assertStatus(404);
    }

    /** @test */
    public function openEditListPage()
    {
        $list = factory(Lists::class)->create();

        $response = $this->get(route('lists.edit', $list->id));

        $response->assertStatus(200)->assertSeeText('Edit list');
    }

    /** @test */
    public function updateListing()
    {
        $list_name = 'My best list';
        $list = factory(Lists::class)->create();
        
        $response = $this->put(route('lists.update', $list->id), [ 'name' => $list_name ]);

        $edited_list = Lists::find($list->id);

        $this->assertEquals($list_name, $edited_list->name);

    }

    /** @test */
    public function updateListingNameCannotBeEmpty()
    {
        $list = factory(Lists::class)->create();

        $response = $this->put(route('lists.update', $list->id), [ 'name' => '' ]);
    
        $response->assertSessionHasErrors();

    }

    /** @test */
    public function deleteList()
    {
        $list = factory(Lists::class)->create();
        $list2 = factory(Lists::class)->create();
        $list3 = factory(Lists::class)->create();
        
        $response = $this->delete(route('lists.delete', $list->id));

        $this->assertEquals(2, $list->count());

    }

    /** @test */
    public function whenDeleteListRemoveAllContacts()
    {
        $list = factory(Lists::class)->create();
        $list1 = factory(Lists::class)->create();

        $contact1 = $this->post(route('contacts.store', $list->id), [ 'email' => 'tom@sawyer.com' ]);
        $contact2 = $this->post(route('contacts.store', $list->id), [ 'email' => 'tom@sawyer.net' ]);
        $contac3 =  $this->post(route('contacts.store', $list1->id), [ 'email' => 'tom@sawyer.org' ]);

        $response = $this->delete(route('lists.delete', $list->id)); 
        
        $this->assertEquals(1, Contact::count());
    }
}
