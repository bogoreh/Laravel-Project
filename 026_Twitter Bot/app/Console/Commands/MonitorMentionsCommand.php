<?php

namespace App\Console\Commands;

use App\Services\Twitter\MentionService;
use Illuminate\Console\Command;

class MonitorMentionsCommand extends Command
{
    protected $signature = 'twitter:monitor-mentions';
    protected $description = 'Monitor and reply to mentions';

    public function handle(MentionService $mentionService): int
    {
        $this->info('Monitoring mentions...');
        
        try {
            $repliedCount = $mentionService->monitorAndReply();
            
            if ($repliedCount > 0) {
                $this->info("Replied to {$repliedCount} mention(s)");
            } else {
                $this->info('No new mentions to reply to');
            }
            
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Error monitoring mentions: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}