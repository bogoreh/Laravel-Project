<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Services\StockService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    protected $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    public function index()
    {
        $stocks = Stock::orderBy('symbol')->get();
        return view('stocks.index', compact('stocks'));
    }

    public function show(Stock $stock)
    {
        $user = Auth::user();
        $userPortfolio = $user->portfolios()->where('stock_id', $stock->id)->first();
        
        return view('stocks.show', compact('stock', 'userPortfolio'));
    }

    public function buy(Request $request, Stock $stock)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $result = $this->stockService->buyStock(
            Auth::user(),
            $stock,
            $request->quantity
        );

        if ($result['success']) {
            return redirect()->route('portfolio.index')
                ->with('success', $result['message']);
        }

        return redirect()->back()
            ->with('error', $result['message']);
    }

    public function sell(Request $request, Stock $stock)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $result = $this->stockService->sellStock(
            Auth::user(),
            $stock,
            $request->quantity
        );

        if ($result['success']) {
            return redirect()->route('portfolio.index')
                ->with('success', $result['message']);
        }

        return redirect()->back()
            ->with('error', $result['message']);
    }
}