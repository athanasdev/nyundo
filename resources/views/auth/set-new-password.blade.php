<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Charset and Viewport -->
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover">


     <link rel="shortcut icon" href="{{ asset('images/logo/favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="{{ asset('client/css/styles.css') }}" />
    <link rel="stylesheet" href=" /css/swiper-bundle.min.css">
    <link rel="stylesheet" href=" /css/countrySelect.css">
    <link href="https://iconsax.gitlab.io/i/icons.css" rel="stylesheet">


</head>

<body>

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

    <div class="header fixed-top bg-surface">
        <a href="#" class="left back-btn">
            <i class="iconsax back-icon-ct" icon-name="arrow-left"></i></a>
    </div>
    <div class="">
        <div class="tf-container" style="margin-left:6%; margin-right:6%">
            <form action="{{ route('password.update') }}" class="mt-32 mb-16" method="POST">
                @csrf
                <div style="display: flex;align-items:center;flex-direction:column">
                    <img src="{{ asset('images/logo/logo.png') }}" style="width:75%" alt="Logo">

                    <h4 class="text-center">Reset Password</h4>
                    <span style="font-size: 16px;font-weight:600;margin:6px 0 20px 0">Create a New Password</span>
                </div>
                <fieldset class="mt-20 mb-16">
                    <p class="mb-1 text-small">Email Address</p>
                    <div class="box-input" style="padding: 6px 6px 6px 10px">

                        <input placeholder="Email Address" name="email">
                    </div>
                    <!--</div>-->
                </fieldset>
                <fieldset class="mb-16">
                    <p class="mb-1 text-small">Verification Code</p>
                    <div class="box-input">

                        <input type="text" placeholder="Verificationcode" name="code" required>
                    </div>
                </fieldset>
                <fieldset class="mb-16">
                    <p class="mb-1 text-small">New Password</p>
                    <div class="box-input">
                        <i class="iconsax" icon-name="key"></i>
                        <div class="box-auth-pass">
                            <input type="password" required placeholder="New Password" class="password-field"
                                name="password" style="">
                            <span class="show-pass" style="">
                                <i class="icon-view"></i>
                                <i class="icon-view-hide"></i>
                            </span>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="mb-16">
                    <p class="mb-1 text-small">Repeat new Password</p>
                    <div class="box-input">
                        <i class="iconsax" icon-name="key"></i>
                        <div class="box-auth-pass">
                            <input type="password" required placeholder="Repeat Your Password"
                                class="password-field2" name="password_confirmation">

                            <span class="show-pass2" style="">
                                <i class="icon-view"></i>
                                <i class="icon-view-hide"></i>
                            </span>
                        </div>
                    </div>
                </fieldset>

                <button class="mt-40 tf-btn lg yl-btn" type="submit">Save New Password</button>
                <p class="mt-20 text-center text-small">I Didn’t Receive the Code? <a
                        href="{{ route('password.request') }}"
                        style="font-weight:600;color:#0f31f2;font-size:14px!important">Resend Again</a></p>
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

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonText: 'OK',
                confirmButtonColor: '#'
            });
        </script>
    @endif

</body>

</html>
