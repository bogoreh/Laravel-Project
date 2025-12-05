<?php

namespace Database\Seeders;

use App\Models\Campaign;
use Illuminate\Database\Seeder;

class CampaignSeeder extends Seeder
{
    public function run()
    {
        $campaigns = [
            [
                'title' => 'Clean Water for Rural Communities',
                'description' => 'Help provide clean drinking water to villages in need. Every dollar provides 5 gallons of clean water.',
                'goal_amount' => 50000,
                'current_amount' => 32500,
                'end_date' => now()->addMonths(3),
                'is_active' => true,
            ],
            [
                'title' => 'Education for Underprivileged Children',
                'description' => 'Support education programs for children in underserved communities. Funds go toward books, supplies, and teacher training.',
                'goal_amount' => 75000,
                'current_amount' => 42000,
                'end_date' => now()->addMonths(4),
                'is_active' => true,
            ],
            [
                'title' => 'Disaster Relief Fund',
                'description' => 'Emergency fund to provide immediate assistance to communities affected by natural disasters.',
                'goal_amount' => 100000,
                'current_amount' => 68000,
                'end_date' => now()->addMonths(6),
                'is_active' => true,
            ],
        ];

        foreach ($campaigns as $campaign) {
            Campaign::create($campaign);
        }
    }
}