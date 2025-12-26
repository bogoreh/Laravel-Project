<?php

namespace App\Console\Commands;

use App\Services\ModelTrainerService;
use Illuminate\Console\Command;

class TrainSpamModel extends Command
{
    protected $signature = 'spam:train';
    protected $description = 'Train the spam classification model';
    
    public function handle(ModelTrainerService $trainer)
    {
        $this->info('Training spam classification model...');
        
        try {
            $result = $trainer->train();
            
            $this->info('Model trained successfully!');
            $this->info('Accuracy: ' . number_format($result['accuracy'] * 100, 2) . '%');
            $this->info('Samples: ' . $result['samples']);
            $this->info('Features: ' . implode(', ', $result['features']));
            
        } catch (\Exception $e) {
            $this->error('Training failed: ' . $e->getMessage());
        }
    }
}