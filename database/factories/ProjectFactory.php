<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            'category'        => 'personal',
            'client_id'       => null,
            'title'           => $this->faker->sentence(3),
            'type'            => $this->faker->randomElement(['joki', 'aplikasi']),
            'status'          => $this->faker->randomElement(['todo', 'in_progress', 'on_hold', 'done']),
            'deadline'        => $this->faker->optional()->dateTimeBetween('now', '+3 months'),
            'estimated_hours' => $this->faker->optional()->numberBetween(1, 100),
            'budget'          => $this->faker->optional()->randomFloat(2, 50000, 5000000),
        ];
    }
}
