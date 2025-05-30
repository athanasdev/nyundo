@extends('user.layouts.app')

@section('title', 'My Team & Referrals - CoinTrades')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
<style>
    .team-content-wrapper {
        padding-top: 10px;
    }
    .tf-container-team {
        max-width: 900px;
        margin: 0 auto;
    }

    /* Swiper Styles */
    .swiper.mySwiperTeam {
        height: 150px !important;
        border-radius: 6px;
        margin-bottom: 20px;
        background-color: #1e2329;
    }
    .swiper-slide a img {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: 6px;
    }
    .swiper-pagination-bullet-active {
        background: #f0b90b !important;
    }

    /* Invite Section Styles */
    .invite-section-card .card-body {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    .invite-header img {
        width: 60%;
        max-width: 180px;
        height: auto;
        margin-bottom: 15px;
    }
    .invite-header .title-text {
        color: #f0b90b;
        font-weight: 600;
        font-size: 1.4em;
        margin-bottom: 8px;
    }
    .invite-header .description-text {
        font-size: 0.9em;
        width: 90%;
        max-width: 550px;
        font-weight: 400;
        color: #c1c8d1;
        line-height: 1.5;
        margin-top: 5px;
    }
    .referral-link-section {
        width: 100%;
        padding: 15px 0 0 0;
        display: flex;
        align-items: stretch;
        gap: 10px;
        margin-top: 15px;
    }
    .link-class {
        flex-grow: 1;
        background-color: #0b0e11;
        padding: 10px 15px;
        border-radius: 4px;
        border: 1px solid #2b3139;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .link-class .title {
        font-size: 0.8em;
        color: #848e9c;
        margin-bottom: 4px;
        text-transform: uppercase;
    }
    .link-class .body {
        font-size: 0.9em;
        color: #f0b90b;
        font-weight: 500;
        word-break: break-all;
    }
    .copy-button {
        padding: 0 18px;
        background: #f0b90b;
        color: #1e2329;
        border: none;
        border-radius: 4px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.2s;
        white-space: nowrap;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9em;
    }
    .copy-button i { margin-right: 6px;}
    .copy-button:hover { background: #d8a40a; }

    /* Team Summary Stats (Registered Users, Active Users) */
    .team-summary-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 16px;
        margin-top: 20px;
        margin-bottom: 20px;
    }
    .stat-summary-card .card-body {
        padding: 20px;
        text-align: center;
    }
    .stat-summary-card .stat-number {
        font-size: 2em;
        font-weight: 700;
        color: #f0b90b;
        margin-bottom: 5px;
    }
    .stat-summary-card .stat-title {
        font-size: 1em;
        font-weight: 600;
        margin-bottom: 6px;
        color: #eaecef;
    }
    .stat-summary-card .stat-description {
        font-size: 0.85em;
        color: #848e9c;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
    }
    .stat-summary-card .stat-description i { font-size: 1em; }

    /* Trading Team Performance Card (Original CoinTrades Style) */
    .stats-grid { /* For the 4-column stat cards */
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 16px;
    }
    .stat-card { /* Individual stat card within stats-grid */
        background: #2b3139; /* Darker than main card bg for contrast */
        padding: 16px;
        border-radius: 4px;
        text-align: center;
    }
    .stat-card .stat-value {
        font-size: 1.3em;
        font-weight: 600;
        margin-bottom: 4px;
        color: #eaecef;
    }
    .stat-card .stat-label {
        font-size: 0.8em;
        color: #848e9c;
        text-transform: uppercase;
    }
    .stat-card .positive { color: #0ecb81; }
    .stat-card .negative { color: #f6465d; }

    /* My Referred Users Table Styles */
    .referrals-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }
    .referrals-table th, .referrals-table td {
        padding: 10px 12px;
        text-align: left;
        border-bottom: 1px solid #2b3139;
        font-size: 0.9em;
    }
    .referrals-table th {
        color: #848e9c;
        font-weight: 500;
        text-transform: uppercase;
        font-size: 0.8em;
        background-color: #222531;
    }
    .referrals-table td { color: #c1c8d1; }
    .referrals-table td.username-col { font-weight: 500; color: #eaecef; }
    .referrals-table td.level-col { text-align: center; }
    .referrals-table td.balance-col { text-align: right; font-weight: 500; color: #0ecb81; }
    .referrals-table tr:hover td { background-color: #222531; }


    /* Referral Levels Info Section */
    .levels-info-section { margin-top: 20px; }
    .level-card { margin-bottom: 16px; }
    .level-card .card-header .level-title {
        font-size: 1.1em;
        font-weight: 600;
        color: #f0b90b;
    }
    .level-card .card-body {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 15px;
        padding: 15px 20px;
    }
    .level-card .stat-item {
        text-align: center;
        background-color: #2b3139;
        padding: 10px;
        border-radius: 4px;
    }
    .level-card .stat-item .label {
        font-size: 0.85em;
        margin-bottom: 5px;
        color: #848e9c;
        display: block;
        text-transform: uppercase;
    }
    .level-card .stat-item .value {
        font-size: 1.1em;
        color: #eaecef;
        font-weight: 600;
    }
    .level-card .stat-item .value small {
        font-size: 0.75em;
        color: #848e9c;
        font-weight: normal;
        margin-left: 3px;
    }

    @media (max-width: 768px) {
        .invite-header .description-text { width: 95%; }
        .referral-link-section { flex-direction: column; gap: 10px; }
        .referral-link-section .link-class { margin-right: 0; }
        .team-summary-stats { grid-template-columns: 1fr; }
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .level-card .card-body { grid-template-columns: 1fr; }
        .referrals-table th, .referrals-table td { font-size: 0.85em; padding: 8px;}

    }
     @media (max-width: 480px) {
        .stats-grid { grid-template-columns: 1fr; }
        .referrals-table th, .referrals-table td { font-size: 0.8em; padding: 6px;}
        .referrals-table .username-col { min-width: 100px; }
     }
</style>
@endpush

@section('content')
<div class="team-content-wrapper">
    <div class="tf-container-team">
        {{-- Swiper for Banners --}}

        {{-- Invite Friends Section --}}
        <div class="card invite-section-card">
            <div class="card-body">
                <div class="invite-header">
                    <img src="{{ asset('images/default/invite_friends_icon.png') }}" alt="Invite Friends to Earn"
                         onerror="this.style.display='none'; this.parentElement.insertAdjacentHTML('beforebegin', '<div style=\'text-align:center; margin-bottom:15px;\'><i class=\'fas fa-gift fa-3x\' style=\'color:#f0b90b;\'></i></div>');"><br>
                    <span class="title-text">Invite Friends & Earn Rewards</span><br>
                    <span class="description-text">
                        Share your referral link with friends. When they join and trade on {{ config('app.name', 'CoinTrades') }}, you earn commissions across multiple levels!
                    </span>
                </div>
                <div class="w-100 d-row align-center referral-link-section">
                    <div class="link-class d-col">
                        <span class="title">Your Unique Referral Link</span>
                        <span class="body" id="referralLinkElement">{{ config('app.url') }}/?invited_by={{ $user->referral_code }}</span>
                    </div>
                    <button class="copy-button" onclick="copyReferralLink()">
                        <i class="fas fa-copy"></i> Copy Link
                    </button>
                </div>
            </div>
        </div>

        {{-- Team Summary Stats --}}
        <div class="team-summary-stats">
            <div class="card stat-summary-card">
                <div class="card-body">
                    <span class="stat-number">{{ $total_registered_users }}</span>
                    <span class="stat-title">Total Team Members</span>
                    <span class="stat-description">
                        <i class="fas fa-users"></i>
                        Across All Referral Levels
                    </span>
                </div>
            </div>
            <div class="card stat-summary-card">
                <div class="card-body">
                    <span class="stat-number">{{ $active_users }}</span>
                    <span class="stat-title">Active Referrals</span>
                    <span class="stat-description">
                        <i class="fas fa-user-check"></i>
                        Users with Recent Activity
                    </span>
                </div>
            </div>
        </div>


        {{-- My Referred Users Table --}}
        <div class="card" style="margin-top: 20px;">
            <div class="card-header">
                <div class="card-title">
                    <i class="fas fa-list-ul"></i>
                    My Referred Users
                </div>
            </div>
            <div class="card-body no-padding"> {{-- no-padding for table to touch edges --}}
                <table class="referrals-table">
                    <thead>
                        <tr>
                            <th style="text-align:center; width:5%;">#</th>
                            <th>Username</th>
                            <th style="text-align:center;">Level</th>
                            <th style="text-align:right;">Deposit Balance (USDT)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $index = 0; @endphp
                        @if($level1_members->isEmpty() && $level2_members->isEmpty() && $level3_members->isEmpty())
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 20px; color: #848e9c;">You have no referred users in your team yet.</td>
                            </tr>
                        @endif

                        @foreach($level1_members as $member)
                            @php $index++; @endphp
                            <tr>
                                <td style="text-align:center;">{{ $index }}</td>
                                <td class="username-col">{{ $member->username }}</td>
                                <td class="level-col">1</td>
                                <td class="balance-col">${{ number_format($member->balance, 2) }}</td>
                            </tr>
                        @endforeach

                        @foreach($level2_members as $member)
                            @php $index++; @endphp
                            <tr>
                                <td style="text-align:center;">{{ $index }}</td>
                                <td class="username-col">{{ $member->username }}</td>
                                <td class="level-col">2</td>
                                <td class="balance-col">${{ number_format($member->balance, 2) }}</td>
                            </tr>
                        @endforeach

                        @foreach($level3_members as $member)
                            @php $index++; @endphp
                            <tr>
                                <td style="text-align:center;">{{ $index }}</td>
                                <td class="username-col">{{ $member->username }}</td>
                                <td class="level-col">3</td>
                                <td class="balance-col">${{ number_format($member->balance, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Referral Levels Information Cards (from Nyundo design) --}}
        <div class="levels-info-section">
            {{-- Level 1 Card --}}
            <div class="card level-card">
                <div class="card-header">
                    <h5 class="card-title level-title"><i class="fas fa-sitemap"></i> Level 1 Summary</h5>
                </div>
                <div class="card-body">
                    <div class="stat-item">
                        <span class="label">Members</span>
                        <span class="value">{{ $level1_count }}</span>
                    </div>
                    <div class="stat-item">
                        <span class="label">Total Deposits</span>
                        <span class="value">{{ number_format($level1_deposit, 2) }} <small>USDT</small></span>
                    </div>
                    <div class="stat-item">
                        <span class="label">My Commissions</span>
                        <span class="value">{{ number_format($level1_commissions, 2) }} <small>USDT</small></span>
                    </div>
                </div>
            </div>

            {{-- Level 2 Card --}}
            <div class="card level-card">
                <div class="card-header">
                    <h5 class="card-title level-title"><i class="fas fa-sitemap"></i> Level 2 Summary</h5>
                </div>
                <div class="card-body">
                    <div class="stat-item">
                        <span class="label">Members</span>
                        <span class="value">{{ $level2_count }}</span>
                    </div>
                    <div class="stat-item">
                        <span class="label">Total Deposits</span>
                        <span class="value">{{ number_format($level2_deposit, 2) }} <small>USDT</small></span>
                    </div>
                    <div class="stat-item">
                        <span class="label">My Commissions</span>
                        <span class="value">{{ number_format($level2_commissions, 2) }} <small>USDT</small></span>
                    </div>
                </div>
            </div>

            {{-- Level 3 Card --}}
            <div class="card level-card">
                <div class="card-header">
                    <h5 class="card-title level-title"><i class="fas fa-sitemap"></i> Level 3 Summary</h5>
                </div>
                <div class="card-body">
                    <div class="stat-item">
                        <span class="label">Members</span>
                        <span class="value">{{ $level3_count }}</span>
                    </div>
                    <div class="stat-item">
                        <span class="label">Total Deposits</span>
                        <span class="value">{{ number_format($level3_deposit, 2) }} <small>USDT</small></span>
                    </div>
                    <div class="stat-item">
                        <span class="label">My Commissions</span>
                        <span class="value">{{ number_format($level3_commissions, 2) }} <small>USDT</small></span>
                    </div>
                </div>
            </div>

            {{-- Totals Card --}}
            <div class="card level-card">
                <div class="card-header">
                    <h5 class="card-title level-title"><i class="fas fa-calculator"></i> Overall Team Totals</h5>
                </div>
                <div class="card-body">
                    <div class="stat-item">
                        <span class="label">Total Team Members</span>
                        <span class="value">{{ $total_registered_users }}</span>
                    </div>
                    <div class="stat-item">
                        <span class="label">Total Team Deposits</span>
                        <span class="value">{{ number_format($total_deposits, 2) }} <small>USDT</small></span>
                    </div>
                    <div class="stat-item">
                        <span class="label">My Total Commissions</span>
                        <span class="value">{{ number_format($total_commissions, 2) }} <small>USDT</small></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var teamSwiper = new Swiper(".mySwiperTeam", {
            direction: "horizontal",
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            loop: true,
        });
    });

    function copyReferralLink() {
        const linkTextElement = document.getElementById('referralLinkElement');
        if (!linkTextElement) return;

        const linkText = linkTextElement.innerText;
        navigator.clipboard.writeText(linkText).then(function() {
            alert('Referral link copied to clipboard!');
        }, function(err) {
            console.error('Could not copy text: ', err);
            alert('Failed to copy link. Please copy it manually.');
        });
    }
</script>
@endpush
