{{-- resources/views/user/game/invest.blade.php --}}

@extends('user.layouts.app') {{-- Assuming your main app layout --}}

@section('content')
<div class="container">
    <h2>Game Investment</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if (session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-header">Current Game Status</div>
        <div class="card-body">
            @if ($activeGameSetting)
                <p><strong>Game Active:</strong> <span class="badge bg-success">YES</span></p>
                <p><strong>Investment Window:</strong> {{ \Carbon\Carbon::parse($activeGameSetting->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($activeGameSetting->end_time)->format('h:i A') }}</p>
                <p><strong>Daily Earning Percentage:</strong> {{ number_format($activeGameSetting->earning_percentage, 2) }}%</p>
                <p><strong>Your Current Balance:</strong> ${{ number_format(auth()->user()->balance, 2) }}</p>

                <hr>
                <h4>Make an Investment</h4>
                <form action="{{ route('user.game.invest') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="amount" class="form-label">Investment Amount (USD)</label>
                        <input type="number" step="0.01" name="amount" id="amount" class="form-control" required min="10" max="{{ auth()->user()->balance }}">
                        @error('amount')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Invest Now</button>
                </form>
            @else
                <p class="text-warning">The game is currently closed for investments or no active game setting found.</p>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-header">Your Active Investments</div>
        <div class="card-body">
            @if ($userInvestments->isEmpty())
                <p>You have no active investments yet.</p>
            @else
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Amount</th>
                            <th>Daily Profit</th>
                            <th>Status</th>
                            <th>Investment Date</th>
                            <th>Next Payout Eligible</th>
                            <th>Total Profit Paid</th>
                            <th>Principal Returned</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($userInvestments as $investment)
                            <tr>
                                <td>{{ $investment->id }}</td>
                                <td>${{ number_format($investment->amount, 2) }}</td>
                                <td>${{ number_format($investment->daily_profit_amount, 2) }}</td>
                                <td><span class="badge bg-primary">{{ $investment->status }}</span></td>
                                <td>{{ $investment->investment_date->format('Y-m-d') }}</td>
                                <td>
                                    @if ($investment->next_payout_eligible_date)
                                        {{ $investment->next_payout_eligible_date->format('Y-m-d') }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>${{ number_format($investment->total_profit_paid_out, 2) }}</td>
                                <td>
                                    @if ($investment->principal_returned)
                                        <span class="badge bg-success">Yes</span>
                                    @else
                                        <span class="badge bg-danger">No</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
