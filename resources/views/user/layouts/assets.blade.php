@extends('user.layouts.app')

@section('title', __('messages.assets_page_title') . ' - Soria10')

@section('content')
<div id="assets" class="content-section active">
    <div class="dashboard-grid">
        <div class="main-content">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fas fa-chart-area"></i>
                        {{ __('messages.live_market_data') }}
                        <span class="status-indicator" title="{{ __('messages.live_feed_active') }}"></span>
                    </div>
                </div>
                <div class="card-body" style="padding: 0;">
                    <div class="chart-container">
                        <div class="trading-view">
                            <div class="chart-placeholder">
                                <i class="fas fa-chart-line"></i>
                                {{ __('messages.real_time_chart_placeholder') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fab fa-bitcoin"></i>
                        {{ __('messages.top_cryptocurrencies') }}
                    </div>
                </div>
                <div class="coins-list" id="coinsListContainer">
                    {{-- Coin data will be injected here by JavaScript --}}
                </div>
            </div>
        </div>

        <div class="sidebar">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fas fa-bolt"></i>
                        {{ __('messages.quick_actions') }}
                    </div>
                </div>
                <div class="card-body">
                    <div class="quick-actions">
                        <button class="action-btn buy">
                            <i class="fas fa-arrow-up"></i>
                            {{ __('messages.buy') }}
                        </button>
                        <button class="action-btn sell">
                            <i class="fas fa-arrow-down"></i>
                            {{ __('messages.sell') }}
                        </button>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fas fa-wallet"></i>
                        {{ __('messages.portfolio') }}
                    </div>
                </div>
                <div class="card-body">
                    <div id="portfolioListContainer">
                        {{-- Portfolio data will be injected here by JavaScript --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // --- Localization for JavaScript ---
    const lang = {
        usd_pair: " / USD", // Fallback
        coins_suffix: "{{ __('messages.coins_suffix') }}",
        avg_buy_price: "{{ __('messages.avg_buy_price') }}"
    };
    try {
        // More robust way to get the translation
        lang.usd_pair = " {{ __('messages.usd_pair') }}";
    } catch(e) { /* use fallback */ }


    // Sample data for Assets page (in a real app, this comes from controller)
    let coinData = [
        { symbol: 'BTC', name: 'Bitcoin', price: 45234.56, change: 2.34, icon: 'btc', marketCap: 890123456789 },
        { symbol: 'ETH', name: 'Ethereum', price: 3156.78, change: -1.23, icon: 'eth', marketCap: 375123456789 },
        { symbol: 'BNB', name: 'Binance Coin', price: 456.89, change: 4.56, icon: 'bnb', marketCap: 70123456789 },
        { symbol: 'ADA', name: 'Cardano', price: 1.23, change: -2.34, icon: 'ada', marketCap: 40123456789 },
        { symbol: 'SOL', name: 'Solana', price: 123.45, change: 3.45, icon: 'sol', marketCap: 50123456789 },
        { symbol: 'DOT', name: 'Polkadot', price: 23.45, change: -0.56, icon: 'dot', marketCap: 22123456789 }
    ];

    let portfolioData = [
        { symbol: 'BTC', amount: 0.5, value: 22617.28, avgBuyPrice: 40000 },
        { symbol: 'ETH', amount: 2.5, value: 7891.95, avgBuyPrice: 2800 },
        { symbol: 'BNB', amount: 10, value: 4568.90, avgBuyPrice: 300 }
    ];

    function updateCoinsList() {
        const coinsListEl = document.getElementById('coinsListContainer');
        if (!coinsListEl) return;
        coinsListEl.innerHTML = coinData.map(coin => `
            <div class="coin-item">
                <div class="coin-info">
                    <div class="coin-icon ${coin.icon}">${coin.symbol.substring(0,3)}</div>
                    <div class="coin-details">
                        <div class="coin-name">${coin.name}</div>
                        <div class="coin-symbol">${coin.symbol}${lang.usd_pair}</div>
                    </div>
                </div>
                <div class="coin-price">
                    <div class="price">${formatCurrency(coin.price)}</div>
                    <div class="change ${coin.change >= 0 ? 'positive' : 'negative'}">
                        ${formatPercentage(coin.change)}
                    </div>
                </div>
            </div>
        `).join('');
    }

    function updatePortfolio() {
        const portfolioListEl = document.getElementById('portfolioListContainer');
        if (!portfolioListEl) return;

        let totalPortfolioValue = 0;
        portfolioListEl.innerHTML = portfolioData.map(item => {
            const coin = coinData.find(c => c.symbol === item.symbol);
            item.value = coin ? coin.price * item.amount : item.value;
            totalPortfolioValue += item.value;
            const pnl = coin ? (coin.price - item.avgBuyPrice) * item.amount : 0;
            const pnlClass = pnl >= 0 ? 'positive' : 'negative';

            return `
            <div class="portfolio-item">
                <div>
                    <strong>${item.symbol}</strong> (${item.amount} ${lang.coins_suffix})<br>
                    <small style="color: #848e9c;">${lang.avg_buy_price} ${formatCurrency(item.avgBuyPrice)}</small>
                </div>
                <div style="text-align: right;">
                    <strong>${formatCurrency(item.value)}</strong><br>
                    <small class="${pnlClass}">${formatCurrency(pnl, 0, 0)} (${formatPercentage(pnl/ (item.avgBuyPrice * item.amount) * 100 || 0)})</small>
                </div>
            </div>
        `;}).join('');
    }

    function updateRealTimeAssetData() {
        coinData = coinData.map(coin => {
            const changePercent = (Math.random() - 0.48) * 1;
            const priceChange = coin.price * (changePercent / 100);
            coin.price += priceChange;
            coin.price = Math.max(0, coin.price);
            coin.change = parseFloat(changePercent.toFixed(2));
            return coin;
        });
        updateCoinsList();
        updatePortfolio();
    }

    document.addEventListener('DOMContentLoaded', function() {
        updateCoinsList();
        updatePortfolio();
        setInterval(updateRealTimeAssetData, 3000); // Update data every 3 seconds
    });
</script>
@endpush
