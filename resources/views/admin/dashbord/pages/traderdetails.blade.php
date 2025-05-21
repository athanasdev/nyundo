@extends('admin.dashbord.pages.layout')

@section('content')
    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <!-- Profile Card Section -->
                <div class="row">
                    <div class="col-12 mb-30">
                        <div class="pd-20 card-box height-100-p">
                            <h5 class="text-center h5 mb-0">Username: {{ $user->username }}</h5>
                            <p class="text-center text-muted font-14">Trader ID {{ $user->unique_id }}</p>
                            <div class="profile-info">
                                <h5 class="mb-20 h5 text-blue">Trader Account:</h5>
                                <ul>
                                    <li><span>Email Address:</span> {{ $user->email }}</li>
                                    <li><span>ID:</span> {{ $user->unique_id }}</li>
                                    <li><span>Country:</span> {{ $user->country }}</li>
                                    <li><span>Balance </span> {{ $user->balance }}</li>
                                </ul>
                            </div>
                            <!-- Form to Add or Remove Amount -->
                            <div class="mt-4">
                                <h5 class="text-blue mb-3">Adjust Balance</h5>
                                <form action="/transactions/add" method="POST">
                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                    <div class="form-group">
                                        <label>Amount</label>
                                        <input type="number" name="amount" step="0.01" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Type</label>
                                        <select name="type" class="form-control">
                                            <option value="credit">Credit</option>
                                            <option value="debit">Debit</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea name="description" class="form-control"></textarea>
                                    </div>
                                    <button class="btn btn-primary">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transactions Table -->
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
                                            <td>{{ tx . created_at }}</td>
                                            <td>{{ tx . type }}</td>
                                            <td>{{ tx . amount }}</td>
                                            <td>{{ tx . balance_before }}</td>
                                            <td>{{ tx . balance_after }}</td>
                                            <td>{{ tx . description }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Referral Earnings and Levels -->
                <div class="row">
                    <div class="col-12 mb-30">
                        <div class="pd-20 card-box height-100-p">
                            <h5 class="text-blue mb-3">Referral Earnings</h5>
                            <p>Invite your friends to join and earn from their deposits.</p>
                            <p><strong>Referral Link:</strong> http://localhost:8000?invited_by={{ $user->referral_code }}
                            </p>

                            <div class="row">
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
    </div>
@endsection
