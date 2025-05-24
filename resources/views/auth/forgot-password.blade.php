<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Charset and Viewport -->
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover">

    <!-- Basic SEO -->
    <title>INEX Trading | Forgot Your Password?</title>
    <meta name="description"
        content="Reset your INEX Trading password. Enter your email to receive a password reset link and regain access to your account.">
    <meta name="keywords"
        content="INEX Trading, forgot password, reset password, trading account recovery, password help">
    <meta name="author" content="INEX Trading">

    <!-- Browser Compatibility -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Theme Color -->
    <meta name="theme-color" content="#0a0a0a">

    <!-- Open Graph -->
    <meta property="og:title" content="INEX Trading | Forgot Your Password?">
    <meta property="og:description"
        content="Reset your password securely and regain access to your INEX Trading account.">
    <meta property="og:image" content="https://inexfx.com/favic.png">
    <meta property="og:url" content="https://inexfx.com/forget-password">
    <meta property="og:type" content="website">

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="INEX Trading | Password Reset">
    <meta name="twitter:description"
        content="Trouble signing in? Reset your INEX Trading password quickly and securely.">
    <meta name="twitter:image" content="https://inexfx.com/favic.png">

    <!-- Favicon and Icons -->
    <link rel="shortcut icon" href="https://inexfx.com/favic.png" />
    <link rel="apple-touch-icon-precomposed" href="https://inexfx.com/favic.png" />

    <!-- Stylesheets -->
    <link rel="stylesheet" href="https://inexfx.com/fonts/fonts.css">
    <link rel="stylesheet" href="https://inexfx.com/fonts/font-icons.css">
    <link rel="stylesheet" href="https://inexfx.com/css/bootstrap.min.css">
     <link rel="stylesheet" type="text/css" href="{{ asset('client/css/styles.css') }}" />
    <link href="https://iconsax.gitlab.io/i/icons.css" rel="stylesheet">
    <style>
        .box-input {
            display: flex;
            flex-direction: row;
            align-items: center;
            background: #29313c;
            padding: 0 0 0 15px;
            border-radius: 8px;
        }

        .box-input i {
            color: #ffffff;
            font-size: 20px;
            /* margin-right: 10px; */
        }

        .box-input input,
        .box-input select {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: none;
            font-size: 14px;
            background: #29313c;
        }

        ::-webkit-input-placeholder {
            font-size: 14px !important;
        }

        input:-webkit-autofill {
            -webkit-box-shadow: 0 0 0 1000px #29313c inset !important;
            -webkit-text-fill-color: #fff !important;
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>
</head>

<body>
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

    <div class="header fixed-top bg-surface">
        <a href="#" class="left back-btn"><i class="iconsax back-icon-ct" icon-name="arrow-left"></i></a>
    </div>
    <div class="pt-45">
        <div class="tf-container">
            <form action="{{ route('password.email') }}" class="mt-32 mb-16" method="POST">
                @csrf
                <div style="display: flex;align-items:center;flex-direction:column">
                    <img src="https://inexfx.com/images/logo/logo.png" style="width:75%" alt="">
                    <h4 class="text-center">Reset Password</h4>
                    <span style="font-size: 16px;font-weight:600;margin:6px 0 20px 0">Enter your email address to
                        continue</span>
                </div>


                <fieldset class="mt-16">
                    <label class="label-ip">
                        <div class="box-input">
                            <i class="iconsax" icon-name="mail"></i>
                            <input class="w-100" type="text" value="" placeholder="Enter your email"
                                name="email" value="">
                        </div>
                    </label>
                </fieldset>
                <button class="mt-40 tf-btn lg yl-btn" type="submit">Send Reset Code</button>
                <p class="mt-20 text-center text-small">Remember your password?<a href="/login"
                        style="font-weight:600;color:#0f3cf2;font-size:14px!important"> Sign In</a></p>
            </form>

        </div>
    </div>
    <script type="text/javascript" src="https://inexfx.com/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://inexfx.com/js/jquery.min.js"></script>
    <script type="text/javascript" src="https://inexfx.com/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.19.1/dist/sweetalert2.all.min.js"></script>
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
    </script>



    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonText: 'OK',
                confirmButtonColor: '#00bfff'
            });
        </script>
    @endif

</body>

</html>
