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
                                        <div class="h4 mb-0">14000</div>
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
                                        <div class="h4 mb-0"> 5600 </div>
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
        @endsection
