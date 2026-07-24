<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function guest_cannot_access_projects(): void
    {
        $this->get(route('projects.index'))->assertRedirect(route('login'));
        $this->get(route('projects.create'))->assertRedirect(route('login'));
    }

    /** @test */
    public function authenticated_user_can_view_projects_page(): void
    {
        $this->actingAs($this->user)
            ->get(route('projects.index'))
            ->assertStatus(200)
            ->assertViewIs('projects.index');
    }

    /** @test */
    public function user_can_create_a_client_project(): void
    {
        $client = Client::factory()->create();

        $this->actingAs($this->user)
            ->post(route('projects.store'), [
                'category'        => 'client',
                'client_id'       => $client->id,
                'title'           => 'Proyek Test Klien',
                'type'            => 'joki',
                'status'          => 'todo',
                'deadline'        => now()->addDays(30)->format('Y-m-d'),
                'estimated_hours' => 10,
                'budget'          => 500000,
            ])
            ->assertRedirect(route('projects.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('projects', [
            'title'     => 'Proyek Test Klien',
            'category'  => 'client',
            'client_id' => $client->id,
        ]);
    }

    /** @test */
    public function user_can_create_a_personal_project_without_client(): void
    {
        $this->actingAs($this->user)
            ->post(route('projects.store'), [
                'category' => 'personal',
                'title'    => 'Proyek Pribadi Saya',
                'type'     => 'aplikasi',
                'status'   => 'todo',
            ])
            ->assertRedirect(route('projects.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('projects', [
            'title'     => 'Proyek Pribadi Saya',
            'category'  => 'personal',
            'client_id' => null,
        ]);
    }

    /** @test */
    public function client_project_without_client_id_fails_validation(): void
    {
        $this->actingAs($this->user)
            ->post(route('projects.store'), [
                'category' => 'client',
                'title'    => 'Proyek Tanpa Klien',
                'type'     => 'joki',
            ])
            ->assertSessionHasErrors('client_id');
    }

    /** @test */
    public function user_can_view_a_project(): void
    {
        $project = Project::factory()->create(['category' => 'personal']);

        $this->actingAs($this->user)
            ->get(route('projects.show', $project))
            ->assertStatus(200)
            ->assertViewIs('projects.show')
            ->assertSee($project->title);
    }

    /** @test */
    public function user_can_update_a_project(): void
    {
        $project = Project::factory()->create(['category' => 'personal', 'status' => 'todo']);

        $this->actingAs($this->user)
            ->patch(route('projects.update', $project), [
                'category' => 'personal',
                'title'    => 'Judul Diperbarui',
                'type'     => 'aplikasi',
                'status'   => 'in_progress',
            ])
            ->assertRedirect(route('projects.show', $project))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('projects', [
            'id'     => $project->id,
            'title'  => 'Judul Diperbarui',
            'status' => 'in_progress',
        ]);
    }

    /** @test */
    public function user_can_delete_a_project(): void
    {
        $project = Project::factory()->create(['category' => 'personal']);

        $this->actingAs($this->user)
            ->delete(route('projects.destroy', $project))
            ->assertRedirect(route('projects.index'))
            ->assertSessionHas('success');

        $this->assertSoftDeleted('projects', ['id' => $project->id]);
    }

    /** @test */
    public function project_index_can_be_filtered_by_category(): void
    {
        Project::factory()->create(['category' => 'personal', 'title' => 'Personal Project']);
        $client = Client::factory()->create();
        Project::factory()->create(['category' => 'client', 'client_id' => $client->id, 'title' => 'Client Project']);

        $response = $this->actingAs($this->user)
            ->get(route('projects.index', ['category' => 'personal']));

        $response->assertSee('Personal Project')->assertDontSee('Client Project');
    }

    /** @test */
    public function project_index_can_be_searched(): void
    {
        Project::factory()->create(['category' => 'personal', 'title' => 'Project Alpha']);
        Project::factory()->create(['category' => 'personal', 'title' => 'Project Beta']);

        $response = $this->actingAs($this->user)
            ->get(route('projects.index', ['search' => 'Alpha']));

        $response->assertSee('Project Alpha')->assertDontSee('Project Beta');
    }
}
