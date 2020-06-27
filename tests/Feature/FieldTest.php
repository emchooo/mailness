<?php

namespace Tests\Feature;

use App\Models\Field;
use App\Models\Lists;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FieldTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    /** @test */
    public function displayAllFieldsForListPage()
    {
        $list = factory(Lists::class)->create();

        $field = factory(Field::class)->create(['list_id' => $list->id]);

        $response = $this->actingAs($this->user)->get(route('fields.index', $list->id));

        $response->assertSuccessful()->assertSeeText($field->name);
    }

    /** @test */
    public function openCreateFieldPage()
    {
        $list = factory(Lists::class)->create();

        $response = $this->actingAs($this->user)->get(route('fields.create', $list->id));

        $response->assertSuccessful()->assertSeeText('Create new field');
    }

    /** @test */
    public function addNewFieldToList()
    {
        $list = factory(Lists::class)->create();

        $response = $this->actingAs($this->user)->post(route('fields.store', $list->id), ['name' => 'City']);
        $response = $this->actingAs($this->user)->post(route('fields.store', $list->id), ['name' => 'Name']);

        $this->assertEquals(2, Field::count());
    }

    /** @test */
    public function openEditPageForField()
    {
        $list = factory(Lists::class)->create();

        $field = factory(Field::class)->create(['list_id' => $list->id]);

        $response = $this->actingAs($this->user)->get(route('fields.edit', [$list->id, $field->id]));

        $response->assertSuccessful();
    }

    /** @test */
    public function updateField()
    {
        $list = factory(Lists::class)->create();

        $field = factory(Field::class)->create(['list_id' => $list->id, 'name' => 'Town']);

        $response = $this->actingAs($this->user)->put(route('fields.update', [$list->id, $field->id]), ['name' => 'City']);

        $this->assertEquals('City', Field::first()->name);
    }

    /** @test */
    public function deleteField()
    {
        $list = factory(Lists::class)->create();

        $field = factory(Field::class)->create(['list_id' => $list->id]);
        $field2 = factory(Field::class)->create(['list_id' => $list->id]);

        $response = $this->actingAs($this->user)->delete(route('fields.delete', [$list->id, $field->id]));

        $this->assertEquals(1, Field::count());
    }
}
