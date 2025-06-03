@extends('admin.dashbord.pages.layout')

@section('content')
    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">

                <div class="section">
                    <div class="row">
                        <div class="col-xl-3 mb-30">
                            <div class="card-box height-100-p widget-style1">
                                <div class="d-flex flex-wrap align-items-center">
                                    <div class="progress-data">
                                        <div id="chart"></div>
                                    </div>
                                    <div class="widget-data">
                                        <div class="h4 mb-0">{{ $pendingCount }}</div>
                                        <div class="weight-600 font-14">Pending Deposits</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 mb-30">
                            <div class="card-box height-100-p widget-style1">
                                <div class="d-flex flex-wrap align-items-center">
                                    <div class="progress-data">
                                        <div id="chart2"></div>
                                    </div>
                                    <div class="widget-data">
                                        <div class="h4 mb-0"> {{ $completedCount }} </div>
                                        <div class="weight-600 font-14">Completed Deposits</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 mb-30">
                            <div class="card-box height-100-p widget-style1">
                                <div class="d-flex flex-wrap align-items-center">
                                    <div class="progress-data">
                                        <div id="chart3"></div>
                                    </div>
                                    <div class="widget-data">
                                        <div class="h4 mb-0">${{ number_format($pendingTotal, 2) }}</div>
                                        <div class="weight-600 font-14">Pending Total</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 mb-30">
                            <div class="card-box height-100-p widget-style1">
                                <div class="d-flex flex-wrap align-items-center">
                                    <div class="progress-data">
                                        <div id="chart4"></div>
                                    </div>
                                    <div class="widget-data">
                                        <div class="h4 mb-0">${{ number_format($completedTotal, 2) }}</div>
                                        <div class="weight-600 font-14">Completed Total</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Deposit Requests Table -->
                <div class="card-box mb-10">
                    <div class="pd-20">
                        <h4 class="text-blue h4">Deposit Requests</h4>
                    </div>
                    <div class="pb-20">
                        <table class="table hover data-table-export nowrap">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Amount</th>
                                    <th>Payment Method</th>
                                    <th>Status</th>
                                    <th>Requested At</th>
                                    <th>Approved At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($withdraws as $deposit)
                                    <tr>
                                        <td>{{ $deposit->id }}</td>
                                        <td>{{ $deposit->user->username ?? 'N/A' }}</td>
                                        <td>${{ number_format($deposit->amount, 2) }}</td>
                                        <td>{{ $deposit->type }}</td>
                                        <td>
                                            <span
                                                class="badge {{ $deposit->status == 'pending' ? 'badge-warning' : 'badge-success' }}">
                                                {{ ucfirst($deposit->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ $deposit->created_at ? $deposit->created_at->format('d-m-Y H:i') : 'N/A' }}
                                        </td>
                                        <td>
                                            {{ $deposit->updated_at ? $deposit->updated_at->format('d-m-Y H:i') : 'N/A' }}
                                        </td>
                                        <td>
                                            {{-- Only show the approve button if the deposit is pending --}}
                                            @if ($deposit->status === 'pending')
                                                <form action="{{ route('admin.aprove-depost', ['id' => $deposit->id]) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf {{-- This is crucial for Laravel's POST security --}}
                                                    <button type="submit" class="btn btn-sm btn-info"
                                                        onclick="return confirm('Are you sure you want to approve this deposit?');">
                                                        Approve
                                                    </button>
                                                </form>
                                            @else
                                                <span class="badge bg-success">Approved</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-3">{{ $withdraws->links() }}</div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
