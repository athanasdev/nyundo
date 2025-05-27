<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Charset and Viewport -->
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover">

    <!-- Basic SEO -->
    <title>Forgot Your Password?</title>

    <!-- Browser Compatibility -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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


    <div class="pt-45">
        <div class="tf-container">
            <form action="{{ route('password.email') }}" class="mt-32 mb-16" method="POST">
                @csrf
                <div style="display: flex;align-items:center;flex-direction:column">
                    <img src="{{ asset('images/logo/logo.png') }}" style="width:75%" alt="Logo">

                    <h4 class="text-center">Reset Password</h4>
                    <span style="font-size: 16px;font-weight:600;margin:6px 0 20px 0">Enter your email address to
                        continue</span>
                </div>


                <fieldset class="mt-16">
                    <label class="label-ip">
                        <div class="box-input">

                            <input class="w-100" type="text" value="" placeholder="Enter your email"
                                name="email" value="">
                        </div>
                    </label>
                </fieldset>
                <button class="mt-40 tf-btn lg yl-btn" type="submit">Send Reset Code</button>
                <p class="mt-20 text-center text-small">Remember your password?<a href="/login"
                        style="font-weight:600;color:#69633c;font-size:14px!important"> Sign In</a></p>
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
                confirmButtonColor: '#00bfff'
            });
        </script>
    @endif

</body>

</html>
