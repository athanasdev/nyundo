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
                                <div class="h4 mb-0">$ {{ $totalDeposit }}</div>
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
                                <div class="h4 mb-0">$ {{ $totalWithdraw }} </div>
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
                                <div class="h4 mb-0">{{ $totalUser }}</div>
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
                                <div class="h4 mb-0">$ {{ $totalWithdrawRequest }}</div>
                                <div class="weight-600 font-14">Request Withdraw</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            {{-- <div class="card-box mb-10">
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
            </div> --}}



            <div class="section mt-10">
                <h3>Mobile Emergency Butons</h3>

                <ul id="accordion-menu">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="dropdown-toggle no-arrow">
                            <span class="micon dw dw-house-1"></span><span class="mtext">Home</span>
                        </a>

                    </li>
                    <li class="dropdown">
                        <a href="{{ route('admin.trader') }}" class="dropdown-toggle no-arrow">
                            <span class="micon dw dw-user text-info"></span><span class="mtext">Traders</span>
                        </a>

                    </li>
                    <li class="dropdown">
                        <a href="{{ route('admin.depost') }}" class="dropdown-toggle no-arrow">
                            <span class="micon dw dw-money text-success"></span><span class="mtext">Deposit</span>
                        </a>

                    </li>
                    <li>
                        <a href="{{ route('admin.withdraw') }}" class="dropdown-toggle no-arrow">
                            <span class="micon dw dw-money text-danger"></span><span class="mtext">Withdraw</span>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="{{ route('admin.password') }}" class="dropdown-toggle no-arrow">
                            <span class="micon dw dw-apartment"></span><span class="mtext"> Password Resets </span>
                        </a>
                    </li>

                    <li class="dropdown">
                        <a href="{{ route('admin.payments.index') }}" class="dropdown-toggle no-arrow">
                            <span class="micon dw dw-paint-brush"></span><span class="mtext">PAYMENTS</span>
                        </a>
                    </li>

                    <li class="dropdown ">
                        <a href="{{ route('admin.game_settings.index') }}" class="dropdown-toggle no-arrow">
                            <span class="micon dw dw-user"></span>
                            <span class="mtext">Siginal And Bolt</span>
                        </a>

                    </li>
                    <li class="dropdown text-warning">
                        <a href="{{ route('admin.user_investments.index') }}" class="dropdown-toggle no-arrow">
                            <span class="micon dw dw-user"></span>
                            <span class="mtext">Trader Beting Siginal</span>
                        </a>

                    </li>


                    {{-- <li class="dropdown ">
                        <a href="{{ route('admin.referrals.index') }}" class="dropdown-toggle no-arrow">
                            <span class="micon dw dw-user-2"></span>
                            <span class="mtext">Referrals</span>
                        </a>

                    </li> --}}

                    {{-- <li class="dropdown ">
                        <a href="{{ route('admin.settings') }}" class="dropdown-toggle no-arrow">
                            <span class="micon dw dw-settings"></span>
                            <span class="mtext">Setups</span>
                        </a>

                    </li> --}}
                    <li>

                        <a class="dropdown-toggle no-arrow text-danger" href="#"
                            onclick="event.preventDefault(); document.getElementById('admin-logout-form2').submit();">
                            <i class="dw dw-logout"></i> Logout
                        </a>
                        <form id="admin-logout-form2" action="{{ route('admin.logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>

                    </li>


                </ul>

            </div>

        </div>
    </div>
@endsection
