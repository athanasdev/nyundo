@extends('user.layouts.app')

@section('title', 'Account - Soria10')

@push('styles')
<style>
/* Transactions Table Styling */
.transactions-card-body {
    padding: 0;
}

.transactions-table-container {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

.transactions-table {
    min-width: 100%;
    width: 100%;
    table-layout: auto;
    border-collapse: collapse;
    font-size: 14px;
    background-color: #000000; /* Black background for table */
}

.transactions-table-header {
    background-color: #1a1a1a; /* Dark header */
    border-bottom: 2px solid #333333;
}

[data-theme="dark"] .transactions-table-header {
    background-color: #1a1a1a;
    border-bottom-color: #333333;
}

.table-header-cell {
    padding: 12px 16px;
    border-bottom: 1px solid #333333;
    text-align: left;
    font-size: 11px;
    font-weight: 600;
    color: #ffffff; /* White text for headers */
    text-transform: uppercase;
    letter-spacing: 0.05em;
    white-space: nowrap;
}

.amount-header {
    text-align: right;
}

[data-theme="dark"] .table-header-cell {
    border-bottom-color: #333333;
    color: #ffffff;
}

.transactions-table-body {
    background-color: #000000; /* Black background for body */
    border: none;
}

[data-theme="dark"] .transactions-table-body {
    background-color: #000000;
}

.transaction-row {
    transition: background-color 0.2s ease;
    border-bottom: 1px solid #333333;
    background-color: #000000; /* Black row background */
}

.transaction-row:hover {
    background-color: #1a1a1a; /* Dark hover effect */
}

.even-row {
    background-color: #0d1117; /* Slightly lighter for even rows */
}

[data-theme="dark"] .transaction-row {
    border-bottom-color: #333333;
    background-color: #000000;
}

[data-theme="dark"] .transaction-row:hover {
    background-color: #1a1a1a;
}

[data-theme="dark"] .even-row {
    background-color: #0d1117;
}

.table-cell {
    padding: 12px 16px;
    border-bottom: 1px solid #333333;
    white-space: nowrap;
    font-size: 14px;
    color: #ffffff; /* White text for cells */
    vertical-align: middle;
}

[data-theme="dark"] .table-cell {
    border-bottom-color: #333333;
    color: #ffffff;
}

.amount-cell {
    text-align: right;
}

.description-cell {
    max-width: 200px;
    white-space: normal;
    word-wrap: break-word;
}

.date-cell {
    color: #cccccc; /* Light gray for dates */
    font-size: 13px;
}

[data-theme="dark"] .date-cell {
    color: #cccccc;
}

/* Type Styling */
.type-credit {
    color: #10b981;
    font-weight: 600;
}

.type-debit {
    color: #ef4444;
    font-weight: 600;
}

.type-neutral {
    color: #ffffff;
    font-weight: 500;
}

[data-theme="dark"] .type-credit {
    color: #34d399;
}

[data-theme="dark"] .type-debit {
    color: #f87171;
}

[data-theme="dark"] .type-neutral {
    color: #ffffff;
}

/* Amount Styling */
.amount-credit {
    color: #10b981;
    font-weight: 700;
}

.amount-debit {
    color: #ef4444;
    font-weight: 700;
}

.amount-neutral {
    color: #ffffff;
    font-weight: 500;
}

[data-theme="dark"] .amount-credit {
    color: #34d399;
}

[data-theme="dark"] .amount-debit {
    color: #f87171;
}

[data-theme="dark"] .amount-neutral {
    color: #ffffff;
}

.currency-label {
    font-size: 11px;
    color: #cccccc;
    margin-left: 4px;
    font-weight: 400;
}

[data-theme="dark"] .currency-label {
    color: #cccccc;
}

/* Status Badge Styling */
.status-badge {
    padding: 2px 8px;
    display: inline-flex;
    font-size: 11px;
    line-height: 1.2;
    font-weight: 600;
    border-radius: 9999px;
    text-transform: capitalize;
}

.status-success {
    background-color: #d1fae5;
    color: #065f46;
}

.status-warning {
    background-color: #fef3c7;
    color: #92400e;
}

.status-error {
    background-color: #fee2e2;
    color: #991b1b;
}

.status-default {
    background-color: #f3f4f6;
    color: #374151;
}

[data-theme="dark"] .status-success {
    background-color: #065f46;
    color: #d1fae5;
}

[data-theme="dark"] .status-warning {
    background-color: #92400e;
    color: #fef3c7;
}

[data-theme="dark"] .status-error {
    background-color: #991b1b;
    color: #fee2e2;
}

[data-theme="dark"] .status-default {
    background-color: #4b5563;
    color: #d1d5db;
}

/* Empty State */
.empty-state {
    text-align: center;
    border-bottom: 1px solid #333333;
    padding: 32px 16px;
    color: #cccccc;
    font-style: italic;
}

[data-theme="dark"] .empty-state {
    border-bottom-color: #333333;
    color: #cccccc;
}

/* Pagination Styling */
.pagination-wrapper {
    padding: 20px;
    background-color: #000000;
    border-top: 1px solid #333333;
    display: flex;
    justify-content: center;
    align-items: center;
}

.pagination {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
    gap: 8px;
}

.pagination li {
    display: inline-block;
}

.pagination a,
.pagination span {
    display: block;
    padding: 8px 12px;
    text-decoration: none;
    border: 1px solid #333333;
    color: #ffffff;
    background-color: #1a1a1a;
    border-radius: 4px;
    transition: all 0.2s ease;
}

.pagination a:hover {
    background-color: #333333;
    color: #ffffff;
}

.pagination .active span {
    background-color: #007bff;
    border-color: #007bff;
    color: #ffffff;
}

.pagination .disabled span {
    color: #666666;
    background-color: #0a0a0a;
    border-color: #222222;
    cursor: not-allowed;
}

/* Pagination Info */
.pagination-info {
    background-color: #000000;
    padding: 15px 20px;
    border-top: 1px solid #333333;
    color: #cccccc;
    font-size: 14px;
    text-align: center;
}

/* Responsive Design */
@media (max-width: 768px) {
    .transactions-table {
        font-size: 12px;
    }

    .table-header-cell,
    .table-cell {
        padding: 8px 12px;
    }

    .table-header-cell {
        font-size: 10px;
    }

    .description-cell {
        max-width: 150px;
    }

    .pagination a,
    .pagination span {
        padding: 6px 10px;
        font-size: 12px;
    }
}

@media (max-width: 640px) {
    .transactions-table {
        font-size: 11px;
    }

    .table-header-cell,
    .table-cell {
        padding: 6px 8px;
    }

    .description-cell {
        max-width: 120px;
    }

    .pagination a,
    .pagination span {
        padding: 4px 8px;
        font-size: 11px;
    }
}
</style>
@endpush

@section('content')
    <div id="accounts" class="content-section active">
        {{-- Account Overview Card --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <i class="fas fa-user-circle"></i> Account Overview
                </div>
            </div>
            <div class="card-body">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-value positive" id="totalValueAccPage1">$ {{ number_format($user->balance ?? 0, 2) }}</div>
                        <div class="stat-label">Total Balance</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value" id="availableBalanceAccPage1">$ {{ number_format($totalReferralEarning ?? 0, 2) }}</div>
                        <div class="stat-label">Total Referral Earning</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value" id="investedAccPage2">$ {{ number_format($totalWithdraws ?? 0, 2) }}</div>
                        <div class="stat-label">Total Withdraw</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value positive" id="pnlAccPage">$ {{ number_format($lifetime_pnl ?? 0, 2) }}</div>
                        <div class="stat-label">Lifetime P&L</div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Recent Transactions Card --}}
        <div class="card" style="margin-top: 16px;">
            <div class="card-header">
                <div class="card-title">
                    <i class="fas fa-history"></i> Recent Transactions
                </div>
            </div>
            <div class="card-body transactions-card-body">
                <div class="transactions-table-container">
                    <table class="transactions-table">
                        <thead class="transactions-table-header">
                            <tr>
                                <th class="table-header-cell">ID</th>
                                <th class="table-header-cell">Type</th>
                                <th class="table-header-cell amount-header">Amount</th>
                                <th class="table-header-cell">Status</th>
                                <th class="table-header-cell">Description</th>
                                <th class="table-header-cell">Date</th>
                            </tr>
                        </thead>
                        <tbody class="transactions-table-body">
                            @forelse($transactions as $txn)
                                <tr class="transaction-row @if($loop->even) even-row @endif">
                                    <td class="table-cell">
                                        {{ $txn->id }}
                                    </td>
                                    <td class="table-cell">
                                        @if(strtolower($txn->type) === 'credit')
                                            <span class="type-credit">{{ ucfirst($txn->type) }}</span>
                                        @elseif(strtolower($txn->type) === 'debit')
                                            <span class="type-debit">{{ ucfirst($txn->type) }}</span>
                                        @else
                                            <span class="type-neutral">{{ ucfirst($txn->type) }}</span>
                                        @endif
                                    </td>
                                    <td class="table-cell amount-cell">
                                        @if(strtolower($txn->type) === 'credit')
                                            <span class="amount-credit">+{{ number_format($txn->amount, 2) }}</span>
                                        @elseif(strtolower($txn->type) === 'debit')
                                            <span class="amount-debit">-{{ number_format($txn->amount, 2) }}</span>
                                        @else
                                            <span class="amount-neutral">{{ number_format($txn->amount, 2) }}</span>
                                        @endif
                                        @if($txn->currency)
                                            <span class="currency-label">{{ $txn->currency }}</span>
                                        @endif
                                    </td>
                                    <td class="table-cell">
                                        @php
                                            $statusClass = 'status-default';
                                            $statusText = $txn->status ?? 'trx ';
                                            switch (strtolower($statusText)) {
                                                case 'completed': case 'confirmed':
                                                    $statusClass = 'status-success'; break;
                                                case 'pending':
                                                    $statusClass = 'status-warning'; break;
                                                case 'failed': case 'cancelled':
                                                    $statusClass = 'status-error'; break;
                                            }
                                        @endphp
                                        <span class="status-badge {{ $statusClass }}">
                                            {{ ucfirst($statusText) }}
                                        </span>
                                    </td>
                                    <td class="table-cell description-cell">
                                        {{ Illuminate\Support\Str::limit($txn->description, 45) }}
                                    </td>
                                    <td class="table-cell date-cell">
                                        {{ \Carbon\Carbon::parse($txn->created_at)->format('M d, Y H:i') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="empty-state">
                                        No transactions found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Section --}}
                @if(isset($transactions) && method_exists($transactions, 'hasPages') && $transactions->hasPages())
                    <div class="pagination-wrapper">
                        {{ $transactions->appends(request()->query())->links() }}
                    </div>

                    {{-- Pagination Info --}}
                    <div class="pagination-info">
                        Showing {{ $transactions->firstItem() ?? 0 }} to {{ $transactions->lastItem() ?? 0 }}
                        of {{ $transactions->total() }} transactions
                    </div>
                @endif
            </div>
        </div>
        
    </div>
@endsection

@push('scripts')
{{-- Add any JavaScript if needed --}}
<script>
    // Optional: Add loading state for pagination
    document.addEventListener('DOMContentLoaded', function() {
        const paginationLinks = document.querySelectorAll('.pagination a');

        paginationLinks.forEach(link => {
            link.addEventListener('click', function() {
                // Add loading state
                const loadingSpinner = '<i class="fas fa-spinner fa-spin"></i>';
                this.innerHTML = loadingSpinner;
            });
        });
    });
</script>
@endpush
