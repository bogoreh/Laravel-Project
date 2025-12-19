<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortfolioController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $portfolio = Portfolio::where('user_id', $user->id)
            ->with('stock')
            ->get();
        
        $totalInvestment = $portfolio->sum('total_investment');
        $currentValue = $portfolio->sum('current_value');
        $totalProfitLoss = $portfolio->sum('profit_loss');
        
        return view('portfolio.index', compact(
            'portfolio',
            'totalInvestment',
            'currentValue',
            'totalProfitLoss'
        ));
    }
}