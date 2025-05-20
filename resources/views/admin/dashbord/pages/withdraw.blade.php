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
                                        <div class="weight-600 font-14">Pending Request</div>
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
                                        <div class="weight-600 font-14">Complete Withdraws</div>
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
                                        <div class="weight-600 font-14">Pending total</div>
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
                                        <div class="weight-600 font-14">Complete Total</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>





                <!-- Withdraw Requests Table -->
                <div class="card-box mb-10">
                    <div class="pd-20">
                        <h4 class="text-blue h4">Withdraw Requests</h4>
                    </div>
                    <div class="pb-20">
                        <table class="table hover multiple-select-row data-table-export nowrap">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Amount</th>
                                    <th>Payment Address</th>
                                    <th>Status</th>
                                    <th>Requested At</th>
                                    <th>Paid At</th>
                                    <th>Action</th>

                                </tr>

                            </thead>
                            <tbody>
                                @foreach ($withdraws as $withdraw)
                                    <tr>
                                        <td>{{ $withdraw->id }}</td>
                                        <td>{{ $withdraw->user->username ?? 'N/A' }}</td>
                                        <td>${{ number_format($withdraw->amount, 2) }}</td>
                                        <td>{{ $withdraw->payment_address }}</td>
                                        <td>
                                            <span
                                                class="badge {{ $withdraw->status == 'pending' ? 'badge-warning' : 'badge-success' }}">
                                                {{ ucfirst($withdraw->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ $withdraw->created_at ? $withdraw->created_at->format('d-m-Y H:i') : 'N/A' }}
                                        </td>

                                        <td>
                                            {{ $withdraw->updated_at ? $withdraw->updated_at->format('d-m-Y H:i') : 'N/A' }}
                                        </td>
                                        <td>
                                            <a href="#"><span class="micon dw dw-edit2"></span> Pay </a>
                                            <a href="#"><span class="micon dw dw-trash"></span></a>
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
