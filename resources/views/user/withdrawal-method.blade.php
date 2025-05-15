<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Charset and Viewport -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover">
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
    <meta property="og:url" content="https://inexfx.com/withdrawal-method">
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
            <h6>Loading...</h6>
        </div>
    </div>
    <!-- /preload -->
    <style>
        .form-group-tr {
            margin-bottom: 10px;
        }

        .form-group-tr span {
            font-size: 14px;
            font-weight: 600;
        }

        .form-group-tr input {
            margin-top: 4px;
            height: fit-content;
            padding: 10px 15px;
            background: #29313c;
            border: none;
        }

        .form-group-tr input:hover,
        .form-group-tr input:focus,
        .form-group-tr input:active {
            background: #29313c;
            border: none;
            box-shadow: none;
            outline: none;
            color: #fff;
        }

        .form-group-tr input::placeholder {
            color: #A0AEC080;
            font-size: 14px;
        }

        .pin-input input {
            height: 47px;
            border-radius: 10px 0 0 10px;
        }

        .pin-input button {
            width: fit-content;
            height: fit-content;
            border: none;
            outline: none;
            color: #A0AEC080;
            background: #29313c;
            height: 47px;
            border-radius: 0 10px 10px 0;
            margin-top: 4px;
        }

        .pin-input button:hover,
        .pin-input button:focus,
        .pin-input button:active {
            background: #29313c;
            border: none;
            box-shadow: none;
            outline: none;
            color: #fff;
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
    </style>
    <div class="header fixed-top bg-surface d-flex justify-content-center align-items-center">
        <a href="#" class="left back-btn"><i class="iconsax back-icon-ct" icon-name="arrow-left"></i></a>
        <h3 style="font-size: 22px;font-weight:600;">
            Payment Method </h3>
    </div>
    <div class="pt-45 pb-90">
        <div class="tf-container" style="padding-top: 40px">
            <form action="https://inexfx.com/save-withdrawal-method" method="POST" class="form" id="payment-form">
                <input type="hidden" name="_token" value="80mL5Ego4Q6zDKYzCuq0kPZ4bs6FNqPYtV1BWJ5O"
                    autocomplete="off">
                <div style="margin-bottom:15px">
                    <span style="font-size: 18px;font-weight:600;">USDT TRC20 Method</span>
                </div>
                <div class="form-group-tr">
                    <span style="margin-bottom: 6px">Payment Address</span>
                    <input type="text" class="form-control" name="address" value=""
                        placeholder="Eg. TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t" required>
                </div>


                <div class="form-group-tr">
                    <span>Withdrawal Password</span>
                    <div class="d-row pin-input pin-1 align-center">
                        <input type="password" class="form-control" name="withdrawal_password" value=""
                            placeholder="Create withdrawal password" required>
                        <button class="btn toggle-pass" type="button"><i class="iconsax" icon-name="eye"></i></button>
                    </div>
                </div>
                <div class="form-group-tr">
                    <span>Confirm Withdrawal Password</span>
                    <div class="d-row pin-input pin-2 align-center">
                        <input type="password" class="form-control" name="confirm_withdrawal_password" value=""
                            placeholder="Confirm withdrawal password" required>
                        <button class="btn toggle-pass" type="button"><i class="iconsax"
                                icon-name="eye"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <div class="hr"></div>
        <div class="tf-container">
            <div class="d-col" style="padding: 10px 0px;margin-top:20px;font-size:13px">
                <div class="">
                    <span>* Please be careful when setting a payment method, as it will be locked and cannot be changed
                        later.</span>
                </div>
                <div class="mt-2">
                    <span>* The withdrawal password is a 4-digit code and is different from your login password.</span>
                </div>
            </div>
        </div>
    </div>
    <div class="withdrawal-footer d-row justify-space">
        <button type="submit" form="payment-form">Save</button>
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
        // Toggle password visibility
        document.querySelectorAll('.toggle-pass').forEach(function(button) {
            button.addEventListener('click', function() {
                const input = this.previousElementSibling;
                if (input.type === 'password') {
                    input.type = 'text';
                    this.innerHTML = '<i class="iconsax" icon-name="eye-slash"></i>';
                } else {
                    input.type = 'password';
                    this.innerHTML = '<i class="iconsax" icon-name="eye"></i>';
                }
            });
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
