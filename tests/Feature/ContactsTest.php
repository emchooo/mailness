<?php

namespace Tests\Feature;

use App\Contact;
use App\Field;
use App\Lists;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ContactsTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    /** @test */
    public function createNewContactAndAttachToList()
    {
        $list = factory(Lists::class)->create();

        $response = $this->actingAs($this->user)->post(route('contacts.store', $list->id), ['email' => 'emir.softi@gmail.com']);

        $response->assertRedirect(route('lists.show', $list->id));
    }

    /** @test */
    public function seeContactCreateForm()
    {
        $list = factory(Lists::class)->create();

        $response = $this->actingAs($this->user)->get(route('contacts.create', $list->id));

        $response->assertSuccessful();
    }

    /** @test */
    public function dontAttachSameContactToList()
    {
        $list = factory(Lists::class)->create();

        $response = $this->actingAs($this->user)->post(route('contacts.store', $list->id), ['email' => 'tom@sawyer.com']);
        $response = $this->actingAs($this->user)->post(route('contacts.store', $list->id), ['email' => 'tom@sawyer.com']);
        $response = $this->actingAs($this->user)->post(route('contacts.store', $list->id), ['email' => 'tomy@sawyer.com']);

        $this->assertEquals(2, Contact::count());
    }

    /** @test */
    public function itIsPossibleToAddSameContactEmailToDifferentLists()
    {
        $list = factory(Lists::class)->create();
        $list2 = factory(Lists::class)->create();

        $response = $this->actingAs($this->user)->post(route('contacts.store', $list->id), ['email' => 'tom@sawyer.com']);
        $response = $this->actingAs($this->user)->post(route('contacts.store', $list2->id), ['email' => 'tom@sawyer.com']);

        $contacts = Contact::all();

        $this->assertEquals(2, $contacts->count());
    }

    /** @test */
    public function cannotCreateContactWithoutEmail()
    {
        $list = factory(Lists::class)->create();

        $response = $this->actingAs($this->user)->post(route('contacts.store', $list->id));

        $response->assertSessionHasErrors();
    }

    /** @test */
    public function emailFieldMustBeValidEmailAddress()
    {
        $list = factory(Lists::class)->create();

        $response = $this->actingAs($this->user)->post(route('contacts.store', $list->id), ['email' => 'emirgmail.com']);

        $response->assertSessionHasErrors();
    }

    /** @test */
    public function thereIsEditContactPage()
    {
        $list = factory(Lists::class)->create();
        $contact = factory(Contact::class)->create(['list_id' => $list->id]);

        $response = $this->actingAs($this->user)->get(route('contacts.edit', [$list->id, $contact->id]));

        $response->assertSuccessful();
    }

    /** @test */
    public function updateContact()
    {
        $list = factory(Lists::class)->create();
        $contact = factory(Contact::class)->create(['list_id' => $list->id]);
        $response = $this->actingAs($this->user)->put(route('contacts.update', [$list->id, $contact->id]), ['email' => 'chuck@norris.com']);

        $this->assertDatabaseHas('contacts', ['email' => 'chuck@norris.com']);
    }

    /** @test */
    public function deleteContact()
    {
        $list = factory(Lists::class)->create();

        $contact1 = factory(Contact::class)->create(['list_id' => $list->id]);
        $contact2 = factory(Contact::class)->create(['list_id' => $list->id]);
        $contact3 = factory(Contact::class)->create(['list_id' => $list->id]);

        $response = $this->actingAs($this->user)->delete(route('contacts.delete', $contact3->id));

        $this->assertEquals(2, Contact::count());
    }

    /** @test */
    public function showContactPage()
    {
        $list = factory(Lists::class)->create();

        $contact = factory(Contact::class)->create(['list_id' => $list->id]);

        $field = factory(Field::class)->create(['list_id' => $list->id, 'name' => 'City']);

        $contact->fields()->attach($field, ['value' => 'Travnik']);

        $response = $this->actingAs($this->user)->get(route('contacts.show', [$list->id, $contact->id]));

        $response->assertSuccessful();
    }
}
