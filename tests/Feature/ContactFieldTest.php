<?php

namespace Tests\Feature;

use App\Contact;
use App\Field;
use App\Lists;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ContactFieldTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function addFeildsToContactFromList()
    {
        $list = factory(Lists::class)->create();

        $field = factory(Field::class)->create(['list_id' => $list->id, 'name' => 'City']);

        $contact = factory(Contact::class)->create(['list_id' => $list->id]);

        $contact->fields()->attach($field, ['value' => 'Travnik']);

        $this->assertEquals($contact->fields()->first()->name, 'City');
        $this->assertEquals($contact->fields()->first()->pivot->value, 'Travnik');
    }
}
