<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\TimeLog;
use Illuminate\Database\Eloquent\Factories\Factory;

class TimeLogFactory extends Factory
{
    protected $model = TimeLog::class;

    public function definition(): array
    {
        $startTime = $this->faker->dateTimeBetween('-1 week', 'now');
        $endTime   = (clone $startTime)->modify('+' . $this->faker->numberBetween(10, 120) . ' minutes');

        return [
            'project_id'       => Project::factory(),
            'start_time'       => $startTime,
            'end_time'         => $endTime,
            'duration_minutes' => (int) (($endTime->getTimestamp() - $startTime->getTimestamp()) / 60),
            'is_running'       => false,
            'note'             => $this->faker->optional()->sentence(),
        ];
    }

    public function running(): static
    {
        return $this->state(['end_time' => null, 'duration_minutes' => null, 'is_running' => true]);
    }
}
