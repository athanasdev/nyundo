@extends('user.layouts.app')

@section('title', 'Team - CoinTrades')

@section('content')
<div id="team" class="content-section active"> {{-- 'active' class not needed for MPA --}}
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
            <div id="teamListContainer">
                {{-- Team members data will be injected here by JavaScript --}}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Sample data for Team page
    const teamData = [
        { name: 'Alex Chen', profit: 2456.78, trades: 23, success: 95.2, avatar: 'fas fa-user-tie' },
        { name: 'Sarah Wilson', profit: 1890.45, trades: 18, success: 88.9, avatar: 'fas fa-user-graduate' },
        { name: 'Mike Johnson', profit: 3245.67, trades: 31, success: 93.5, avatar: 'fas fa-user-secret' },
        { name: 'Lisa Davis', profit: 1567.89, trades: 15, success: 80.0, avatar: 'fas fa-user-astronaut' }
    ];

    function updateTeamListOnPage() {
        const teamListEl = document.getElementById('teamListContainer');
        if (!teamListEl) return;
        teamListEl.innerHTML = teamData.map(member => `
            <div class="activity-item">
                <div class="activity-info">
                    <div class="activity-icon bot"> {{-- Using 'bot' style for team icon color --}}
                        <i class="${member.avatar || 'fas fa-user'}"></i>
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

    document.addEventListener('DOMContentLoaded', function() {
        updateTeamListOnPage();
        // Example: Update global header with placeholder or relevant data for team page
        updateGlobalHeaderDisplay(12345.67, 100.50);
    });
</script>
@endpush
