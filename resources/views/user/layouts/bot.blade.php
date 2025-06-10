@extends('user.layouts.app')

@section('title', __('messages.bot_page_title') . ' - Soria10')

@push('styles')
    <style>
        /* Styles are inherited, only page-specific styles are here */
        .active-game-info-card, .trading-form-card, .active-trade-card, .chart-card { margin-top: 16px; }
        .active-game-details p { margin-bottom: 0.5rem; font-size: 0.95em; }
        .active-game-details strong { color: #f0b90b; margin-right: 5px; }
        .active-game-details .game-time { font-size: 0.85em; color: #848e9c; }
        .no-active-game { text-align: center; padding: 20px; color: #848e9c; }
        .signal-timing-card { background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); border: 1px solid #2b3139; border-radius: 8px; padding: 16px; margin-bottom: 16px; }
        .signal-timing-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
        .signal-title { color: #f0b90b; font-weight: 600; font-size: 1.1em; }
        .signal-status { padding: 4px 12px; border-radius: 16px; font-size: 0.8em; font-weight: 500; }
        .signal-status.waiting { background: rgba(240, 185, 11, 0.2); color: #f0b90b; }
        .signal-status.active { background: rgba(14, 203, 129, 0.2); color: #0ecb81; }
        .signal-status.expired { background: rgba(246, 70, 93, 0.2); color: #f6465d; }
        .timing-info { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 12px; }
        .timing-item { background: rgba(43, 49, 57, 0.5); padding: 10px; border-radius: 6px; }
        .timing-label { color: #848e9c; font-size: 0.8em; margin-bottom: 4px; }
        .timing-value { color: #eaecef; font-weight: 500; }
        .countdown-timer { text-align: center; padding: 16px; background: rgba(240, 185, 11, 0.1); border: 1px solid #f0b90b; border-radius: 8px; margin: 12px 0; }
        .countdown-display { font-size: 1.8em; font-weight: bold; color: #f0b90b; margin-bottom: 8px; }
        .countdown-label { color: #c1c8d1; font-size: 0.9em; }
        .chart-container { height: 400px; background: #0b0e11; border: 1px solid #2b3139; border-radius: 6px; position: relative; }
        .chart-loading { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #848e9c; }
        .chart-header { display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; border-bottom: 1px solid #2b3139; }
        .chart-symbol { color: #f0b90b; font-weight: 600; font-size: 1.1em; }
        .chart-price { color: #0ecb81; font-weight: 500; }
        .chart-change { font-size: 0.9em; font-weight: 500; }
        .chart-change.positive { color: #0ecb81; }
        .chart-change.negative { color: #f6465d; }
        .trading-form .form-group { margin-bottom: 15px; }
        .trading-form label { display: block; margin-bottom: 6px; color: #c1c8d1; font-size: 0.9em; font-weight: 500; }
        .trading-form input[type="text"], .trading-form input[type="number"], .trading-form select { width: 100%; padding: 10px 12px; border-radius: 4px; border: 1px solid #2b3139; background-color: #0b0e11; color: #eaecef; font-size: 1em; }
        .trading-form input:focus, .trading-form select:focus { outline: none; border-color: #f0b90b; box-shadow: 0 0 0 2px rgba(240, 185, 11, 0.2); }
        .trading-form select { cursor: pointer; }
        .trading-form select option { background-color: #0b0e11; color: #eaecef; }
        .trade-direction-group { display: flex; gap: 10px; margin-bottom: 15px; }
        .trade-direction-btn { flex: 1; padding: 12px 16px; border: 2px solid #2b3139; background-color: #0b0e11; color: #c1c8d1; border-radius: 6px; cursor: pointer; transition: all 0.3s ease; text-align: center; font-weight: 500; display: flex; align-items: center; justify-content: center; gap: 8px; }
        .trade-direction-btn:hover { border-color: #f0b90b; color: #f0b90b; }
        .trade-direction-btn.buy.active { border-color: #0ecb81; background-color: rgba(14, 203, 129, 0.1); color: #0ecb81; }
        .trade-direction-btn.sell.active { border-color: #f6465d; background-color: rgba(246, 70, 93, 0.1); color: #f6465d; }
        .profit-calculator { background: linear-gradient(135deg, #0b1426 0%, #1a1f3a 100%); border: 1px solid #2b3139; border-radius: 8px; padding: 16px; margin-top: 16px; }
        .profit-calculator-header { display: flex; align-items: center; margin-bottom: 12px; color: #f0b90b; font-weight: 600; }
        .profit-calculator-header i { margin-right: 8px; }
        .profit-details { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 16px; }
        .profit-item { background: rgba(43, 49, 57, 0.3); padding: 12px; border-radius: 6px; text-align: center; }
        .profit-label { color: #848e9c; font-size: 0.8em; margin-bottom: 4px; }
        .profit-value { font-size: 1.1em; font-weight: 600; }
        .profit-value.investment { color: #c1c8d1; }
        .profit-value.potential { color: #0ecb81; }
        .profit-summary { background: rgba(14, 203, 129, 0.1); border: 1px solid #0ecb81; border-radius: 6px; padding: 12px; text-align: center; }
        .total-return { color: #0ecb81; font-size: 1.2em; font-weight: bold; }
        .return-percentage { color: #848e9c; font-size: 0.9em; margin-top: 4px; }
        .trade-actions { display: flex; gap: 10px; margin-top: 20px; }
        .trade-actions .action-btn { flex-grow: 1; padding: 12px 16px; font-weight: 500; transition: all 0.3s ease; }
        .trade-actions .action-btn:disabled { opacity: 0.6; cursor: not-allowed; }
        .trade-info-preview { background-color: #1e2026; border: 1px solid #2b3139; border-radius: 6px; padding: 12px; margin-bottom: 15px; }
        .trade-info-preview p { margin: 0; font-size: 0.9em; color: #c1c8d1; }
        .trade-info-display span { padding: 4px 8px; border-radius: 4px; font-weight: 500; font-size: 0.85em; }
        .trade-info-display .crypto-category-display { background-color: #2b3139; color: #f0b90b; }
        .trade-info-display .trade-type-display.buy { background-color: rgba(14, 203, 129, 0.2); color: #0ecb81; }
        .trade-info-display .trade-type-display.sell { background-color: rgba(246, 70, 93, 0.2); color: #f6465d; }
        .active-trade-details p { margin-bottom: 0.6rem; font-size: 0.95em; }
        .active-trade-details strong { color: #f0b90b; }
        .active-trade-details .pnl-positive { color: #0ecb81; }
        .active-trade-details .pnl-negative { color: #f6465d; }
        .close-trade-btn { width: 100%; margin-top: 15px; padding: 10px; }
        .countdown-timer-inline { font-weight: bold; color: #f0b90b; }
        .form-note { color: #848e9c; font-size: 0.85em; margin-top: 5px; }
        .balance-warning { color: #f6465d; font-size: 0.85em; margin-top: 5px; display: none; }
        @media (max-width: 768px) {
            .timing-info, .profit-details { grid-template-columns: 1fr; }
            .chart-container { height: 300px; }
        }
    </style>
@endpush

@section('content')
    <div id="bot-page-content">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <i class="fas fa-cogs"></i> {{ __('messages.trading_bot_control') }}
                </div>
            </div>
            <div class="card-body">
                <div class="bot-status" id="botStatusContainerPage">
                    <div class="bot-info">
                        <i class="fas fa-robot"></i>
                        <span>{{ __('messages.automated_trading_bot') }}</span>
                        <span class="status-indicator" id="botIndicatorPage"></span>
                        <span id="botStatusTextPage">{{ __('messages.status_inactive') }}</span>
                    </div>
                    <div class="bot-toggle" id="botTogglePage"></div>
                </div>

                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-value positive" id="botProfitPageDisplay">$0.00</div>
                        <div class="stat-label">{{ __('messages.bot_profit_24h') }}</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value" id="botTradesPageDisplay">0</div>
                        <div class="stat-label">{{ __('messages.bot_trades_24h') }}</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value positive" id="botSuccessRatePageDisplay">0.0%</div>
                        <div class="stat-label">{{ __('messages.bot_success_rate') }}</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value" id="botUptimePageDisplay">0h 0m</div>
                        <div class="stat-label">{{ __('messages.current_uptime') }}</div>
                    </div>
                </div>
            </div>
        </div>

        @if ($activeGameSetting)
            {{-- Signal Timing Information --}}
            <div class="signal-timing-card">
                <div class="signal-timing-header">
                    <div class="signal-title">
                        <i class="fas fa-broadcast-tower"></i> {{ __('messages.trading_signal') }} #{{ $activeGameSetting->id ?? __('messages.not_applicable') }}
                    </div>
                    <div class="signal-status waiting" id="signalStatus">{{ __('messages.status_waiting') }}</div>
                </div>

                <div class="timing-info">
                    <div class="timing-item">
                        <div class="timing-label">{{ __('messages.opening_time') }}</div>
                        <div class="timing-value" id="signalOpenTime">
                            {{ isset($activeGameSetting) ? $activeGameSetting->start_time->format('M d, Y H:i') : __('messages.not_applicable') }}
                        </div>
                    </div>
                    <div class="timing-item">
                        <div class="timing-label">{{ __('messages.closing_time') }}</div>
                        <div class="timing-value" id="signalCloseTime">
                            {{ isset($activeGameSetting) ? $activeGameSetting->end_time->format('M d, Y H:i') : __('messages.not_applicable') }}
                        </div>
                    </div>
                </div>

                <div class="countdown-timer" id="countdownContainer">
                    <div class="countdown-display" id="countdownDisplay">00:00:00</div>
                    <div class="countdown-label" id="countdownLabel">{{ __('messages.time_until_opens') }}</div>
                </div>
            </div>

            {{-- Candlestick Chart --}}
            <div class="card chart-card">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fas fa-chart-line"></i> {{ __('messages.live_market_chart') }}
                    </div>
                </div>
                <div class="card-body" style="padding: 0;">
                    <div class="chart-header">
                        <div class="chart-symbol" id="chartSymbol">BTC/USD</div>
                        <div style="display: flex; gap: 16px; align-items: center;">
                            <div class="chart-price" id="chartPrice">$0.00</div>
                            <div class="chart-change positive" id="chartChange">+0.00%</div>
                        </div>
                    </div>
                    <div class="chart-container" id="tradingViewChart">
                        <div class="chart-loading">
                            <i class="fas fa-spinner fa-spin"></i> {{ __('messages.loading_chart') }}...
                        </div>
                    </div>
                </div>
            </div>

            <div class="section">
                @if ($errors->any())
                    <div class="alert-error flex items-start space-x-2">
                        <span class="mt-1">⚠️</span>
                        <ul style="list-style-type: none;" class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert-error flex items-center space-x-2">
                        <span>❌</span>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success flex items-center space-x-2">
                        <span>✅</span>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
            </div>

            {{-- Trading Form --}}
            <div id="tradingFormCard" class="card trading-form-card" style="display: none;">
                <div class="card-header">
                    <div class="card-title"><i class="fas fa-exchange-alt"></i> {{ __('messages.place_your_trade') }}</div>
                </div>
                <div class="card-body">
                    <form id="placeTradeForm" method="POST" action="{{ route('bot.place_trade') }}" class="trading-form">
                        @csrf

                        <div class="form-group">
                            <label>{{ __('messages.select_trade_direction') }}</label>
                            <div class="trade-direction-group">
                                <div class="trade-direction-btn buy" data-direction="buy">
                                    <i class="fas fa-arrow-up"></i>
                                    <span>{{ __('messages.buy_long') }}</span>
                                </div>
                                <div class="trade-direction-btn sell" data-direction="sell">
                                    <i class="fas fa-arrow-down"></i>
                                    <span>{{ __('messages.sell_short') }}</span>
                                </div>
                            </div>
                            <input type="hidden" name="trade_type" id="selectedTradeType" required>
                        </div>

                        <div class="form-group crypto-select-group">
                            <label for="crypto_category">{{ __('messages.select_cryptocurrency') }}</label>
                            <select name="crypto_category" id="crypto_category" required>
                                <option value="">{{ __('messages.choose_cryptocurrency') }}...</option>
                                <option value="BTC">Bitcoin (BTC)</option>
                                <option value="ETH">Ethereum (ETH)</option>
                                <option value="XRP">Ripple (XRP)</option>
                                <option value="SOL">Solana (SOL)</option>
                                <option value="ADA">Cardano (ADA)</option>
                                <option value="DOT">Polkadot (DOT)</option>
                                <option value="DOGE">Dogecoin (DOGE)</option>
                                <option value="PI">Pi Network (PI)</option>
                            </select>
                        </div>

                        <div class="trade-info-preview" id="tradePreview" style="display: none;">
                            <p><strong>{{ __('messages.trade_summary') }}:</strong></p>
                            <p>
                                {{ __('messages.direction') }}: <span id="previewDirection" class="trade-type-display">-</span> |
                                {{ __('messages.crypto') }}: <span id="previewCrypto" class="crypto-category-display">-</span>
                            </p>
                        </div>

                        <div class="form-group">
                            <label for="trade_amount">{{ __('messages.amount_to_trade_usd') }}</label>
                            <input type="number" id="trade_amount" name="amount" step="0.01" min="10" placeholder="{{ __('messages.amount_placeholder') }}" required oninput="updateProfitCalculator(this.value)">
                            <div class="form-note">{{ __('messages.available_balance') }}: ${{ number_format(Auth::user()->balance, 2) }}</div>
                            <div id="balanceWarning" class="balance-warning">{{ __('messages.insufficient_balance') }}</div>
                        </div>

                        <div class="profit-calculator" id="profitCalculator" style="display: none;">
                            <div class="profit-calculator-header">
                                <i class="fas fa-calculator"></i>
                                {{ __('messages.profit_calculator') }}
                            </div>
                            <div class="profit-details">
                                <div class="profit-item">
                                    <div class="profit-label">{{ __('messages.your_investment') }}</div>
                                    <div class="profit-value investment" id="investmentAmount">$0.00</div>
                                </div>
                                <div class="profit-item">
                                    <div class="profit-label">{{ __('messages.potential_profit') }}</div>
                                    <div class="profit-value potential" id="potentialProfit">$0.00</div>
                                </div>
                            </div>
                            <div class="profit-summary">
                                <div class="total-return" id="totalReturn">{{ __('messages.total_return') }}: $0.00</div>
                                <div class="return-percentage" id="returnPercentage">{{ __('messages.expected_roi') }}: 0.00%</div>
                            </div>
                        </div>

                        <div class="trade-actions">
                            <button type="submit" id="executeTradeBtn" class="action-btn" disabled>
                                <i class="fas fa-exchange-alt"></i>
                                <span id="executeBtnText">{{ __('messages.execute_trade_button_default') }}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            @if ($activeUserInvestment && $activeUserInvestment->count() > 0)
                @foreach ($activeUserInvestment as $investment)
                    <div class="card active-trade-card">
                        <div class="card-header">
                            <div class="card-title">
                                <i class="fas fa-stopwatch"></i>
                                {{ __('messages.active_trade_title') }} - {{ strtoupper($investment->crypto_category) }}
                            </div>
                        </div>
                        <div class="card-body active-trade-details">
                            <p><strong>{{ __('messages.trading') }}:</strong> {{ strtoupper($investment->crypto_category) }}</p>
                            <p><strong>{{ __('messages.direction') }}:</strong>
                                <span class="trade-type-display {{ $investment->type === 'buy' ? 'buy' : 'sell' }}">
                                    {{ strtoupper($investment->type) }}
                                </span>
                            </p>
                            <p><strong>{{ __('messages.invested_amount') }}:</strong> ${{ number_format($investment->amount, 2) }}</p>
                            <p><strong>{{ __('messages.opened_at') }}:</strong>
                                {{ \Carbon\Carbon::parse($investment->created_at)->format('M d, Y H:i') }}</p>
                            <p><strong>{{ __('messages.closes_at') }}:</strong>
                                {{ \Carbon\Carbon::parse($investment->game_end_time)->format('M d, Y H:i') }}</p>
                            <p><strong>{{ __('messages.current_pnl') }}:</strong>
                                <span id="activeTradePnl_{{ $investment->id }}" class="pnl-positive">{{ __('messages.calculating') }}...</span>
                            </p>

                            <form method="POST" action="{{ route('bot.close_trade') }}">
                                @csrf
                                <input type="hidden" name="user_investment_id" value="{{ $investment->id }}">
                                <button type="submit" class="action-btn sell close-trade-btn">
                                    <i class="fas fa-times-circle"></i> {{ __('messages.close_trade_now') }}
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
                    <p>{{ __('messages.no_active_signals') }}</p>
                </div>
            </div>
        @endif
    </div>
@endsection


@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script>
        // --- DATA FROM LARAVEL CONTROLLER ---
        const botStatsInitialData = {
            profit24h: {{ $bot_profit_24h ?? 0 }},
            trades24h: {{ $bot_trades_24h ?? 0 }},
            successRate: {{ $bot_success_rate ?? 0.0 }},
            uptimeSeconds: {{ $bot_uptime_seconds ?? 0 }}
        };
        const initialBotActiveState = {{ $is_bot_globally_active ? 'true' : 'false' }};
        const userAvailableBalance = parseFloat("{{ Auth::user()->balance ?? 0 }}");
        const activeGamesAvailable = {{ $activeGameSetting ? 'true' : 'false' }};
        const signalData = {
            startTime: "{{ isset($activeGameSetting) ? $activeGameSetting->start_time->toISOString() : '' }}",
            endTime: "{{ isset($activeGameSetting) ? $activeGameSetting->end_time->toISOString() : '' }}",
        };
        const profitSettings = {
            expectedROI: {{ $activeGameSetting->earning_percentage ?? 0 }},
        };

        // --- LOCALIZATION FOR JAVASCRIPT ---
        const lang = {
            status_active: "{{ __('messages.status_active') }}",
            status_inactive: "{{ __('messages.status_inactive') }}",
            status_waiting: "{{ __('messages.status_waiting') }}",
            status_expired: "{{ __('messages.status_expired') }}",
            time_until_opens: "{{ __('messages.time_until_opens') }}",
            time_remaining_to_trade: "{{ __('messages.time_remaining_to_trade') }}",
            signal_has_ended: "{{ __('messages.signal_has_ended') }}",
            execute_buy_button: `<i class="fas fa-exchange-alt"></i> {{ __('messages.execute_buy') }}`,
            execute_sell_button: `<i class="fas fa-exchange-alt"></i> {{ __('messages.execute_sell') }}`,
            execute_trade_button_default: "{{ __('messages.execute_trade_button_default') }}",
            total_return_prefix: "{{ __('messages.total_return') }}",
            expected_roi_prefix: "{{ __('messages.expected_roi') }}"
        };
        // -----------------------------------------

        let countdownInterval;

        document.addEventListener('DOMContentLoaded', function() {
            // --- ELEMENTS ---
            let candlestickChart;
            const botToggleEl = document.getElementById('botTogglePage');
            const botStatusTextEl = document.getElementById('botStatusTextPage');
            const tradingFormCardEl = document.getElementById('tradingFormCard');
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

            // --- HELPER FUNCTIONS ---
            function formatCurrency(amount) {
                return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(amount);
            }

            // --- UI UPDATE & INITIALIZATION FUNCTIONS ---
            function updateBotDisplayStatus() {
                if (!botToggleEl) return;
                if (botActive) {
                    botToggleEl.classList.add('active');
                    botStatusTextEl.textContent = lang.status_active;
                    botStatusTextEl.style.color = '#0ecb81';
                    if (activeGamesAvailable && tradingFormCardEl) {
                        tradingFormCardEl.style.display = 'block';
                    }
                } else {
                    botToggleEl.classList.remove('active');
                    botStatusTextEl.textContent = lang.status_inactive;
                    botStatusTextEl.style.color = '#848e9c';
                    if (tradingFormCardEl) tradingFormCardEl.style.display = 'none';
                }
            }

            function initializeCountdown() {
                if (!signalData.startTime || !signalData.endTime) return;
                const startTime = new Date(signalData.startTime);
                const endTime = new Date(signalData.endTime);

                countdownInterval = setInterval(() => {
                    const now = new Date();
                    const signalStatus = document.getElementById('signalStatus');
                    const countdownDisplay = document.getElementById('countdownDisplay');
                    const countdownLabel = document.getElementById('countdownLabel');

                    if (now < startTime) {
                        const timeToStart = startTime - now;
                        const h = Math.floor(timeToStart / 3600000);
                        const m = Math.floor((timeToStart % 3600000) / 60000);
                        const s = Math.floor((timeToStart % 60000) / 1000);
                        signalStatus.textContent = lang.status_waiting;
                        signalStatus.className = 'signal-status waiting';
                        countdownDisplay.textContent = `${h.toString().padStart(2, '0')}:${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
                        countdownLabel.textContent = lang.time_until_opens;
                    } else if (now < endTime) {
                        const timeToEnd = endTime - now;
                        const h = Math.floor(timeToEnd / 3600000);
                        const m = Math.floor((timeToEnd % 3600000) / 60000);
                        const s = Math.floor((timeToEnd % 60000) / 1000);
                        signalStatus.textContent = lang.status_active;
                        signalStatus.className = 'signal-status active';
                        countdownDisplay.textContent = `${h.toString().padStart(2, '0')}:${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
                        countdownLabel.textContent = lang.time_remaining_to_trade;
                    } else {
                        signalStatus.textContent = lang.status_expired;
                        signalStatus.className = 'signal-status expired';
                        countdownDisplay.textContent = '00:00:00';
                        countdownLabel.textContent = lang.signal_has_ended;
                        clearInterval(countdownInterval);
                    }
                }, 1000);
            }

            function updateTradePreview() {
                if (selectedDirection && selectedCrypto) {
                    tradePreview.style.display = 'block';
                    previewDirection.textContent = selectedDirection.toUpperCase();
                    previewDirection.className = `trade-type-display ${selectedDirection}`;
                    previewCrypto.textContent = selectedCrypto.toUpperCase();
                    document.getElementById('chartSymbol').textContent = `${selectedCrypto}/USD`;
                    executeTradeBtn.disabled = false;
                    executeTradeBtn.className = `action-btn ${selectedDirection}`;
                    executeBtnText.innerHTML = (selectedDirection === 'buy') ? lang.execute_buy_button : lang.execute_sell_button;
                } else {
                    tradePreview.style.display = 'none';
                    executeTradeBtn.disabled = true;
                    executeTradeBtn.className = 'action-btn';
                    executeBtnText.textContent = lang.execute_trade_button_default;
                }
            }

            function initializeCandlestickChart() {
                const ctx = document.getElementById('tradingViewChart');
                if (!ctx) return;
                const sampleData = generateSampleCandlestickData();
                ctx.innerHTML = '<canvas id="chartCanvas"></canvas>';
                const canvas = document.getElementById('chartCanvas');
                candlestickChart = new Chart(canvas, {
                    type: 'line',
                    data: {
                        labels: sampleData.labels,
                        datasets: [{
                            label: 'Price',
                            data: sampleData.prices,
                            borderColor: '#f0b90b',
                            backgroundColor: 'rgba(240, 185, 11, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: { grid: { color: '#2b3139' }, ticks: { color: '#848e9c' } },
                            y: { grid: { color: '#2b3139' }, ticks: { color: '#848e9c' } }
                        },
                        plugins: { legend: { display: false } },
                        elements: { point: { radius: 0 } }
                    }
                });
                setInterval(updateChartData, 5000);
            }

            function generateSampleCandlestickData() {
                const labels = [];
                const prices = [];
                let currentPrice = 45000;
                for (let i = 0; i < 50; i++) {
                    const time = new Date();
                    time.setMinutes(time.getMinutes() - (49 - i));
                    labels.push(time.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }));
                    currentPrice += (Math.random() - 0.5) * 200;
                    prices.push(currentPrice);
                }
                return { labels, prices };
            }

            function updateChartData() {
                if (!candlestickChart) return;
                const lastPrice = candlestickChart.data.datasets[0].data.slice(-1)[0];
                const change = (Math.random() - 0.5) * 100;
                const newPrice = lastPrice + change;
                const now = new Date();
                candlestickChart.data.labels.push(now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }));
                candlestickChart.data.datasets[0].data.push(newPrice);
                if (candlestickChart.data.labels.length > 50) {
                    candlestickChart.data.labels.shift();
                    candlestickChart.data.datasets[0].data.shift();
                }
                candlestickChart.update('none');
                updatePriceDisplay(newPrice, change);
            }

            function updatePriceDisplay(price, change) {
                const chartPrice = document.getElementById('chartPrice');
                const chartChange = document.getElementById('chartChange');
                if (chartPrice) {
                    chartPrice.textContent = formatCurrency(price);
                }
                if (chartChange) {
                    const changePercent = (change / price * 100).toFixed(2);
                    chartChange.textContent = `${change >= 0 ? '+' : ''}${changePercent}%`;
                    chartChange.className = `chart-change ${change >= 0 ? 'positive' : 'negative'}`;
                }
            }

            function simulatePnlUpdates() {
                const pnlElements = document.querySelectorAll('[id^="activeTradePnl_"]');
                if (pnlElements.length === 0) return;
                pnlElements.forEach(el => {
                    el.dataset.currentPnl = (Math.random() * 2 - 1).toFixed(2);
                });
                setInterval(() => {
                    pnlElements.forEach(el => {
                        let currentPnl = parseFloat(el.dataset.currentPnl);
                        currentPnl += (Math.random() - 0.5) * 0.25;
                        el.dataset.currentPnl = currentPnl.toFixed(4);
                        const displayPnl = currentPnl.toFixed(2);
                        const sign = displayPnl >= 0 ? '+' : '';
                        el.textContent = `${sign}$ ${Math.abs(displayPnl)}`;
                        el.className = displayPnl >= 0 ? 'pnl-positive' : 'pnl-negative';
                    });
                }, 2500);
            }

            // --- EVENT LISTENERS ---
            tradeDirectionBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    tradeDirectionBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    selectedDirection = this.dataset.direction;
                    selectedTradeTypeInput.value = selectedDirection;
                    updateTradePreview();
                });
            });
            if (cryptoCategorySelect) {
                cryptoCategorySelect.addEventListener('change', function() {
                    selectedCrypto = this.value;
                    updateTradePreview();
                });
            }
            if (botToggleEl) {
                botToggleEl.addEventListener('click', function() {
                    botActive = !botActive;
                    updateBotDisplayStatus();
                });
            }

            // --- INITIAL PAGE LOAD CALLS ---
            updateBotDisplayStatus();
            initializeCandlestickChart();
            initializeCountdown();
            simulatePnlUpdates(); // PNL simulation starts here

            document.getElementById('botProfitPageDisplay').textContent = formatCurrency(botStatsInitialData.profit24h);
            document.getElementById('botTradesPageDisplay').textContent = botStatsInitialData.trades24h;
            document.getElementById('botSuccessRatePageDisplay').textContent = `${botStatsInitialData.successRate.toFixed(1)}%`;
            const h = Math.floor(botStatsInitialData.uptimeSeconds / 3600);
            const m = Math.floor((botStatsInitialData.uptimeSeconds % 3600) / 60);
            document.getElementById('botUptimePageDisplay').textContent = `${h}h ${m}m`;
        });

        function updateProfitCalculator(amount) {
            const profitCalculator = document.getElementById('profitCalculator');
            const investmentAmountEl = document.getElementById('investmentAmount');
            const potentialProfitEl = document.getElementById('potentialProfit');
            const totalReturnEl = document.getElementById('totalReturn');
            const returnPercentageEl = document.getElementById('returnPercentage');
            const balanceWarningEl = document.getElementById('balanceWarning');
            const tradeAmount = parseFloat(amount);

            if (tradeAmount > userAvailableBalance) {
                balanceWarningEl.style.display = 'block';
            } else {
                balanceWarningEl.style.display = 'none';
            }

            if (!isNaN(tradeAmount) && tradeAmount > 0) {
                profitCalculator.style.display = 'block';
                const expectedProfit = tradeAmount * (profitSettings.expectedROI / 100);
                const totalReturnAmount = tradeAmount + expectedProfit;
                const formatter = new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' });

                investmentAmountEl.textContent = formatter.format(tradeAmount);
                potentialProfitEl.textContent = formatter.format(expectedProfit);
                totalReturnEl.textContent = `${lang.total_return_prefix}: ${formatter.format(totalReturnAmount)}`;
                returnPercentageEl.textContent = `${lang.expected_roi_prefix}: ${profitSettings.expectedROI}%`;
            } else {
                profitCalculator.style.display = 'none';
            }
        }

        window.addEventListener('beforeunload', () => clearInterval(countdownInterval));
    </script>
@endpush
