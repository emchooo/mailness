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

        $response = $this->get('/lists/'.$list->id);

        $response->assertViewHas('contacts');
    }

    /** @test */
    public function createNewContactAndAttachToList()
    {
        $list = factory(Lists::class)->create();
        $contact = factory(Contact::class)->create();

        $list->contacts()->attach($contact);

        $this->assertEquals($list->contacts[0]->id, $contact->id);
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

        $response = $this->post('/lists/'.$list->id.'/contacts', [ 'email' => 'tom@sawyer.com' ]);
        $response = $this->post('/lists/'.$list->id.'/contacts', [ 'email' => 'tom@sawyer.com' ]);
        $response = $this->post('/lists/'.$list->id.'/contacts', [ 'email' => 'tomy@sawyer.com' ]);

        $this->assertEquals(2, $list->contacts->count());
    }

    /** @test */
    public function itIsPossibleToAddSameContactEmailToDifferentLists()
    {
        $list = factory(Lists::class)->create();
        $list2 = factory(Lists::class)->create();

        $response = $this->post('/lists/'.$list->id.'/contacts', [ 'email' => 'tom@sawyer.com']);
        $response = $this->post('/lists/'.$list2->id.'/contacts', [ 'email' => 'tom@sawyer.com']);

        $contacts = Contact::all();

        $this->assertEquals(2, $contacts->count());
    }
    
    
}
