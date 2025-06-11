@extends('user.layouts.app')

@section('title', __('messages.account_page_title') . ' - Soria10')

@push('styles')
    <style>
        /* Main Card and Grid Styling */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; }
        .stat-card { background-color: #0d1117; padding: 16px; border-radius: 8px; border: 1px solid #30363d; }
        .stat-value { font-size: 24px; font-weight: 700; color: #ffffff; }
        .stat-value.positive { color: #28a745; }
        .stat-value.negative { color: #dc3545; }
        .stat-label { font-size: 14px; color: #8b949e; margin-top: 4px; }
        .card-header .card-title { font-size: 18px; font-weight: 600; }
        .card-header .card-title .fas { margin-right: 8px; color: #007bff; }

        /* Transactions Table Styling */
        .transactions-card-body { padding: 0; }
        .transactions-table-container { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .transactions-table { min-width: 100%; width: 100%; table-layout: auto; border-collapse: collapse; font-size: 14px; background-color: #000000; }
        .transactions-table-header { background-color: #1a1a1a; border-bottom: 2px solid #333333; }
        .table-header-cell { padding: 12px 16px; border-bottom: 1px solid #333333; text-align: left; font-size: 11px; font-weight: 600; color: #ffffff; text-transform: uppercase; letter-spacing: 0.05em; white-space: nowrap; }
        .amount-header { text-align: right; }
        .transaction-row { transition: background-color 0.2s ease; border-bottom: 1px solid #333333; }
        .transaction-row:hover { background-color: #1a1a1a; }
        .table-cell { padding: 12px 16px; white-space: nowrap; font-size: 14px; color: #ffffff; vertical-align: middle; }
        .amount-cell { text-align: right; }
        .description-cell { max-width: 200px; white-space: normal; word-wrap: break-word; }
        .date-cell { color: #cccccc; font-size: 13px; }
        .type-credit { color: #10b981; font-weight: 600; }
        .type-debit { color: #ef4444; font-weight: 600; }
        .amount-credit { color: #10b981; font-weight: 700; }
        .amount-debit { color: #ef4444; font-weight: 700; }
        .currency-label { font-size: 11px; color: #cccccc; margin-left: 4px; font-weight: 400; }
        .status-badge { padding: 4px 10px; display: inline-flex; font-size: 11px; font-weight: 600; border-radius: 9999px; text-transform: capitalize; }
        [data-theme="dark"] .status-success { background-color: rgba(4, 120, 87, 0.3); color: #34d399; }
        [data-theme="dark"] .status-warning { background-color: rgba(245, 158, 11, 0.3); color: #fcd34d; }
        [data-theme="dark"] .status-error { background-color: rgba(220, 38, 38, 0.3); color: #f87171; }
        [data-theme="dark"] .status-default { background-color: #4b5563; color: #d1d5db; }
        .empty-state { text-align: center; padding: 48px 16px; color: #8b949e; font-style: italic; }

        /* Improved Tab Navigation Styling */
        .nav-tabs { border-bottom: none; display: flex; gap: 8px; padding: 8px; }
        .nav-tabs .nav-link { border: 1px solid #30363d; border-radius: 8px; padding: 8px 16px; color: #8b949e; font-weight: 600; font-size: 14px; background-color: #161b22; transition: all 0.3s ease; display: flex; align-items: center; gap: 8px; cursor: pointer; }
        .nav-tabs .nav-link:hover { background-color: #21262d; color: #ffffff; border-color: #8b949e; }
        .nav-tabs .nav-link.active { color: #ffffff; background-color: #007bff; border-color: #007bff; box-shadow: 0 0 10px rgba(0, 123, 255, 0.5); }
        .tab-pane { display: none; }
        .tab-pane.active { display: block; }

        /* Responsive Tab Styling */
        .tabs-container { overflow-x: auto; -ms-overflow-style: none; scrollbar-width: none; }
        .tabs-container::-webkit-scrollbar { display: none; }
        @media (max-width: 768px) {
            .nav-tabs { flex-wrap: nowrap; padding-bottom: 8px; }
        }

        /* NEW & IMPROVED Pagination Styling */
        .pagination-wrapper {
            padding: 24px 16px;
            background-color: #0d1117;
            border-top: 1px solid #30363d;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .pagination {
            display: flex;
            padding-left: 0;
            list-style: none;
            border-radius: 0.25rem;
            gap: 6px; /* Adds space between pagination buttons */
        }
        .page-item .page-link {
            position: relative;
            display: block;
            padding: .5rem .75rem;
            line-height: 1.25;
            color: #8b949e; /* Default text color for numbers */
            background-color: #161b22; /* Button background */
            border: 1px solid #30363d;
            transition: all 0.2s ease-in-out;
            border-radius: 6px; /* Rounded corners for buttons */
            font-weight: 600;
        }
        .page-item:not(.active) .page-link:hover {
            z-index: 2;
            color: #ffffff;
            text-decoration: none;
            background-color: #21262d;
            border-color: #8b949e;
        }
        .page-item.active .page-link {
            z-index: 3;
            color: #fff;
            background-color: #007bff; /* Primary blue for active page */
            border-color: #007bff;
        }
        .page-item.disabled .page-link {
            color: #484f58;
            pointer-events: none;
            cursor: auto;
            background-color: #010409;
            border-color: #21262d;
        }
    </style>
@endpush

@section('content')
    <div id="accounts" class="content-section active">
        {{-- Account Overview Card --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <i class="fas fa-user-circle"></i> {{ __('messages.account_overview') }}
                </div>
            </div>
            <div class="card-body">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-value positive">${{ number_format($user->balance ?? 0, 2) }}</div>
                        <div class="stat-label">{{ __('messages.total_balance') }}</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value">${{ number_format($totalReferralEarning ?? 0, 2) }}</div>
                        <div class="stat-label">{{ __('messages.total_referral_earning') }}</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value">${{ number_format($totalWithdraws ?? 0, 2) }}</div>
                        <div class="stat-label">{{ __('messages.total_withdrawals') }}</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value {{ ($lifetime_pnl ?? 0) >= 0 ? 'positive' : 'negative' }}">${{ number_format($lifetime_pnl ?? 0, 2) }}</div>
                        <div class="stat-label">{{ __('messages.lifetime_profit_loss') }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabbed History Card --}}
        <div class="card" style="margin-top: 16px;">
            <div class="card-header">
                <div class="tabs-container">
                    <ul class="nav nav-tabs" id="historyTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="transactions-tab-btn" data-target="#transactions-content" type="button" role="tab">
                                <i class="fas fa-history"></i> {{ __('messages.transactions') }}
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="withdrawals-tab-btn" data-target="#withdrawals-content" type="button" role="tab">
                                <i class="fas fa-arrow-circle-down"></i> {{ __('messages.withdrawals') }}
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="deposits-tab-btn" data-target="#deposits-content" type="button" role="tab">
                                <i class="fas fa-arrow-circle-up"></i> {{ __('messages.deposits') }}
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card-body transactions-card-body">
                <div class="tab-content" id="historyTabsContent">

                    {{-- 1. Transactions Tab Content --}}
                    <div class="tab-pane active" id="transactions-content" role="tabpanel">
                        <div class="transactions-table-container">
                            <table class="transactions-table">
                                <thead class="transactions-table-header">
                                    <tr>
                                        <th class="table-header-cell">{{ __('messages.table_header_id') }}</th>
                                        <th class="table-header-cell">{{ __('messages.table_header_type') }}</th>
                                        <th class="table-header-cell amount-header">{{ __('messages.table_header_amount') }}</th>
                                        <th class="table-header-cell">{{ __('messages.table_header_status') }}</th>
                                        <th class="table-header-cell">{{ __('messages.table_header_description') }}</th>
                                        <th class="table-header-cell">{{ __('messages.table_header_date') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transactions as $txn)
                                        <tr class="transaction-row">
                                            <td class="table-cell">{{ $txn->id }}</td>
                                            <td class="table-cell">
                                                <span class="type-{{ strtolower($txn->type) }}">{{ __('messages.type_' . strtolower($txn->type)) }}</span>
                                            </td>
                                            <td class="table-cell amount-cell">
                                                @if(strtolower($txn->type) === 'credit') <span class="amount-credit">+{{ number_format($txn->amount, 2) }}</span>
                                                @else <span class="amount-debit">-{{ number_format($txn->amount, 2) }}</span> @endif
                                                <span class="currency-label">{{ $txn->currency }}</span>
                                            </td>
                                            <td class="table-cell"><span class="status-badge status-success">{{ __('messages.status_' . strtolower($txn->status)) }}</span></td>
                                            <td class="table-cell description-cell">{{ Illuminate\Support\Str::limit($txn->description, 45) }}</td>
                                            <td class="table-cell date-cell">{{ \Carbon\Carbon::parse($txn->created_at)->format('M d, Y H:i') }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="6" class="empty-state">{{ __('messages.no_transactions_found') }}</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($transactions->hasPages())
                            <div class="pagination-wrapper">{{ $transactions->appends(request()->query())->links('pagination::bootstrap-4') }}</div>
                        @endif
                    </div>

                    {{-- 2. Withdrawals Tab Content --}}
                    <div class="tab-pane" id="withdrawals-content" role="tabpanel">
                         <div class="transactions-table-container">
                            <table class="transactions-table">
                                <thead class="transactions-table-header">
                                    <tr>
                                        <th class="table-header-cell">{{ __('messages.table_header_id') }}</th>
                                        <th class="table-header-cell amount-header">{{ __('messages.table_header_amount') }}</th>
                                        <th class="table-header-cell">{{ __('messages.table_header_status') }}</th>
                                        <th class="table-header-cell">{{ __('messages.table_header_date') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($withdrawals as $withdrawal)
                                        <tr class="transaction-row">
                                            <td class="table-cell">{{ $withdrawal->id }}</td>
                                            <td class="table-cell amount-cell"><span class="amount-debit">-{{ number_format($withdrawal->amount, 2) }}</span></td>
                                            <td class="table-cell">
                                                @php
                                                    $statusClass = 'status-default';
                                                    switch (strtolower($withdrawal->status)) {
                                                        case 'complete': $statusClass = 'status-success'; break;
                                                        case 'pending': $statusClass = 'status-warning'; break;
                                                        case 'rejected': $statusClass = 'status-error'; break;
                                                    }
                                                @endphp
                                                <span class="status-badge {{ $statusClass }}">{{ __('messages.status_' . strtolower($withdrawal->status)) }}</span>
                                            </td>
                                            <td class="table-cell date-cell">{{ \Carbon\Carbon::parse($withdrawal->created_at)->format('M d, Y H:i') }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="empty-state">{{ __('messages.no_withdrawals_found') }}</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($withdrawals->hasPages())
                            <div class="pagination-wrapper">{{ $withdrawals->appends(request()->query())->links('pagination::bootstrap-4') }}</div>
                        @endif
                    </div>

                    {{-- 3. Deposits Tab Content --}}
                    <div class="tab-pane" id="deposits-content" role="tabpanel">
                        <div class="transactions-table-container">
                            <table class="transactions-table">
                                 <thead class="transactions-table-header">
                                    <tr>
                                        <th class="table-header-cell">{{ __('messages.table_header_id') }}</th>
                                        <th class="table-header-cell amount-header">{{ __('messages.table_header_amount') }}</th>
                                        <th class="table-header-cell">{{ __('messages.table_header_network') }}</th>
                                        <th class="table-header-cell">{{ __('messages.table_header_status') }}</th>
                                        <th class="table-header-cell">{{ __('messages.table_header_date') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   @forelse($deposits as $deposit)
                                        <tr class="transaction-row">
                                            <td class="table-cell">{{ $deposit->id }}</td>
                                            <td class="table-cell amount-cell"><span class="amount-credit">+{{ number_format($deposit->price_amount, 2) }}</span> <span class="currency-label">{{ $deposit->price_currency }}</span></td>
                                            <td class="table-cell">{{ $deposit->network ?? __('messages.not_applicable') }}</td>
                                            <td class="table-cell">
                                                @php
                                                    $statusClass = 'status-default';
                                                    switch (strtolower($deposit->payment_status)) {
                                                        case 'finished': case 'confirmed': $statusClass = 'status-success'; break;
                                                        case 'waiting': $statusClass = 'status-warning'; break;
                                                        case 'failed': case 'expired': $statusClass = 'status-error'; break;
                                                    }
                                                @endphp
                                                <span class="status-badge {{ $statusClass }}">{{ strtolower($deposit->payment_status)}}</span>
                                            </td>
                                            <td class="table-cell date-cell">{{ \Carbon\Carbon::parse($deposit->created_at)->format('M d, Y H:i') }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5" class="empty-state">{{ __('messages.no_deposits_found') }}</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($deposits->hasPages())
                            <div class="pagination-wrapper">{{ $deposits->appends(request()->query())->links('pagination::bootstrap-4') }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabs = document.querySelectorAll('#historyTabs .nav-link');
            const tabPanes = document.querySelectorAll('#historyTabsContent .tab-pane');

            tabs.forEach(tab => {
                tab.addEventListener('click', function (event) {
                    event.preventDefault();

                    tabs.forEach(t => t.classList.remove('active'));
                    tabPanes.forEach(p => p.classList.remove('active'));

                    this.classList.add('active');
                    const targetPane = document.querySelector(this.getAttribute('data-target'));
                    if (targetPane) {
                        targetPane.classList.add('active');
                    }
                });
            });
        });
    </script>
@endpush
