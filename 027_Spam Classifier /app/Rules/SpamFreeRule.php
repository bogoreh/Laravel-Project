<?php

namespace App\Rules;

use App\Services\SpamClassifierService;
use Illuminate\Contracts\Validation\Rule;

class SpamFreeRule implements Rule
{
    private $classifier;
    
    public function __construct()
    {
        $this->classifier = new SpamClassifierService();
    }
    
    public function passes($attribute, $value)
    {
        if (!$this->classifier->modelExists()) {
            return true; // Allow if no model trained
        }
        
        $result = $this->classifier->predict($value);
        return !$result['is_spam'];
    }
    
    public function message()
    {
        return 'The content appears to be spam.';
    }
}