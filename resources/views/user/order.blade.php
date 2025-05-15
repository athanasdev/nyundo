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
    <meta property="og:url" content="https://inexfx.com/orders">
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
    <div class="header fixed-top d-flex justify-content-center align-items-center" style="background: #1e2730;">
        <a href="#" class="left back-btn"><i class="iconsax back-icon-ct" icon-name="arrow-left"></i></a>
        <h3 style="font-size:16px!important;font-weight:600">My Trading Orders</h3>
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
                        style="column-gap: 20px;padding-bottom:0px;border-color:#7e808820">
                        <div class="swiper-slide1 nav-link active" data-bs-toggle="tab" data-bs-target="#active-orders"
                            style="width:fit-content;margin-left:10px" role="tab" aria-controls="active-orders"
                            aria-selected="true">
                            Completed Orders </div>
                        <div class="swiper-slide1 nav-link" data-bs-toggle="tab" data-bs-target="#all-orders"
                            role="tab" style="width:fit-content;margin-left:10px" aria-controls="all-orders"
                            aria-selected="false">
                            Active Orders </div>
                    </div>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="active-orders" role="tabpanel" style="padding-top: 10px">
                        <div class="tf-tab">
                            <div>
                                <div
                                    style="height:80vh;display:flex;flex-direction:column;justify-content:center;align-items:center;width:100%">
                                    <img src="https://inexfx.com/images/empty.png" style="height: 100px;width:100px"
                                        alt="">
                                    <span>No Order Yet!</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="all-orders" role="tabpanel" style="padding-top: 10px">
                        <div class="ongoing-order-area">


                        </div>
                    </div>
                </div>
            </div>
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
        function getOngoingOrders() {
            $.ajax({
                url: "https://inexfx.com/ongoing-orders",
                data: {
                    'exchange_id': 'all'
                },
                method: "GET",
                success: function(response) {
                    if (response.status == 'success') {
                        $('.ongoing-order-area').html(response.data);
                        document.querySelectorAll('.progress-circle').forEach(circle => {
                            const percent = circle.getAttribute('data-percentage');
                            const angle = percent * 3.6;
                            circle.style.setProperty('--percent', percent);
                            circle.style.setProperty('--angle', `${angle}deg`);
                            circle.querySelector('.percentage').textContent = `${percent}%`;
                        });
                        orderProgress();
                    }
                },
                error: function(xhr) {
                    console.error(xhr);
                }
            });
        }

        getOngoingOrders();

        function orderProgress() {
            //select all order-card which data-remaining-time is greater than 0
            var orderCards = document.querySelectorAll('.order-card');
            orderCards.forEach(function(card) {
                var remainingTime = card.getAttribute('data-remaining-time');
                var totalOrderTime = card.getAttribute('data-total-time');

                var progressCircle = card.querySelector('.progress-circle');
                var percentage = card.querySelector('.percentage');
                var progressBar = card.querySelector('.progress-bar');

                if (remainingTime > 0) {
                    var interval = setInterval(function() {
                        remainingTime--;
                        var percent = Math.floor(100 - (remainingTime / totalOrderTime) * 100);
                        progressCircle.style.setProperty('--percent', percent);
                        progressCircle.style.setProperty('--angle', `${percent * 3.6}deg`);
                        percentage.textContent = `${percent}%`;
                        progressBar.style.width = `${percent}%`;

                        if (remainingTime <= 0) {
                            clearInterval(interval);
                            card.remove();
                        }
                    }, 1000);
                }
            });
        }
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
