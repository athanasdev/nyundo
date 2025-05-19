@extends('admin.dashbord.pages.layout')

@section('content')
    <div class="main-container">
        <div class="pd-ltr-20">
            <div class="card-box pd-20 height-100-p mb-30">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <img src="{{ asset('admin/vendors/images/banner-img.png') }}" alt="">
                    </div>
                    <div class="col-md-8">
                        <h4 class="font-20 weight-500 mb-10 text-capitalize">
                            Welcome back <div class="weight-600 font-30 text-blue">{{ $admin->name }}</div>
                        </h4>
                        <p class="font-18 max-width-600">
                            “Volatility is the price you pay for opportunity. Stay calm, zoom out, and trust the
                            process.”<br>
                            <small>— Crypto Enthusiast</small>
                        </p>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-3 mb-30">
                    <div class="card-box height-100-p widget-style1">
                        <div class="d-flex flex-wrap align-items-center">
                            <div class="progress-data">
                                <div id="chart"></div>
                            </div>
                            <div class="widget-data">
                                <div class="h4 mb-0">14000 $</div>
                                <div class="weight-600 font-14">Deposts</div>
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
                                <div class="h4 mb-0"> 5600 $</div>
                                <div class="weight-600 font-14">Withdraw</div>
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
                                <div class="h4 mb-0">350</div>
                                <div class="weight-600 font-14">Traders</div>
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
                                <div class="h4 mb-0"> 100</div>
                                <div class="weight-600 font-14">Request Withdraw</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-8 mb-30">
                    <div class="card-box height-100-p pd-20">
                        <h2 class="h4 mb-20">Activity</h2>
                        <div id="chart5"></div>
                    </div>
                </div>
                <div class="col-xl-4 mb-30">
                    <div class="card-box height-100-p pd-20">
                        <h2 class="h4 mb-20">Lead Target</h2>
                        <div id="chart6"></div>
                    </div>
                </div>
            </div>

             <div class="card-box mb-10">
                    <div class="pd-20">
                        <h4 class="text-blue h4">Traders</h4>
                    </div>
                    <div class="pb-20">
                        <table class="table hover multiple-select-row table-stripled data-table-export nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="table-plus datatable-nosort">Id</th>
                                    <th>Username</th>
                                    <th>Balance</th>
                                    <th>status</th>
                                    <th>Join Date</th>
                                    <th>Withdraw</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td class="table-plus">Gloria F. Mead</td>
                                    <td>25</td>
                                    <td>456899 $</td>
                                    <td>2829 Trainer Avenue Peoria, IL 61602 </td>
                                    <td>29-03-2018</td>
                                    <td>
                                        678900 $
                                    </td>
                                    <td>
                                        <a href="#">
                                            <span class="micon dw dw-edit-2"></span>
                                        </a>
                                        <a href="#">
                                            <span class="micon dw dw-chat3"></span>
                                        </a>
                                        <a href="#">
                                            <span class="micon dw dw-transh"></span>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>

@endsection

