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
    <meta property="og:url" content="https://inexfx.com/assets">
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

    <!-- Stylesheets -->
    <link rel="stylesheet" type="text/css" href="{{ asset('client/css/styles.css') }}" />
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
    <script src="//code.jivosite.com/widget/Cr6CmJv8z9" async></script>

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
            <h6>Loading...</h6>
        </div>
    </div>
    <!-- /preload -->
    <style>
        body {
            background: #1e2730;
        }

        svg {
            margin-top: -3px;
            height: 16px !important;
            width: 16px !important;
        }
    </style>
    <div class="header fixed-top d-flex justify-content-center align-items-center" style="background: #1e2730;">
        <a href="#" class="left back-btn"><i class="iconsax back-icon-ct" icon-name="arrow-left"></i></a>
        <h3 style="font-size:16px!important;font-weight:600">Asset Management</h3>
        <div style="position:absolute;right:20px">
            <a href="#" class="system-mode-toggle">
                <div class="d-row align-center account-mode" style="column-gap:4px">
                    <i class="iconsax" icon-name="setting-1"></i>
                    <span style="font-size:14px">Real</span>
                </div>
            </a>
        </div>
    </div>
    <div class="pt-45 pb-16">
        <div class="tf-container" style="padding-left:0px;padding-right:0px">
            <div class="pb-12 mt-2">
                <div class="wrap-filter-swiper">
                    <div class="swiper-wrapper1 menu-tab-v3 mt-12" role="tablist"
                        style="column-gap: 20px;border-bottom:1px solid #7e808830;padding-bottom:0px;">
                        <div class="swiper-slide1 nav-link active" data-bs-toggle="tab" data-bs-target="#main-account"
                            role="tab" aria-controls="main-account" aria-selected="true" style="margin-left:10px">
                            Main Account </div>
                        <div class="swiper-slide1 nav-link" data-bs-toggle="tab" data-bs-target="#asset-account"
                            role="tab" aria-controls="asset-account" aria-selected="false">
                            Trading Asset </div>
                    </div>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="main-account" role="tabpanel">
                        <div class="p-10" style="padding-top: 10px">
                            <div class="d-row justify-space w-100 ">
                                <span>Estimated Total Balance</span>
                                <span><i class="iconsax" icon-name="document-text-2"></i> History</span>
                            </div>
                            <div class="d-col" style="margin-top: 10px">
                                <span style="font-size: 20px;font-weight:800;color:#fff">1.000 USDT</span>
                                <span style="margin-top:6px;color:#fff">Assets balance <span>0.000 USDT</span></span>
                            </div>
                            <div class="d-row justify-evenly w-100" style="margin-top: 20px">
                                <a href="{{route('deposit')}}" class="d-col align-center">
                                    <div class="icon-box">
                                        <i class="iconsax" icon-name="download-2"></i>
                                    </div>
                                    <span style="color: #fff">Deposit</span>
                                </a>
                                <a href="{{ route('withdraw')}}" class="d-col align-center">
                                    <div class="icon-box">
                                        <i class="iconsax" icon-name="upload-2"></i>
                                    </div>
                                    <span style="color: #fff">Withdraw</span>
                                </a>
                                <a href="{{ route('buy-crypto') }}" class="d-col align-center">
                                    <div class="icon-box">
                                        <i class="iconsax" icon-name="wallet-money"></i>
                                    </div>
                                    <span style="color: #fff">Buy</span>
                                </a>
                                <a href="{{route('transfer')}}" class="d-col align-center">
                                    <div class="icon-box">
                                        <i class="iconsax" icon-name="shuffle-2"></i>
                                    </div>
                                    <span style="color: #fff">Transfer</span>
                                </a>
                            </div>
                        </div>
                        <div class="" style="border-top: 2px solid #7e808830;margin-top: 20px"></div>
                        <a href="/view-deposit/{id}">
                            <div class="d-row w-100"
                                style="column-gap: 10px;padding:10px;border-bottom: 1px solid #7e808830">
                                <div class="">
                                    <img src="https://inexfx.com/usdt.png" style="height: 40px;width:40px"
                                        alt="">
                                </div>
                                <div class="d-row justify-space w-100">
                                    <div class="d-col">
                                        <span
                                            style="color: #fff;text-transform:uppercase;font-size:16px;margin-top:4px">deposit</span>
                                        <span style="margin-top: 4px">USDT TRC20</span>
                                    </div>
                                    <div class="d-col align-end">
                                        <span style=" color: #fff ;font-size:16px;font-weight:700">
                                            0.000 USDT
                                        </span>

                                        <span style="margin-top: 4px">2025-05-14 10:43:47 AM</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="tab-pane fade" id="asset-account" role="tabpanel">
                        <div class="p-10" style="padding-top: 10px">
                            <div class="d-row justify-space w-100 ">
                                <span>Total Assets</span>
                                <span><i class="iconsax" icon-name="document-text-2"></i> History</span>
                            </div>
                            <div class="d-col" style="margin-top: 10px">
                                <span style="font-size: 20px;font-weight:800;color:#fff">0.000 USDT</span>
                                <span style="margin-top:6px;color:#fff">Ongoing Trading Balance <span>0.000
                                        USDT</span></span>
                            </div>
                            <div class="d-row w-100" style="margin-top: 20px">
                                <a href="{{route('transfer')}}" class="d-col align-center">
                                    <div class="icon-box">
                                        <i class="iconsax" icon-name="shuffle-2"></i>
                                    </div>
                                    <span style="color: #fff">Transfer</span>
                                </a>
                            </div>
                        </div>
                        <div class="" style="border-top: 2px solid #7e808830;margin-top: 20px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    @include('user.components.footer')

    @include('user.common.script')

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
