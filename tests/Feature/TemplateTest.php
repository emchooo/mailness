<?php

namespace Tests\Feature;

use App\Models\Template;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class TemplateTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    /** @test */
    public function openTemplatesListPage()
    {
        $template = factory(Template::class)->create();

        $response = $this->actingAs($this->user)->get(route('templates.index'));

        $response->assertSuccessful()->assertSeeText($template->name);
    }

    /** @test */
    public function openTemplateCreatePage()
    {
        $template = factory(Template::class)->create();

        $response = $this->actingAs($this->user)->get(route('templates.create'));

        $response->assertSuccessful()->assertSeeText('Create new template');
    }

    /** @test */
    public function saveNewTemplate()
    {
        $response = $this->actingAs($this->user)->post(route('templates.store', ['name' => 'My first template', 'content' => 'This is content']));

        $template = Template::first();

        $this->assertEquals('My first template', $template->name);
    }

    /** @test */
    public function openSingleTemplate()
    {
        $template = factory(Template::class)->create();

        $response = $this->actingAs($this->user)->get(route('templates.show', $template->id));

        $response->assertSuccessful()->assertSeeText($template->name);
    }

    /** @test */
    public function openEditTemplatePage()
    {
        $template = factory(Template::class)->create();

        $response = $this->actingAs($this->user)->get(route('templates.edit', $template->id));

        $response->assertSuccessful()->assertSeeText($template->name);
    }

    /** @test */
    public function updateTemplate()
    {
        $template = factory(Template::class)->create();

        $response = $this->actingAs($this->user)->put(route('templates.update', $template->id), ['name' => 'Updated template', 'content' => 'Updated content']);

        $template = Template::first();

        $this->assertEquals($template->name, 'Updated template');
    }

    /** @test */
    public function deleteTemplate()
    {
        $template = factory(Template::class)->create();

        $response = $this->actingAs($this->user)->delete(route('templates.delete', $template->id));

        $this->assertEquals(0, Template::count());
    }
}
