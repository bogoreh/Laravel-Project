<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SpamClassifierService
{
    private $model = null;
    private $config;
    
    public function __construct()
    {
        $this->config = config('spam-classifier');
        $this->loadModel();
    }
    
    public function predict(string $text): array
    {
        $features = $this->extractFeatures($text);
        $spamProbability = $this->calculateSpamProbability($features);
        $isSpam = $spamProbability >= $this->config['threshold'];
        
        return [
            'is_spam' => $isSpam,
            'probability' => $spamProbability,
            'features' => $features,
            'words' => $this->tokenize($text),
        ];
    }
    
    private function extractFeatures(string $text): array
    {
        $words = $this->tokenize($text);
        
        $features = [
            'has_urgent' => Str::contains(strtolower($text), ['urgent', 'asap', 'immediately']),
            'has_money' => Str::contains(strtolower($text), ['money', 'cash', 'price', '$', 'free']),
            'has_links' => preg_match('/https?:\/\/\S+/', $text),
            'caps_ratio' => $this->getCapsRatio($text),
            'word_count' => count($words),
            'avg_word_length' => $this->getAvgWordLength($words),
            'spam_keywords' => $this->countSpamKeywords($words),
        ];
        
        return $features;
    }
    
    private function calculateSpamProbability(array $features): float
    {
        if (!$this->model) {
            return 0.5; // Default neutral probability if no model
        }
        
        $spamScore = 0;
        $totalWeight = 0;
        
        foreach ($features as $feature => $value) {
            if (isset($this->model['feature_weights'][$feature])) {
                $weight = $this->model['feature_weights'][$feature];
                $spamScore += $value * $weight;
                $totalWeight += abs($weight);
            }
        }
        
        if ($totalWeight > 0) {
            $probability = $spamScore / $totalWeight;
            return max(0, min(1, $probability));
        }
        
        return 0.5;
    }
    
    private function tokenize(string $text): array
    {
        $text = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $text);
        $words = preg_split('/\s+/', strtolower($text));
        
        return array_filter($words, function($word) {
            return strlen($word) >= $this->config['training']['min_word_length'] 
                && !in_array($word, $this->config['training']['stop_words']);
        });
    }
    
    private function getCapsRatio(string $text): float
    {
        if (strlen($text) === 0) return 0;
        
        $caps = preg_match_all('/[A-Z]/', $text);
        $total = preg_match_all('/[A-Za-z]/', $text);
        
        return $total > 0 ? $caps / $total : 0;
    }
    
    private function getAvgWordLength(array $words): float
    {
        if (empty($words)) return 0;
        
        $totalLength = array_sum(array_map('strlen', $words));
        return $totalLength / count($words);
    }
    
    private function countSpamKeywords(array $words): int
    {
        $spamKeywords = ['win', 'free', 'prize', 'offer', 'limited', 'click', 'guaranteed'];
        return count(array_intersect($words, $spamKeywords));
    }
    
    public function loadModel(): void
    {
        if (file_exists($this->config['model_path'])) {
            $this->model = json_decode(file_get_contents($this->config['model_path']), true);
        }
    }
    
    public function modelExists(): bool
    {
        return $this->model !== null;
    }
}