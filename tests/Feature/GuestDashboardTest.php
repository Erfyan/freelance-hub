<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Project;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuestDashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_access_public_dashboard_without_login(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200)
            ->assertViewIs('public.index')
            ->assertSee('Public Showcase')
            ->assertSee('Status Proyek Real-Time');
    }

    /** @test */
    public function public_dashboard_displays_only_in_progress_and_on_hold_projects(): void
    {
        $client = Client::factory()->create();
        $projectDone = Project::factory()->create([
            'title'     => 'Proyek Selesai Super',
            'status'    => 'done',
            'client_id' => $client->id,
            'category'  => 'client',
        ]);
        $projectProgress = Project::factory()->create([
            'title'    => 'Proyek Dalam Pengerjaan',
            'status'   => 'in_progress',
            'category' => 'personal',
        ]);
        $projectHold = Project::factory()->create([
            'title'    => 'Proyek Tertunda Klien',
            'status'   => 'on_hold',
            'category' => 'client',
            'client_id' => $client->id,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200)
            ->assertSee('Proyek Dalam Pengerjaan')
            ->assertSee('Proyek Tertunda Klien')
            ->assertDontSee('Proyek Selesai Super');
    }

    /** @test */
    public function public_dashboard_hides_financial_transaction_details(): void
    {
        $project = Project::factory()->create(['title' => 'Secret Project', 'budget' => 99999999, 'status' => 'in_progress']);
        Transaction::factory()->create([
            'project_id'  => $project->id,
            'amount'      => 50000000,
            'description' => 'Rahasia Keuangan Klien',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200)
            ->assertSee('Secret Project')
            ->assertDontSee('50000000')
            ->assertDontSee('Rahasia Keuangan Klien');
    }

    /** @test */
    public function guest_cannot_access_admin_crud_routes(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
        $this->get('/projects')->assertRedirect('/login');
        $this->get('/clients')->assertRedirect('/login');
        $this->post('/projects', ['title' => 'Illegal Project'])->assertRedirect('/login');
    }
}
