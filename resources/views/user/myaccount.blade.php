<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Charset and Viewport -->
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover">
    <!-- Basic SEO -->
    <title>INEX Trading | Empowering Your Financial Journey</title>
    <meta name="description"
        content="Explore INEX Trading tools, features, and services designed to help you trade smarter and grow your investments with confidence.">
    <meta name="keywords"
        content="INEX Trading, trading platform, investment tools, finance, portfolio management, trading dashboard">
    <meta name="author" content="INEX Trading">

    <!-- Browser Compatibility -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Theme Color -->
    <meta name="theme-color" content="#0a0a0a">

    <!-- Open Graph -->
    <meta property="og:title" content="INEX Trading | Smarter Investment Tools">
    <meta property="og:description" content="Access intelligent tools and real-time insights with INEX Trading.">
    <meta property="og:image" content="https://inexfx.com/favic.png">
    <meta property="og:url" content="{{ route('my-account') }}">
    <meta property="og:type" content="website">

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="INEX Trading | Modern Investment Platform">
    <meta name="twitter:description"
        content="Simplify your trading experience with secure, user-friendly tools at INEX Trading.">
    <meta name="twitter:image" content="https://inexfx.com/favic.png">

    <!-- Favicon and Icons -->
    <link rel="shortcut icon" href="https://inexfx.com/favic.png" />
    <link rel="apple-touch-icon-precomposed" href="https://inexfx.com/favic.png" />
    <link rel="stylesheet" type="text/css" href="{{ asset('client/css/styles.css') }}" />
    <!-- Stylesheets -->
    <link rel="stylesheet" href="https://inexfx.com/fonts/fonts.css">
    <link rel="stylesheet" href="https://inexfx.com/fonts/font-icons.css">
    <link rel="stylesheet" href="https://inexfx.com/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://inexfx.com/css/styles.css" />
    <link rel="stylesheet" href="https://inexfx.com/css/swiper-bundle.min.css">
    <link href="https://iconsax.gitlab.io/i/icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://inexfx.com/css/countrySelect.css">
    <style>
        .account-mode {
            background: #29313c;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: 700;
        }
    </style>
</head>

