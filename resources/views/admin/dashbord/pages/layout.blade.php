<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8">
    <title>Desk</title>

    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('admin/vendors/images/apple-touch-icon.png') }}">
    {{-- <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('admin/vendors/images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('admin/vendors/images/favicon-16x16.png') }}"> --}}

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/vendors/styles/core.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/vendors/styles/icon-font.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/vendors/styles/style.css') }}">

    {{--  admin css --}}

    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin/src/plugins/datatables/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin/src/plugins/datatables/css/responsive.bootstrap4.min.css') }}">


    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin/src/plugins/datatables/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin/src/plugins/datatables/css/responsive.bootstrap4.min.css') }}">





</head>

<body>


    <div class="header">
        <div class="header-left">
            <div class="menu-icon dw dw-menu"></div>
            <div class="search-toggle-icon dw dw-search2" data-toggle="header_search"></div>
        </div>
        <div class="header-right">
            <div class="user-info-dropdown">
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                        <span class="user-icon">
                            <img src="{{ asset('admin/vendors/images/photo1.jpg') }}" alt="">
                        </span>
                        @if (session('admin'))
                            <span class="user-name"> welcome {{ $admin->name }}</span>
                        @endif

                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                        <a class="dropdown-item" href="profile.html"><i class="dw dw-user1"></i> Profile</a>
                        <a class="dropdown-item" href="profile.html"><i class="dw dw-settings2"></i> Setting</a>
                        <a class="dropdown-item" href="faq.html"><i class="dw dw-help"></i> Help</a>
                        <a class="dropdown-item" href="#"
                            onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
                            <i class="dw dw-logout"></i> Log Out
                        </a>
                        <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>


    <div class="left-side-bar">
        <div class="brand-logo">
            <span>
                <h3 class="text-light p-4">Crypto</h3>
            </span>
            <div class="close-sidebar" data-toggle="left-sidebar-close">
                <i class="ion-close-round"></i>
            </div>
        </div>
        <div class="menu-block customscroll">
            <div class="sidebar-menu">
                <ul id="accordion-menu">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="dropdown-toggle no-arrow">
                            <span class="micon dw dw-house-1"></span><span class="mtext">Home</span>
                        </a>

                    </li>
                    <li class="dropdown">
                        <a href="{{route('admin.trader')}}" class="dropdown-toggle no-arrow">
                            <span class="micon dw dw-user text-info"></span><span class="mtext">Traders</span>
                        </a>

                    </li>
                    <li class="dropdown">
                        <a href="{{route('admin.depost')}}" class="dropdown-toggle no-arrow">
                            <span class="micon dw dw-money text-success"></span><span class="mtext">Deposit</span>
                        </a>

                    </li>
                    <li>
                        <a href="{{route('admin.withdraw')}}" class="dropdown-toggle no-arrow">
                            <span class="micon dw dw-money text-danger"></span><span class="mtext">Withdraw</span>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="{{ route('admin.password') }}" class="dropdown-toggle no-arrow">
                            <span class="micon dw dw-apartment"></span><span class="mtext"> Password Resets </span>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="{{ route('admin.logs') }}" class="dropdown-toggle no-arrow">
                            <span class="micon dw dw-paint-brush"></span><span class="mtext"> Logs </span>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:;" class="dropdown-toggle">
                            <span class="micon dw dw-analytics-21"></span><span class="mtext">Charts</span>
                        </a>
                        <ul class="submenu">
                            <li><a href="highchart.html">Highchart</a></li>
                            <li><a href="knob-chart.html">jQuery Knob</a></li>
                            <li><a href="jvectormap.html">jvectormap</a></li>
                            <li><a href="apexcharts.html">Apexcharts</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:;" class="dropdown-toggle">
                            <span class="micon dw dw-right-arrow1"></span><span class="mtext">Additional Pages</span>
                        </a>
                        <ul class="submenu">
                            <li><a href="video-player.html">Video Player</a></li>
                            <li><a href="login.html">Login</a></li>
                            <li><a href="forgot-password.html">Forgot Password</a></li>
                            <li><a href="reset-password.html">Reset Password</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:;" class="dropdown-toggle">
                            <span class="micon dw dw-browser2"></span><span class="mtext">Error Pages</span>
                        </a>
                        <ul class="submenu">
                            <li><a href="400.html">400</a></li>
                            <li><a href="403.html">403</a></li>
                            <li><a href="404.html">404</a></li>
                            <li><a href="500.html">500</a></li>
                            <li><a href="503.html">503</a></li>
                        </ul>
                    </li>

                    <li>

                        <a class="dropdown-toggle text-danger" href="#"
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

    <div class="mobile-menu-overlay"></div>


    @yield('content')


    <!-- js -->
    <script src="{{ asset('admin/vendors/scripts/core.js') }}"></script>
    <script src="{{ asset('admin/vendors/scripts/script.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/scripts/process.js') }}"></script>
    <script src="{{ asset('admin/vendors/scripts/layout-settings.js') }}"></script>
    <script src="{{ asset('admin/src/plugins/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('admin/src/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/src/plugins/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin/src/plugins/datatables/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('admin/src/plugins/datatables/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/scripts/dashboard.js') }}"></script>


    {{--  data tables --}}
    <!-- buttons for Export datatable -->
    <script src="{{ asset('admin/src/plugins/datatables/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('admin/src/plugins/datatables/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin/src/plugins/datatables/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('admin/src/plugins/datatables/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('admin/src/plugins/datatables/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('admin/src/plugins/datatables/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('admin/src/plugins/datatables/js/vfs_fonts.js') }}"></script>


    <script src="{{ asset('admin/src/plugins/datatables/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{ asset('admin/src/plugins/datatables/js/dataTables.bootstrap4.min.js')}}"></script>
	<script src="{{ asset('admin/src/plugins/datatables/js/dataTables.responsive.min.js')}}"></script>
	<script src="{{ asset('admin/src/plugins/datatables/js/responsive.bootstrap4.min.js')}}"></script>
    <!-- Datatable Setting js -->
    <script src="{{ asset('admin/vendors/scripts/datatable-setting.js') }}"></script>


</body>

</html>
