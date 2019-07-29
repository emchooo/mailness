<?php

namespace Tests\Feature;

use App\Lists;
use App\Contact;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ContactsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function seeContactsPage()
    {
        $list = factory(Lists::class)->create();

        $response = $this->get(route('contacts.index', $list->id));

        $response->assertViewHas('list');
    }

    /** @test */
    public function createNewContactAndAttachToList()
    {
        $list = factory(Lists::class)->create();

        $response = $this->post(route('contacts.store', $list->id), [ 'email' => 'billy@kid.com' ]);

        $response->assertSuccessful();
    }

    /** @test */
    public function seeContactCreateForm()
    {
        $list = factory(Lists::class)->create();

        $response = $this->get(route('contacts.create', $list->id));

        $response->assertSeeText('Create new contact');
    }

    /** @test */
    public function dontAttachSameContactToList()
    {
        $list = factory(Lists::class)->create();

        $response = $this->post(route('contacts.store', $list->id), [ 'email' => 'tom@sawyer.com' ]);
        $response = $this->post(route('contacts.store', $list->id), [ 'email' => 'tom@sawyer.com' ]);
        $response = $this->post(route('contacts.store', $list->id), [ 'email' => 'tomy@sawyer.com' ]);

        $this->assertEquals(2, Contact::count());
    }

    /** @test */
    public function itIsPossibleToAddSameContactEmailToDifferentLists()
    {
        $list = factory(Lists::class)->create();
        $list2 = factory(Lists::class)->create();

        $response = $this->post(route('contacts.store',$list->id), [ 'email' => 'tom@sawyer.com']);
        $response = $this->post(route('contacts.store',$list2->id), [ 'email' => 'tom@sawyer.com']);

        $contacts = Contact::all();

        $this->assertEquals(2, $contacts->count());
    }

    /** @test */
    public function cannotCreateContactWithoutEmail()
    {
        $list = factory(Lists::class)->create();

        $response = $this->post(route('contacts.store', $list->id));

        $response->assertSessionHasErrors();
    }

    /** @test */
    public function emailFieldMustBeValidEmailAddress()
    {
        $list = factory(Lists::class)->create();
        
        $response = $this->post(route('contacts.store', $list->id), [ 'email' => 'emirgmail.com' ]);

        $response->assertSessionHasErrors();
    }

    /** @test */
    public function thereIsEditContactPage()
    {
        $list = factory(Lists::class)->create();
        $contact = factory(Contact::class)->create([ 'list_id' => $list->id ]);

        $response = $this->get(route('contacts.edit', [ $list->id, $contact->id ]));

        $response->assertSuccessful()->assertSeeText('Edit contact');
    }
   
    /** @test */
    public function updateContact()
    {
        $list = factory(Lists::class)->create();
        $contact = factory(Contact::class)->create([ 'list_id' => $list->id ]);
        $response = $this->put(route('contacts.update', [ $list->id, $contact->id ]),[ 'email' => 'chuck@norris.com' ]);

        $this->assertDatabaseHas('contacts', [ 'email' => 'chuck@norris.com' ]);
    }
    
}
