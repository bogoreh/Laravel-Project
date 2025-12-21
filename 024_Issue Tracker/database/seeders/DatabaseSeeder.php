<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Issue;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@issuetracker.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        // Create regular users
        $users = User::factory(5)->create();

        // Create projects
        $projects = Project::factory(3)->create([
            'created_by' => $admin->id
        ]);

        // Create issues for each project
        foreach ($projects as $project) {
            $issues = Issue::factory(10)->create([
                'project_id' => $project->id,
                'reported_by' => $users->random()->id,
                'assigned_to' => $users->random()->id,
            ]);

            // Create comments for each issue
            foreach ($issues as $issue) {
                Comment::factory(3)->create([
                    'issue_id' => $issue->id,
                    'user_id' => $users->random()->id,
                ]);
            }
        }
    }
}