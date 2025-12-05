<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        $campaigns = Campaign::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
            
        $totalRaised = Campaign::sum('current_amount');
        $totalDonors = \App\Models\Donation::where('status', 'completed')->count();
        
        return view('pages.home', compact('campaigns', 'totalRaised', 'totalDonors'));
    }

    public function about()
    {
        return view('pages.about');
    }

    public function campaigns()
    {
        $campaigns = Campaign::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate(6);
            
        return view('pages.campaigns', compact('campaigns'));
    }
}