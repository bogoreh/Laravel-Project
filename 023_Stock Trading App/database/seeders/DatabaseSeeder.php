<?php

namespace Database\Seeders;

use App\Models\Stock;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'balance' => 50000.00,
        ]);

        // Create sample stocks
        $stocks = [
            [
                'symbol' => 'AAPL',
                'company_name' => 'Apple Inc.',
                'current_price' => 175.25,
                'change' => 2.15,
                'change_percent' => 1.24,
                'volume' => 58203100,
                'high' => 176.80,
                'low' => 172.12,
                'open' => 173.50,
                'previous_close' => 173.10,
            ],
            [
                'symbol' => 'GOOGL',
                'company_name' => 'Alphabet Inc.',
                'current_price' => 138.75,
                'change' => -1.25,
                'change_percent' => -0.89,
                'volume' => 28751200,
                'high' => 140.20,
                'low' => 137.85,
                'open' => 139.50,
                'previous_close' => 140.00,
            ],
            [
                'symbol' => 'MSFT',
                'company_name' => 'Microsoft Corporation',
                'current_price' => 330.42,
                'change' => 5.20,
                'change_percent' => 1.60,
                'volume' => 24578100,
                'high' => 332.15,
                'low' => 327.80,
                'open' => 328.50,
                'previous_close' => 325.22,
            ],
            [
                'symbol' => 'TSLA',
                'company_name' => 'Tesla Inc.',
                'current_price' => 210.15,
                'change' => 8.75,
                'change_percent' => 4.35,
                'volume' => 98124500,
                'high' => 212.80,
                'low' => 204.50,
                'open' => 205.75,
                'previous_close' => 201.40,
            ],
            [
                'symbol' => 'AMZN',
                'company_name' => 'Amazon.com Inc.',
                'current_price' => 145.80,
                'change' => 1.20,
                'change_percent' => 0.83,
                'volume' => 45238900,
                'high' => 146.95,
                'low' => 144.25,
                'open' => 145.10,
                'previous_close' => 144.60,
            ],
            [
                'symbol' => 'META',
                'company_name' => 'Meta Platforms Inc.',
                'current_price' => 310.25,
                'change' => -2.15,
                'change_percent' => -0.69,
                'volume' => 18745200,
                'high' => 314.80,
                'low' => 308.40,
                'open' => 312.50,
                'previous_close' => 312.40,
            ],
            [
                'symbol' => 'NVDA',
                'company_name' => 'NVIDIA Corporation',
                'current_price' => 485.75,
                'change' => 15.25,
                'change_percent' => 3.24,
                'volume' => 52478100,
                'high' => 488.90,
                'low' => 475.20,
                'open' => 478.50,
                'previous_close' => 470.50,
            ],
            [
                'symbol' => 'JPM',
                'company_name' => 'JPMorgan Chase & Co.',
                'current_price' => 155.40,
                'change' => 0.80,
                'change_percent' => 0.52,
                'volume' => 12457800,
                'high' => 156.25,
                'low' => 154.10,
                'open' => 154.80,
                'previous_close' => 154.60,
            ],
        ];

        foreach ($stocks as $stock) {
            Stock::create($stock);
        }

        // Create 5 more test users
        User::factory(5)->create([
            'balance' => 10000.00,
        ]);
    }
}