<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    /** @test */
    public function notLoggedUserCantSeeDashboard()
    {
        $response = $this->get(route('dashboard.show'));

        $response->assertStatus(302);
    }

    /** @test */
    public function loggedUserCanSeeDashboardPage()
    {
        $response = $this->actingAs($this->user)->get(route('dashboard.show'));

        $response->assertStatus(200);
    }
}
