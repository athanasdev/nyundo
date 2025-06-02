@extends('user.layouts.app')

@section('title', 'Trading Bot - Soria10')

@push('styles')
    <style>
        /* Existing bot styles from layouts/app.blade.php are inherited */
        /* Add new styles for the trading form and active game display */
        .active-game-info-card,
        .trading-form-card,
        .active-trade-card,
        .chart-card {
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

        /* Signal Timing Cards */
        .signal-timing-card {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            border: 1px solid #2b3139;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 16px;
        }

        .signal-timing-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .signal-title {
            color: #f0b90b;
            font-weight: 600;
            font-size: 1.1em;
        }

        .signal-status {
            padding: 4px 12px;
            border-radius: 16px;
            font-size: 0.8em;
            font-weight: 500;
        }

        .signal-status.waiting {
            background: rgba(240, 185, 11, 0.2);
            color: #f0b90b;
        }

        .signal-status.active {
            background: rgba(14, 203, 129, 0.2);
            color: #0ecb81;
        }

        .signal-status.expired {
            background: rgba(246, 70, 93, 0.2);
            color: #f6465d;
        }

        .timing-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 12px;
        }

        .timing-item {
            background: rgba(43, 49, 57, 0.5);
            padding: 10px;
            border-radius: 6px;
        }

        .timing-label {
            color: #848e9c;
            font-size: 0.8em;
            margin-bottom: 4px;
        }

        .timing-value {
            color: #eaecef;
            font-weight: 500;
        }

        .countdown-timer {
            text-align: center;
            padding: 16px;
            background: rgba(240, 185, 11, 0.1);
            border: 1px solid #f0b90b;
            border-radius: 8px;
            margin: 12px 0;
        }

        .countdown-display {
            font-size: 1.8em;
            font-weight: bold;
            color: #f0b90b;
            margin-bottom: 8px;
        }

        .countdown-label {
            color: #c1c8d1;
            font-size: 0.9em;
        }

        /* Chart Container */
        .chart-container {
            height: 400px;
            background: #0b0e11;
            border: 1px solid #2b3139;
            border-radius: 6px;
            position: relative;
        }

        .chart-loading {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #848e9c;
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 16px;
            border-bottom: 1px solid #2b3139;
        }

        .chart-symbol {
            color: #f0b90b;
            font-weight: 600;
            font-size: 1.1em;
        }

        .chart-price {
            color: #0ecb81;
            font-weight: 500;
        }

        .chart-change {
            font-size: 0.9em;
            font-weight: 500;
        }

        .chart-change.positive {
            color: #0ecb81;
        }

        .chart-change.negative {
            color: #f6465d;
        }

        /* Trading Form Enhancements */
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

        /* Profit Calculator */
        .profit-calculator {
            background: linear-gradient(135deg, #0b1426 0%, #1a1f3a 100%);
            border: 1px solid #2b3139;
            border-radius: 8px;
            padding: 16px;
            margin-top: 16px;
        }

        .profit-calculator-header {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            color: #f0b90b;
            font-weight: 600;
        }

        .profit-calculator-header i {
            margin-right: 8px;
        }

        .profit-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 16px;
        }

        .profit-item {
            background: rgba(43, 49, 57, 0.3);
            padding: 12px;
            border-radius: 6px;
            text-align: center;
        }

        .profit-label {
            color: #848e9c;
            font-size: 0.8em;
            margin-bottom: 4px;
        }

        .profit-value {
            font-size: 1.1em;
            font-weight: 600;
        }

        .profit-value.investment {
            color: #c1c8d1;
        }

        .profit-value.potential {
            color: #0ecb81;
        }

        .profit-summary {
            background: rgba(14, 203, 129, 0.1);
            border: 1px solid #0ecb81;
            border-radius: 6px;
            padding: 12px;
            text-align: center;
        }

        .total-return {
            color: #0ecb81;
            font-size: 1.2em;
            font-weight: bold;
        }

        .return-percentage {
            color: #848e9c;
            font-size: 0.9em;
            margin-top: 4px;
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

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .timing-info {
                grid-template-columns: 1fr;
            }

            .profit-details {
                grid-template-columns: 1fr;
            }

            .chart-container {
                height: 300px;
            }
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
            {{-- Signal Timing Information --}}
            <div class="signal-timing-card">
                <div class="signal-timing-header">
                    <div class="signal-title">
                        <i class="fas fa-broadcast-tower"></i> Trading Signal #{{ $activeGameSetting->id ?? 'N/A' }}
                    </div>
                    <div class="signal-status waiting" id="signalStatus">Waiting</div>
                </div>

                <div class="timing-info">
                    <div class="timing-item">
                        <div class="timing-label">Opening Time</div>
                        <div class="timing-value" id="signalOpenTime">
                            {{ isset($activeGameSetting) ? \Carbon\Carbon::parse($activeGameSetting->start_time)->format('M d, Y H:i') : 'N/A' }}
                        </div>
                    </div>
                    <div class="timing-item">
                        <div class="timing-label">Closing Time</div>
                        <div class="timing-value" id="signalCloseTime">
                            {{ isset($activeGameSetting) ? \Carbon\Carbon::parse($activeGameSetting->end_time)->format('M d, Y H:i') : 'N/A' }}
                        </div>
                    </div>
                </div>

                <div class="countdown-timer" id="countdownContainer">
                    <div class="countdown-display" id="countdownDisplay">00:00:00</div>
                    <div class="countdown-label" id="countdownLabel">Time until signal opens</div>
                </div>
            </div>

            {{-- Candlestick Chart --}}
            <div class="card chart-card">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fas fa-chart-line"></i> Live Market Chart
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
                            <i class="fas fa-spinner fa-spin"></i> Loading chart...
                        </div>
                    </div>
                </div>
            </div>

            {{-- Trading Form - Show if bot is active and user can place trades --}}
            <div id="tradingFormCard" class="card trading-form-card" style="display: none;">
                <div class="card-header">
                    <div class="card-title"><i class="fas fa-exchange-alt"></i> Place Your Trade</div>
                </div>
                <div class="card-body">
                    <form id="placeTradeForm" method="POST" action="{{ route('bot.place_trade') }}" class="trading-form">
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
                                placeholder="e.g., 100" required oninput="updateProfitCalculator(this.value)">
                            <div class="form-note">Available Balance: ${{ number_format(Auth::user()->balance, 2) }}</div>
                            <div id="balanceWarning" class="balance-warning">Amount exceeds available balance.</div>
                        </div>

                        {{-- Profit Calculator --}}
                        <div class="profit-calculator" id="profitCalculator" style="display: none;">
                            <div class="profit-calculator-header">
                                <i class="fas fa-calculator"></i>
                                Profit Calculator
                            </div>
                            <div class="profit-details">
                                <div class="profit-item">
                                    <div class="profit-label">Your Investment</div>
                                    <div class="profit-value investment" id="investmentAmount">$0.00</div>
                                </div>
                                <div class="profit-item">
                                    <div class="profit-label">Potential Profit</div>
                                    <div class="profit-value potential" id="potentialProfit">$0.00</div>
                                </div>
                            </div>
                            <div class="profit-summary">
                                <div class="total-return" id="totalReturn">Total Return: $0.00</div>
                                <div class="return-percentage" id="returnPercentage">Expected ROI: 0.00%</div>
                            </div>
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
            @if ($activeUserInvestment && $activeUserInvestment->count() > 0)
                @foreach ($activeUserInvestment as $investment)
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
                            <p><strong>Closes At:</strong>
                                {{ \Carbon\Carbon::parse($investment->game_end_time)->format('M d, Y H:i') }}</p>
                            <p><strong>Status:</strong>
                                <span class="countdown-timer-inline" data-end-time="{{ $investment->game_end_time }}">
                                    Active
                                </span>
                            </p>
                            <p><strong>Current PNL (Est.):</strong>
                                <span id="activeTradePnl_{{ $investment->id }}" class="pnl-positive">Calculating...</span>
                            </p>

                            <form method="POST" action="{{ route('bot.close_trade') }}">
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
                    <p>There are no active trading signals at the moment. Please check back later.</p>
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
    <!-- TradingView Charting Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>

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

        // Signal timing data
        const signalData = {
            startTime: "{{ isset($activeGameSetting) ? $activeGameSetting->start_time : '' }}",
            endTime: "{{ isset($activeGameSetting) ? $activeGameSetting->end_time : '' }}",
            currentTime: "{{ now()->toISOString() }}"
        };

        // Profit calculation settings
        const profitSettings = {
            expectedROI: 15, // 15% expected return
            riskFactor: 0.85 // 85% success rate
        };

        let candlestickChart;
        let countdownInterval;

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

            function initializeCandlestickChart() {
                const ctx = document.getElementById('tradingViewChart');
                if (!ctx) return;

                // Generate sample candlestick data
                const sampleData = generateSampleCandlestickData();

                // Clear loading message
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
                            x: {
                                grid: {
                                    color: '#2b3139'
                                },
                                ticks: {
                                    color: '#848e9c'
                                }
                            },
                            y: {
                                grid: {
                                    color: '#2b3139'
                                },
                                ticks: {
                                    color: '#848e9c'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        elements: {
                            point: {
                                radius: 0
                            }
                        }
                    }
                });

                // Update chart data periodically
                setInterval(updateChartData, 5000);
            }

            function generateSampleCandlestickData() {
                const labels = [];
                const prices = [];
                const basePrice = 45000;
                let currentPrice = basePrice;

                for (let i = 0; i < 50; i++) {
                    const time = new Date();
                    time.setMinutes(time.getMinutes() - (49 - i));
                    labels.push(time.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}));

                    // Generate realistic price movement
                    const change = (Math.random() - 0.5) * 200;
                    currentPrice += change;
                    prices.push(currentPrice);
                }

                return { labels, prices };
            }

            function updateChartData() {
                if (!candlestickChart) return;

                // Simulate new price data
                const lastPrice = candlestickChart.data.datasets[0].data.slice(-1)[0];
                const change = (Math.random() - 0.5) * 100;
                const newPrice = lastPrice + change;

                // Add new data point
                const now = new Date();
                candlestickChart.data.labels.push(now.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}));
                candlestickChart.data.datasets[0].data.push(newPrice);

                // Remove old data points (keep last 50)
                if (candlestickChart.data.labels.length > 50) {
                    candlestickChart.data.labels.shift();
                    candlestickChart.data.datasets[0].data.shift();
                }

                candlestickChart.update('none');

                // Update price display
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

            function initializeCountdown() {
                if (!signalData.startTime || !signalData.endTime) return;

                const startTime = new Date(signalData.startTime);
                const endTime = new Date(signalData.endTime);
                const currentTime = new Date();

                countdownInterval = setInterval(() => {
                    const now = new Date();
                    const signalStatus = document.getElementById('signalStatus');
                    const countdownDisplay = document.getElementById('countdownDisplay');
                    const countdownLabel = document.getElementById('countdownLabel');

                    if (now < startTime) {
                        // Signal hasn't started yet
                        const timeToStart = startTime - now;
                        const hours = Math.floor(timeToStart / (1000 * 60 * 60));
                        const minutes = Math.floor((timeToStart % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((timeToStart % (1000 * 60)) / 1000);

                        signalStatus.textContent = 'Waiting';
                        signalStatus.className = 'signal-status waiting';
                        countdownDisplay.textContent = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                        countdownLabel.textContent = 'Time until signal opens';
                    } else if (now >= startTime && now < endTime) {
                        // Signal is active
                        const timeToEnd = endTime - now;
                        const hours = Math.floor(timeToEnd / (1000 * 60 * 60));
                        const minutes = Math.floor((timeToEnd % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((timeToEnd % (1000 * 60)) / 1000);

                        signalStatus.textContent = 'Active';
                        signalStatus.className = 'signal-status active';
                        countdownDisplay.textContent = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                        countdownLabel.textContent = 'Time remaining to trade';
                    } else {
                        // Signal has expired
                        signalStatus.textContent = 'Expired';
                        signalStatus.className = 'signal-status expired';
                        countdownDisplay.textContent = '00:00:00';
                        countdownLabel.textContent = 'Signal has ended';
                        clearInterval(countdownInterval);
                    }
                }, 1000);
            }

            function updateProfitCalculator(amount) {
                const profitCalculator = document.getElementById('profitCalculator');
                const investmentAmount = document.getElementById('investmentAmount');
                const potentialProfit = document.getElementById('potentialProfit');
                const totalReturn = document.getElementById('totalReturn');
                const returnPercentage = document.getElementById('returnPercentage');
                const balanceWarningEl = document.getElementById('balanceWarning');

                const tradeAmount = parseFloat(amount);

                // Check balance warning
                if (!isNaN(tradeAmount) && tradeAmount > userAvailableBalance) {
                    balanceWarningEl.style.display = 'block';
                } else {
                    balanceWarningEl.style.display = 'none';
                }

                if (!isNaN(tradeAmount) && tradeAmount > 0) {
                    profitCalculator.style.display = 'block';

                    const expectedProfit = tradeAmount * (profitSettings.expectedROI / 100);
                    const totalReturnAmount = tradeAmount + expectedProfit;

                    investmentAmount.textContent = formatCurrency(tradeAmount);
                    potentialProfit.textContent = formatCurrency(expectedProfit);
                    totalReturn.textContent = `Total Return: ${formatCurrency(totalReturnAmount)}`;
                    returnPercentage.textContent = `Expected ROI: ${profitSettings.expectedROI}%`;
                } else {
                    profitCalculator.style.display = 'none';
                }
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

                    // Update chart symbol
                    const chartSymbol = document.getElementById('chartSymbol');
                    if (chartSymbol) {
                        chartSymbol.textContent = `${selectedCrypto}/USD`;
                    }

                    executeTradeBtn.disabled = false;
                    executeTradeBtn.className = `action-btn ${selectedDirection}`;
                    executeBtnText.innerHTML =
                        `<i class="fas fa-${selectedDirection === 'buy' ? 'shopping-cart' : 'hand-holding-usd'}"></i> Execute ${selectedDirection.toUpperCase()}`;
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

            // Initialize components
            updateBotDisplayStatus();
            initializeCandlestickChart();
            initializeCountdown();

            // Initialize bot stats display
            const botProfitElPage = document.getElementById('botProfitPageDisplay');
            const botTradesElPage = document.getElementById('botTradesPageDisplay');
            const botSuccessRateElPage = document.getElementById('botSuccessRatePageDisplay');
            const botUptimeElPage = document.getElementById('botUptimePageDisplay');

            if (botProfitElPage) {
                botProfitElPage.textContent =
                    `${botStatsInitialData.profit24h >= 0 ? '+' : ''}${formatCurrency(botStatsInitialData.profit24h)}`;
                botProfitElPage.className =
                    `stat-value ${botStatsInitialData.profit24h >= 0 ? 'positive' : 'negative'}`;
            }
            if (botTradesElPage) botTradesElPage.textContent = botStatsInitialData.trades24h.toString();
            if (botSuccessRateElPage) {
                botSuccessRateElPage.textContent = `${botStatsInitialData.successRate.toFixed(1)}%`;
                botSuccessRateElPage.className =
                    `stat-value ${botStatsInitialData.successRate >= 90 ? 'positive' : ''}`;
            }
            if (botUptimeElPage) {
                const h = Math.floor(botStatsInitialData.uptimeSeconds / 3600);
                const m = Math.floor((botStatsInitialData.uptimeSeconds % 3600) / 60);
                botUptimeElPage.textContent = `${h}h ${m}m`;
            }

            // Update active trade countdowns
            updateActiveTradeCountdowns();
        });

        function updateActiveTradeCountdowns() {
            const countdownElements = document.querySelectorAll('.countdown-timer-inline');

            countdownElements.forEach(element => {
                const endTime = element.getAttribute('data-end-time');
                if (!endTime) return;

                const endDate = new Date(endTime);

                const updateCountdown = () => {
                    const now = new Date();
                    const timeLeft = endDate - now;

                    if (timeLeft > 0) {
                        const hours = Math.floor(timeLeft / (1000 * 60 * 60));
                        const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                        element.textContent = `${hours}h ${minutes}m ${seconds}s remaining`;
                    } else {
                        element.textContent = 'Expired';
                        element.style.color = '#f6465d';
                    }
                };

                updateCountdown();
                setInterval(updateCountdown, 1000);
            });
        }

        // Make updateProfitCalculator available globally
        window.updateProfitCalculator = updateProfitCalculator;

        // Cleanup on page unload
        window.addEventListener('beforeunload', function() {
            if (countdownInterval) {
                clearInterval(countdownInterval);
            }
        });
    </script>
@endpush
