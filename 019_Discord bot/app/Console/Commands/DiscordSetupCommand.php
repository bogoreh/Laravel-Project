<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DiscordSetupCommand extends Command
{
    protected $signature = 'discord:setup';
    protected $description = 'Setup Discord bot configuration';

    public function handle()
    {
        $this->info('Discord Bot Setup');
        $this->info('=================');
        
        $token = $this->ask('Enter your Discord bot token');
        $prefix = $this->ask('Enter command prefix (default: !)', '!');
        
        $this->updateEnv([
            'DISCORD_TOKEN' => $token,
            'DISCORD_PREFIX' => $prefix,
        ]);
        
        $this->info('✅ Configuration updated!');
        $this->info('Run: php artisan discord:run');
    }
    
    private function updateEnv($values)
    {
        $envPath = base_path('.env');
        $envContent = file_get_contents($envPath);
        
        foreach ($values as $key => $value) {
            $pattern = "/^{$key}=.*/m";
            
            if (preg_match($pattern, $envContent)) {
                $envContent = preg_replace($pattern, "{$key}={$value}", $envContent);
            } else {
                $envContent .= "\n{$key}={$value}";
            }
        }
        
        file_put_contents($envPath, $envContent);
    }
}