<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CoinTrades - Advanced Trading Platform</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: #0b0e11;
            color: #eaecef;
            min-height: 100vh;
            font-size: 14px;
            line-height: 1.5;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 16px;
            padding-bottom: 90px; /* Space for bottom nav */
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            padding: 16px 20px;
            background: #1e2329;
            border-radius: 4px;
            border: 1px solid #2b3139;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 20px;
            font-weight: 600;
            color: #f0b90b;
        }

        .logo i {
            font-size: 24px;
        }

        .user-balance {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .balance-item {
            text-align: right;
        }

        .balance-amount {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 2px;
        }

        .balance-label {
            color: #848e9c;
            font-size: 12px;
        }

        .positive { color: #0ecb81; }
        .negative { color: #f6465d; }

        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 16px;
            margin-bottom: 24px;
        }

        .main-content {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .sidebar {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .card {
            background: #1e2329;
            border-radius: 4px;
            border: 1px solid #2b3139;
            overflow: hidden;
        }

        .card-header {
            padding: 16px 20px;
            border-bottom: 1px solid #2b3139;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-title {
            font-size: 16px;
            font-weight: 600;
            color: #eaecef;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-body {
            padding: 16px 20px;
        }

        .coins-list {
            display: flex;
            flex-direction: column;
        }

        .coin-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 20px;
            border-bottom: 1px solid #2b3139;
            transition: background-color 0.2s;
            cursor: pointer;
        }

        .coin-item:last-child {
            border-bottom: none;
        }

        .coin-item:hover {
            background: #2b3139;
        }

        .coin-info {
            display: flex;
            align-items: center;
            gap: 12px;
            flex: 1;
        }

        .coin-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 600;
            color: white;
        }

        .btc { background: #f7931a; }
        .eth { background: #627eea; }
        .bnb { background: #f0b90b; }
        .ada { background: #0033ad; }
        .sol { background: #9945ff; }
        .dot { background: #e6007a; }

        .coin-details {
            flex: 1;
        }

        .coin-name {
            font-weight: 500;
            margin-bottom: 2px;
        }

        .coin-symbol {
            color: #848e9c;
            font-size: 12px;
        }

        .coin-price {
            text-align: right;
            min-width: 120px;
        }

        .price {
            font-weight: 500;
            margin-bottom: 2px;
        }

        .change {
            font-size: 12px;
            font-weight: 500;
        }

        .chart-container {
            height: 300px;
            background: #0b0e11; /* Darker background for chart area */
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .trading-view {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(15, 185, 177, 0.05), rgba(240, 185, 11, 0.05)); /* Subtle gradient */
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .chart-placeholder {
            color: #848e9c;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .quick-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .action-btn {
            padding: 12px 16px;
            border: none;
            border-radius: 4px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 14px;
        }

        .action-btn.buy {
            background: #0ecb81;
            color: white;
        }

        .action-btn.sell {
            background: #f6465d;
            color: white;
        }

        .action-btn:hover {
            opacity: 0.8;
            transform: translateY(-1px);
        }

        .portfolio-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #2b3139;
        }

        .portfolio-item:last-child {
            border-bottom: none;
        }

        .bot-status {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px;
            background: rgba(14, 203, 129, 0.1);
            border-radius: 4px;
            margin-bottom: 16px;
            border: 1px solid rgba(14, 203, 129, 0.2);
        }

        .bot-status.inactive {
            background: rgba(132, 142, 156, 0.1);
            border-color: rgba(132, 142, 156, 0.2);
        }
        .bot-status.inactive .status-indicator {
            background: #848e9c;
            animation: none;
        }
        .bot-status.inactive #botStatusText {
            color: #848e9c;
        }


        .bot-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .bot-info i { color: #f0b90b; }
        #botStatusText { color: #0ecb81; font-weight: 500;}


        .bot-toggle {
            width: 48px;
            height: 24px;
            background: #848e9c;
            border-radius: 12px;
            position: relative;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .bot-toggle.active {
            background: #0ecb81;
        }

        .bot-toggle::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            background: white;
            border-radius: 50%;
            top: 2px;
            left: 2px;
            transition: all 0.3s ease;
        }

        .bot-toggle.active::after {
            left: 26px;
        }

        .status-indicator {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #0ecb81;
            animation: pulse 2s infinite;
        }

        .status-indicator.inactive { /* For general inactive use if needed elsewhere */
            background: #848e9c;
            animation: none;
        }


        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }

        .content-section {
            display: none;
            animation: fadeIn 0.5s;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .content-section.active {
            display: block;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 16px;
            margin-bottom: 16px; /* Added margin */
        }

        .stat-card {
            background: #2b3139;
            padding: 16px;
            border-radius: 4px;
            text-align: center;
        }

        .stat-value {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 12px;
            color: #848e9c;
        }

        .trading-signals {
            margin-bottom: 16px;
        }

        .signal-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px;
            background: #2b3139;
            border-radius: 4px;
            margin-bottom: 12px;
            border-left: 4px solid;
        }

        .signal-item.buy {
            border-left-color: #0ecb81;
        }
        .signal-item.buy .signal-type i { color: #0ecb81; }

        .signal-item.sell {
            border-left-color: #f6465d;
        }
        .signal-item.sell .signal-type i { color: #f6465d; }


        .signal-info {
            flex: 1;
        }

        .signal-type {
            font-weight: 600;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .signal-details {
            color: #848e9c;
            font-size: 12px;
        }

        .countdown-timer {
            text-align: right; /* Align to right */
            min-width: 90px; /* Increased width */
        }

        .countdown-time {
            font-size: 18px;
            font-weight: 600;
            color: #f0b90b;
        }

        .countdown-label {
            font-size: 11px;
            color: #848e9c;
        }

        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #1e2329;
            border-top: 1px solid #2b3139;
            padding: 10px 0; /* Adjusted padding */
            z-index: 1000;
            box-shadow: 0 -2px 5px rgba(0,0,0,0.1);
        }

        .nav-container {
            max-width: 1400px; /* Consistent with .container */
            margin: 0 auto;
            display: flex;
            justify-content: space-around;
            align-items: center;
        }

        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            cursor: pointer;
            transition: all 0.2s ease;
            padding: 6px 10px; /* Adjusted padding */
            border-radius: 4px;
            color: #848e9c;
            flex: 1; /* Distribute space evenly */
            text-align: center;
        }

        .nav-item.active {
            color: #f0b90b;
            background: #2b3139;
        }

        .nav-item:hover:not(.active) { /* Prevent hover on active */
            color: #eaecef;
            background: #262b32;
        }
        .nav-item i { font-size: 18px; margin-bottom: 2px; } /* Icon size */

        .nav-text {
            font-size: 11px;
            font-weight: 500;
        }

        .activity-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #2b3139;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .activity-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        .activity-icon.buy {
            background: rgba(14, 203, 129, 0.2);
            color: #0ecb81;
        }

        .activity-icon.sell {
            background: rgba(246, 70, 93, 0.2);
            color: #f6465d;
        }
        .activity-icon.bot {
            background: rgba(240, 185, 11, 0.2);
            color: #f0b90b;
        }
        .activity-icon.system {
            background: rgba(132, 142, 156, 0.2);
            color: #848e9c;
        }


        .activity-details h4 {
            font-weight: 500;
            margin-bottom: 2px;
            color: #eaecef;
        }

        .activity-details span {
            color: #848e9c;
            font-size: 12px;
        }

        .activity-result {
            text-align: right;
        }
        .activity-result strong { font-weight: 500; }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }

            .sidebar {
                order: -1; /* Moves sidebar to top on smaller screens */
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 12px;
                padding-bottom: 80px; /* Adjust for nav bar */
            }

            .header {
                flex-direction: column;
                gap: 12px;
                text-align: center;
            }

            .user-balance {
                justify-content: center;
                gap: 12px; /* Reduce gap */
            }
            .balance-item { text-align: center; }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr); /* 2 columns for stats */
            }

            .chart-container {
                height: 250px; /* Slightly more height */
            }
            .nav-item i { font-size: 16px; }
            .nav-text { font-size: 10px; }
        }

        @media (max-width: 480px) {
            .quick-actions {
                grid-template-columns: 1fr; /* Single column for quick actions */
            }

            .stats-grid {
                grid-template-columns: 1fr; /* Single column for stats on very small screens */
            }

            .coin-item {
                padding: 10px 16px;
                flex-direction: column; /* Stack coin info and price */
                align-items: flex-start;
                gap: 8px;
            }
            .coin-price { text-align: left; width: 100%; }

            .signal-item {
                padding: 12px;
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
            .countdown-timer { text-align: left; width: 100%;}


            .countdown-time {
                font-size: 16px;
            }
            .nav-container { justify-content: space-between; } /* Better spacing for fewer items if needed */
            .nav-item { padding: 6px 8px; gap: 2px;}
            .nav-item i { font-size: 14px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <i class="fas fa-chart-line"></i>
                CoinTrades
            </div>
            <div class="user-balance">
                <div class="balance-item">
                    <div class="balance-amount positive" id="userBalance">$12,456.78</div>
                    <div class="balance-label">Total Balance</div>
                </div>
                <div class="balance-item">
                    <div class="balance-amount positive" id="todayPnL">+$234.56</div>
                    <div class="balance-label">Today's P&L</div>
                </div>
            </div>
        </div>

        <div id="assets" class="content-section active">
            <div class="dashboard-grid">
                <div class="main-content">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <i class="fas fa-chart-area"></i>
                                Live Market Data
                                <span class="status-indicator" title="Live Feed Active"></span>
                            </div>
                        </div>
                        <div class="card-body" style="padding: 0;">
                            <div class="chart-container">
                                <div class="trading-view">
                                    <div class="chart-placeholder">
                                        <i class="fas fa-chart-line"></i>
                                        Real-time Chart View (Placeholder)
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <i class="fab fa-bitcoin"></i>
                                Top Cryptocurrencies
                            </div>
                        </div>
                        <div class="coins-list" id="coinsList">
                            </div>
                    </div>
                </div>

                <div class="sidebar">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <i class="fas fa-bolt"></i>
                                Quick Actions
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="quick-actions">
                                <button class="action-btn buy">
                                    <i class="fas fa-arrow-up"></i>
                                    Buy
                                </button>
                                <button class="action-btn sell">
                                    <i class="fas fa-arrow-down"></i>
                                    Sell
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <i class="fas fa-wallet"></i>
                                Portfolio
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="portfolioList">
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="accounts" class="content-section">
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
                            <div class="stat-value positive" id="totalValueAcc">$12,456.78</div>
                            <div class="stat-label">Total Value</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value" id="availableBalanceAcc">$3,245.67</div>
                            <div class="stat-label">Available Funds</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value" id="investedAcc">$9,211.11</div>
                            <div class="stat-label">Invested Capital</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value positive" id="pnlAcc">+$1,234.56</div>
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
                    <div id="transactionsList">
                        </div>
                </div>
            </div>
        </div>

        <div id="team" class="content-section">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fas fa-users"></i>
                        Trading Team Performance
                    </div>
                </div>
                <div class="card-body">
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-value">15</div>
                            <div class="stat-label">Active Traders</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value positive">87.3%</div>
                            <div class="stat-label">Avg. Success Rate</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value positive">$45,123</div>
                            <div class="stat-label">Team Profit (Month)</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value">234</div>
                            <div class="stat-label">Team Trades Today</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card" style="margin-top: 16px;">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fas fa-trophy"></i>
                        Top Performers
                    </div>
                </div>
                <div class="card-body">
                    <div id="teamList">
                        </div>
                </div>
            </div>
        </div>

        <div id="bot" class="content-section">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fas fa-cogs"></i> Trading Bot Control
                    </div>
                </div>
                <div class="card-body">
                    <div class="bot-status" id="botStatusContainer">
                        <div class="bot-info">
                            <i class="fas fa-robot"></i>
                            <span>Automated Trading Bot</span>
                            <span class="status-indicator" id="botIndicator"></span>
                            <span id="botStatusText">Active</span>
                        </div>
                        <div class="bot-toggle active" id="botToggle" onclick="toggleBot()"></div>
                    </div>

                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-value positive" id="botProfit">+$2,456.78</div>
                            <div class="stat-label">Bot Profit (24h)</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value" id="botTrades">156</div>
                            <div class="stat-label">Bot Trades (24h)</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value positive" id="botSuccessRate">92.4%</div>
                            <div class="stat-label">Bot Success Rate</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value" id="botUptime">23h 45m</div>
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
                    <div class="trading-signals" id="tradingSignalsContainer">
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
                    <div id="botActivityList">
                        </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bottom-nav">
        <div class="nav-container">
            <div class="nav-item active" data-section="assets" onclick="showSection('assets', this)">
                <i class="fas fa-coins"></i>
                <span class="nav-text">Assets</span>
            </div>
            <div class="nav-item" data-section="accounts" onclick="showSection('accounts', this)">
                <i class="fas fa-user"></i>
                <span class="nav-text">Account</span>
            </div>
            <div class="nav-item" data-section="team" onclick="showSection('team', this)">
                <i class="fas fa-users"></i>
                <span class="nav-text">Team</span>
            </div>
            <div class="nav-item" data-section="bot" onclick="showSection('bot', this)">
                <i class="fas fa-robot"></i>
                <span class="nav-text">Bot</span>
            </div>
        </div>
    </div>

    <script>
        // Sample data
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

        const teamData = [
            { name: 'Alex Chen', profit: 2456.78, trades: 23, success: 95.2, avatar: 'fas fa-user-tie' },
            { name: 'Sarah Wilson', profit: 1890.45, trades: 18, success: 88.9, avatar: 'fas fa-user-graduate' },
            { name: 'Mike Johnson', profit: 3245.67, trades: 31, success: 93.5, avatar: 'fas fa-user-secret' },
            { name: 'Lisa Davis', profit: 1567.89, trades: 15, success: 80.0, avatar: 'fas fa-user-astronaut' }
        ];

        let tradingSignalsData = [
            { id: 'sig1', type: 'BUY', coin: 'BTC', price: 45000, target: 46500, timeLeft: 180, originalTime: 180 },
            { id: 'sig2', type: 'SELL', coin: 'ETH', price: 3200, target: 3050, timeLeft: 95, originalTime: 95 },
            { id: 'sig3', type: 'BUY', coin: 'SOL', price: 120, target: 135, timeLeft: 240, originalTime: 240 }
        ];

        let transactionData = [
            { type: 'Buy', coin: 'BTC', amountCoin: 0.1, amountUSD: 4523.45, date: '2025-05-28 10:30', status: 'Completed' },
            { type: 'Sell', coin: 'ETH', amountCoin: 0.5, amountUSD: 1578.39, date: '2025-05-28 09:15', status: 'Completed' },
            { type: 'Deposit', coin: 'USD', amountCoin: 1000, amountUSD: 1000, date: '2025-05-27 15:00', status: 'Confirmed' },
            { type: 'Withdrawal', coin: 'USD', amountCoin: 500, amountUSD: 500, date: '2025-05-26 12:00', status: 'Pending' }
        ];

        let botActivityData = [
            { time: '10:35:12', action: 'BUY BTC', details: '0.02 BTC @ $45100.50', profit: null, type:'buy' },
            { time: '10:30:05', action: 'SELL ETH', details: '0.1 ETH @ $3180.20', profit: 15.32, type:'sell' },
            { time: '10:25:00', action: 'Monitored ADA', details: 'Price within target range.', profit: null, type:'system' },
            { time: '10:20:00', action: 'Bot parameters updated', details: 'Risk level set to Medium.', profit: null, type:'system' }
        ];


        let currentSection = 'assets';
        let botActive = true;
        let signalTimers = {}; // Store timers by signal ID

        // DOM Elements
        const userBalanceEl = document.getElementById('userBalance');
        const todayPnLEl = document.getElementById('todayPnL');
        const totalValueAccEl = document.getElementById('totalValueAcc');
        const availableBalanceAccEl = document.getElementById('availableBalanceAcc');
        const investedAccEl = document.getElementById('investedAcc');
        const pnlAccEl = document.getElementById('pnlAcc');
        const botProfitEl = document.getElementById('botProfit');
        const botTradesEl = document.getElementById('botTrades');
        const botSuccessRateEl = document.getElementById('botSuccessRate');
        const botUptimeEl = document.getElementById('botUptime');


        // Formatters
        const formatCurrency = (value, minDigits = 2, maxDigits = 2) => `$${value.toLocaleString('en-US', {minimumFractionDigits: minDigits, maximumFractionDigits: maxDigits})}`;
        const formatPercentage = (value) => `${value >= 0 ? '+' : ''}${value.toFixed(2)}%`;

        function initDashboard() {
            updateCoinsList();
            updatePortfolio();
            updateTeamList();
            updateTransactions();
            updateBotActivity();
            updateTradingSignals();
            updateAccountOverview();
            updateBotStats();

            setInterval(updateRealTimeData, 3000); // Update data every 3 seconds
            updateSignalCountdowns(); // Start countdowns
        }

        function updateCoinsList() {
            const coinsList = document.getElementById('coinsList');
            if (!coinsList) return;
            coinsList.innerHTML = coinData.map(coin => `
                <div class="coin-item">
                    <div class="coin-info">
                        <div class="coin-icon ${coin.icon}">${coin.symbol.substring(0,3)}</div>
                        <div class="coin-details">
                            <div class="coin-name">${coin.name}</div>
                            <div class="coin-symbol">${coin.symbol} / USD</div>
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
            const portfolioList = document.getElementById('portfolioList');
            if (!portfolioList) return;

            let totalPortfolioValue = 0;
            portfolioList.innerHTML = portfolioData.map(item => {
                const coin = coinData.find(c => c.symbol === item.symbol);
                item.value = coin ? coin.price * item.amount : item.value; // Update value based on current price
                totalPortfolioValue += item.value;
                const pnl = coin ? (coin.price - item.avgBuyPrice) * item.amount : 0;
                const pnlClass = pnl >= 0 ? 'positive' : 'negative';

                return `
                <div class="portfolio-item">
                    <div>
                        <strong>${item.symbol}</strong> (${item.amount} coins)<br>
                        <small style="color: #848e9c;">Avg. Buy: ${formatCurrency(item.avgBuyPrice)}</small>
                    </div>
                    <div style="text-align: right;">
                        <strong>${formatCurrency(item.value)}</strong><br>
                        <small class="${pnlClass}">${formatCurrency(pnl, 0, 0)} (${formatPercentage(pnl/ (item.avgBuyPrice * item.amount) * 100 || 0)})</small>
                    </div>
                </div>
            `;}).join('');
            if(userBalanceEl) userBalanceEl.textContent = formatCurrency(totalPortfolioValue); // Update header balance
            if(totalValueAccEl) totalValueAccEl.textContent = formatCurrency(totalPortfolioValue); // Update account overview
        }

        function updateTeamList() {
            const teamList = document.getElementById('teamList');
            if (!teamList) return;
            teamList.innerHTML = teamData.map(member => `
                <div class="activity-item">
                    <div class="activity-info">
                        <div class="activity-icon buy"> <i class="${member.avatar || 'fas fa-user'}"></i>
                        </div>
                        <div class="activity-details">
                            <h4>${member.name}</h4>
                            <span>${member.trades} trades &bull; ${member.success.toFixed(1)}% success</span>
                        </div>
                    </div>
                    <div class="activity-result">
                        <strong class="${member.profit >= 0 ? 'positive' : 'negative'}">${member.profit >= 0 ? '+' : ''}${formatCurrency(member.profit)}</strong>
                    </div>
                </div>
            `).join('');
        }

        function updateTransactions() {
            const transactionsList = document.getElementById('transactionsList');
            if (!transactionsList) return;
            transactionsList.innerHTML = transactionData.slice(0, 5).map(tx => `
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
                        ${tx.type !== 'Deposit' && tx.type !== 'Withdrawal' ? `<small style="color: #848e9c;">${tx.amountCoin.toFixed(4)} ${tx.coin}</small>` : ''}
                    </div>
                </div>
            `).join('');
        }

        function updateBotActivity() {
            const botActivityList = document.getElementById('botActivityList');
            if (!botActivityList) return;
            botActivityList.innerHTML = botActivityData.slice(0, 5).map(activity => `
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
                    ${activity.profit ? `
                    <div class="activity-result">
                        <strong class="${activity.profit >= 0 ? 'positive' : 'negative'}">
                        ${activity.profit >= 0 ? '+' : ''}${formatCurrency(activity.profit)}
                        </strong>
                    </div>` : ''}
                </div>
            `).join('');
        }

        function updateTradingSignals() {
            const signalsContainer = document.getElementById('tradingSignalsContainer');
            if (!signalsContainer) return;

            // Clear existing timers before re-rendering
            Object.values(signalTimers).forEach(clearInterval);
            signalTimers = {};

            signalsContainer.innerHTML = tradingSignalsData.map((signal, index) => {
                const icon = signal.type === 'BUY' ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down';
                const minutes = Math.floor(signal.timeLeft / 60);
                const seconds = signal.timeLeft % 60;
                const timeFormatted = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

                return `
                <div class="signal-item ${signal.type.toLowerCase()}" id="signal-${signal.id}">
                    <div class="signal-info">
                        <div class="signal-type">
                            <i class="fas ${icon}"></i>
                            <span>${signal.type} ${signal.coin} @ ${formatCurrency(signal.price, 2,2)}</span>
                        </div>
                        <div class="signal-details">
                            Target: ${formatCurrency(signal.target, 2,2)} | Strength: ${Math.floor(Math.random()*3 + 3)}/5
                        </div>
                    </div>
                    <div class="countdown-timer">
                        <div class="countdown-time" id="time-${signal.id}">${timeFormatted}</div>
                        <div class="countdown-label">Expires In</div>
                    </div>
                </div>
            `;
            }).join('');
        }

        function updateSignalCountdowns() {
            tradingSignalsData.forEach(signal => {
                if (signal.timeLeft > 0) {
                    signal.timeLeft--;
                    const minutes = Math.floor(signal.timeLeft / 60);
                    const seconds = signal.timeLeft % 60;
                    const timeFormatted = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                    const el = document.getElementById(`time-${signal.id}`);
                    if (el) el.textContent = timeFormatted;

                    if (signal.timeLeft === 0) {
                       const signalEl = document.getElementById(`signal-${signal.id}`);
                       if(signalEl) {
                           signalEl.style.opacity = '0.5';
                           signalEl.querySelector('.countdown-label').textContent = 'Expired';
                       }
                    }
                }
            });
            requestAnimationFrame(updateSignalCountdowns); // Smoother countdown
        }


        function updateRealTimeData() {
            // Simulate coin price changes
            coinData = coinData.map(coin => {
                const changePercent = (Math.random() - 0.48) * 3; // +/- up to 3%
                const priceChange = coin.price * (changePercent / 100);
                coin.price += priceChange;
                coin.change = parseFloat(changePercent.toFixed(2)); // Update overall change for display
                return coin;
            });
            updateCoinsList();
            updatePortfolio(); // This will also update header balance

            // Simulate P&L change
            const pnlChange = (Math.random() - 0.5) * 50;
            let currentPnl = parseFloat(todayPnLEl.textContent.replace(/[^0-9.-]+/g,""));
            currentPnl += pnlChange;
            todayPnLEl.textContent = `${currentPnl >= 0 ? '+' : ''}${formatCurrency(currentPnl)}`;
            todayPnLEl.className = `balance-amount ${currentPnl >= 0 ? 'positive' : 'negative'}`;

            // Update account overview stats
            updateAccountOverview();
            // Update bot stats if bot is active
            if (botActive) {
                updateBotStats(true);
            }
        }

        function updateAccountOverview() {
            const totalPortfolioValue = portfolioData.reduce((sum, asset) => sum + asset.value, 0);
            if(totalValueAccEl) totalValueAccEl.textContent = formatCurrency(totalPortfolioValue);
            if(totalValueAccEl) totalValueAccEl.className = `stat-value ${totalPortfolioValue >= 0 ? 'positive' : 'negative'}`;

            const available = totalPortfolioValue * 0.2; // Example: 20% available
            const invested = totalPortfolioValue * 0.8; // Example: 80% invested
            if(availableBalanceAccEl) availableBalanceAccEl.textContent = formatCurrency(available);
            if(investedAccEl) investedAccEl.textContent = formatCurrency(invested);

            // Simulate lifetime P&L
            let lifetimePnl = parseFloat(pnlAccEl.textContent.replace(/[^0-9.-]+/g,""));
            lifetimePnl += (Math.random() - 0.45) * 10; // Small random change
            if(pnlAccEl) pnlAccEl.textContent = `${lifetimePnl >= 0 ? '+' : ''}${formatCurrency(lifetimePnl)}`;
            if(pnlAccEl) pnlAccEl.className = `stat-value ${lifetimePnl >= 0 ? 'positive' : 'negative'}`;
        }

        let botUptimeSeconds = 23 * 3600 + 45 * 60; // Initial uptime
        function updateBotStats(isIncrement = false) {
            if (isIncrement && botActive) {
                let profit = parseFloat(botProfitEl.textContent.replace(/[^0-9.-]+/g,""));
                profit += (Math.random() - 0.4) * 20;
                botProfitEl.textContent = `${profit >= 0 ? '+' : ''}${formatCurrency(profit)}`;
                botProfitEl.className = `stat-value ${profit >= 0 ? 'positive' : 'negative'}`;

                let trades = parseInt(botTradesEl.textContent);
                if (Math.random() > 0.9) trades++; // Occasionally increment trades
                botTradesEl.textContent = trades;

                let success = parseFloat(botSuccessRateEl.textContent);
                success += (Math.random() - 0.5) * 0.1;
                success = Math.max(80, Math.min(99, success)); // Keep in range
                botSuccessRateEl.textContent = `${success.toFixed(1)}%`;
                botSuccessRateEl.className = `stat-value ${success >= 90 ? 'positive' : (success < 85 ? 'negative' : '')}`;

                botUptimeSeconds += 3; // Assuming called every 3 seconds by updateRealTimeData
                const h = Math.floor(botUptimeSeconds / 3600);
                const m = Math.floor((botUptimeSeconds % 3600) / 60);
                botUptimeEl.textContent = `${h}h ${m}m`;
            } else if (!botActive) {
                 // If bot is off, can show last known stats or placeholder
            }
        }


        function showSection(sectionId, navElement) {
            document.querySelectorAll('.content-section').forEach(section => {
                section.classList.remove('active');
            });
            document.getElementById(sectionId).classList.add('active');

            document.querySelectorAll('.nav-item').forEach(item => {
                item.classList.remove('active');
            });
            if (navElement) { // If called from nav click
                navElement.classList.add('active');
            } else { // If called programmatically, find nav item by data attribute
                document.querySelector(`.nav-item[data-section="${sectionId}"]`).classList.add('active');
            }
            currentSection = sectionId;
            window.scrollTo(0, 0); // Scroll to top of page
        }

        function toggleBot() {
            botActive = !botActive;
            const botToggleEl = document.getElementById('botToggle');
            const botStatusContainerEl = document.getElementById('botStatusContainer');
            const botIndicatorEl = document.getElementById('botIndicator');
            const botStatusTextEl = document.getElementById('botStatusText');

            if (botActive) {
                botToggleEl.classList.add('active');
                botStatusContainerEl.classList.remove('inactive');
                botIndicatorEl.classList.remove('inactive');
                botStatusTextEl.textContent = 'Active';
                botStatusTextEl.style.color = '#0ecb81'; // Positive color
            } else {
                botToggleEl.classList.remove('active');
                botStatusContainerEl.classList.add('inactive');
                botIndicatorEl.classList.add('inactive');
                botStatusTextEl.textContent = 'Inactive';
                botStatusTextEl.style.color = '#848e9c'; // Neutral color
            }
            updateBotStats(); // Update display based on new status
        }

        // Initial call
        document.addEventListener('DOMContentLoaded', initDashboard);

    </script>
</body>
</html>
