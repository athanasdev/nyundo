<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $isRTL ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', __('messages.trading_platform') . ' - Soria10')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* --- PRELOADER STYLES --- */
        .preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #0b0e11;
            /* Match body background */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            /* Ensure it's on top */
            opacity: 1;
            transition: opacity 0.5s ease-out, visibility 0.5s ease-out;
            visibility: visible;
        }

        .preloader.loaded {
            opacity: 0;
            visibility: hidden;
        }

        .preloader .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #2b3139;
            /* Spinner track color */
            border-top-color: #f0b90b;
            /* Spinner color - your accent yellow */
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* --- END PRELOADER STYLES --- */

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
            direction: {{ $isRTL ? 'rtl' : 'ltr' }};
            /* Dynamic direction */
        }

        .container-main {
            max-width: 1400px;
            margin: 0 auto;
            padding: 16px;
            padding-top: 150px;
            /* Account for fixed header AND profile card */
            padding-bottom: 90px;
            /* Space for bottom nav */
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0;
            padding: 10px 20px;
            background: #1e2329;
            border-bottom: 1px solid #2b3139;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1002;
            height: 64px;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo-link {
            text-decoration: none;
            display: flex;
            align-items: center;
            color: #f0b90b;
        }

        .header-logo-img {
            height: 30px;
            width: auto;
        }

        .logo-text {
            font-size: 20px;
            font-weight: 600;
            color: #f0b90b;
            margin-left: 8px;
        }

        .logo-link .fas.fa-chart-line {
            /* Fallback icon */
            font-size: 24px;
            color: #f0b90b;
        }

        .user-balance-display {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .balance-item {
            text-align: right;
        }

        .balance-amount {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 1px;
        }

        .balance-label {
            color: #848e9c;
            font-size: 10px;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header-action-btn {
            padding: 6px 12px;
            border: 1px solid #4a4a4a;
            background: #2b3139;
            color: #c1c8d1;
            border-radius: 4px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            font-size: 12px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            white-space: nowrap;
        }

        .header-action-btn i {
            font-size: 13px;
        }

        .header-action-btn:hover {
            border-color: #f0b90b;
            color: #f0b90b;
            background-color: #363d47;
        }

        .header-action-btn.logout {
            border-color: #f6465d;
            color: #f6465d;
            background-color: transparent;
        }

        .header-action-btn.logout:hover {
            background-color: #f6465d;
            color: #fff;
        }

        .logout-form-inline {
            display: inline;
            margin: 0;
            padding: 0;
        }

        .language-selector {
            position: relative;
            display: inline-block;
        }

        .language-btn {
            background: #2b3139;
            border: 1px solid #4a4a4a;
            color: #c1c8d1;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            transition: all 0.2s ease-in-out;
        }

        .language-btn:hover {
            border-color: #f0b90b;
            color: #f0b90b;
            background-color: #363d47;
        }

        .language-dropdown {
            position: absolute;
            top: 100%;
            {{ $isRTL ? 'left: 0;' : 'right: 0;' }}
            background: #1e2329;
            border: 1px solid #2b3139;
            border-radius: 4px;
            min-width: 180px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            z-index: 1003;
            display: none;
            margin-top: 4px;
        }

        .language-dropdown.show {
            display: block;
        }

        .language-option {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 15px;
            color: #c1c8d1;
            text-decoration: none;
            transition: background-color 0.2s;
            border-bottom: 1px solid #2b3139;
        }

        .language-option:last-child {
            border-bottom: none;
        }

        .language-option:hover {
            background-color: #2b3139;
            color: #f0b90b;
        }

        .language-option.active {
            background-color: #363d47;
            color: #f0b90b;
        }

        .language-flag {
            font-size: 16px;
        }

        .language-name {
            font-size: 13px;
        }

        .user-profile-card {
            background: #1e2329;
            border-radius: 6px;
            border: 1px solid #2b3139;
            padding: 15px 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .profile-image-placeholder {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #2b3139;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
        }

        .profile-image-placeholder i {
            font-size: 24px;
            color: #565f6b;
        }

        .profile-image-placeholder img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-details {
            display: flex;
            flex-direction: column;
        }

        .profile-username {
            font-size: 1.1em;
            font-weight: 600;
            color: #eaecef;
            margin-bottom: 3px;
        }

        .profile-unique-id {
            font-size: 0.8em;
            color: #848e9c;
            background-color: #2b3139;
            padding: 2px 5px;
            border-radius: 3px;
            display: inline-block;
        }

        .positive {
            color: #0ecb81;
        }

        .negative {
            color: #f6465d;
        }

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
            margin-bottom: 16px;
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

        .card-title i {
            color: #f0b90b !important;
        }

        .card-body {
            padding: 16px 20px;
        }

        .card-body.no-padding {
            padding: 0;
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
        .xrp { background: #0077c8; }
        .doge { background: #c3a634; }
        .avax { background: #e84142; }
        .link { background: #2a5ada; }
        .ltc { background: #bebebe; }
        .trx { background: #eb0029; }
        .shib { background: #ffc107; }
        .uni { background: #ff007a; }
        .bch { background: #8dc351; }
        .icp { background: #29abe2; }
        .xlm { background: #000000; }
        .atom { background: #5064fb; }
        .etc { background: #328332; }

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
            background: #0b0e11;
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
            background: linear-gradient(135deg, rgba(15, 185, 177, 0.05), rgba(240, 185, 11, 0.05));
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

        .portfolio-item,
        .activity-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #2b3139;
        }

        .portfolio-item:last-child,
        .activity-item:last-child {
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

        .bot-info i {
            color: #f0b90b;
        }

        #botStatusText {
            color: #0ecb81;
            font-weight: 500;
        }

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

        .status-indicator.inactive {
            background: #848e9c;
            animation: none;
        }

        @keyframes pulse {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }

            100% {
                opacity: 1;
            }
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 16px;
            margin-bottom: 16px;
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

        .signal-item.buy .signal-type i {
            color: #0ecb81;
        }

        .signal-item.sell {
            border-left-color: #f6465d;
        }

        .signal-item.sell .signal-type i {
            color: #f6465d;
        }

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
            text-align: right;
            min-width: 90px;
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

        .activity-result strong {
            font-weight: 500;
        }

        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #1e2329;
            border-top: 1px solid #2b3139;
            padding: 8px 0;
            z-index: 1000;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
            height: 60px;
        }

        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-around;
            align-items: center;
            height: 100%;
        }

        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2px;
            cursor: pointer;
            transition: all 0.2s ease;
            padding: 4px 8px;
            border-radius: 4px;
            color: #848e9c;
            flex: 1;
            text-align: center;
            text-decoration: none;
        }

        .nav-item.active {
            color: #f0b90b;
            background: #2b3139;
        }

        .nav-item:hover:not(.active) {
            color: #eaecef;
            background: #262b32;
        }

        .nav-item i {
            font-size: 18px;
            margin-bottom: 1px;
        }

        .nav-text {
            font-size: 10px;
            font-weight: 500;
        }

        [dir="rtl"] .header-left {
            flex-direction: row-reverse;
        }

        [dir="rtl"] .header-actions {
            flex-direction: row-reverse;
        }

        [dir="rtl"] .nav-container {
            flex-direction: row-reverse;
        }

        [dir="rtl"] .balance-item {
            text-align: left;
        }

        [dir="rtl"] .logo-text {
            margin-left: 0;
            margin-right: 8px;
        }

        @media (max-width: 1024px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }

            .sidebar {
                order: -1;
            }

            .header-left {
                flex-grow: 1;
            }

            .header-actions {
                flex-shrink: 0;
            }
        }

        @media (max-width: 768px) {
            .container-main {
                padding: 10px;
                padding-top: 135px;
                padding-bottom: 75px;
            }

            .header {
                flex-direction: column;
                height: auto;
                gap: 10px;
                padding: 6px;
            }

            .header-left {
                flex-direction: column;
                gap: 10px;
                width: 100%;
            }

            .user-balance-display {
                justify-content: space-around;
                width: 100%;
                margin-top: 10px;
            }

            .header-actions {
                margin-top: 10px;
                width: 100%;
                justify-content: space-around;
            }

            .user-profile-card {
                margin-top: 5px;
                flex-direction: column;
                text-align: center;
            }

            .profile-details {
                align-items: center;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .chart-container {
                height: 250px;
            }

            .nav-item i {
                font-size: 16px;
            }

            .nav-text {
                font-size: 10px;
            }
        }

        @media (max-width: 480px) {
            .container-main {
                padding-top: 150px;
            }

            .quick-actions {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .coin-item {
                padding: 10px 16px;
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .coin-price {
                text-align: left;
                width: 100%;
            }

            .signal-item {
                padding: 12px;
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .countdown-timer {
                text-align: left;
                width: 100%;
            }

            .nav-container {
                justify-content: space-between;
            }

            .nav-item {
                padding: 6px 8px;
                gap: 2px;
            }

            .nav-item i {
                font-size: 14px;
            }

            .header-actions {
                flex-wrap: wrap;
                justify-content: center;
                gap: 8px;
            }

            .header-action-btn,
            .language-btn {
                padding: 6px 10px;
                font-size: 11px;
            }

            .logo-text {
                font-size: 18px;
            }

            .header-logo-img {
                height: 28px;
            }
        }

        .alert {
            padding: 12px 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            font-size: 0.9em;
            border: 1px solid transparent;
        }

        .alert-error {
            color: #f6465d;
            background-color: rgba(246, 70, 93, 0.1);
            border-color: rgba(246, 70, 93, 0.3);
        }

        .alert-error ul {
            list-style-position: inside;
            padding-left: 5px;
            margin-bottom: 0;
        }

        .alert-error li {
            margin-bottom: 5px;
        }

        .alert-error li:last-child {
            margin-bottom: 0;
        }

        .alert-success {
            color: #0ecb81;
            background-color: rgba(14, 203, 129, 0.1);
            border-color: rgba(14, 203, 129, 0.3);
        }

        .alert-info {
            color: #f0b90b;
            background-color: rgba(240, 185, 11, 0.1);
            border-color: rgba(240, 185, 11, 0.3);
        }
    </style>
    @stack('styles')
</head>

<body>

    {{-- ================================================================= --}}
    {{-- =================== IMPERSONATION LEAVE BUTTON ================== --}}
    {{-- ================================================================= --}}
    @if (Session::has('impersonated_by'))
        <style>
            /* --- Styles for the 'Leave Impersonation' button --- */
            .impersonate-leave-container {
                position: fixed;
                bottom: 65px;
                right: 20px;
                z-index: 9999;
                /* Ensure it's on top of everything */
            }

            .impersonate-leave-btn {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 12px 18px;
                background-color: #f0b90b;
                /* Your theme's accent color */
                color: #0b0e11;
                /* Dark text for contrast */
                border: none;
                border-radius: 8px;
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
                font-size: 14px;
                font-weight: 600;
                text-decoration: none;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
                transition: all 0.3s ease;
                cursor: pointer;
            }

            .impersonate-leave-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
                background-color: #ffca2c;
            }

            .impersonate-leave-btn i {
                font-size: 16px;
            }
        </style>

        <div class="impersonate-leave-container">
            <a href="{{ route('impersonate.leave') }}" class="impersonate-leave-btn">
                <i class="fas fa-user-secret"></i>
                <span>{{ __('messages.leave_impersonation', ['default' => 'Leave Impersonation']) }}</span>
            </a>
        </div>
    @endif
    {{-- ================= END IMPERSONATION LEAVE BUTTON ================ --}}


    <div class="preloader">
        <div class="spinner"></div>
    </div>

    <header class="header">
        <div class="header-left">
            <a href="{{ route('dashboard') }}" class="logo-link">
                <img src="{{ asset('images/logo/logo.png') }}" alt="Soria10 Logo" class="header-logo-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-flex';">
                <span class="logo-text" style="display:none;"><i class="fas fa-chart-line icon-fallback"></i>
                    Soria10</span>
            </a>
            <div class="user-balance-display">
                <div class="balance-item">
                    <div class="balance-amount positive" id="balalnce">
                        ${{ number_format(Auth::user()->balance ?? 0, 2) }}
                    </div>
                    <div class="balance-label">{{ __('messages.total_balance') }}</div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            <div class="language-selector">
                <button class="language-btn" onclick="toggleLanguageDropdown()">
                    <span class="language-flag">{{ $availableLanguages[$currentLanguage]['flag'] ?? '🌐' }}</span>
                    <span>{{ $availableLanguages[$currentLanguage]['name'] ?? __('messages.language') }}</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="language-dropdown" id="languageDropdown">
                    @if (isset($availableLanguages) && is_array($availableLanguages))
                        @foreach ($availableLanguages as $code => $language)
                            <a href="{{ route('language.change', $code) }}" class="language-option {{ $code == $currentLanguage ? 'active' : '' }}">
                                <span class="language-flag">{{ $language['flag'] }}</span>
                                <span class="language-name">{{ $language['name'] }}</span>
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>

            <a href="{{ route('deposit.form') }}" class="header-action-btn">
                <i class="fas fa-arrow-alt-circle-down"></i> {{ __('messages.deposit') }}
            </a>

            @php
                $user = Auth::user();
                $needsSetup = $user ? is_null($user->withdrawal_address) || is_null($user->withdrawal_pin_hash) : true;
            @endphp

            <a href="{{ $needsSetup ? route('withdraw.setup') : route('withdraw') }}" id="withdrawButton" class="header-action-btn">
                <i class="fas fa-arrow-alt-circle-up"></i> {{ __('messages.withdraw') }}
            </a>
            @auth
                <form method="POST" action="{{ route('user.logout') }}" class="logout-form-inline">
                    @csrf
                    <button type="submit" class="header-action-btn logout">
                        <i class="fas fa-sign-out-alt"></i> {{ __('messages.logout') }}
                    </button>
                </form>
            @endauth
        </div>
    </header>

    <div class="container-main">
        @auth
            <div class="user-profile-card">
                <div class="profile-image-placeholder">
                    <i class="fas fa-user-circle"></i>
                </div>
                <div class="profile-details">
                    <div class="profile-username">{{ Auth::user()->username }}</div>
                    <div class="profile-unique-id">ID: {{ Auth::user()->unique_id }}</div>
                </div>
            </div>
        @endauth

        @yield('content')
    </div>

    <nav class="bottom-nav">
        <div class="nav-container">
            <a href="{{ route('dashboard') }}" class="nav-item {{ Request::is('dashboard') || Request::is('/') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span class="nav-text">{{ __('messages.home') }}</span>
            </a>
            <a href="{{ route('my-account') }}" class="nav-item {{ Request::is('my-account*') ? 'active' : '' }}">
                <i class="fas fa-user"></i>
                <span class="nav-text">{{ __('messages.account') }}</span>
            </a>
            <a href="{{ route('team') }}" class="nav-item {{ Request::is('team*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span class="nav-text">{{ __('messages.team') }}</span>
            </a>
            <a href="{{ route('ai-trading') }}" class="nav-item {{ Request::is('bot*') ? 'active' : '' }}">
                <i class="fas fa-robot"></i>
                <span class="nav-text">{{ __('messages.bot') }}</span>
            </a>
        </div>
    </nav>

    <script>
        // Preloader JavaScript
        window.addEventListener('load', function() {
            const preloader = document.querySelector('.preloader');
            if (preloader) {
                preloader.classList.add('loaded');
            }
        });

        // Language dropdown functionality
        function toggleLanguageDropdown() {
            const dropdown = document.getElementById('languageDropdown');
            if (dropdown) {
                dropdown.classList.toggle('show');
            }
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const selector = document.querySelector('.language-selector');
            const dropdown = document.getElementById('languageDropdown');

            if (selector && dropdown && !selector.contains(event.target)) {
                dropdown.classList.remove('show');
            }
        });

        // Function to format currency
        const formatCurrency = (value, minDigits = 2, maxDigits = 2) => {
            const locale = '{{ app()->getLocale() }}'.split('_')[0] || 'en';
            return `$${Number(value).toLocaleString(locale, { minimumFractionDigits: minDigits, maximumFractionDigits: maxDigits })}`;
        }

        // Function to format percentage
        const formatPercentage = (value) => `${Number(value) >= 0 ? '+' : ''}${Number(value).toFixed(2)}%`;

        // Function to update the global header display
        function updateGlobalHeaderDisplay(totalBalance, pnlToday) {
            const userBalanceEl = document.getElementById('userBalanceDisplay2');
            if (userBalanceEl) {
                userBalanceEl.textContent = formatCurrency(totalBalance);
                userBalanceEl.className = `balance-amount ${Number(totalBalance) >= 0 ? 'positive' : 'negative'}`;
            }
        }
    </script>

    @stack('scripts')
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/684180efa46165190e5866cf/1isvtvaan';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->
</body>

</html>
