@extends('admin.dashbord.pages.layout')

@section('content')
    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <div class="row">
                    <div class="col-12 mb-30">
                        <div class="pd-20 card-box height-100-p">
                            <h5 class="text-center h5 mb-0">Username: {{ $user->username }}</h5>
                            <p class="text-center text-muted font-14">Trader ID {{ $user->unique_id }}</p>
                            <div class="section mb-3 mt-1 text-center">

                                @if (Auth::guard('admin')->check())
                                    {{-- Only show if an admin is logged in --}}
                                    <a href="{{ route('impersonate.login', $user->id) }}"
                                        class="btn btn-warning btn-sm mt-3">
                                        Login as {{ $user->username }}
                                    </a>
                                @endif

                            </div>
                            <div class="profile-info">
                                <h5 class="mb-20 h5 text-blue">Trader Account:</h5>
                                <ul>
                                    <li><span>Email Address:</span> {{ $user->email }}</li>
                                    <li><span>ID:</span> {{ $user->unique_id }}</li>
                                    <li><span>Country:</span> {{ $user->country }}</li>
                                    <li><span>Balance </span> {{ $user->balance }}</li>

                                </ul>
                            </div>
                            <div class="mt-4">
                                <h5 class="text-blue mb-3">Adjust Balance</h5>
                                {{-- This form would typically be in a user-facing dashboard or admin panel --}}
                                <form action="{{ route('transactions.add') }}" method="POST">
                                    @csrf {{-- Don't forget the CSRF token for security! --}}
                                    <input type="hidden" name="user_id" value="{{ $user->id }}"> {{-- Make sure $user is passed to this view --}}
                                    <div class="form-group">
                                        <label>Amount</label>
                                        <input type="number" name="amount" step="0.0000001" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Type</label>
                                        <select name="type" class="form-control">
                                            <option value="credit">Add Balance</option>
                                            <option value="debit">Remove Balance</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea name="description" class="form-control"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-30">
                        <div class="pd-20 card-box height-100-p">
                            <h5 class="text-blue mb-3">Transaction History</h5>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Balance Before</th>
                                        <th>Balance After</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transactions as $tx)
                                        <tr>
                                            <td>{{ $tx->created_at }}</td>
                                            <td>{{ $tx->type }}</td>
                                            <td>{{ $tx->amount }}</td>
                                            <td>{{ $tx->balance_before }}</td>
                                            <td>{{ $tx->balance_after }}</td>
                                            <td>{{ $tx->description }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mb-30">
                        <div class="pd-20 card-box height-100-p">
                            <h5 class="text-blue mb-3">Referral Earnings</h5>
                            <p>Invite your friends to join and earn from their deposits.</p>
                            <p><strong>Referral Link:</strong>
                                {{ config('app.url') }}/register/?invited_by={{ $user->referral_code }}</p>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="border p-3 mb-3">
                                        <h6>Referral Summary</h6>
                                        <p>Total Registered Users: {{ $total_registered_users }}</p>
                                        <p>Active Users: {{ $active_users }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border p-3 mb-3">
                                        <h6>Level 1</h6>
                                        <p>Members: {{ $level1_count }}</p>
                                        <p>Deposit: {{ number_format($level1_deposit, 2) }} USDT</p>
                                        <p>Commissions: {{ number_format($level1_commissions, 2) }} USDT</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border p-3 mb-3">
                                        <h6>Level 2</h6>
                                        <p>Members: {{ $level2_count }}</p>
                                        <p>Deposit: {{ number_format($level2_deposit, 2) }} USDT</p>
                                        <p>Commissions: {{ number_format($level2_commissions, 2) }} USDT</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border p-3 mb-3">
                                        <h6>Level 3</h6>
                                        <p>Members: {{ $level3_count }}</p>
                                        <p>Deposit: {{ number_format($level3_deposit, 2) }} USDT</p>
                                        <p>Commissions: {{ number_format($level3_commissions, 2) }} USDT</p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="border p-3 mb-3">
                                        <h6>Total</h6>
                                        <p>Total Members: {{ $total_registered_users }}</p>
                                        <p>Total Deposits: {{ number_format($total_deposits, 2) }} USDT</p>
                                        <p>Total Commissions: {{ number_format($total_commissions, 2) }} USDT</p>
                                    </div>
                                </div>
                            </div>

                            @foreach ($referralSummary['levels'] as $level => $teams)
                                <div class="col-md-4">
                                    @php
                                        $members = $teams->count();
                                        $deposit = $teams->sum('deposit');
                                        $commissions = $teams->sum('commissions');
                                    @endphp
                                    <div class="border p-3 mb-3">
                                        <h6>Level {{ $level }}</h6>
                                        <p>Members: {{ $members }}</p>
                                        <p>Deposit: {{ $deposit }} USDT</p>
                                        <p>Commissions: {{ $commissions }} USDT</p>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
