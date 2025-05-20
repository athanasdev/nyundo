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
                                        <div class="h4 mb-0">{{ $totalUsers }}</div>
                                        <div class="weight-600 font-14">All Traders</div>
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
                                        <div class="h4 mb-0"> {{ $blockedUsers }} </div>
                                        <div class="weight-600 font-14">Blocked</div>
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
                                        <div class="h4 mb-0">{{ $activeTraders }}</div>
                                        <div class="weight-600 font-14">Active Traders</div>
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
                                        <div class="h4 mb-0">{{ $withdrawRequests }}</div>
                                        <div class="weight-600 font-14">Request Withdraw</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                
                <!-- Export Datatable start -->
                <div class="card-box mb-10">
                    <div class="pd-20">
                        <h4 class="text-blue h4">Traders</h4>
                    </div>
                    <div class="pb-20">
                        <table class="table hover multiple-select-row table-stripled data-table-export nowrap">
                            <thead>
                                <tr>
                                    <th class="table-plus datatable-nosort">Id</th>
                                    <th>Username</th>
                                    <th>Balance</th> {{-- Placeholder --}}
                                    <th>Status</th> {{-- Placeholder --}}
                                    <th>Join Date</th>
                                    <th>Withdraw</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($traders as $index => $trader)
                                    <tr>
                                        <td class="table-plus">{{ $trader->id }}</td>
                                        <td>{{ $trader->username }}</td>
                                        <td>$ {{ $trader->balance}} </td>
                                        <td>{{ $trader->status }}</td>
                                        <td>{{ $trader->created_at ? $trader->created_at->format('d-m-Y') : '--' }}</td>
                                        <td>$ {{ $trader->Withdraw_amount }}</td>
                                        <td>
                                            <a href="{{ route('admin.trader-details', ['id' => $trader->id]) }}">
                                                <span class="micon dw dw-edit-2"></span>
                                            </a>
                                            <a href="#"><span class="micon dw dw-chat3"></span></a>
                                            <a href="#"><span class="micon dw dw-edit-1"></span></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="mt-3">
                            {{ $traders->links() }}
                        </div>

                    </div>
                </div>

            </div>
        @endsection
