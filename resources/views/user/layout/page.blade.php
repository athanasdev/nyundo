<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CoinTrades - Advanced Trading Platform')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    {{-- In a real Laravel app, this CSS would likely be in public/css/app.css and linked via asset() --}}
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

        .container-main { /* Renamed from .container to avoid conflict if bootstrap is used */
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
        .coin-item:last-child { border-bottom: none; }
        .coin-item:hover { background: #2b3139; }
        .coin-info { display: flex; align-items: center; gap: 12px; flex: 1; }
        .coin-icon {
            width: 32px; height: 32px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; font-weight: 600; color: white;
        }
        .btc { background: #f7931a; } .eth { background: #627eea; }
        .bnb { background: #f0b90b; } .ada { background: #0033ad; }
        .sol { background: #9945ff; } .dot { background: #e6007a; }
        .coin-details { flex: 1; }
        .coin-name { font-weight: 500; margin-bottom: 2px; }
        .coin-symbol { color: #848e9c; font-size: 12px; }
        .coin-price { text-align: right; min-width: 120px; }
        .price { font-weight: 500; margin-bottom: 2px; }
        .change { font-size: 12px; font-weight: 500; }

        .chart-container {
            height: 300px; background: #0b0e11; border-radius: 4px;
            display: flex; align-items: center; justify-content: center;
            position: relative; overflow: hidden;
        }
        .trading-view {
            width: 100%; height: 100%;
            background: linear-gradient(135deg, rgba(15, 185, 177, 0.05), rgba(240, 185, 11, 0.05));
            position: relative; display: flex; align-items: center; justify-content: center;
        }
        .chart-placeholder { color: #848e9c; font-size: 16px; display: flex; align-items: center; gap: 8px;}

        .quick-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .action-btn {
            padding: 12px 16px; border: none; border-radius: 4px; font-weight: 500;
            cursor: pointer; transition: all 0.2s; display: flex; align-items: center;
            justify-content: center; gap: 8px; font-size: 14px;
        }
        .action-btn.buy { background: #0ecb81; color: white; }
        .action-btn.sell { background: #f6465d; color: white; }
        .action-btn:hover { opacity: 0.8; transform: translateY(-1px); }

        .portfolio-item {
            display: flex; justify-content: space-between; align-items: center;
            padding: 12px 0; border-bottom: 1px solid #2b3139;
        }
        .portfolio-item:last-child { border-bottom: none; }

        .bot-status {
            display: flex; align-items: center; justify-content: space-between; padding: 16px;
            background: rgba(14, 203, 129, 0.1); border-radius: 4px; margin-bottom: 16px;
            border: 1px solid rgba(14, 203, 129, 0.2);
        }
        .bot-status.inactive { background: rgba(132, 142, 156, 0.1); border-color: rgba(132, 142, 156, 0.2); }
        .bot-status.inactive .status-indicator { background: #848e9c; animation: none; }
        .bot-status.inactive #botStatusText { color: #848e9c; }
        .bot-info { display: flex; align-items: center; gap: 12px; }
        .bot-info i { color: #f0b90b; }
        #botStatusText { color: #0ecb81; font-weight: 500;}
        .bot-toggle {
            width: 48px; height: 24px; background: #848e9c; border-radius: 12px;
            position: relative; cursor: pointer; transition: all 0.3s ease;
        }
        .bot-toggle.active { background: #0ecb81; }
        .bot-toggle::after {
            content: ''; position: absolute; width: 20px; height: 20px;
            background: white; border-radius: 50%; top: 2px; left: 2px;
            transition: all 0.3s ease;
        }
        .bot-toggle.active::after { left: 26px; }
        .status-indicator {
            display: inline-block; width: 8px; height: 8px; border-radius: 50%;
            background: #0ecb81; animation: pulse 2s infinite;
        }
        .status-indicator.inactive { background: #848e9c; animation: none; }
        @keyframes pulse { 0% { opacity: 1; } 50% { opacity: 0.5; } 100% { opacity: 1; } }

        .stats-grid {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 16px; margin-bottom: 16px;
        }
        .stat-card { background: #2b3139; padding: 16px; border-radius: 4px; text-align: center; }
        .stat-value { font-size: 20px; font-weight: 600; margin-bottom: 4px; }
        .stat-label { font-size: 12px; color: #848e9c; }

        .trading-signals { margin-bottom: 16px; }
        .signal-item {
            display: flex; align-items: center; justify-content: space-between;
            padding: 16px; background: #2b3139; border-radius: 4px;
            margin-bottom: 12px; border-left: 4px solid;
        }
        .signal-item.buy { border-left-color: #0ecb81; }
        .signal-item.buy .signal-type i { color: #0ecb81; }
        .signal-item.sell { border-left-color: #f6465d; }
        .signal-item.sell .signal-type i { color: #f6465d; }
        .signal-info { flex: 1; }
        .signal-type { font-weight: 600; margin-bottom: 4px; display: flex; align-items: center; gap: 8px; }
        .signal-details { color: #848e9c; font-size: 12px; }
        .countdown-timer { text-align: right; min-width: 90px; }
        .countdown-time { font-size: 18px; font-weight: 600; color: #f0b90b; }
        .countdown-label { font-size: 11px; color: #848e9c; }

        .bottom-nav {
            position: fixed; bottom: 0; left: 0; right: 0;
            background: #1e2329; border-top: 1px solid #2b3139;
            padding: 10px 0; z-index: 1000; box-shadow: 0 -2px 5px rgba(0,0,0,0.1);
        }
        .nav-container {
            max-width: 1400px; margin: 0 auto; display: flex;
            justify-content: space-around; align-items: center;
        }
        .nav-item {
            display: flex; flex-direction: column; align-items: center; gap: 4px;
            cursor: pointer; transition: all 0.2s ease; padding: 6px 10px;
            border-radius: 4px; color: #848e9c; flex: 1; text-align: center;
        }
        .nav-item.active { color: #f0b90b; background: #2b3139; }
        .nav-item:hover:not(.active) { color: #eaecef; background: #262b32; }
        .nav-item i { font-size: 18px; margin-bottom: 2px; }
        .nav-text { font-size: 11px; font-weight: 500; }

        .activity-item {
            display: flex; align-items: center; justify-content: space-between;
            padding: 12px 0; border-bottom: 1px solid #2b3139;
        }
        .activity-item:last-child { border-bottom: none; }
        .activity-info { display: flex; align-items: center; gap: 12px; }
        .activity-icon {
            width: 32px; height: 32px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center; font-size: 14px;
        }
        .activity-icon.buy { background: rgba(14, 203, 129, 0.2); color: #0ecb81; }
        .activity-icon.sell { background: rgba(246, 70, 93, 0.2); color: #f6465d; }
        .activity-icon.bot { background: rgba(240, 185, 11, 0.2); color: #f0b90b; }
        .activity-icon.system { background: rgba(132, 142, 156, 0.2); color: #848e9c; }
        .activity-details h4 { font-weight: 500; margin-bottom: 2px; color: #eaecef; }
        .activity-details span { color: #848e9c; font-size: 12px; }
        .activity-result { text-align: right; }
        .activity-result strong { font-weight: 500; }

        /* Responsive Design from original */
        @media (max-width: 1024px) {
            .dashboard-grid { grid-template-columns: 1fr; }
            .sidebar { order: -1; }
        }
        @media (max-width: 768px) {
            .container-main { padding: 12px; padding-bottom: 80px; }
            .header { flex-direction: column; gap: 12px; text-align: center; }
            .user-balance { justify-content: center; gap: 12px; }
            .balance-item { text-align: center; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .chart-container { height: 250px; }
            .nav-item i { font-size: 16px; }
            .nav-text { font-size: 10px; }
        }
        @media (max-width: 480px) {
            .quick-actions { grid-template-columns: 1fr; }
            .stats-grid { grid-template-columns: 1fr; }
            .coin-item { padding: 10px 16px; flex-direction: column; align-items: flex-start; gap: 8px;}
            .coin-price { text-align: left; width: 100%; }
            .signal-item { padding: 12px; flex-direction: column; align-items: flex-start; gap: 8px; }
            .countdown-timer { text-align: left; width: 100%;}
            .countdown-time { font-size: 16px; }
            .nav-container { justify-content: space-between; }
            .nav-item { padding: 6px 8px; gap: 2px;}
            .nav-item i { font-size: 14px; }
        }
    </style>
    @stack('styles') {{-- For page-specific CSS --}}
</head>
<body>
    <div class="container-main">
        <div class="header">
            <div class="logo">
                <i class="fas fa-chart-line"></i>
                CoinTrades
            </div>
            <div class="user-balance">
                <div class="balance-item">
                    <div class="balance-amount positive" id="userBalanceDisplay">$0.00</div>
                    <div class="balance-label">Total Balance</div>
                </div>
                <div class="balance-item">
                    <div class="balance-amount positive" id="todayPnLDisplay">$0.00</div>
                    <div class="balance-label">Today's P&L</div>
                </div>
            </div>
        </div>

        @yield('content')

    </div>

    <div class="bottom-nav">
        <div class="nav-container">
            <a href="{{ route('assets') }}" class="nav-item {{ Request::is('assets*') ? 'active' : '' }}" data-section="assets">
                <i class="fas fa-coins"></i>
                <span class="nav-text">Assets</span>
            </a>
            <a href="{{ route('accounts') }}" class="nav-item {{ Request::is('accounts*') ? 'active' : '' }}" data-section="accounts">
                <i class="fas fa-user"></i>
                <span class="nav-text">Account</span>
            </a>
            <a href="{{ route('team') }}" class="nav-item {{ Request::is('team*') ? 'active' : '' }}" data-section="team">
                <i class="fas fa-users"></i>
                <span class="nav-text">Team</span>
            </a>
            <a href="{{ route('bot') }}" class="nav-item {{ Request::is('bot*') ? 'active' : '' }}" data-section="bot">
                <i class="fas fa-robot"></i>
                <span class="nav-text">Bot</span>
            </a>
        </div>
    </div>

    {{-- Global Utility Scripts --}}
    <script>
        const formatCurrency = (value, minDigits = 2, maxDigits = 2) => `$${Number(value).toLocaleString('en-US', {minimumFractionDigits: minDigits, maximumFractionDigits: maxDigits})}`;
        const formatPercentage = (value) => `${Number(value) >= 0 ? '+' : ''}${Number(value).toFixed(2)}%`;

        // Update header balances (example, should be driven by real data)
        function updateGlobalHeaderDisplay(totalBalance, pnl) {
            const userBalanceEl = document.getElementById('userBalanceDisplay');
            const todayPnLEl = document.getElementById('todayPnLDisplay');
            if (userBalanceEl) {
                userBalanceEl.textContent = formatCurrency(totalBalance);
                userBalanceEl.className = `balance-amount ${totalBalance >= 0 ? 'positive' : 'negative'}`;
            }
            if (todayPnLEl) {
                todayPnLEl.textContent = `${pnl >= 0 ? '+' : ''}${formatCurrency(pnl)}`;
                todayPnLEl.className = `balance-amount ${pnl >= 0 ? 'positive' : 'negative'}`;
            }
        }
        // Example initial update
        // updateGlobalHeaderDisplay(12456.78, 234.56);
    </script>

    @stack('scripts') {{-- For page-specific JavaScript --}}
</body>
</html>
