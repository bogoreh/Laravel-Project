<?php

namespace App\Services;

use App\Models\Portfolio;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class StockService
{
    public function buyStock($user, $stock, $quantity)
    {
        $totalCost = $stock->current_price * $quantity;
        $fees = $totalCost * 0.01; // 1% transaction fee
        $netAmount = $totalCost + $fees;

        if ($user->balance < $netAmount) {
            return [
                'success' => false,
                'message' => 'Insufficient balance'
            ];
        }

        return DB::transaction(function () use ($user, $stock, $quantity, $totalCost, $fees, $netAmount) {
            // Update user balance
            $user->decrement('balance', $netAmount);

            // Create transaction record
            Transaction::create([
                'user_id' => $user->id,
                'stock_id' => $stock->id,
                'type' => 'buy',
                'quantity' => $quantity,
                'price_per_share' => $stock->current_price,
                'total_amount' => $totalCost,
                'fees' => $fees,
                'net_amount' => $netAmount
            ]);

            // Update or create portfolio
            $portfolio = Portfolio::where('user_id', $user->id)
                ->where('stock_id', $stock->id)
                ->first();

            if ($portfolio) {
                $newQuantity = $portfolio->quantity + $quantity;
                $newTotalInvestment = $portfolio->total_investment + $totalCost;
                $newAveragePrice = $newTotalInvestment / $newQuantity;

                $portfolio->update([
                    'quantity' => $newQuantity,
                    'average_price' => $newAveragePrice,
                    'total_investment' => $newTotalInvestment,
                    'current_value' => $newQuantity * $stock->current_price,
                    'profit_loss' => ($newQuantity * $stock->current_price) - $newTotalInvestment,
                    'profit_loss_percent' => ($newTotalInvestment > 0) 
                        ? ((($newQuantity * $stock->current_price) - $newTotalInvestment) / $newTotalInvestment) * 100 
                        : 0
                ]);
            } else {
                Portfolio::create([
                    'user_id' => $user->id,
                    'stock_id' => $stock->id,
                    'quantity' => $quantity,
                    'average_price' => $stock->current_price,
                    'total_investment' => $totalCost,
                    'current_value' => $quantity * $stock->current_price,
                    'profit_loss' => 0,
                    'profit_loss_percent' => 0
                ]);
            }

            return [
                'success' => true,
                'message' => "Successfully bought {$quantity} shares of {$stock->symbol}"
            ];
        });
    }

    public function sellStock($user, $stock, $quantity)
    {
        $portfolio = Portfolio::where('user_id', $user->id)
            ->where('stock_id', $stock->id)
            ->first();

        if (!$portfolio || $portfolio->quantity < $quantity) {
            return [
                'success' => false,
                'message' => 'Insufficient shares to sell'
            ];
        }

        $totalValue = $stock->current_price * $quantity;
        $fees = $totalValue * 0.01; // 1% transaction fee
        $netAmount = $totalValue - $fees;

        return DB::transaction(function () use ($user, $stock, $portfolio, $quantity, $totalValue, $fees, $netAmount) {
            // Update user balance
            $user->increment('balance', $netAmount);

            // Create transaction record
            Transaction::create([
                'user_id' => $user->id,
                'stock_id' => $stock->id,
                'type' => 'sell',
                'quantity' => $quantity,
                'price_per_share' => $stock->current_price,
                'total_amount' => $totalValue,
                'fees' => $fees,
                'net_amount' => $netAmount
            ]);

            // Update portfolio
            $newQuantity = $portfolio->quantity - $quantity;
            
            if ($newQuantity > 0) {
                $remainingInvestment = ($portfolio->average_price * $newQuantity);
                
                $portfolio->update([
                    'quantity' => $newQuantity,
                    'total_investment' => $remainingInvestment,
                    'current_value' => $newQuantity * $stock->current_price,
                    'profit_loss' => ($newQuantity * $stock->current_price) - $remainingInvestment,
                    'profit_loss_percent' => ($remainingInvestment > 0) 
                        ? ((($newQuantity * $stock->current_price) - $remainingInvestment) / $remainingInvestment) * 100 
                        : 0
                ]);
            } else {
                $portfolio->delete();
            }

            return [
                'success' => true,
                'message' => "Successfully sold {$quantity} shares of {$stock->symbol}"
            ];
        });
    }
}