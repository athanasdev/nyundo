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
    <
    <link href="https://iconsax.gitlab.io/i/icons.css" rel="stylesheet">
</head>

<body>
    <style>
        .box-input {
            display: flex;
            flex-direction: row;
            align-items: center;
            background: #29313c;
            padding: 0 0 0 15px;
            border-radius: 8px;
        }

        input:-webkit-autofill {
            -webkit-box-shadow: 0 0 0 1000px #29313c inset !important;
            -webkit-text-fill-color: #fff !important;
            transition: background-color 5000s ease-in-out 0s;
        }

        .box-input i {
            color: #ffffff;
            font-size: 20px;
        }

        .box-input input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: none;
            font-size: 14px;
            background: transparent;
        }

        ::-webkit-input-placeholder {
            font-size: 14px !important;
        }

        .lang-selector {
            position: absolute;
            right: 20px;
            top: 20px;
            padding: 10px;
            background: #29313c;
            border-radius: 6px;
            display: flex;
            flex-direction: row;
            align-items: center;
            column-gap: 5px;
        }

        .lang-selector i {
            font-size: 20px;
        }

        .lang-selector span {
            font-size: 14px;
            font-weight: 600
        }

        .search-field {
            background: #29313c;
            padding: 10px;
            border-radius: 6px;
        }

        .search-field i {
            font-size: 20px;
        }

        .search-field input {
            background: transparent;
            padding: 0;
            border: none;
        }

        .languages-list {
            padding: 10px;
        }

        .language-class {
            margin: 15px 0;
        }

        .language-class span {
            font-size: 16px;
            font-weight: 500;
            color: #fff;
        }

        .language-class i {
            font-size: 20px;
            color: #fff;
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
            <h6>...</h6>
        </div>
    </div>
    <!-- /preload -->
    {{-- <div class="header fixed-top bg-surface">
        <a href="#" class="left back-btn"><i class="iconsax back-icon-ct" icon-name="arrow-left"></i></a>
    </div> --}}
    <div class="pt-45 pb-20">
        <div class="tf-container" style="margin-left:6%; margin-right:6%">
            <div class="mt-32" style="display: flex;align-items:center;flex-direction:column">
                <img src="https://inexfx.com/images/logo/logo.png" style="width:75%" alt="">
                <h4 class="text-center" style="margin-top: 50px">Login</h4>
            </div>

            <form action="{{ route('login')}}" class="mt-16" method="POST">
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
                        <a href="{{ route ('password.request') }}" style="font-size:14px">Forgot Password?</a>
                    </div>
                </div>

                <button class="mt-20 tf-btn lg yl-btn" type="submit">LOGIN</button>

                <p class="mt-20 text-center text-small" style="font-size:14px">
                    I don’t have an account?
                    <a href="{{ route('home') }}"
                        style="font-weight:600;color:#f2b90f;font-size:14px!important">Sign Up</a>
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

    @if(session('status'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('status') }}',
            confirmButtonText: 'OK',
            confirmButtonColor: '#3085d6'
        });
    </script>
@endif

</body>

</html>
