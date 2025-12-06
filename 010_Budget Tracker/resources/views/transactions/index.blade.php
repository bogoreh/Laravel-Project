@extends('layouts.app')

@section('title', 'Dashboard')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-graph-up"></i> Financial Dashboard</h1>
        <a href="{{ route('transactions.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add Transaction
        </a>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card summary-card summary-income">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-arrow-down-circle"></i> Total Income</h5>
                    <h2 class="card-text">${{ number_format($summary->total_income ?? 0, 2) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card summary-card summary-expense">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-arrow-up-circle"></i> Total Expense</h5>
                    <h2 class="card-text">${{ number_format($summary->total_expense ?? 0, 2) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card summary-card summary-balance">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-wallet2"></i> Current Balance</h5>
                    <h2 class="card-text">${{ number_format($summary->balance ?? 0, 2) }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="card mb-4">
        <div class="card-header bg-white">
            <h4 class="mb-0"><i class="bi bi-clock-history"></i> Recent Transactions</h4>
        </div>
        <div class="card-body">
            @if($transactions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->date->format('M d, Y') }}</td>
                                <td>{{ $transaction->description }}</td>
                                <td>
                                    <span class="badge bg-secondary">{{ $transaction->category }}</span>
                                </td>
                                <td>
                                    <span class="badge {{ $transaction->type == 'income' ? 'badge-income' : 'badge-expense' }}">
                                        {{ ucfirst($transaction->type) }}
                                    </span>
                                </td>
                                <td class="{{ $transaction->type == 'income' ? 'income' : 'expense' }}">
                                    {{ $transaction->type == 'income' ? '+' : '-' }}${{ number_format($transaction->amount, 2) }}
                                </td>
                                <td>
                                    <a href="{{ route('transactions.edit', $transaction) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                onclick="return confirm('Delete this transaction?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $transactions->links() }}
            @else
                <div class="text-center py-5">
                    <i class="bi bi-receipt display-1 text-muted"></i>
                    <h4 class="mt-3">No transactions yet</h4>
                    <p class="text-muted">Start by adding your first transaction</p>
                    <a href="{{ route('transactions.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Add Transaction
                    </a>
                </div>
            @endif
        </div>
    </div>

<div class="card-body">
    <div class="row">
        @foreach($monthlyData as $month)
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        @php
                            // Convert month number to month name
                            $monthNumber = (int)$month->month;
                            $monthName = DateTime::createFromFormat('!m', $monthNumber)->format('F');
                        @endphp
                        {{ $monthName }} {{ $month->year }}
                    </h5>
                    <div class="row">
                        <div class="col-6">
                            <small class="text-muted">Income</small>
                            <p class="mb-0 income">+${{ number_format($month->income, 2) }}</p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Expense</small>
                            <p class="mb-0 expense">-${{ number_format($month->expense, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
</div>
@endsection