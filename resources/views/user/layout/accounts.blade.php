@extends('layouts.app')

@section('title', 'Account - CoinTrades')

@section('content')
<div id="accounts" class="content-section active"> {{-- 'active' class not needed for MPA --}}
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-user-circle"></i>
                Account Overview
            </div>
        </div>
        <div class="card-body">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-value positive" id="totalValueAccPage">$0.00</div>
                    <div class="stat-label">Total Value</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" id="availableBalanceAccPage">$0.00</div>
                    <div class="stat-label">Available Funds</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" id="investedAccPage">$0.00</div>
                    <div class="stat-label">Invested Capital</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value positive" id="pnlAccPage">$0.00</div>
                    <div class="stat-label">Lifetime P&L</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card" style="margin-top: 16px;">
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-history"></i>
                Recent Transactions
            </div>
        </div>
        <div class="card-body">
            <div id="transactionsListContainer">
                {{-- Transactions data will be injected here by JavaScript --}}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Sample data for Account page
    let transactionData = [
        { type: 'Buy', coin: 'BTC', amountCoin: 0.1, amountUSD: 4523.45, date: '2025-05-28 10:30', status: 'Completed' },
        { type: 'Sell', coin: 'ETH', amountCoin: 0.5, amountUSD: 1578.39, date: '2025-05-28 09:15', status: 'Completed' },
        { type: 'Deposit', coin: 'USD', amountCoin: 1000, amountUSD: 1000, date: '2025-05-27 15:00', status: 'Confirmed' },
        { type: 'Withdrawal', coin: 'USD', amountCoin: 500, amountUSD: 500, date: '2025-05-26 12:00', status: 'Pending' }
    ];
    let accountOverviewData = { // Example data
        totalValue: 12456.78,
        availableFunds: 3245.67,
        investedCapital: 9211.11,
        lifetimePnL: 1234.56
    };


    function updateAccountPageOverview() {
        const totalValueEl = document.getElementById('totalValueAccPage');
        const availableEl = document.getElementById('availableBalanceAccPage');
        const investedEl = document.getElementById('investedAccPage');
        const pnlEl = document.getElementById('pnlAccPage');

        if(totalValueEl) {
            totalValueEl.textContent = formatCurrency(accountOverviewData.totalValue);
            totalValueEl.className = `stat-value ${accountOverviewData.totalValue >= 0 ? 'positive' : 'negative'}`;
        }
        if(availableEl) availableEl.textContent = formatCurrency(accountOverviewData.availableFunds);
        if(investedEl) investedEl.textContent = formatCurrency(accountOverviewData.investedCapital);
        if(pnlEl) {
            pnlEl.textContent = `${accountOverviewData.lifetimePnL >= 0 ? '+' : ''}${formatCurrency(accountOverviewData.lifetimePnL)}`;
            pnlEl.className = `stat-value ${accountOverviewData.lifetimePnL >= 0 ? 'positive' : 'negative'}`;
        }
        // Also update global header if these values drive it
         updateGlobalHeaderDisplay(accountOverviewData.totalValue, parseFloat(document.getElementById('todayPnLDisplay')?.textContent.replace(/[^0-9.-]+/g,"") || "0"));

    }

    function updateTransactionsOnPage() {
        const transactionsListEl = document.getElementById('transactionsListContainer');
        if (!transactionsListEl) return;
        transactionsListEl.innerHTML = transactionData.slice(0, 10).map(tx => `
            <div class="activity-item">
                <div class="activity-info">
                    <div class="activity-icon ${tx.type.toLowerCase().includes('buy') || tx.type.toLowerCase().includes('deposit') ? 'buy' : 'sell'}">
                        <i class="fas fa-${tx.type.toLowerCase().includes('buy') ? 'arrow-up' : (tx.type.toLowerCase().includes('sell') ? 'arrow-down' : (tx.type.toLowerCase().includes('deposit') ? 'plus' : 'minus'))}"></i>
                    </div>
                    <div class="activity-details">
                        <h4>${tx.type} ${tx.coin}</h4>
                        <span>${tx.date} &bull; Status: ${tx.status}</span>
                    </div>
                </div>
                <div class="activity-result">
                    <strong class="${tx.type.toLowerCase().includes('buy') || tx.type.toLowerCase().includes('withdrawal') ? 'negative' : 'positive'}">
                        ${tx.type.toLowerCase().includes('withdrawal') ? '-' : (tx.type.toLowerCase().includes('sell') || tx.type.toLowerCase().includes('deposit') ? '+' : '')}${formatCurrency(tx.type === 'Deposit' || tx.type === 'Withdrawal' ? tx.amountUSD : Math.abs(tx.amountUSD))}
                    </strong><br>
                    ${tx.type !== 'Deposit' && tx.type !== 'Withdrawal' ? `<small style="color: #848e9c;">${Number(tx.amountCoin).toFixed(4)} ${tx.coin}</small>` : ''}
                </div>
            </div>
        `).join('');
    }

    document.addEventListener('DOMContentLoaded', function() {
        updateAccountPageOverview();
        updateTransactionsOnPage();
        
    });
</script>

@endpush
