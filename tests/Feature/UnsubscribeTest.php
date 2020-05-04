<?php

namespace Tests\Feature;

use App\Contact;
use App\Lists;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UnsubscribeTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function userCanUnsubscribe()
    {
        $list = factory(Lists::class)->create();
        $contact = factory(Contact::class)->create(['list_id' => $list->id]);
        $contact2 = factory(Contact::class)->create(['list_id' => $list->id]);

        $this->assertEquals(2, Contact::count());

        $this->get(route('unsubscribe.contact', $contact2->uuid));

        $this->assertEquals(1, Contact::subscribed()->count());
    }
}
