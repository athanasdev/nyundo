<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Charset and Viewport -->
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover">

    <!-- Basic SEO -->
    <title>Nyundo | Login to your account</title>
    <meta name="description"
        content="Login to your Nyundo    account to manage your investments, view trading history, and more.">
    <meta name="keywords" content="Nyundo   , trading platform, user login, investments, finance">
    <meta name="author" content="Nyundo   ">

    <!-- Browser Compatibility -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Theme Color for Mobile Browsers -->
    <meta name="theme-color" content="#0a0a0a">

    <!-- Open Graph (Facebook, LinkedIn, etc.) -->
    <meta property="og:title" content="Nyundo    | Login to your account">
    <meta property="og:description" content="Secure login to your Nyundo    account.">
    <meta property="og:image" content="https://inexfx.com/favic.png">
    <meta property="og:url" content="https://inexfx.com/login">
    <meta property="og:type" content="website">

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Nyundo    | Login">
    <meta name="twitter:description" content="Access your Nyundo    account securely.">
    <meta name="twitter:image" content="https://inexfx.com/favic.png">

    <!-- Favicon and Icons -->
    <link rel="shortcut icon" href="https://inexfx.com/favic.png" />
    <link rel="apple-touch-icon-precomposed" href="https://inexfx.com/favic.png" />

    <!-- Stylesheets -->
    <link rel="stylesheet" type="text/css" href="{{ asset('client/css/styles.css') }}" />
    <link rel="stylesheet" href="https://inexfx.com/fonts/fonts.css">
    <link rel="stylesheet" href="https://inexfx.com/fonts/font-icons.css">
    <link rel="stylesheet" href="https://inexfx.com/css/bootstrap.min.css">
    < <link href="https://iconsax.gitlab.io/i/icons.css" rel="stylesheet">
</head>

<body>
    <style>
        /* Teal-themed UI colors for box input and language selector */
        .box-input {
            background: #005f5f;
            /* Dark teal background */
        }

        .lang-selector {
            background: #007373;
            /* Medium teal background */
        }

        /* Keep input default look, only change focus appearance */
        input:focus,
        .search-field:focus {
            outline: none !important;
            border: 1px solid #008080 !important;
            /* Teal border */
            box-shadow: 0 0 0 2px rgba(0, 128, 128, 0.4) !important;
            background-color: #fff;
            /* Ensure input doesn't darken */
            color: #000;
            /* Text remains black */
        }

        /* Optional autofill background fix for Chrome */
        input:-webkit-autofill {
            -webkit-box-shadow: 0 0 0 1000px white inset !important;
            -webkit-text-fill-color: #000 !important;
        }

        /* Optional: Customize button appearance */
        .tf-btn.lg.yl-btn {
            background-color: #008080;
            color: #ffffff;
            border: none;
            transition: background-color 0.3s ease;
        }

        .tf-btn.lg.yl-btn:hover {
            background-color: #006666;
        }
    </style>

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

    <div class="pt-45 pb-20">
        <div class="tf-container" style="margin-left:6%; margin-right:6%">
            <div class="mt-32" style="display: flex;align-items:center;flex-direction:column">
                <img src="{{ asset('images/logo/logo.png') }}" style="width:75%" alt="Logo">
                <h4 class="text-center" style="margin-top: 50px">Login</h4>
            </div>

            <div class="section mt-2 mb-2">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
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

            <form action="{{ route('login') }}" class="mt-16" method="POST">
                @csrf
                <fieldset class="mt-16">
                    <label class="label-ip">
                        <div class="box-input">
                            <i class="iconsax" icon-name="user-2"></i>
                            <input type="text" name="username" placeholder="Username" required>
                        </div>
                    </label>
                </fieldset>

                <fieldset class="mt-16 mb-12">
                    <label class="label-ip">
                        <div class="box-input">
                            <i class="iconsax" icon-name="unlock"></i>
                            <div class="box-auth-pass">
                                <input type="password" name="password" required placeholder="Password"
                                    class="password-field">
                                <span class="show-pass">
                                    <i class="icon-view"></i>
                                    <i class="icon-view-hide"></i>
                                </span>
                            </div>
                        </div>
                    </label>
                </fieldset>


                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 60px">
                    <div>
                        <a href="{{ route('password.request') }}" style="font-size:14px">Forgot Password?</a>
                    </div>
                </div>

                <button class="mt-20 tf-btn lg yl-btn" type="submit">LOGIN</button>

                <p class="mt-20 text-center text-small" style="font-size:14px">
                    I don’t have an account?
                    <a href="{{ route('home') }}" style="font-weight:600;color:#090703;font-size:14px!important">Sign
                        Up</a>
                </p>
            </form>


        </div>
        <div class="modal fade modalRight" id="notification">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="header fixed-top bg-surface d-flex justify-content-center align-items-center">
                        <span class="left" data-bs-dismiss="modal" aria-hidden="true"><i
                                class="icon-left-btn"></i></span>
                        <h3>Language</h3>
                    </div>
                    <div class="overflow-auto pt-45 pb-16">
                        <div class="tf-container">
                            <div class="search-field d-row align-center" style="column-gap: 6px">
                                <i class="iconsax" icon-name="search-normal-2"></i>
                                <input type="text" placeholder="Search">
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @include('user.common.script')

    <script src="//code.jivosite.com/widget/7CRJb72HNd" async></script>
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

    {{-- @if (session('status'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('status') }}',
                confirmButtonText: 'OK',
                confirmButtonColor: '#3085d6'
            });
        </script>
    @endif --}}

</body>

</html>
