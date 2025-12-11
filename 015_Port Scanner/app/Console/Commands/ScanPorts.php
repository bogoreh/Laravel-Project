<?php

namespace App\Console\Commands;

use App\Services\PortScannerService;
use Illuminate\Console\Command;

class ScanPorts extends Command
{
    protected $signature = 'port:scan {host} {--ports=} {--type=common}';
    protected $description = 'Scan ports on a host';
    
    protected $scannerService;
    
    public function __construct(PortScannerService $scannerService)
    {
        parent::__construct();
        $this->scannerService = $scannerService;
    }
    
    public function handle()
    {
        $host = $this->argument('host');
        $type = $this->option('type');
        $ports = [];
        
        if ($this->option('ports')) {
            $ports = array_map('intval', explode(',', $this->option('ports')));
        }
        
        $this->info("Scanning {$host}...");
        
        $results = $this->scannerService->scan($host, $ports, $type);
        
        $this->table(
            ['Port', 'Status', 'Service', 'Response Time', 'Description'],
            array_map(function($result) {
                return [
                    $result['port'],
                    $result['status'],
                    $result['service'],
                    $result['response_time'] . ' ms',
                    $result['description']
                ];
            }, $results)
        );
        
        $openPorts = count(array_filter($results, fn($r) => $r['status'] === 'Open'));
        $this->info("Found {$openPorts} open ports out of " . count($results) . " scanned.");
        
        return 0;
    }
}