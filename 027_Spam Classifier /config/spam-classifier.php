<?php

return [
    'model_path' => storage_path('models/spam-classifier-model.json'),
    
    'threshold' => 0.7,
    
    'training' => [
        'min_word_length' => 2,
        'stop_words' => ['the', 'and', 'is', 'in', 'to', 'of', 'a', 'for'],
        'test_split' => 0.2, // 20% for testing
    ],
    
    'features' => [
        'use_keywords' => true,
        'use_patterns' => true,
        'use_links' => true,
        'use_caps_ratio' => true,
    ],
];