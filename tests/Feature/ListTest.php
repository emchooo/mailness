<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\Lists;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ListTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

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

        $response = $this->actingAs($this->user)->get(route('lists.index'));

        $response->assertSeeText($list->name);
    }

    /** @test */
    public function createNewList()
    {
        $name = 'My best list';
        $email = 'john@example.com';

        $response = $this->actingAs($this->user)->post(route('lists.store'), [
            'name' => $name,
            'from_email' => $email,
        ]);

        $list = Lists::first();

        $this->assertEquals($list->name, $name);
        $response->assertRedirect(route('lists.show', $list->id));
    }

    /** @test */
    public function createNewListCannotBeAddedWithoutName()
    {
        $response = $this->actingAs($this->user)->post(route('lists.store'));

        $response->assertSessionHasErrors();
    }

    /** @test */
    public function openSingleListPage()
    {
        $list = factory(Lists::class)->create();

        $response = $this->actingAs($this->user)->get(route('lists.show', $list->id));

        $response->assertSuccessful()->assertSeeText($list->name);
    }

    /** @test */
    public function inListWithoutContatDisplayMessage()
    {
        $list = factory(Lists::class)->create();

        $response = $this->actingAs($this->user)->get(route('lists.show', $list->id));

        $response->assertSuccessful()->assertSeeText('no contacts yet');
    }

    /** @test */
    public function openCreateListPage()
    {
        $response = $this->actingAs($this->user)->get(route('lists.create'));

        $response->assertSuccessful()->assertSeeText('Create new list');
    }

    /** @test */
    public function ifListIdIsNotValidReturn404()
    {
        $response = $this->actingAs($this->user)->get(route('lists.show', 1));

        $response->assertStatus(404);
    }

    /** @test */
    public function openEditListPage()
    {
        $list = factory(Lists::class)->create();

        $response = $this->actingAs($this->user)->get(route('lists.edit', $list->id));

        $response->assertStatus(200)->assertSeeText('Edit list');
    }

    /** @test */
    public function updateListing()
    {
        $list_name = 'My best list';
        $list = factory(Lists::class)->create();

        $response = $this->actingAs($this->user)->put(route('lists.update', $list->id), ['name' => $list_name]);

        $response->assertRedirect();

        $edited_list = Lists::find($list->id);

        $this->assertEquals($list_name, $edited_list->name);
    }

    /** @test */
    public function updateListingNameCannotBeEmpty()
    {
        $list = factory(Lists::class)->create();

        $response = $this->actingAs($this->user)->put(route('lists.update', $list->id), ['name' => '']);

        $response->assertSessionHasErrors();
    }

    /** @test */
    public function deleteList()
    {
        $list = factory(Lists::class)->create();
        $list2 = factory(Lists::class)->create();
        $list3 = factory(Lists::class)->create();

        $response = $this->actingAs($this->user)->delete(route('lists.delete', $list->id));

        $this->assertEquals(2, $list->count());
    }

    /** @test */
    public function whenDeleteListRemoveAllContacts()
    {
        $list = factory(Lists::class)->create();
        $list1 = factory(Lists::class)->create();

        $contact1 = $this->actingAs($this->user)->post(route('contacts.store', $list->id), ['email' => 'tom@sawyer.com']);
        $contact2 = $this->actingAs($this->user)->post(route('contacts.store', $list->id), ['email' => 'tom@sawyer.net']);
        $contac3 = $this->actingAs($this->user)->post(route('contacts.store', $list1->id), ['email' => 'tom@sawyer.org']);

        $response = $this->delete(route('lists.delete', $list->id));

        $this->assertEquals(1, Contact::count());
    }

    /** @test */
    public function openSubscribeToListPage()
    {
        $list = factory(Lists::class)->create();

        $response = $this->get(route('lists.subscribe', $list->uuid));

        $response->assertSuccessful();
    }

    /** @test */
    public function subscribeContactFromForm()
    {
        $list = factory(Lists::class)->create();

        $response = $this->post(route('lists.subscribe.store', $list->uuid), ['email' => 'batman@spiderman.com']);

        $this->assertEquals(1, Contact::count());
    }
}
