
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
    <meta property="og:url" content="https://inexfx.com/withdraw">
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
    <link rel="stylesheet" href="https://inexfx.com/fonts/fonts.css">
    <link rel="stylesheet" href="https://inexfx.com/fonts/font-icons.css">
    <link rel="stylesheet" href="https://inexfx.com/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://inexfx.com/css/styles.css" />
    <link rel="stylesheet" href="https://inexfx.com/css/swiper-bundle.min.css">
    <link href="https://iconsax.gitlab.io/i/icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://inexfx.com/css/countrySelect.css">
    <style>
         .account-mode{
            background:#29313c;
            padding:2px 6px;
            border-radius:4px;
            font-weight:700;
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
            <h6>Loading...</h6>
        </div>
    </div>
    <!-- /preload -->
        <style>
        input {
            background: #29313c !important;
            border: none !important;
            color: white !important;
        }

        .menubar-footer {
            display: none;
        }

        .withdrawal-footer {
            position: fixed;
            width: 100%;
            left: 0;
            bottom: 0;
            padding: 20px;
            border-top: 1px solid #29313c;
        }

        .withdrawal-footer button {
            width: fit-content;
            height: fit-content;
        }

        .with-box-input {
            background: #29313c;
            border-radius: 10px;
            align-items: center;
            padding: 0 20px 0 0;
            margin-bottom: 8px;
        }

        .with-box-input button {
            width: fit-content;
            font-size: 20px;
            color: #8d98a6;
            border: none;
            box-shadow: none;
        }

        .with-box-input span {
            font-size: 16px;
            font-weight: 800;
            color: #fff;
        }

        .with-box-input button:hover,
        .with-box-input button:focus,
        .with-box-input button:active {
            background: #29313c;
            color: #fff;
            border: none;
            box-shadow: none;
        }

        .withdrawal-button:active,
        .withdrawal-button:hover,
        .withdrawal-button:focus {
            background: #26de81;
            color: #fff;
            border: none;
            box-shadow: none;
        }
    </style>
        <div class="header fixed-top bg-surface d-flex justify-content-center align-items-center">
        <a href="https://inexfx.com/assets" class="left"><i class="iconsax back-icon-ct" icon-name="arrow-left"></i></a>
        <h3 style="font-size:16px!important;font-weight:600">
            Withdraw                            USDT
                    </h3>
    </div>
    <div class="pt-45 pb-90">
        <div class="tf-container" style="padding-top: 40px">
            <form action="https://inexfx.com/request-withdrawal" method="POST" id="request-withdrawal-form">
                <input type="hidden" name="_token" value="7MK8h8Hoiansg0JrdC75N7UiGNk4WYhldNL1995n" autocomplete="off">                <div style="margin-bottom: 20px">
                                            <label for="" style="margin-bottom: 4px;font-weight:700">Address</label>

                                                                        <input type="text" class="form-control" value="TCsXZ2Fkaz61zDSU9XA3q625NnmUEvXNyu" readonly>
                                                            </div>
                <div>
                    <label for="" style="margin-bottom: 4px;font-weight:700">Withdrawal Amount</label>
                    <div class="d-row with-box-input">
                        <input type="text" name="amount" class="amount-input">
                        <button class="btn reset-amount"><i class="iconsax" icon-name="x-circle"></i></button>
                        <span>
                            USDT
                        </span>
                    </div>
                </div>
                <div class="d-row justify-space" style="margin-bottom: 20px">
                    <span>Available</span>
                    <span>1.000 USDT</span>
                </div>
                <div class="">
                    <label for="" style="margin-bottom: 4px;font-weight:700">Withdrawal PIN</label>
                    <input type="password" name="withdrawal_password" placeholder="Withdrawal PIN">
                </div>
            </form>
        </div>
        <div class="hr"></div>
        <div class="tf-container">
            <div class="d-col" style="padding: 10px 0px;margin-top:20px;font-size:13px">
                <div class="">
                    <span>* Your withdrawal will be credited to your wallet or account within 24 hours.</span>
                </div>
                <div class="mt-2">
                    <span>* Withdrawals are permitted once per day.</span>
                </div>
                <div class="mt-2">
                    <span>* If you encounter any issues, please contact our <a href="https://jivo.chat/mYllXH6MUc" style="color:#1f0b6c;font-weight:600">Customer Support</a></span>
                </div>
            </div>
        </div>
    </div>
    <div class="withdrawal-footer d-row justify-space">
        <div class="d-col">
            <span style="font-size: 14px;font-weight:700;margin-bottom:8px">Received Amount</span>
            <span style="font-size:20px;font-weight:800;color:#fff;margin-bottom:8px"><span
                    class="receivable-amount">0.000</span> USDT</span>
            <div class="">
                <span style="font-weight:600;border-bottom:1px dotted #8d98a6">Transaction Fee</span>
                <span style="color: white;font-weight:600"><span class="fee">0.00</span> USDT</span>
            </div>
        </div>
        <button class="withdrawal-button yl-btn" type="submit" form="request-withdrawal-form">Withdraw</button>
    </div>

    @include("user.components.footer")

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
        $('.system-mode-toggle').on('click',function(){
            var mode = "1";
            if(mode == '1'){
                Swal.fire({
                    title: "Switch to Demo account",
                    text: "You are about to switch to demo account are you sure?",
                    icon: 'info',
                    showCancelButton: true,
                    showConfirmButton: true,
                }).then(function(result){
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
            }else if(mode == 0){
                Swal.fire({
                   title: "Switch to Real account",
                    text: "You are about to switch to real account are you sure?",
                    icon: 'info',
                    showCancelButton: true,
                    showConfirmButton: true,
                }).then(function(result){
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
        $(document).ready(function() {
            $('.amount-input').on('input', function() {
                var amount = parseFloat($(this).val());
                var fee = amount * 0.05;
                if (isNaN(fee)) {
                    fee = 0;
                    var receivableAmount = 0;
                } else {
                    var receivableAmount = amount - fee;
                }
                $('.fee').text(fee.toFixed(2));
                $('.receivable-amount').text(receivableAmount.toFixed(2));
            });
        });

        $('.reset-amount').on('click', function() {
            $('.amount-input').val('');
            $('.fee').text('0.00');
            $('.receivable-amount').text('0.00');
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