<body style="overflow-x: hidden">
    <!-- preloade -->
    <div class="preloader preload-container">
        <div class="preload-logo " style="display: flex; flex-direction: column; align-items: center;">
            <div class="lds-ring" style="margin-bottom: 10px">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>

        </div>
    </div>
    <!-- /preload -->
    <style>
        .vip-tag {
            background: #f2b90f10;
            padding: 1px 8px;
            font-weight: 800;
            color: #f2b90f;
            border-radius: 6px;
            margin-right: 10px;
        }

        .verified-tag {
            background: #26de8110;
            padding: 1px 8px;
            font-weight: 800;
            color: #26de81;
            border-radius: 6px;
        }

        .unverified-tag {
            background: #f6465d20;
            padding: 1px 8px;
            font-weight: 800;
            color: #f6465d;
            border-radius: 6px;
        }

        .profile-btn,
        .profile-btn:hover,
        .profile-btn:active,
        .profile-btn:focus {
            background: transparent;
            padding: 0;
            margin: 0;
            height: fit-content;
            width: fit-content;
            color: #8d98a6;
            border: none;
            outline: none;
            font-weight: 600;
            box-shadow: none;
        }

        .setting-item {
            padding: 10px;
            column-gap: 10px;
            border-bottom: 1px solid #7e808830
        }

        .leading-icon {
            font-size: 22px;
        }
    </style>
    <div class="header fixed-top d-flex justify-space align-items-center" style="background: #1e2730;">
        <a href="#" class="left back-btn"><i class="iconsax back-icon-ct" icon-name="arrow-left"></i></a>
        <h3 style="font-size:16px!important;font-weight:600"></h3>
        <div class="d-row align-center" style="margin-right: 10px;color: #fff;font-size: 20px;column-gap:10px">

            <a href="#">
                <i class="iconsax" icon-name="question-message"></i>
            </a>
        </div>
    </div>
    <div class="pt-45">
        <div class="tf-container" style="padding-left:0px;padding-right:0px">
            <div class="d-row align-center w-100" style="padding:10px 15px;column-gap:10px">
                <img src="https://inexfx.com/avatar.png" alt=""
                    style="height: 60px;width:60px;border-radius:15px">
                <div class="d-row align-center justify-space w-100">
                    <div class="d-col">
                        <span style="font-size: 13px;font-weight:600">ID: {{ $user->unique_id }}</span>
                        <span
                            style="font-size: 18px;color:#fff;font-weight:600;margin:6px 0;text-transform:capitalize">{{ $user->username }}</span>
                        <div class="d-row mt-1">
                            <span class="unverified-tag">{{ $user->status }}</span>
                        </div>
                    </div>
                    <a href="{{route('user.logout')}}"
                        onclick="event.preventDefault(); document.getElementById('frm-logout').submit();"
                        class="btn profile-btn d-row align-center">
                        <span>Logout</span>
                        <i class="iconsax" icon-name="chevron-right"></i>
                    </a>
                    <form id="frm-logout" action="logout" method="POST" style="display: none;">
                         @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="hr"></div>
    <div class="d-row justify-evenly w-100 mb-3" style="margin-top: 20px">
        <a href="{{route('ai-trading')}}" class="d-col align-center">
            <div class="icon-box">
                <i class="iconsax" icon-name="cpu"></i>
            </div>
            <span style="color: #fff">AI Bot</span>
        </a>

        <a href="{{ route('team') }}" class="d-col align-center">
            <div class="icon-box">
                <i class="iconsax" icon-name="users"></i>
            </div>
            <span style="color: #fff">Team</span>
        </a>
        <a href="{{ route('bonuses') }}" class="d-col align-center">
            <div class="icon-box">
                <i class="iconsax" icon-name="gift"></i>
            </div>
            <span style="color: #fff">Bonus</span>
        </a>
    </div>
    <div class="hr"></div>
    <div class="" style="padding-bottom:80px">
        <div class="tf-container" style="padding-left:0px;padding-right:0px">
            <a href="#" class="d-row setting-item align-center w-100">
                <i class="iconsax leading-icon" icon-name="verify"></i>
                <div class="d-row justify-space w-100 align-center">
                    <div class="d-col">
                        <span style="font-size:14px;color:#fff;font-weight:800">KYC Verification</span>
                        <span style="margin-top: 4px">ID Verification</span>
                    </div>
                    <i class="iconsax" icon-name="chevron-right"></i>
                </div>
            </a>
            <a href="#" class="d-row setting-item align-center w-100">
                <i class="iconsax leading-icon" icon-name="shield-lock"></i>
                <div class="d-row justify-space w-100 align-center">
                    <div class="d-col">
                        <span style="font-size:14px;color:#fff;font-weight:800">Two-Factor Authentication</span>
                        <span style="margin-top: 4px">Extra Security for Maximum Protection</span>
                    </div>
                    <i class="iconsax" icon-name="chevron-right"></i>
                </div>
            </a>
            <a href="https://inexfx.com/withdrawal-method" class="d-row setting-item align-center w-100">
                <i class="iconsax leading-icon" icon-name="bank-card-add"></i>
                <div class="d-row justify-space w-100 align-center">
                    <div class="d-col">
                        <span style="font-size:14px;color:#fff;font-weight:800">Withdrawal Method</span>
                        <span style="margin-top: 4px">Account or Address Details for Withdrawals</span>
                    </div>
                    <i class="iconsax" icon-name="chevron-right"></i>
                </div>
            </a>
            <a href="https://inexfx.com/withdrawal-password" class="d-row setting-item align-center w-100">
                <i class="iconsax leading-icon" icon-name="shield-card"></i>
                <div class="d-row justify-space w-100 align-center">
                    <div class="d-col">
                        <span style="font-size:14px;color:#fff;font-weight:800">Withdrawal Password</span>
                        <span style="margin-top: 4px">Update or Reset Withdrawal Password</span>
                    </div>
                    <i class="iconsax" icon-name="chevron-right"></i>
                </div>
            </a>
            <a href="https://inexfx.com/account-password" class="d-row setting-item align-center w-100">
                <i class="iconsax leading-icon" icon-name="lock-2"></i>
                <div class="d-row justify-space w-100 align-center">
                    <div class="d-col">
                        <span style="font-size:14px;color:#fff;font-weight:800">Account Password</span>
                        <span style="margin-top: 4px">Update or Reset Account Password</span>
                    </div>
                    <i class="iconsax" icon-name="chevron-right"></i>
                </div>
            </a>
            <a href="{{route('language')}}" class="d-row setting-item align-center w-100">
                <i class="iconsax leading-icon" icon-name="translate"></i>
                <div class="d-row justify-space w-100 align-center">
                    <div class="d-col">
                        <span style="font-size:14px;color:#fff;font-weight:800">System Language</span>
                        <span style="margin-top: 4px">
                            English (United Kingdom)
                        </span>
                    </div>
                    <i class="iconsax" icon-name="chevron-right"></i>
                </div>
            </a>
            <a href="" class="d-row setting-item align-center w-100">
                <i class="iconsax leading-icon" icon-name="globe"></i>
                <div class="d-row justify-space w-100 align-center">
                    <div class="d-col">
                        <span style="font-size:14px;color:#fff;font-weight:800">System Time</span>
                        <span style="margin-top: 4px">UTC</span>
                    </div>
                    <i class="iconsax" icon-name="chevron-right"></i>
                </div>
            </a>
            <a href="https://jivo.chat/mYllXH6MUc" class="d-row setting-item align-center w-100">
                <i class="iconsax leading-icon" icon-name="question-message"></i>
                <div class="d-row justify-space w-100 align-center">
                    <div class="d-col">
                        <span style="font-size:14px;color:#fff;font-weight:800">Support</span>
                        <span style="margin-top: 4px">Live Chat</span>
                    </div>
                    <i class="iconsax" icon-name="chevron-right"></i>
                </div>
            </a>
            <a href="https://inexfx.com/app-release.apk" download class="d-row setting-item align-center w-100">
                <i class="iconsax leading-icon" icon-name="mobile"></i>
                <div class="d-row justify-space w-100 align-center">
                    <div class="d-col">
                        <span style="font-size:14px;color:#fff;font-weight:800">Download App</span>
                        <span style="margin-top: 4px">Access Inex easly via mobile app</span>
                    </div>
                    <i class="iconsax" icon-name="chevron-right"></i>
                </div>
            </a>
            <a href="https://inexfx.com/about-inex" class="d-row setting-item align-center w-100">
                <i class="iconsax leading-icon" icon-name="building-2"></i>
                <div class="d-row justify-space w-100 align-center">
                    <div class="d-col">
                        <span style="font-size:14px;color:#fff;font-weight:800">About Us</span>
                        <span style="margin-top: 4px">Learn More About Inex</span>
                    </div>
                    <i class="iconsax" icon-name="chevron-right"></i>
                </div>
            </a>
        </div>
    </div>

    @include('user.components.footer')

    <script type="text/javascript" src="https://inexfx.com/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://inexfx.com/js/jquery.min.js"></script>
    <script type="text/javascript" src="https://inexfx.com/js/swiper-bundle.min.js"></script>
    <script type="text/javascript" src="https://inexfx.com/js/carousel.js"></script>
    <script type="text/javascript" src="https://inexfx.com/js/apexcharts.js"></script>
    <script type="text/javascript" src="https://inexfx.com/js/chart.bundle.min.js"></script>
    <script type="text/javascript" src="https://inexfx.com/js/line-chart.js"></script>
    <script type="text/javascript" src="https://inexfx.com/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.19.1/dist/sweetalert2.all.min.js"></script>
    <script>
        $('.system-mode-toggle').on('click', function() {
            var mode = "1";
            if (mode == '1') {
                Swal.fire({
                    title: "Switch to Demo account",
                    text: "You are about to switch to demo account are you sure?",
                    icon: 'info',
                    showCancelButton: true,
                    showConfirmButton: true,
                }).then(function(result) {
                    if (result.isConfirmed) {
                        window.location.href = "https://inexfx.com/switch-to-demo";
                    } else if (result.isDismissed) {
                        Swal.fire({
                            title: "Action dismissed",
                            text: "You choose to stay in Real account",
                            icon: 'info',
                        });
                    }
                });
            } else if (mode == 0) {
                Swal.fire({
                    title: "Switch to Real account",
                    text: "You are about to switch to real account are you sure?",
                    icon: 'info',
                    showCancelButton: true,
                    showConfirmButton: true,
                }).then(function(result) {
                    if (result.isConfirmed) {
                        window.location.href = "https://inexfx.com/switch-to-real";
                    } else if (result.isDismissed) {
                        Swal.fire({
                            title: "Action dismissed",
                            text: "You choose to stay in Demo account",
                            icon: 'info',
                        });
                    }
                });
            }
        });
    </script>
    <script>
        const handleSwalButtons = () => {
            const actions = document.querySelector('.swal2-actions');
            if (!actions) return;

            const buttons = actions.querySelectorAll('button');
            const visibleButtons = Array.from(buttons).filter(btn => btn.style.display !== 'none');

            buttons.forEach(btn => btn.classList.remove('only-visible-button'));

            if (visibleButtons.length === 1) {
                visibleButtons[0].classList.add('only-visible-button');
            }
        };

        const swalConfig = Swal.mixin({
            didRender: () => {
                handleSwalButtons();
            }
        });
        window.Swal = swalConfig;

        function copy(text, message) {
            navigator.clipboard.writeText(text).then(
                function() {
                    Swal.fire({
                        icon: 'success',
                        title: message,
                        showConfirmButton: true,
                        confirmButtonText: 'Okay',
                    });
                },
                function(err) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error copying text',
                        text: err,
                        showConfirmButton: true,
                        confirmButtonText: 'Okay',
                    });
                });
        }
    </script>
</body>

</html>
