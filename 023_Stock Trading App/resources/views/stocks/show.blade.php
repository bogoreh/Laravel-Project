@extends('layouts.app')

@section('title', $stock->symbol . ' - ' . $stock->company_name)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">{{ $stock->symbol }}</h4>
                        <p class="text-muted mb-0">{{ $stock->company_name }}</p>
                    </div>
                    <div class="text-end">
                        <h2 class="mb-0 {{ $stock->change >= 0 ? 'stock-price-up' : 'stock-price-down' }}">
                            ${{ number_format($stock->current_price, 2) }}
                        </h2>
                        <p class="mb-0 {{ $stock->change >= 0 ? 'stock-price-up' : 'stock-price-down' }}">
                            {{ $stock->change >= 0 ? '+' : '' }}${{ number_format($stock->change, 2) }}
                            ({{ $stock->change >= 0 ? '+' : '' }}{{ number_format($stock->change_percent, 2) }}%)
                        </p>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Open</strong></td>
                                <td>${{ number_format($stock->open, 2) }}</td>
                            </tr>
                            <tr>
                                <td><strong>High</strong></td>
                                <td>${{ number_format($stock->high, 2) }}</td>
                            </tr>
                            <tr>
                                <td><strong>Volume</strong></td>
                                <td>{{ number_format($stock->volume) }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Previous Close</strong></td>
                                <td>${{ number_format($stock->previous_close, 2) }}</td>
                            </tr>
                            <tr>
                                <td><strong>Low</strong></td>
                                <td>${{ number_format($stock->low, 2) }}</td>
                            </tr>
                            <tr>
                                <td><strong>Market Cap</strong></td>
                                <td>${{ number_format($stock->volume * $stock->current_price) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        @if($userPortfolio)
            <div class="card">
                <div class="card-header">
                    <h5>Your Holdings</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <td>Quantity</td>
                            <td><strong>{{ $userPortfolio->quantity }} shares</strong></td>
                        </tr>
                        <tr>
                            <td>Average Price</td>
                            <td><strong>${{ number_format($userPortfolio->average_price, 2) }}</strong></td>
                        </tr>
                        <tr>
                            <td>Total Investment</td>
                            <td><strong>${{ number_format($userPortfolio->total_investment, 2) }}</strong></td>
                        </tr>
                        <tr>
                            <td>Current Value</td>
                            <td><strong>${{ number_format($userPortfolio->current_value, 2) }}</strong></td>
                        </tr>
                        <tr>
                            <td>Profit/Loss</td>
                            <td class="{{ $userPortfolio->profit_loss >= 0 ? 'profit' : 'loss' }}">
                                <strong>
                                    ${{ number_format(abs($userPortfolio->profit_loss), 2) }}
                                    ({{ number_format($userPortfolio->profit_loss_percent, 2) }}%)
                                </strong>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        @endif
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Trade {{ $stock->symbol }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('stocks.buy', $stock) }}" method="POST" class="mb-4">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Buy Shares</label>
                        <div class="input-group">
                            <input type="number" name="quantity" class="form-control" 
                                   placeholder="Quantity" min="1" value="1" required>
                            <span class="input-group-text">shares</span>
                        </div>
                        <div class="mt-2 text-muted small">
                            Estimated cost: <span id="buyCost">${{ number_format($stock->current_price, 2) }}</span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-cart-plus"></i> Buy Stock
                    </button>
                </form>
                
                <hr>
                
                <form action="{{ route('stocks.sell', $stock) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Sell Shares</label>
                        <div class="input-group">
                            <input type="number" name="quantity" class="form-control" 
                                   placeholder="Quantity" min="1" 
                                   value="{{ $userPortfolio ? min(1, $userPortfolio->quantity) : 1 }}" 
                                   max="{{ $userPortfolio ? $userPortfolio->quantity : 1 }}" 
                                   required>
                            <span class="input-group-text">shares</span>
                        </div>
                        <div class="mt-2 text-muted small">
                            Max available: {{ $userPortfolio ? $userPortfolio->quantity : 0 }} shares
                        </div>
                        <div class="mt-2 text-muted small">
                            Estimated proceeds: <span id="sellProceeds">${{ number_format($stock->current_price, 2) }}</span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-danger w-100" 
                            {{ !$userPortfolio || $userPortfolio->quantity == 0 ? 'disabled' : '' }}>
                        <i class="bi bi-cart-dash"></i> Sell Stock
                    </button>
                </form>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-body">
                <h6>Quick Info</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <small class="text-muted">Transaction Fee:</small>
                        <div>1% per transaction</div>
                    </li>
                    <li class="mb-2">
                        <small class="text-muted">Available Balance:</small>
                        <div>${{ number_format(auth()->user()->balance, 2) }}</div>
                    </li>
                    @if($userPortfolio)
                        <li>
                            <small class="text-muted">Your Holdings:</small>
                            <div>{{ $userPortfolio->quantity }} shares</div>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const stockPrice = {{ $stock->current_price }};
    
    document.querySelector('input[name="quantity"]').addEventListener('input', function(e) {
        const quantity = e.target.value;
        const cost = quantity * stockPrice;
        const fees = cost * 0.01;
        const total = cost + fees;
        document.getElementById('buyCost').textContent = '$' + total.toFixed(2);
    });
    
    document.querySelectorAll('input[name="quantity"]')[1]?.addEventListener('input', function(e) {
        const quantity = e.target.value;
        const proceeds = quantity * stockPrice;
        const fees = proceeds * 0.01;
        const net = proceeds - fees;
        document.getElementById('sellProceeds').textContent = '$' + net.toFixed(2);
    });
</script>
@endpush