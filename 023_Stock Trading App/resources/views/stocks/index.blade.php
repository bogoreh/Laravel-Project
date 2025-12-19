@extends('layouts.app')

@section('title', 'Stocks Market')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Stock Market</h2>
    <div class="d-flex">
        <input type="text" class="form-control me-2" placeholder="Search stocks..." id="searchStocks">
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="stocksTable">
                <thead>
                    <tr>
                        <th>Symbol</th>
                        <th>Company Name</th>
                        <th>Current Price</th>
                        <th>Change</th>
                        <th>Change %</th>
                        <th>Volume</th>
                        <th>Market Cap</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stocks as $stock)
                        <tr>
                            <td>
                                <strong>{{ $stock->symbol }}</strong>
                            </td>
                            <td>{{ $stock->company_name }}</td>
                            <td>${{ number_format($stock->current_price, 2) }}</td>
                            <td class="{{ $stock->change >= 0 ? 'stock-price-up' : 'stock-price-down' }}">
                                {{ $stock->change >= 0 ? '+' : '' }}${{ number_format($stock->change, 2) }}
                            </td>
                            <td class="{{ $stock->change_percent >= 0 ? 'stock-price-up' : 'stock-price-down' }}">
                                {{ $stock->change_percent >= 0 ? '+' : '' }}{{ number_format($stock->change_percent, 2) }}%
                            </td>
                            <td>{{ number_format($stock->volume) }}</td>
                            <td>${{ number_format($stock->volume * $stock->current_price) }}</td>
                            <td>
                                <a href="{{ route('stocks.show', $stock) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i> View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('searchStocks').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('#stocksTable tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });
</script>
@endpush