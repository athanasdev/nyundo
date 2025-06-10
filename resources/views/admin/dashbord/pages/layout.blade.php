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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/vendors/styles/core.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/vendors/styles/icon-font.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/vendors/styles/style.css') }}">

    {{--  admin css --}}
    <link rel="stylesheet" href="{{ asset('admin/src/plugins/datatables/css/dataTables.bootstrap4.min.css') }}">
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

    <div class="section">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

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

    <div class="mobile-menu-overlay"></div>


    @yield('content')


    <!-- js -->
    <script src="{{ asset('admin/vendors/scripts/core.js') }}"></script>
    <script src="{{ asset('admin/vendors/scripts/script.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/scripts/process.js') }}"></script>
    <script src="{{ asset('admin/vendors/scripts/layout-settings.js') }}"></script>
    <script src="{{ asset('admin/src/plugins/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('admin/src/scripts/jquery.min.js') }}"></script>
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


    <!-- Datatable Setting js -->
    <script src="{{ asset('admin/vendors/scripts/datatable-setting.js') }}"></script>


    <!-- SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function copyToClipboard(code) {
            navigator.clipboard.writeText(code).then(function() {
                alert('Code copied: ' + code);
            }, function(err) {
                alert('Failed to copy: ', err);
            });
        }

         function copyToClipboardAddres(payment_address) {
            navigator.clipboard.writeText(payment_address).then(function() {
                alert('Address Copyied: ' + payment_address);
            }, function(err) {
                alert('Failed to copy: ', err);
            });
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Copy button logic remains the same...

            // Pay button confirmation
            document.querySelectorAll('.pay-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault(); // Stop default
                    if (confirm('Are you sure you want to mark this payment as complete?')) {
                        form.submit(); // Submit only if confirmed
                    }
                });
            });
        });
    </script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session('error') }}',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif

    @push('scripts')

    </body>

    </html>
