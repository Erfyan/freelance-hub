<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        return [
            'project_id'       => Project::factory(),
            'type'             => $this->faker->randomElement(['income', 'expense']),
            'amount'           => $this->faker->randomFloat(2, 10000, 2000000),
            'description'      => $this->faker->sentence(),
            'transaction_date' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'payment_proof'    => null,
        ];
    }

    public function income(): static
    {
        return $this->state(['type' => 'income']);
    }

    public function expense(): static
    {
        return $this->state(['type' => 'expense']);
    }
}
