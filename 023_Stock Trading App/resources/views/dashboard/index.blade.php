@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card balance-card">
            <div class="card-body">
                <h6 class="card-subtitle mb-2">Available Balance</h6>
                <h2 class="card-title">${{ number_format($user->balance, 2) }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h6 class="card-subtitle mb-2">Total Investment</h6>
                <h2 class="card-title">${{ number_format($totalInvestment, 2) }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h6 class="card-subtitle mb-2">Current Value</h6>
                <h2 class="card-title">${{ number_format($currentValue, 2) }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h6 class="card-subtitle mb-2">Total P&L</h6>
                <h2 class="card-title {{ $totalProfitLoss >= 0 ? 'profit' : 'loss' }}">
                    ${{ number_format(abs($totalProfitLoss), 2) }}
                    <small class="fs-6">({{ $totalInvestment > 0 ? number_format(($totalProfitLoss/$totalInvestment)*100, 2) : 0 }}%)</small>
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Your Portfolio</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Symbol</th>
                                <th>Company</th>
                                <th>Quantity</th>
                                <th>Avg Price</th>
                                <th>Current Price</th>
                                <th>Investment</th>
                                <th>P&L</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($portfolio as $item)
                                <tr>
                                    <td>
                                        <strong>{{ $item->stock->symbol }}</strong>
                                    </td>
                                    <td>{{ $item->stock->company_name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>${{ number_format($item->average_price, 2) }}</td>
                                    <td>${{ number_format($item->stock->current_price, 2) }}</td>
                                    <td>${{ number_format($item->total_investment, 2) }}</td>
                                    <td class="{{ $item->profit_loss >= 0 ? 'profit' : 'loss' }}">
                                        ${{ number_format(abs($item->profit_loss), 2) }}
                                        ({{ number_format($item->profit_loss_percent, 2) }}%)
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">
                                        No stocks in portfolio. <a href="{{ route('stocks.index') }}">Browse stocks</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Recent Transactions</h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    @forelse($recentTransactions as $transaction)
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">
                                    <span class="badge bg-{{ $transaction->type == 'buy' ? 'success' : 'danger' }}">
                                        {{ strtoupper($transaction->type) }}
                                    </span>
                                    {{ $transaction->stock->symbol }}
                                </h6>
                                <small>{{ $transaction->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-1">
                                {{ $transaction->quantity }} shares @ ${{ number_format($transaction->price_per_share, 2) }}
                            </p>
                            <small class="text-muted">
                                Total: ${{ number_format($transaction->total_amount, 2) }}
                            </small>
                        </div>
                    @empty
                        <div class="text-center text-muted py-3">
                            No transactions yet
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-body text-center">
                <h5>Ready to Trade?</h5>
                <p class="text-muted">Start buying and selling stocks</p>
                <a href="{{ route('stocks.index') }}" class="btn btn-primary">
                    <i class="bi bi-currency-exchange"></i> Browse Stocks
                </a>
            </div>
        </div>
    </div>
</div>
@endsection