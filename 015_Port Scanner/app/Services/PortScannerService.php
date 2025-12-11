<?php

namespace App\Services;

class PortScannerService
{
    private $timeout = 2; // Timeout in seconds
    
    public function scan(string $host, array $ports = [], string $type = 'common'): array
    {
        $results = [];
        $portsToScan = $this->getPortsToScan($ports, $type);
        
        foreach ($portsToScan as $port) {
            $result = $this->checkPort($host, $port);
            $results[] = $result;
        }
        
        return $results;
    }
    
    private function getPortsToScan(array $ports, string $type): array
    {
        if (!empty($ports)) {
            return $ports;
        }
        
        $commonPorts = [
            20, 21, 22, 23, 25, 53, 80, 110, 115, 135,
            139, 143, 443, 445, 993, 995, 1433, 3306,
            3389, 5432, 5900, 8080, 8443
        ];
        
        $allPorts = range(1, 1024);
        
        return $type === 'common' ? $commonPorts : $allPorts;
    }
    
    private function checkPort(string $host, int $port): array
    {
        $startTime = microtime(true);
        $connection = @fsockopen($host, $port, $errno, $errstr, $this->timeout);
        $endTime = microtime(true);
        $responseTime = round(($endTime - $startTime) * 1000, 2); // Convert to ms
        
        $status = false;
        $service = $this->getServiceName($port);
        
        if (is_resource($connection)) {
            fclose($connection);
            $status = true;
        }
        
        return [
            'port' => $port,
            'status' => $status ? 'Open' : 'Closed',
            'service' => $service,
            'response_time' => $responseTime,
            'description' => $this->getPortDescription($port)
        ];
    }
    
    private function getServiceName(int $port): string
    {
        $services = [
            20 => 'FTP Data',
            21 => 'FTP Control',
            22 => 'SSH',
            23 => 'Telnet',
            25 => 'SMTP',
            53 => 'DNS',
            80 => 'HTTP',
            110 => 'POP3',
            143 => 'IMAP',
            443 => 'HTTPS',
            3306 => 'MySQL',
            5432 => 'PostgreSQL',
            27017 => 'MongoDB',
            6379 => 'Redis',
            8080 => 'HTTP Proxy',
            8443 => 'HTTPS Alt'
        ];
        
        return $services[$port] ?? 'Unknown';
    }
    
    private function getPortDescription(int $port): string
    {
        $descriptions = [
            22 => 'Secure Shell - Secure remote access',
            80 => 'HTTP - Web traffic',
            443 => 'HTTPS - Secure web traffic',
            3306 => 'MySQL Database',
            5432 => 'PostgreSQL Database',
            27017 => 'MongoDB Database',
            6379 => 'Redis Cache'
        ];
        
        return $descriptions[$port] ?? 'No description available';
    }
}