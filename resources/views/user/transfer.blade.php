
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
    <meta property="og:url" content="https://inexfx.com/transfer">
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
        body {
            background: #1e2730;
        }

        svg {
            margin-top: -3px;
            height: 16px !important;
            width: 16px !important;
        }

        .exchange-class {
            margin: 15px;
            padding: 10px;
            background: #2c3540;
            border-radius: 10px;
        }

        .exchange-class .labels {
            width: 20%;
            font-size: 14px;
            font-weight: 600;
        }

        .exchange-class select {
            padding: 0;
            height: fit-content;
            width: 80%;
            background: transparent;
            font-size: 16px;
        }

        .exchange-class button {
            color: #ffffff;
            font-size: 25px;
            padding: 0;
            width: fit-content;
            height: fit-content;
            border: none;
            outline: none;
        }

        .exchange-class button:hover,
        .exchange-class button:focus,
        .exchange-class button:active {
            background: #2c3540;
            border: none;
            box-shadow: none;
            outline: none;
            color: #ffffff;
        }

        .coin-area {
            background: #2c3540;
            padding: 10px;
            margin-top: 4px;
            border-radius: 10px;
        }

        .amount-class {
            background: #2c3540;
            padding: 10px 15px;
            margin-top: 4px;
            border-radius: 10px;
            column-gap: 10px;
        }

        .amount-class input {
            background: transparent;
            padding: 0;
            height: fit-content;
            width: 100%;
            border: none;
            outline: none;
        }

        .amount-class span {
            font-size: 16px;
            color: white;
            font-weight: 700;
        }

        .amount-class button {
            background: transparent;
            padding: 0;
            height: fit-content;
            width: fit-content;
            border: none;
            color: #f2b90f;
        }

        .menubar-footer {
            display: none;
        }

        .transfer-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            width: 100%;
            padding: 20px;
            background: #1e2730;
            border: none;
        }
    </style>
    <div class="header fixed-top d-flex justify-content-center align-items-center" style="background: #1e2730;">
        <a href="https://inexfx.com/assets" class="left back-btn"><i class="iconsax back-icon-ct" icon-name="arrow-left"></i></a>
        <h3 style="font-size:16px!important;font-weight:600">Transfer</h3>
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
            <form action="{{route ('funds-transfer') }}" method="POST" id="transfer-form">
                     @csrf
            <div class="d-row exchange-class align-center" style="column-gap: 10px">
                    <div class="d-col" style="width: 90%;row-gap:10px">
                        <div class="d-row align-center">
                            <span class="labels">From</span>
                            <select name="from_account" id="from_account">
                                <option value="main" selected>Main Account</option>
                                <option value="asset">Trading Asset Account</option>
                            </select>
                            <i class="iconsax" icon-name="chevron-right"></i>
                        </div>
                        <div class="d-row align-center">
                            <span class="labels">To</span>
                            <select name="to_account" id="to_account">
                                <option value="main">Main Account</option>
                                <option value="asset" selected>Trading Asset Account</option>
                            </select>
                            <i class="iconsax" icon-name="chevron-right"></i>
                        </div>
                    </div>
                    <div class="" style="width:10%">
                        <button class="btn swap-btn" type="button"><i class="iconsax" icon-name="swap-vertical"></i></button>
                    </div>
                </div>
                <div style="padding:10px 15px">
                    <span>Coin</span>
                    <div class="d-row align-center coin-area" style="column-gap: 10px">
                                                <img src="https://inexfx.com/usdt.png" alt="" style="height: 25px;width: 25px">
                        <div class="">
                            <span style="font-size:16px;font-weight:700;color:#ffffff">USDT</span>
                            <span>TetherUS</span>
                        </div>
                                            </div>
                </div>
                <div style="padding:10px 15px">
                    <span>Amount</span>
                    <div class="amount-class d-row align-center" style="margin-top: 4px">
                        <input type="text" name="amount" placeholder="0.00" required>
                        <span>USDT</span>
                        <button class="max-button" type="button">Max</button>
                    </div>
                </div>
            </form>
                <div class="" style="padding:0 15px">
                    <span div>Available                                            <span class="main_balance">0.000 USDT</span>
                        <span class="asset_balance" style="display: none">1.000 USDT</span>
                                        </span>
                </div>
        </div>
    </div>
    <div class="transfer-footer d-row justify-space">
        <button type="submit" class="yl-btn" form="transfer-form">Confirm Transfer</button>
    </div>

    @include('user.components.footer')

    @include('user.common.script')

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
            $('#from_account').change(function() {
                var selectedValue = $(this).val();
                if (selectedValue == 'main') {
                    $('.main_balance').show();
                    $('.asset_balance').hide();
                } else {
                    $('.main_balance').hide();
                    $('.asset_balance').show();
                }
            });
            $('#to_account').change(function() {
                var selectedValue = $(this).val();
                if (selectedValue == 'main') {
                    $('.main_balance').show();
                    $('.asset_balance').hide();
                } else {
                    $('.main_balance').hide();
                    $('.asset_balance').show();
                }
            });


            $('.swap-btn').click(function() {
                var fromAccount = $('#from_account').val();
                var toAccount = $('#to_account').val();

                $('#from_account').val(toAccount);
                $('#to_account').val(fromAccount);

                $('#from_account').change();
                $('#to_account').change();

                var fromBalance = $('.' + fromAccount + '_balance');
                var toBalance = $('.' + toAccount + '_balance');
                fromBalance.toggle();
                toBalance.toggle();

                $('.amount-class input').val('');
                $('.amount-class input').focus();
            });

            //max button
            $('.max-button').click(function() {
                var fromAccount = $('#from_account').val();
                var accMode = "1";
                if(accMode == '1'){
                    var maxAmount = fromAccount == 'main' ? '0' :
                    '1';
                }else{
                    var maxAmount = fromAccount == 'main' ? '10000' :
                    '0';
                }

                $(this).siblings('input').val(maxAmount);
            });
        });
        $(document).on('submit', '#transfer-form', function(e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            var data = form.serialize();

            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                success: function(response) {
                    if (response.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message,
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred. Please try again.',
                    });
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
