<?php

namespace App\Http\Controllers;

use App\Services\PortScannerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PortScannerController extends Controller
{
    protected $scannerService;
    
    public function __construct(PortScannerService $scannerService)
    {
        $this->scannerService = $scannerService;
    }
    
    public function index()
    {
        return view('scanner');
    }
    
    public function scan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'host' => 'required|string|max:255',
            'ports' => 'nullable|string',
            'scan_type' => 'required|in:common,custom,range'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }
        
        $host = $request->input('host');
        $scanType = $request->input('scan_type');
        $ports = [];
        
        if ($scanType === 'custom' && $request->filled('ports')) {
            $ports = array_map('intval', explode(',', $request->input('ports')));
        } elseif ($scanType === 'range') {
            $range = explode('-', $request->input('port_range'));
            if (count($range) === 2) {
                $ports = range($range[0], $range[1]);
            }
        }
        
        try {
            $results = $this->scannerService->scan($host, $ports, $scanType);
            
            return response()->json([
                'success' => true,
                'host' => $host,
                'total_ports' => count($results),
                'open_ports' => count(array_filter($results, fn($r) => $r['status'] === 'Open')),
                'results' => $results
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Scan failed: ' . $e->getMessage()
            ]);
        }
    }
}