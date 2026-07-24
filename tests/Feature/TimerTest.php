<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\TimeLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TimerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function user_can_view_timer_page(): void
    {
        $this->actingAs($this->user)
            ->get(route('timer.index'))
            ->assertStatus(200)
            ->assertViewIs('timer.index');
    }

    /** @test */
    public function user_can_start_a_timer_for_a_project(): void
    {
        $project = Project::factory()->create(['category' => 'personal', 'status' => 'in_progress']);

        $this->actingAs($this->user)
            ->post(route('timer.start', $project))
            ->assertRedirect();

        $this->assertDatabaseHas('time_logs', [
            'project_id' => $project->id,
            'is_running' => 1,
        ]);
    }

    /** @test */
    public function user_cannot_start_timer_when_one_is_already_running(): void
    {
        $project1 = Project::factory()->create(['category' => 'personal']);
        $project2 = Project::factory()->create(['category' => 'personal']);

        // Start first timer
        $this->actingAs($this->user)->post(route('timer.start', $project1));

        // Try to start second timer
        $this->actingAs($this->user)
            ->post(route('timer.start', $project2))
            ->assertRedirect();

        // Only one running timer should exist
        $this->assertEquals(1, TimeLog::where('is_running', true)->count());
    }

    /** @test */
    public function user_can_stop_a_running_timer(): void
    {
        $project = Project::factory()->create(['category' => 'personal']);
        $timeLog = TimeLog::factory()->create([
            'project_id' => $project->id,
            'is_running'  => true,
            'start_time'  => now()->subMinutes(30),
        ]);

        $this->actingAs($this->user)
            ->post(route('timer.stop'))
            ->assertRedirect();

        $timeLog->refresh();
        $this->assertFalse($timeLog->is_running);
        $this->assertNotNull($timeLog->end_time);
        $this->assertGreaterThan(0, $timeLog->duration_minutes);
    }

    /** @test */
    public function stopping_timer_calculates_duration_correctly(): void
    {
        $project = Project::factory()->create(['category' => 'personal']);
        TimeLog::factory()->create([
            'project_id' => $project->id,
            'is_running'  => true,
            'start_time'  => now()->subMinutes(60),
        ]);

        $this->actingAs($this->user)->post(route('timer.stop'));

        $timeLog = TimeLog::where('project_id', $project->id)->first();
        // Should be approximately 60 minutes (within 2 min margin)
        $this->assertBetween(58, 62, $timeLog->duration_minutes);
    }

    /** @test */
    public function timer_status_endpoint_returns_active_timer(): void
    {
        $project = Project::factory()->create(['category' => 'personal']);
        TimeLog::factory()->create([
            'project_id' => $project->id,
            'is_running'  => true,
            'start_time'  => now()->subMinutes(5),
        ]);

        $this->actingAs($this->user)
            ->getJson(route('timer.status'))
            ->assertStatus(200)
            ->assertJsonPath('active', true);
    }

    /** @test */
    public function timer_status_returns_inactive_when_no_timer(): void
    {
        $this->actingAs($this->user)
            ->getJson(route('timer.status'))
            ->assertStatus(200)
            ->assertJsonPath('active', false);
    }

    protected function assertBetween(int $min, int $max, int $actual): void
    {
        $this->assertGreaterThanOrEqual($min, $actual, "Expected $actual to be >= $min");
        $this->assertLessThanOrEqual($max, $actual, "Expected $actual to be <= $max");
    }
}
