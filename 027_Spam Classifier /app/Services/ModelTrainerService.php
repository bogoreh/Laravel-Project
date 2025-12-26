<?php

namespace App\Services;

use App\Models\TrainingData;
use Illuminate\Support\Facades\Log;

class ModelTrainerService
{
    private $classifier;
    
    public function __construct()
    {
        $this->classifier = new SpamClassifierService();
    }
    
    public function train(): array
    {
        $trainingData = TrainingData::all();
        
        if ($trainingData->isEmpty()) {
            throw new \Exception('No training data available');
        }
        
        $features = [];
        $labels = [];
        
        foreach ($trainingData as $data) {
            $features[] = $this->classifier->extractFeatures($data->content);
            $labels[] = $data->label === 'spam' ? 1 : 0;
        }
        
        $model = $this->trainModel($features, $labels);
        
        $this->saveModel($model);
        
        return [
            'accuracy' => $this->testModel($model, $features, $labels),
            'samples' => count($trainingData),
            'features' => array_keys($features[0] ?? []),
        ];
    }
    
    private function trainModel(array $features, array $labels): array
    {
        // Simple linear regression weights for features
        $featureWeights = [];
        $featureNames = array_keys($features[0] ?? []);
        
        foreach ($featureNames as $feature) {
            $featureValues = array_column($features, $feature);
            $featureWeights[$feature] = $this->calculateWeight($featureValues, $labels);
        }
        
        return [
            'feature_weights' => $featureWeights,
            'trained_at' => now()->toDateTimeString(),
            'total_samples' => count($features),
        ];
    }
    
    private function calculateWeight(array $featureValues, array $labels): float
    {
        // Simple correlation calculation
        $meanX = array_sum($featureValues) / count($featureValues);
        $meanY = array_sum($labels) / count($labels);
        
        $numerator = 0;
        $denominatorX = 0;
        
        for ($i = 0; $i < count($featureValues); $i++) {
            $numerator += ($featureValues[$i] - $meanX) * ($labels[$i] - $meanY);
            $denominatorX += pow($featureValues[$i] - $meanX, 2);
        }
        
        return $denominatorX != 0 ? $numerator / $denominatorX : 0;
    }
    
    private function testModel(array $model, array $features, array $labels): float
    {
        $correct = 0;
        
        for ($i = 0; $i < count($features); $i++) {
            $prediction = $this->classifier->calculateSpamProbability($features[$i]);
            $predictedLabel = $prediction >= 0.5 ? 1 : 0;
            
            if ($predictedLabel === $labels[$i]) {
                $correct++;
            }
        }
        
        return count($features) > 0 ? $correct / count($features) : 0;
    }
    
    private function saveModel(array $model): void
    {
        file_put_contents(config('spam-classifier.model_path'), json_encode($model, JSON_PRETTY_PRINT));
    }
}