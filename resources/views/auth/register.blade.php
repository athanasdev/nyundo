<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Charset and Viewport -->
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover">

    <!-- Basic SEO -->
    <title>Nyundo | Create Your Account</title>
    <meta name="description"
        content="Register for an Nyundo  account to access secure and powerful investment tools, real-time trading, and portfolio management.">
    <meta name="keywords" content="INEX Trading, create account, sign up, register, investment platform, trading account">
    <meta name="author" content="INEX Trading">

    <!-- Browser Compatibility -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Theme Color -->
    <meta name="theme-color" content="#0a0a0a">

    <!-- Open Graph -->
    <meta property="og:title" content="Nyundo  | Register Your Account">
    <meta property="og:description"
        content="Join Nyundo  and take control of your financial future. Register today to start trading.">
    <meta property="og:image" content="https://inexfx.com/favic.png">
    <meta property="og:url" content="https://inexfx.com/register">
    <meta property="og:type" content="website">

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Nyundo  | Sign Up Now">
    <meta name="twitter:description"
        content="Start your journey with INEX Trading. Create a free account and begin investing today.">
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
    </style>
</head>

<body>
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

    <div class="header fixed-top bg-surface">
        <a href="#" class="left back-btn"><i class="iconsax back-icon-ct" icon-name="arrow-left"></i></a>
    </div>
    <div class="pb-3">
        <div class="tf-container" style="margin-left:6%; margin-right:6%">
            <form action="{{ route('register') }}" class="mt-32 mb-16" method="POST">
                @csrf
                <div style="display: flex;align-items:center;flex-direction:column">
                    <img src="https://inexfx.com/images/logo/logo.png" style="width:75%" alt="">
                    <h4 class="text-center">Create account here</h4>
                    <span style="font-size: 16px;font-weight:600;margin:6px 0 10px 0">Fill all details correctly to
                        continue</span>
                </div>

                <fieldset class="mt-20">
                    <label class="label-ip">
                        <div class="box-input">
                            <i class="iconsax" icon-name="user-2"></i>
                            <input type="text" name="username" placeholder="Username" required>
                        </div>
                    </label>
                </fieldset>

                <fieldset class="mt-16">
                    <label class="label-ip">
                        <div class="box-input">
                            <i class="iconsax" icon-name="mail"></i>
                            <input class="w-100" type="email" placeholder="Email" name="email" required>
                        </div>
                    </label>
                </fieldset>

                <fieldset class="mt-16">
                    <label class="label-ip">
                        <div class="box-input">
                            <i class="iconsax" icon-name="card-coin"></i>
                            <select name="currency" class="w-100" required>
                                <option disabled selected>Choose currency</option>
                                <option value="usdttrc20" selected>USDT TRC-20</option>
                            </select>
                        </div>
                    </label>
                </fieldset>

                <fieldset class="mt-16">
                    <label class="label-ip">
                        <div class="box-input">
                            <i class="iconsax" icon-name="share"></i>
                            {{-- <input type="text" placeholder="Invitation Code" name="invitation_code"> --}}
                            <input type="text" name="invitation_code" placeholder="Invitation Code" value="{{ $ref ?? old('invitation_code') }}">

                        </div>
                    </label>
                </fieldset>

                <fieldset class="mt-16">
                    <label class="label-ip">
                        <div class="box-input">
                            <i class="iconsax" icon-name="lock-2"></i>
                            <div class="box-auth-pass">
                                <input type="password" required name="password" placeholder="8-20 characters"
                                    class="password-field">
                                <span class="show-pass">
                                    <i class="icon-view"></i>
                                    <i class="icon-view-hide"></i>
                                </span>
                            </div>
                        </div>
                    </label>
                </fieldset>

                <fieldset class="mt-16">
                    <label class="label-ip">
                        <div class="box-input">
                            <i class="iconsax" icon-name="lock-2"></i>
                            <div class="box-auth-pass">
                                <input type="password" required name="password_confirmation"
                                    placeholder="8-20 characters" class="password-field2">
                                <span class="show-pass2">
                                    <i class="icon-view"></i>
                                    <i class="icon-view-hide"></i>
                                </span>
                            </div>
                        </div>
                    </label>
                </fieldset>

                <fieldset class="group-cb cb-signup mt-12" style="padding: 10px">
                    <input type="checkbox" class="tf-checkbox" name="agree" value="1" id="cb-ip" checked
                        required>
                    <label for="cb-ip">I agree to the Terms and Conditions</label>
                </fieldset>

                <button class="mt-40 tf-btn lg yl-btn"
                    style="height: 46px!important;display:flex;align-items:center;justify-content:center"
                    type="submit">Create an Account</button>

                <p class="mt-20 text-center text-small">
                    Already have an account?&ensp;
                    <a href="{{ route('login') }}"
                        style="font-weight:600;color:#f2b90f;font-size:14px!important">Sign In</a>
                </p>
            </form>

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
</body>

</html>
