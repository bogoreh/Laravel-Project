<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $portfolio = Portfolio::where('user_id', $user->id)
            ->with('stock')
            ->get();
        
        $recentTransactions = Transaction::where('user_id', $user->id)
            ->with('stock')
            ->latest()
            ->take(5)
            ->get();
        
        $totalInvestment = $portfolio->sum('total_investment');
        $currentValue = $portfolio->sum('current_value');
        $totalProfitLoss = $portfolio->sum('profit_loss');
        
        return view('dashboard.index', compact(
            'user',
            'portfolio',
            'recentTransactions',
            'totalInvestment',
            'currentValue',
            'totalProfitLoss'
        ));
    }
}