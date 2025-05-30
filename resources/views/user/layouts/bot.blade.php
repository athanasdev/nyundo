@extends('user.layouts.app')

@section('title', 'Trading Bot - CoinTrades')

@section('content')
<div id="bot" class="content-section active"> {{-- 'active' class not needed for MPA --}}
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-cogs"></i> Trading Bot Control
            </div>
        </div>
        <div class="card-body">
            <div class="bot-status" id="botStatusContainerPage">
                <div class="bot-info">
                    <i class="fas fa-robot"></i>
                    <span>Automated Trading Bot</span>
                    <span class="status-indicator" id="botIndicatorPage"></span>
                    <span id="botStatusTextPage">Active</span>
                </div>
                <div class="bot-toggle active" id="botTogglePage"></div>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-value positive" id="botProfitPage">+$0.00</div>
                    <div class="stat-label">Bot Profit (24h)</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" id="botTradesPage">0</div>
                    <div class="stat-label">Bot Trades (24h)</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value positive" id="botSuccessRatePage">0.0%</div>
                    <div class="stat-label">Bot Success Rate</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" id="botUptimePage">0h 0m</div>
                    <div class="stat-label">Current Uptime</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card" style="margin-top: 16px;">
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-bullseye"></i>
                Active Trading Signals
            </div>
        </div>
        <div class="card-body">
            <div class="trading-signals" id="tradingSignalsContainerPage">
                {{-- Trading signals will be injected here --}}
            </div>
        </div>
    </div>

    <div class="card" style="margin-top: 16px;">
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-clipboard-list"></i> Bot Activity Log
            </div>
        </div>
        <div class="card-body">
            <div id="botActivityListContainer">
                {{-- Bot activity will be injected here --}}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Sample data for Bot page
    let tradingSignalsData = [
        { id: 'sig1', type: 'BUY', coin: 'BTC', price: 45000, target: 46500, timeLeft: 180, originalTime: 180 },
        { id: 'sig2', type: 'SELL', coin: 'ETH', price: 3200, target: 3050, timeLeft: 95, originalTime: 95 },
        { id: 'sig3', type: 'BUY', coin: 'SOL', price: 120, target: 135, timeLeft: 240, originalTime: 240 }
    ];
    let botActivityData = [
        { time: '10:35:12', action: 'BUY BTC', details: '0.02 BTC @ $45100.50', profit: null, type:'buy' },
        { time: '10:30:05', action: 'SELL ETH', details: '0.1 ETH @ $3180.20', profit: 15.32, type:'sell' },
        { time: '10:25:00', action: 'Monitored ADA', details: 'Price within target range.', profit: null, type:'system' }
    ];
    let botStatsData = { // Example data
        profit24h: 2456.78,
        trades24h: 156,
        successRate: 92.4,
        uptimeSeconds: 23 * 3600 + 45 * 60 // 23h 45m
    };
    let botActive = true; // Initial bot state

    function updateTradingSignalsOnPage() {
        const signalsContainerEl = document.getElementById('tradingSignalsContainerPage');
        if (!signalsContainerEl) return;
        signalsContainerEl.innerHTML = tradingSignalsData.map(signal => {
            const icon = signal.type === 'BUY' ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down';
            const minutes = Math.floor(signal.timeLeft / 60);
            const seconds = signal.timeLeft % 60;
            const timeFormatted = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            return `
            <div class="signal-item ${signal.type.toLowerCase()}" id="signal-${signal.id}">
                <div class="signal-info">
                    <div class="signal-type"><i class="fas ${icon}"></i> <span>${signal.type} ${signal.coin} @ ${formatCurrency(signal.price, 2,2)}</span></div>
                    <div class="signal-details">Target: ${formatCurrency(signal.target, 2,2)} | Strength: ${Math.floor(Math.random()*3 + 3)}/5</div>
                </div>
                <div class="countdown-timer">
                    <div class="countdown-time" id="time-${signal.id}-page">${timeFormatted}</div>
                    <div class="countdown-label">Expires In</div>
                </div>
            </div>`;
        }).join('');
    }

    let signalIntervals = {};
    function startSignalCountdownsOnPage() {
        Object.values(signalIntervals).forEach(clearInterval); // Clear existing intervals
        signalIntervals = {};

        tradingSignalsData.forEach(signal => {
            if (signal.timeLeft > 0) {
                const el = document.getElementById(`time-${signal.id}-page`);
                if (!el) return;

                signalIntervals[signal.id] = setInterval(() => {
                    signal.timeLeft--;
                    if (signal.timeLeft >= 0) {
                        const minutes = Math.floor(signal.timeLeft / 60);
                        const seconds = signal.timeLeft % 60;
                        el.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                    }
                    if (signal.timeLeft <= 0) {
                        clearInterval(signalIntervals[signal.id]);
                        const signalEl = document.getElementById(`signal-${signal.id}`);
                        if(signalEl) {
                            signalEl.style.opacity = '0.5';
                            const labelEl = signalEl.querySelector('.countdown-label');
                            if(labelEl) labelEl.textContent = 'Expired';
                        }
                    }
                }, 1000);
            }
        });
    }


    function updateBotActivityOnPage() {
        const botActivityListEl = document.getElementById('botActivityListContainer');
        if (!botActivityListEl) return;
        botActivityListEl.innerHTML = botActivityData.slice(0, 5).map(activity => `
            <div class="activity-item">
                <div class="activity-info">
                     <div class="activity-icon ${activity.type || 'system'}">
                        <i class="fas fa-${activity.type === 'buy' ? 'cart-plus' : (activity.type === 'sell' ? 'cash-register' : 'cog')}"></i>
                    </div>
                    <div class="activity-details">
                        <h4>${activity.action}</h4>
                        <span>${activity.time} - ${activity.details}</span>
                    </div>
                </div>
                ${activity.profit !== null ? `
                <div class="activity-result">
                    <strong class="${activity.profit >= 0 ? 'positive' : 'negative'}">
                    ${activity.profit >= 0 ? '+' : ''}${formatCurrency(activity.profit)}
                    </strong>
                </div>` : ''}
            </div>
        `).join('');
    }

    function updateBotStatsOnPage(isIncrement = false) {
        const botProfitElPage = document.getElementById('botProfitPage');
        const botTradesElPage = document.getElementById('botTradesPage');
        const botSuccessRateElPage = document.getElementById('botSuccessRatePage');
        const botUptimeElPage = document.getElementById('botUptimePage');

        if (isIncrement && botActive) {
            botStatsData.profit24h += (Math.random() - 0.4) * 20;
            if (Math.random() > 0.9) botStatsData.trades24h++;
            botStatsData.successRate += (Math.random() - 0.5) * 0.1;
            botStatsData.successRate = Math.max(80, Math.min(99.9, botStatsData.successRate));
            botStatsData.uptimeSeconds += 3; // Assuming called every 3 seconds by a global updater
        }

        if(botProfitElPage) {
            botProfitElPage.textContent = `${botStatsData.profit24h >= 0 ? '+' : ''}${formatCurrency(botStatsData.profit24h)}`;
            botProfitElPage.className = `stat-value ${botStatsData.profit24h >= 0 ? 'positive' : 'negative'}`;
        }
        if(botTradesElPage) botTradesElPage.textContent = botStatsData.trades24h;
        if(botSuccessRateElPage) {
             botSuccessRateElPage.textContent = `${botStatsData.successRate.toFixed(1)}%`;
             botSuccessRateElPage.className = `stat-value ${botStatsData.successRate >= 90 ? 'positive' : (botStatsData.successRate < 85 ? 'negative' : '')}`;
        }

        const h = Math.floor(botStatsData.uptimeSeconds / 3600);
        const m = Math.floor((botStatsData.uptimeSeconds % 3600) / 60);
        if(botUptimeElPage) botUptimeElPage.textContent = `${h}h ${m}m`;
    }

    function toggleBotOnPage() {
        botActive = !botActive;
        const botToggleEl = document.getElementById('botTogglePage');
        const botStatusContainerEl = document.getElementById('botStatusContainerPage');
        const botIndicatorEl = document.getElementById('botIndicatorPage');
        const botStatusTextEl = document.getElementById('botStatusTextPage');

        if (botActive) {
            botToggleEl.classList.add('active');
            botStatusContainerEl.classList.remove('inactive');
            botIndicatorEl.classList.remove('inactive');
            botStatusTextEl.textContent = 'Active';
            botStatusTextEl.style.color = '#0ecb81';
        } else {
            botToggleEl.classList.remove('active');
            botStatusContainerEl.classList.add('inactive');
            botIndicatorEl.classList.add('inactive');
            botStatusTextEl.textContent = 'Inactive';
            botStatusTextEl.style.color = '#848e9c';
        }
        updateBotStatsOnPage(false); // Update display, don't increment
    }


    document.addEventListener('DOMContentLoaded', function() {
        updateTradingSignalsOnPage();
        startSignalCountdownsOnPage();
        updateBotActivityOnPage();
        updateBotStatsOnPage(false); // Initial display

        const botToggleEl = document.getElementById('botTogglePage');
        if (botToggleEl) {
            botToggleEl.addEventListener('click', toggleBotOnPage);
        }

        // Example: Update global header with placeholder or relevant data for bot page
        updateGlobalHeaderDisplay(12345.67, 100.50);

        // If you need real-time updates for bot stats even when this page is active
        // setInterval(() => updateBotStatsOnPage(true), 3000); // But be careful if global interval also runs
    });

</script>
@endpush
