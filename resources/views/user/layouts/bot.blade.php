@extends('user.layouts.app')

@section('title', 'Trading Bot - CoinTrades')

@push('styles')
    <style>
        /* Existing bot styles from layouts/app.blade.php are inherited */
        /* Add new styles for the trading form and active game display */
        .active-game-info-card,
        .trading-form-card,
        .active-trade-card {
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
            font-weight: 500;
        }

        .trading-form input[type="text"],
        .trading-form input[type="number"],
        .trading-form select {
            width: 100%;
            padding: 10px 12px;
            border-radius: 4px;
            border: 1px solid #2b3139;
            background-color: #0b0e11;
            color: #eaecef;
            font-size: 1em;
        }

        .trading-form input:focus,
        .trading-form select:focus {
            outline: none;
            border-color: #f0b90b;
            box-shadow: 0 0 0 2px rgba(240, 185, 11, 0.2);
        }

        .trading-form select {
            cursor: pointer;
        }

        .trading-form select option {
            background-color: #0b0e11;
            color: #eaecef;
        }

        .trade-direction-group {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }

        .trade-direction-btn {
            flex: 1;
            padding: 12px 16px;
            border: 2px solid #2b3139;
            background-color: #0b0e11;
            color: #c1c8d1;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .trade-direction-btn:hover {
            border-color: #f0b90b;
            color: #f0b90b;
        }

        .trade-direction-btn.buy.active {
            border-color: #0ecb81;
            background-color: rgba(14, 203, 129, 0.1);
            color: #0ecb81;
        }

        .trade-direction-btn.sell.active {
            border-color: #f6465d;
            background-color: rgba(246, 70, 93, 0.1);
            color: #f6465d;
        }

        .crypto-select-group {
            position: relative;
        }

        .crypto-option {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
        }

        .crypto-icon {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: linear-gradient(45deg, #f0b90b, #ffd700);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: bold;
            color: #000;
        }

        .trade-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .trade-actions .action-btn {
            /* Reuses .action-btn from global styles */
            flex-grow: 1;
            padding: 12px 16px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .trade-actions .action-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .trade-info-preview {
            background-color: #1e2026;
            border: 1px solid #2b3139;
            border-radius: 6px;
            padding: 12px;
            margin-bottom: 15px;
        }

        .trade-info-preview p {
            margin: 0;
            font-size: 0.9em;
            color: #c1c8d1;
        }

        .trade-info-display span {
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: 500;
            font-size: 0.85em;
        }

        .trade-info-display .crypto-category-display {
            background-color: #2b3139;
            color: #f0b90b;
        }

        .trade-info-display .trade-type-display.buy {
            background-color: rgba(14, 203, 129, 0.2);
            color: #0ecb81;
        }

        .trade-info-display .trade-type-display.sell {
            background-color: rgba(246, 70, 93, 0.2);
            color: #f6465d;
        }

        /* Active Trade Card */
        .active-trade-details p {
            margin-bottom: 0.6rem;
            font-size: 0.95em;
        }

        .active-trade-details strong {
            color: #f0b90b;
        }

        .active-trade-details .pnl-positive {
            color: #0ecb81;
        }

        .active-trade-details .pnl-negative {
            color: #f6465d;
        }

        .close-trade-btn {
            width: 100%;
            margin-top: 15px;
            padding: 10px;
        }

        .countdown-timer-inline {
            /* For game end time countdown */
            font-weight: bold;
            color: #f0b90b;
        }

        .form-note {
            color: #848e9c;
            font-size: 0.85em;
            margin-top: 5px;
        }

        .balance-warning {
            color: #f6465d;
            font-size: 0.85em;
            margin-top: 5px;
            display: none;
        }
    </style>
@endpush

@section('content')
    <div id="bot-page-content">
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
                        <span id="botStatusTextPage">Inactive</span>
                    </div>
                    <div class="bot-toggle" id="botTogglePage"></div>
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

        {{-- Check if there are any active games available --}}
        @if ($activeGameSetting)
            {{-- Trading Form - Show if bot is active and user can place trades --}}
            <div id="tradingFormCard" class="card trading-form-card" style="display: none;">
                <div class="card-header">
                    <div class="card-title"><i class="fas fa-exchange-alt"></i> Place Your Trade</div>
                </div>
                <div class="card-body">
                    <form id="placeTradeForm" method="POST" action="#" class="trading-form">
                        @csrf

                        {{-- Trade Direction Selection --}}
                        <div class="form-group">
                            <label>Select Trade Direction:</label>
                            <div class="trade-direction-group">
                                <div class="trade-direction-btn buy" data-direction="buy">
                                    <i class="fas fa-arrow-up"></i>
                                    <span>BUY / LONG</span>
                                </div>
                                <div class="trade-direction-btn sell" data-direction="sell">
                                    <i class="fas fa-arrow-down"></i>
                                    <span>SELL / SHORT</span>
                                </div>
                            </div>
                            <input type="hidden" name="trade_type" id="selectedTradeType" required>
                        </div>

                        {{-- Cryptocurrency Selection --}}
                        <div class="form-group crypto-select-group">
                            <label for="crypto_category">Select Cryptocurrency:</label>
                            <select name="crypto_category" id="crypto_category" required>
                                <option value="">Choose a cryptocurrency...</option>
                                <option value="btc">Bitcoin (BTC)</option>
                                <option value="eth">Ethereum (ETH)</option>
                                <option value="xrp">Ripple (XRP)</option>
                                <option value="sol">Solana (SOL)</option>
                                <option value="ada">Cardano (ADA)</option>
                                <option value="dot">Polkadot (DOT)</option>
                                <option value="matic">Polygon (MATIC)</option>
                                <option value="link">Chainlink (LINK)</option>
                                <option value="doge">Dogecoin (DOGE)</option>
                                <option value="pi">Pi Network (PI)</option>
                            </select>
                        </div>

                        {{-- Trade Preview --}}
                        <div class="trade-info-preview" id="tradePreview" style="display: none;">
                            <p><strong>Trade Summary:</strong></p>
                            <p>
                                Direction: <span id="previewDirection" class="trade-type-display">-</span> |
                                Crypto: <span id="previewCrypto" class="crypto-category-display">-</span>
                            </p>
                        </div>

                        {{-- Trade Amount --}}
                        <div class="form-group">
                            <label for="trade_amount">Amount to Trade (USD):</label>
                            <input type="number" id="trade_amount" name="amount" step="0.01" min="10"
                                   placeholder="e.g., 100" required oninput="updateAvailableBalanceWarning(this.value)">
                            <div class="form-note">Available Balance: ${{ number_format(Auth::user()->balance, 2) }}</div>
                            <div id="balanceWarning" class="balance-warning">Amount exceeds available balance.</div>
                        </div>

                        {{-- Trade Execution --}}
                        <div class="trade-actions">
                            <button type="submit" id="executeTradeBtn" class="action-btn" disabled>
                                <i class="fas fa-exchange-alt"></i>
                                <span id="executeBtnText">Select Direction & Crypto</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Display Active User Investments --}}
            @if ($activeUserInvestment && count($activeUserInvestment) > 0)
                @foreach($activeUserInvestment as $investment)
                    <div class="card active-trade-card">
                        <div class="card-header">
                            <div class="card-title">
                                <i class="fas fa-stopwatch"></i>
                                Active Trade - {{ strtoupper($investment->crypto_category) }}
                            </div>
                        </div>
                        <div class="card-body active-trade-details">
                            <p><strong>Trading:</strong> {{ strtoupper($investment->crypto_category) }}</p>
                            <p><strong>Direction:</strong>
                                <span class="trade-type-display {{ $investment->type === 'buy' ? 'buy' : 'sell' }}">
                                    {{ strtoupper($investment->type) }}
                                </span>
                            </p>
                            <p><strong>Invested Amount:</strong> ${{ number_format($investment->amount, 2) }}</p>
                            <p><strong>Opened At:</strong>
                                {{ \Carbon\Carbon::parse($investment->created_at)->format('M d, Y H:i') }}</p>
                            <p><strong>Status:</strong>
                                <span class="countdown-timer-inline" data-end-time="{{ $investment->game_end_time }}">
                                    Active
                                </span>
                            </p>
                            <p><strong>Current PNL (Est.):</strong>
                                <span id="activeTradePnl_{{ $investment->id }}" class="pnl-positive">Calculating...</span>
                            </p>

                            <form method="POST" action="#">
                                @csrf
                                <input type="hidden" name="user_investment_id" value="{{ $investment->id }}">
                                <button type="submit" class="action-btn sell close-trade-btn">
                                    <i class="fas fa-times-circle"></i> Close Trade Now
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
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
        let tradingSignalsData = [];
        let botActivityData = [];
        let botStatsInitialData = {
            profit24h: {{ $bot_profit_24h ?? 0 }},
            trades24h: {{ $bot_trades_24h ?? 0 }},
            successRate: {{ $bot_success_rate ?? 0.0 }},
            uptimeSeconds: {{ $bot_uptime_seconds ?? 0 }}
        };
        let initialBotActiveState = {{ $is_bot_globally_active ? 'true' : 'false' }};

        // User data
        const userAvailableBalance = parseFloat("{{ Auth::user()->balance ?? 0 }}");
        const activeGamesAvailable = {{ $activeGameSetting ? 'true' : 'false' }};

        document.addEventListener('DOMContentLoaded', function() {
            const botToggleEl = document.getElementById('botTogglePage');
            const botStatusContainerEl = document.getElementById('botStatusContainerPage');
            const botIndicatorEl = document.getElementById('botIndicatorPage');
            const botStatusTextEl = document.getElementById('botStatusTextPage');
            const tradingFormCardEl = document.getElementById('tradingFormCard');

            // Trading form elements
            const tradeDirectionBtns = document.querySelectorAll('.trade-direction-btn');
            const selectedTradeTypeInput = document.getElementById('selectedTradeType');
            const cryptoCategorySelect = document.getElementById('crypto_category');
            const tradePreview = document.getElementById('tradePreview');
            const previewDirection = document.getElementById('previewDirection');
            const previewCrypto = document.getElementById('previewCrypto');
            const executeTradeBtn = document.getElementById('executeTradeBtn');
            const executeBtnText = document.getElementById('executeBtnText');

            let botActive = initialBotActiveState;
            let selectedDirection = '';
            let selectedCrypto = '';

            function formatCurrency(amount) {
                return new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'USD'
                }).format(amount);
            }

            function updateBotDisplayStatus() {
                if (!botToggleEl || !botStatusContainerEl || !botIndicatorEl || !botStatusTextEl) return;

                if (botActive) {
                    botToggleEl.classList.add('active');
                    botStatusContainerEl.classList.remove('inactive');
                    botIndicatorEl.classList.remove('inactive');
                    botStatusTextEl.textContent = 'Active';
                    botStatusTextEl.style.color = '#0ecb81';

                    if (activeGamesAvailable && tradingFormCardEl) {
                        tradingFormCardEl.style.display = 'block';
                    }
                } else {
                    botToggleEl.classList.remove('active');
                    botStatusContainerEl.classList.add('inactive');
                    botIndicatorEl.classList.add('inactive');
                    botStatusTextEl.textContent = 'Inactive';
                    botStatusTextEl.style.color = '#848e9c';

                    if (tradingFormCardEl) tradingFormCardEl.style.display = 'none';
                }
            }

            function updateTradePreview() {
                if (selectedDirection && selectedCrypto) {
                    tradePreview.style.display = 'block';

                    previewDirection.textContent = selectedDirection.toUpperCase();
                    previewDirection.className = `trade-type-display ${selectedDirection}`;

                    previewCrypto.textContent = selectedCrypto.toUpperCase();

                    executeTradeBtn.disabled = false;
                    executeTradeBtn.className = `action-btn ${selectedDirection}`;
                    executeBtnText.innerHTML = `<i class="fas fa-${selectedDirection === 'buy' ? 'shopping-cart' : 'hand-holding-usd'}"></i> Execute ${selectedDirection.toUpperCase()}`;
                } else {
                    tradePreview.style.display = 'none';
                    executeTradeBtn.disabled = true;
                    executeTradeBtn.className = 'action-btn';
                    executeBtnText.textContent = 'Select Direction & Crypto';
                }
            }

            // Trade direction selection
            tradeDirectionBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    tradeDirectionBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    selectedDirection = this.getAttribute('data-direction');
                    selectedTradeTypeInput.value = selectedDirection;
                    updateTradePreview();
                });
            });

            // Crypto selection
            if (cryptoCategorySelect) {
                cryptoCategorySelect.addEventListener('change', function() {
                    selectedCrypto = this.value;
                    updateTradePreview();
                });
            }

            // Bot toggle functionality
            if (botToggleEl) {
                botToggleEl.addEventListener('click', function() {
                    botActive = !botActive;
                    console.log("Bot toggled. New state:", botActive);

                    // TODO: Make API call to update bot status on backend
                    // fetch('/api/bot/toggle', {
                    //     method: 'POST',
                    //     body: JSON.stringify({isActive: botActive}),
                    //     headers: {
                    //         'Content-Type': 'application/json',
                    //         'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    //     }
                    // })
                    // .then(response => response.json())
                    // .then(data => {
                    //     botActive = data.isActive;
                    //     updateBotDisplayStatus();
                    // })
                    // .catch(error => console.error('Error:', error));

                    updateBotDisplayStatus();
                });
            }

            updateBotDisplayStatus();

            // Initialize bot stats display
            const botProfitElPage = document.getElementById('botProfitPageDisplay');
            const botTradesElPage = document.getElementById('botTradesPageDisplay');
            const botSuccessRateElPage = document.getElementById('botSuccessRatePageDisplay');
            const botUptimeElPage = document.getElementById('botUptimePageDisplay');

            if (botProfitElPage) {
                botProfitElPage.textContent = `${botStatsInitialData.profit24h >= 0 ? '+' : ''}${formatCurrency(botStatsInitialData.profit24h)}`;
                botProfitElPage.className = `stat-value ${botStatsInitialData.profit24h >= 0 ? 'positive' : 'negative'}`;
            }
            if (botTradesElPage) botTradesElPage.textContent = botStatsInitialData.trades24h.toString();
            if (botSuccessRateElPage) {
                botSuccessRateElPage.textContent = `${botStatsInitialData.successRate.toFixed(1)}%`;
                botSuccessRateElPage.className = `stat-value ${botStatsInitialData.successRate >= 90 ? 'positive' : ''}`;
            }
            if (botUptimeElPage) {
                const h = Math.floor(botStatsInitialData.uptimeSeconds / 3600);
                const m = Math.floor((botStatsInitialData.uptimeSeconds % 3600) / 60);
                botUptimeElPage.textContent = `${h}h ${m}m`;
            }
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
