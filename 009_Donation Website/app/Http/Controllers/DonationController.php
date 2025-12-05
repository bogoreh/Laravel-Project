<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Campaign;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function create($campaignId = null)
    {
        $campaign = $campaignId ? Campaign::findOrFail($campaignId) : null;
        $suggestedAmounts = [10, 25, 50, 100, 250, 500];
        
        return view('donations.create', compact('campaign', 'suggestedAmounts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'donor_name' => 'required|string|max:255',
            'email' => 'required|email',
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|in:card,paypal,bank',
            'is_anonymous' => 'boolean',
            'message' => 'nullable|string|max:500',
            'campaign_id' => 'nullable|exists:campaigns,id'
        ]);

        // For demo, we'll mark as completed immediately
        $validated['status'] = 'completed';
        $validated['transaction_id'] = 'DEMO-' . strtoupper(uniqid());

        $donation = Donation::create($validated);

        // Update campaign total if specified
        if ($request->campaign_id) {
            $campaign = Campaign::find($request->campaign_id);
            $campaign->increment('current_amount', $validated['amount']);
        }

        return redirect()->route('donations.success', $donation->id);
    }

    public function success(Donation $donation)
    {
        return view('donations.success', compact('donation'));
    }
}