<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function root_redirects_to_dashboard(): void
    {
        $this->get('/')->assertRedirect(route('dashboard'));
    }

    /** @test */
    public function root_redirects_authenticated_user_to_dashboard(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user)->get('/')->assertRedirect(route('dashboard'));
    }

    /** @test */
    public function dashboard_is_accessible_when_authenticated(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user)->get(route('dashboard'))->assertStatus(200);
    }

    /** @test */
    public function login_page_is_accessible_to_guests(): void
    {
        $this->get(route('login'))->assertStatus(200);
    }

    /** @test */
    public function register_page_is_inaccessible(): void
    {
        // We intentionally disabled registration - route should return 404
        $this->get('/register')->assertStatus(404);
    }
}
