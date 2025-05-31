@extends('user.layouts.app')

@section('title', 'Trading Bot - CoinTrades')

@push('styles')
<style>
    /* Existing bot styles from layouts/app.blade.php are inherited */
    /* Add new styles for the trading form and active game display */
    .active-game-info-card, .trading-form-card, .active-trade-card {
        margin-top: 16px;
    }

    .active-game-details p {
        margin-bottom: 0.5rem;
        font-size: 0.95em;
    }
    .active-game-details strong {
        color: #f0b90b;
        margin-right: 5px;
    }
    .active-game-details .game-time {
        font-size: 0.85em;
        color: #848e9c;
    }
    .no-active-game {
        text-align: center;
        padding: 20px;
        color: #848e9c;
    }

    .trading-form .form-group {
        margin-bottom: 15px;
    }
    .trading-form label {
        display: block;
        margin-bottom: 6px;
        color: #c1c8d1;
        font-size: 0.9em;
    }
    .trading-form input[type="text"],
    .trading-form input[type="number"] {
        width: 100%;
        padding: 10px 12px;
        border-radius: 4px;
        border: 1px solid #2b3139;
        background-color: #0b0e11;
        color: #eaecef;
        font-size: 1em;
    }
    .trading-form input:focus {
        outline: none;
        border-color: #f0b90b;
        box-shadow: 0 0 0 2px rgba(240, 185, 11, 0.2);
    }
    .trade-actions {
        display: flex;
        gap: 10px;
        margin-top: 15px;
    }
    .trade-actions .action-btn { /* Reuses .action-btn from global styles */
        flex-grow: 1;
    }
    .trade-info-display span {
        padding: 6px 10px;
        border-radius: 4px;
        font-weight: 500;
    }
    .trade-info-display .crypto-category-display {
        background-color: #2b3139; color: #f0b90b;
    }
    .trade-info-display .trade-type-display.buy {
        background-color: rgba(14, 203, 129, 0.2); color: #0ecb81;
    }
    .trade-info-display .trade-type-display.sell {
        background-color: rgba(246, 70, 93, 0.2); color: #f6465d;
    }

    /* Active Trade Card */
    .active-trade-details p { margin-bottom: 0.6rem; font-size: 0.95em;}
    .active-trade-details strong { color: #f0b90b; }
    .active-trade-details .pnl-positive { color: #0ecb81; }
    .active-trade-details .pnl-negative { color: #f6465d; }
    .close-trade-btn {
        width: 100%;
        margin-top: 15px;
        padding: 10px;
    }
    .countdown-timer-inline { /* For game end time countdown */
        font-weight: bold;
        color: #f0b90b;
    }
</style>
@endpush

@section('content')
<div id="bot-page-content"> {{-- Changed ID to avoid conflict with original 'bot' --}}
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
                    <span id="botStatusTextPage">Inactive</span> {{-- Default to Inactive --}}
                </div>
                <div class="bot-toggle" id="botTogglePage"></div> {{-- Will be initialized by JS --}}
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-value positive" id="botProfitPageDisplay">$0.00</div>
                    <div class="stat-label">Bot Profit (24h)</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" id="botTradesPageDisplay">0</div>
                    <div class="stat-label">Bot Trades (24h)</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value positive" id="botSuccessRatePageDisplay">0.0%</div>
                    <div class="stat-label">Bot Success Rate</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" id="botUptimePageDisplay">0h 0m</div>
                    <div class="stat-label">Current Uptime</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Display Active Game Setting --}}
    @if($activeGameSetting)
        <div class="card active-game-info-card">
            <div class="card-header">
                <div class="card-title"><i class="fas fa-gamepad"></i> Current Active Game</div>
            </div>
            <div class="card-body active-game-details">
                <p><strong>Crypto Category:</strong> <span class="crypto-category-display" style="text-transform: uppercase;">{{ $activeGameSetting->crypto_category }}</span></p>
                <p><strong>Market Direction:</strong>
                    <span class="trade-type-display {{ $activeGameSetting->type === 'buy' ? 'buy' : 'sell' }}" style="text-transform: uppercase;">
                        {{ $activeGameSetting->type }}
                    </span>
                </p>
                <p><strong>Earning Percentage:</strong> {{ $activeGameSetting->earning_percentage }}%</p>
                <p class="game-time"><strong>Game Ends In:</strong> <span class="countdown-timer-inline" id="activeGameEndTime">Loading...</span></p>
            </div>
        </div>

        {{-- Trading Form - Show if bot is active and no current user investment for this game --}}
        <div id="tradingFormCard" class="card trading-form-card" style="display: none;"> {{-- Initially hidden --}}
            <div class="card-header">
                <div class="card-title"><i class="fas fa-exchange-alt"></i> Place Your Trade</div>
            </div>
            <div class="card-body">
                <form id="placeTradeForm" method="POST" action="{{-- {{ route('bot.place_trade') }} --}}"> {{-- Route needs to be defined --}}
                    @csrf
                    <input type="hidden" name="game_setting_id" value="{{ $activeGameSetting->id }}">
                    <input type="hidden" name="trade_type" value="{{ $activeGameSetting->type }}">
                    <input type="hidden" name="crypto_category" value="{{ $activeGameSetting->crypto_category }}">

                    <div class="form-group trade-info-display">
                        <p>Trading: <span class="crypto-category-display">{{ strtoupper($activeGameSetting->crypto_category) }}</span>
                           Direction: <span class="trade-type-display {{ $activeGameSetting->type === 'buy' ? 'buy' : 'sell' }}">{{ strtoupper($activeGameSetting->type) }}</span>
                        </p>
                    </div>

                    <div class="form-group">
                        <label for="trade_amount">Amount to Trade (USD):</label>
                        <input type="number" id="trade_amount" name="amount" step="0.01" min="1" {{-- Example min --}}
                               placeholder="e.g., 100" required
                               oninput="updateAvailableBalanceWarning(this.value)">
                        <small class="note">Available Balance: ${{ number_format(Auth::user()->balance, 2) }}</small>
                        <small id="balanceWarning" style="color: #f6465d; display:none;">Amount exceeds available balance.</small>
                    </div>

                    <div class="trade-actions">
                        <button type="submit" class="action-btn {{ $activeGameSetting->type === 'buy' ? 'buy' : 'sell' }}">
                            <i class="fas fa-{{ $activeGameSetting->type === 'buy' ? 'shopping-cart' : 'hand-holding-usd' }}"></i>
                            Execute {{ ucfirst($activeGameSetting->type) }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Display Active User Investment for this Game & Option to Close --}}
        @if($activeUserInvestment)
        <div id="activeTradeCard" class="card active-trade-card">
            <div class="card-header">
                <div class="card-title"><i class="fas fa-stopwatch"></i> Your Active Trade</div>
            </div>
            <div class="card-body active-trade-details">
                <p><strong>Trading:</strong> {{ strtoupper($activeUserInvestment->crypto_category) }}</p>
                <p><strong>Direction:</strong> <span class="trade-type-display {{ $activeUserInvestment->type === 'buy' ? 'buy' : 'sell' }}">{{ strtoupper($activeUserInvestment->type) }}</span></p>
                <p><strong>Invested Amount:</strong> ${{ number_format($activeUserInvestment->amount, 2) }}</p>
                <p><strong>Opened At:</strong> {{ \Carbon\Carbon::parse($activeUserInvestment->game_start_time)->format('M d, Y H:i') }}</p>
                <p><strong>Game Ends:</strong> <span class="countdown-timer-inline" id="userTradeEndTime">Loading...</span></p>
                {{-- P&L could be updated via JS if you have live price feeds to compare against entry --}}
                <p><strong>Current PNL (Est.):</strong> <span id="activeTradePnl" class="pnl-positive">Calculating...</span></p>

                <form id="closeTradeForm" method="POST" action="{{-- {{ route('bot.close_trade') }} --}}"> {{-- Route needs to be defined --}}
                    @csrf
                    <input type="hidden" name="user_investment_id" value="{{ $activeUserInvestment->id }}">
                    <button type="submit" class="action-btn sell close-trade-btn">
                        <i class="fas fa-times-circle"></i> Close Trade Now
                    </button>
                </form>
            </div>
        </div>
        @endif

    @else
        <div class="card">
            <div class="card-body no-active-game">
                <p><i class="fas fa-hourglass-half fa-2x mb-2"></i></p>
                <p>There are no active trading games at the moment. Please check back later.</p>
            </div>
        </div>
    @endif

    {{-- Existing Bot Signals and Activity Log Cards --}}
    <div class="card" style="margin-top: 16px;">
        <div class="card-header">
            <div class="card-title"><i class="fas fa-bullseye"></i> Active Trading Signals</div>
        </div>
        <div class="card-body">
            <div class="trading-signals" id="tradingSignalsContainerPage">
                <p class="text-muted text-center p-3">No active signals currently.</p>
            </div>
        </div>
    </div>

    <div class="card" style="margin-top: 16px;">
        <div class="card-header">
            <div class="card-title"><i class="fas fa-clipboard-list"></i> Bot Activity Log</div>
        </div>
        <div class="card-body">
            <div id="botActivityListContainer">
                <p class="text-muted text-center p-3">No recent bot activity.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Sample data (replace with data from controller or API calls)
    let tradingSignalsData = [ /* ... your sample data ... */ ];
    let botActivityData = [ /* ... your sample data ... */ ];
    let botStatsInitialData = {
        profit24h: {{ $bot_profit_24h ?? 0 }}, // Pass these from controller
        trades24h: {{ $bot_trades_24h ?? 0 }},
        successRate: {{ $bot_success_rate ?? 0.0 }},
        uptimeSeconds: {{ $bot_uptime_seconds ?? 0 }}
    };
    let initialBotActiveState = {{ $is_bot_globally_active ?? 'true' }}; // From controller

    // Active Game Setting Data (passed from controller)
    const activeGameSetting = @json($activeGameSetting ?? null);
    const activeUserInvestment = @json($activeUserInvestment ?? null);
    const userAvailableBalance = parseFloat("{{ Auth::user()->balance ?? 0 }}");

    document.addEventListener('DOMContentLoaded', function() {
        const botToggleEl = document.getElementById('botTogglePage');
        const botStatusContainerEl = document.getElementById('botStatusContainerPage');
        const botIndicatorEl = document.getElementById('botIndicatorPage');
        const botStatusTextEl = document.getElementById('botStatusTextPage');
        const tradingFormCardEl = document.getElementById('tradingFormCard');
        const activeTradeCardEl = document.getElementById('activeTradeCard');

        let botActive = initialBotActiveState; // Reflect actual bot state

        function updateBotDisplayStatus() {
            if (!botToggleEl || !botStatusContainerEl || !botIndicatorEl || !botStatusTextEl) return;
            if (botActive) {
                botToggleEl.classList.add('active');
                botStatusContainerEl.classList.remove('inactive');
                botIndicatorEl.classList.remove('inactive'); // Ensure indicator is active styled
                botStatusTextEl.textContent = 'Active';
                botStatusTextEl.style.color = '#0ecb81';
                if (activeGameSetting && !activeUserInvestment && tradingFormCardEl) {
                    tradingFormCardEl.style.display = 'block';
                }
                if (activeUserInvestment && activeTradeCardEl) {
                    activeTradeCardEl.style.display = 'block';
                    if (tradingFormCardEl) tradingFormCardEl.style.display = 'none'; // Hide place trade form if trade active
                }

            } else {
                botToggleEl.classList.remove('active');
                botStatusContainerEl.classList.add('inactive');
                botIndicatorEl.classList.add('inactive'); // Ensure indicator is inactive styled
                botStatusTextEl.textContent = 'Inactive';
                botStatusTextEl.style.color = '#848e9c';
                if (tradingFormCardEl) tradingFormCardEl.style.display = 'none';
                // Closing an active trade should ideally be a separate explicit action,
                // not just tied to bot toggle, but if that's the logic:
                // if (activeUserInvestment && activeTradeCardEl) {
                //     // Trigger close trade logic or inform user
                //     console.log("Bot deactivated. Active trade needs handling.");
                // }
            }
        }

        if (botToggleEl) {
            botToggleEl.addEventListener('click', function() {
                // TODO: This should ideally POST to backend to change bot state
                // For now, just toggles UI and local 'botActive' variable
                botActive = !botActive;
                console.log("Bot toggled. New state (client-side):", botActive);
                // Example: Make an API call to toggle bot status on backend
                // fetch('/api/bot/toggle', { method: 'POST', body: JSON.stringify({isActive: botActive}), headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }})
                // .then(response => response.json())
                // .then(data => {
                //     console.log('Bot status updated on backend:', data);
                //     botActive = data.isActive; // Update based on server response
                //     updateBotDisplayStatus();
                // })
                // .catch(error => console.error('Error toggling bot status:', error));
                updateBotDisplayStatus(); // Update UI immediately for now
            });
        }

        updateBotDisplayStatus(); // Initial UI setup based on botActive and game state

        // Countdown Timers
        function setupCountdown(elementId, endTimeISO) {
            const endTimeEl = document.getElementById(elementId);
            if (!endTimeEl || !endTimeISO) return;

            const endTimestamp = new Date(endTimeISO).getTime();

            function updateTimer() {
                const now = new Date().getTime();
                const timeLeft = endTimestamp - now;

                if (timeLeft <= 0) {
                    endTimeEl.textContent = "Expired";
                    // Optionally disable form/buttons
                    if (tradingFormCardEl && elementId === 'activeGameEndTime') tradingFormCardEl.style.display = 'none';
                    if (activeTradeCardEl && elementId === 'userTradeEndTime') {
                        const closeBtn = activeTradeCardEl.querySelector('.close-trade-btn');
                        if(closeBtn) closeBtn.textContent = "Game Ended - Process Result"; // Or similar
                        // Might auto-trigger a close/result check here
                    }
                    return;
                }
                const d = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                const h = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const m = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                const s = Math.floor((timeLeft % (1000 * 60)) / 1000);

                let timerString = "";
                if (d > 0) timerString += `${d}d `;
                timerString += `${h.toString().padStart(2, '0')}:${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
                endTimeEl.textContent = timerString;

                requestAnimationFrame(updateTimer);
            }
            requestAnimationFrame(updateTimer);
        }

        if (activeGameSetting && activeGameSetting.end_time) {
            setupCountdown('activeGameEndTime', activeGameSetting.end_time);
        }
        if (activeUserInvestment && activeUserInvestment.game_end_time) {
            setupCountdown('userTradeEndTime', activeUserInvestment.game_end_time);
            // Placeholder for PNL update if you have live price feed for active investment
            // updateActiveTradePnl();
        }


        // Functions from your original script (updateTradingSignalsOnPage, etc.)
        // You'll need to adapt them to fetch data from your backend instead of sample data.
        // For brevity, I'm omitting the direct copy of those sample data display functions.
        // You would call functions here like:
        // fetchAndDisplayTradingSignals();
        // fetchAndDisplayBotActivity();
        // updateBotStatsOnPageDisplay(); // To display initial stats from controller

        // Example: Initialize bot stats display from passed data
        const botProfitElPage = document.getElementById('botProfitPageDisplay');
        const botTradesElPage = document.getElementById('botTradesPageDisplay');
        const botSuccessRateElPage = document.getElementById('botSuccessRatePageDisplay');
        const botUptimeElPage = document.getElementById('botUptimePageDisplay');

        if(botProfitElPage) botProfitElPage.textContent = `${botStatsInitialData.profit24h >=0 ? '+':''}${formatCurrency(botStatsInitialData.profit24h)}`;
        if(botProfitElPage) botProfitElPage.className = `stat-value ${botStatsInitialData.profit24h >=0 ? 'positive':'negative'}`;
        if(botTradesElPage) botTradesElPage.textContent = botStatsInitialData.trades24h.toString();
        if(botSuccessRateElPage) botSuccessRateElPage.textContent = `${botStatsInitialData.successRate.toFixed(1)}%`;
        if(botSuccessRateElPage) botSuccessRateElPage.className = `stat-value ${botStatsInitialData.successRate >= 90 ? 'positive':''}`;
        if(botUptimeElPage) {
            const h = Math.floor(botStatsInitialData.uptimeSeconds / 3600);
            const m = Math.floor((botStatsInitialData.uptimeSeconds % 3600) / 60);
            botUptimeElPage.textContent = `${h}h ${m}m`;
        }

        // Update global header display
        // updateGlobalHeaderDisplay( {{ Auth::user()->balance ?? 0 }}, {{-- some PNL value if available --}} 0);
    });

    function updateAvailableBalanceWarning(tradeAmount) {
        const amount = parseFloat(tradeAmount);
        const balanceWarningEl = document.getElementById('balanceWarning');
        if (!balanceWarningEl) return;

        if (!isNaN(amount) && amount > userAvailableBalance) {
            balanceWarningEl.style.display = 'block';
        } else {
            balanceWarningEl.style.display = 'none';
        }
    }

</script>
@endpush
