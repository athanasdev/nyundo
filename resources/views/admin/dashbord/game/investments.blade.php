@extends('admin.dashbord.pages.layout')

@section('content')
    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">

                <h2>Manage User Investments</h2>

                {{-- Session Messages --}}
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if (session('info'))
                    <div class="alert alert-info">{{ session('info') }}</div>
                @endif

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">All User Investments</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responseive">
                            <table class="table hover table-stripled data-table-export nowrap ">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Game Setting</th>
                                        <th>Amount Invested</th>
                                        <th>Daily Profit Rate</th>
                                        <th>Calculated Daily Profit</th>
                                        <th>Status</th>
                                        <th>Investment Date</th>
                                        <th>Next Payout Eligible</th>
                                        <th>Total Profit Paid</th>
                                        <th>Principal Returned</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($investments as $investment)
                                        <tr>
                                            <td>{{ $investment->id }}</td>
                                            <td>{{ $investment->user->name ?? 'N/A' }} (ID: {{ $investment->user_id }})
                                            </td>
                                            <td>
                                                @if ($investment->gameSetting)
                                                    {{ $investment->gameSetting->earning_percentage }}%
                                                    ({{ \Carbon\Carbon::parse($investment->gameSetting->start_time)->format('H:i') }}
                                                    -
                                                    {{ \Carbon\Carbon::parse($investment->gameSetting->end_time)->format('H:i') }})
                                                @else
                                                    N/A (Deleted)
                                                @endif
                                            </td>
                                            <td>${{ number_format($investment->amount, 2) }}</td>
                                            <td>{{ number_format($investment->gameSetting->earning_percentage ?? 0, 2) }}%
                                            </td>
                                            <td>${{ number_format($investment->daily_profit_amount, 2) }}</td>
                                            <td>
                                                @if ($investment->status === 'active')
                                                    <span class="badge bg-primary">{{ $investment->status }}</span>
                                                @elseif ($investment->status === 'completed')
                                                    <span class="badge bg-success">{{ $investment->status }}</span>
                                                @else
                                                    <span class="badge bg-warning">{{ $investment->status }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $investment->investment_date->format('Y-m-d') }}</td>
                                            <td>
                                                @if ($investment->next_payout_eligible_date)
                                                    <span
                                                        class="{{ $investment->next_payout_eligible_date->lte(now()->toDateString()) ? 'text-success' : 'text-danger' }}">
                                                        {{ $investment->next_payout_eligible_date->format('Y-m-d') }}
                                                    </span>
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
                                            <td>
                                                @if ($investment->status === 'active')
                                                    {{-- Form for Payout Daily Profit --}}
                                                    <form
                                                        action="{{ route('admin.user_investments.payout_profit', $investment) }}"
                                                        method="POST" style="display:inline-block;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-info"
                                                            title="Credit daily profit to user"
                                                            @if ($investment->next_payout_eligible_date && $investment->next_payout_eligible_date->gt(now()->toDateString())) disabled @endif
                                                            onclick="return confirm('Process daily profit payout for this investment?');">
                                                            Payout Profit
                                                        </button>
                                                    </form>
                                                    {{-- Form for Return Principal --}}
                                                    {{-- <form
                                                            action="{{ route('admin.user_investments.return_principal', $investment) }}"
                                                            method="POST" style="display:inline-block; margin-left: 5px;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-warning"
                                                                title="Return principal and mark as completed"
                                                                @if ($investment->principal_returned) disabled @endif
                                                                onclick="return confirm('Are you sure you want to return principal and complete this investment?');">
                                                                Return Principal & Complete
                                                            </button>
                                                        </form> --}}

                                                    {{-- Example of a new form/button to call completeInvestment --}}
                                                    @if ($investment->status === 'active' && !$investment->principal_returned)
                                                        {{-- Add your desired conditions --}}
                                                        <form
                                                            action="{{ route('admin.user_investments.complete', $investment) }}"
                                                            method="POST" style="display:inline-block; margin-left: 5px;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success"
                                                                title="Mark investment as completed"
                                                                onclick="return confirm('Are you sure you want to mark this investment as complete?');">
                                                                Mark as Completed
                                                            </button>
                                                        </form>
                                                    @endif

                                                    {{-- Optional: Form for Cancel Investment --}}
                                                    <form
                                                        action="{{ route('admin.user_investments.cancel', $investment) }}"
                                                        method="POST" style="display:inline-block; margin-left: 5px;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            title="Cancel investment (review your cancellation policy)"
                                                            onclick="return confirm('Are you sure you want to cancel this investment? This action might not be reversible or return funds depending on policy.');">
                                                            Cancel
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-muted">No Actions</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="12" class="text-center">No user investments found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $investments->links() }} {{-- Pagination links --}}
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
