<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Charset and Viewport -->
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover">

    <!-- Basic SEO -->
    <title>Cointrades | Signup</title>

    <!-- Browser Compatibility -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta property="og:description"
        content="Join Nyundo  and take control of your financial future. Register today to start trading.">

    <meta property="og:type" content="website">

    <!-- Stylesheets -->
    <link rel="shortcut icon" href="{{ asset('images/logo/favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="{{ asset('client/css/styles.css') }}" />
    <link rel="stylesheet" href=" /css/swiper-bundle.min.css">
    <link rel="stylesheet" href=" /css/countrySelect.css">
    <link href="https://iconsax.gitlab.io/i/icons.css" rel="stylesheet">

</head>

<body>
    <!-- preloade -->
    {{-- <div class="preloader preload-container">
        <div class="preload-logo " style="display: flex; flex-direction: column; align-items: center;">
            <div class="lds-ring" style="margin-bottom: 10px">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>

        </div>
    </div> --}}
    <!-- /preload -->


    <div class="pb-3 mt-10">
        <div class="tf-container" style="margin-left:6%; margin-right:6%">
            <form action="{{ route('register') }}" class="mt-32 mb-16" method="POST">
                @csrf
                <div style="display: flex;align-items:center;flex-direction:column">
                    <img src="{{ asset('images/logo/logo.png') }}" style="width:75%" alt="Logo">
                    <h4 class="text-center">Create account now</h4>
                </div>

                <fieldset class="mt-20">
                    <label class="label-ip">
                        <div class="box-input">
                            <input type="text" name="username" placeholder="Username" required>
                        </div>
                    </label>
                </fieldset>

                <fieldset class="mt-16">
                    <label class="label-ip">
                        <div class="box-input">
                            <input class="w-100" type="email" placeholder="Email" name="email" required>
                        </div>
                    </label>
                </fieldset>

                {{-- <fieldset class="mt-16">
                    <label class="label-ip">
                        <div class="box-input">
                            <select name="currency" class="w-100" required>
                                <option disabled selected>Choose currency</option>
                                <option value="usdttrc20" selected>TRC-20(USDT)</option>
                            </select>
                        </div>
                    </label>
                </fieldset> --}}

                <fieldset class="mt-16" style="display: none;"> <label class="label-ip">
                        <div class="box-input">
                            <select name="currency" class="w-100" required>
                                <option disabled selected>Choose currency</option>
                                <option value="usdttrc20" selected>TRC-20(USDT)</option>
                            </select>
                        </div>
                    </label>
                </fieldset>

                <fieldset class="mt-16">
                    <label class="label-ip">
                        <div class="box-input">
                            <input type="text" name="invitation_code" placeholder="Invitation Code"
                                value="{{ $ref ?? old('invitation_code') }}">
                        </div>
                    </label>
                </fieldset>

                <fieldset class="mt-16">
                    <label class="label-ip">
                        <div class="box-input">
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
                    <a href="{{ route('login') }}" style="font-weight:600;color:#634b02a1;font-size:14px!important">Sign
                        In</a>
                </p>
            </form>
        </div>

    </div>

    @include('user.common.script')

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
