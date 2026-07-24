<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function guest_cannot_access_clients(): void
    {
        $this->get(route('clients.index'))->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_view_clients_page(): void
    {
        $this->actingAs($this->user)
            ->get(route('clients.index'))
            ->assertStatus(200)
            ->assertViewIs('clients.index');
    }

    /** @test */
    public function user_can_create_a_client(): void
    {
        $this->actingAs($this->user)
            ->post(route('clients.store'), [
                'name'  => 'Budi Santoso',
                'phone' => '081234567890',
                'email' => 'budi@example.com',
                'notes' => 'Klien reguler',
            ])
            ->assertRedirect(route('clients.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('clients', [
            'name'  => 'Budi Santoso',
            'email' => 'budi@example.com',
        ]);
    }

    /** @test */
    public function client_name_is_required(): void
    {
        $this->actingAs($this->user)
            ->post(route('clients.store'), ['name' => ''])
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_can_view_a_client(): void
    {
        $client = Client::factory()->create();

        $this->actingAs($this->user)
            ->get(route('clients.show', $client))
            ->assertStatus(200)
            ->assertSee($client->name);
    }

    /** @test */
    public function user_can_update_a_client(): void
    {
        $client = Client::factory()->create(['name' => 'Nama Lama']);

        $this->actingAs($this->user)
            ->patch(route('clients.update', $client), [
                'name'  => 'Nama Baru',
                'phone' => $client->phone,
                'email' => $client->email,
            ])
            ->assertRedirect(route('clients.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('clients', ['id' => $client->id, 'name' => 'Nama Baru']);
    }

    /** @test */
    public function user_can_delete_a_client(): void
    {
        $client = Client::factory()->create();

        $this->actingAs($this->user)
            ->delete(route('clients.destroy', $client))
            ->assertRedirect(route('clients.index'))
            ->assertSessionHas('success');

        $this->assertSoftDeleted('clients', ['id' => $client->id]);
    }
}
