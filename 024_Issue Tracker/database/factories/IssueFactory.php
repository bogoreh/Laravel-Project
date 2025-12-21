<?php

namespace Database\Factories;

use App\Models\Issue;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class IssueFactory extends Factory
{
    protected $model = Issue::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraphs(3, true),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high', 'critical']),
            'status' => $this->faker->randomElement(['open', 'in_progress', 'resolved', 'closed']),
            'type' => $this->faker->randomElement(['bug', 'feature', 'task', 'improvement']),
            'project_id' => Project::factory(),
            'assigned_to' => User::factory(),
            'reported_by' => User::factory(),
            'due_date' => $this->faker->optional()->dateTimeBetween('now', '+1 month'),
        ];
    }
}