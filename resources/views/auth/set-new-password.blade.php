<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Charset and Viewport -->
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover">

    <!-- Basic SEO -->
    <title>INEX Trading | Set a New Password</title>
    <meta name="description"
        content="Create a new secure password for your INEX Trading account to regain access and continue managing your investments.">
    <meta name="keywords" content="INEX Trading, set new password, update password, account security, password reset">
    <meta name="author" content="INEX Trading">

    <!-- Browser Compatibility -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Theme Color -->
    <meta name="theme-color" content="#0a0a0a">

    <!-- Open Graph -->
    <meta property="og:title" content="INEX Trading | Set a New Password">
    <meta property="og:description" content="Securely set a new password for your INEX Trading account.">
    <meta property="og:image" content="https://inexfx.com/favic.png">
    <meta property="og:url" content="https://inexfx.com/set-new-password">
    <meta property="og:type" content="website">

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="INEX Trading | New Password Setup">
    <meta name="twitter:description"
        content="You're almost there. Set your new password and regain secure access to your INEX Trading account.">
    <meta name="twitter:image" content="https://inexfx.com/favic.png">

    <!-- Favicon and Icons -->
    <link rel="shortcut icon" href="https://inexfx.com/favic.png" />
    <link rel="apple-touch-icon-precomposed" href="https://inexfx.com/favic.png" />

    <!-- Stylesheets -->
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
        }

        .box-input input,
        .box-input select {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: none;
            font-size: 14px;
            background: #29313c;
            color: #ffffff !important;
        }

        ::-webkit-input-placeholder {
            font-size: 14px !important;
        }
    </style>
</head>

<body>
    <script src="https://inexfx.com/vendor/sweetalert/sweetalert.all.js"></script>

            <script>
            document.addEventListener('click', function(event) {
                // Check if the clicked element or its parent has the attribute
                var target = event.target;
                var confirmDeleteElement = target.closest('[data-confirm-delete]');

                if (confirmDeleteElement) {
                    event.preventDefault();
                    Swal.fire().then(function(result) {
                        if (result.isConfirmed) {
                            var form = document.createElement('form');
                            form.action = confirmDeleteElement.href;
                            form.method = 'POST';
                            form.innerHTML = `
                            <input type="hidden" name="_token" value="CsCtlXnLEo0CFqyLvz4h9rdjTxbfd6y7sTgxFzjC" autocomplete="off">                            <input type="hidden" name="_method" value="DELETE">                        `;
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                }
            });

                            Swal.fire({"title":"Success","text":"Verification Code Sent","background":"#fff","width":"32rem","heightAuto":true,"padding":"1.25rem","showConfirmButton":true,"showCloseButton":false,"confirmButtonText":"Ok","cancelButtonText":"Close","timerProgressBar":false,"customClass":{"container":null,"popup":null,"header":null,"title":null,"closeButton":null,"icon":null,"image":null,"content":null,"input":null,"actions":null,"confirmButton":null,"cancelButton":null,"footer":null},"icon":"success","confirmButtonColor":"#3085d6","allowOutsideClick":false,"showCancelButton":true,"cancelButtonColor":"#aaa"});
                    </script>
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
    <div class="">
        <div class="tf-container" style="margin-left:6%; margin-right:6%">
            <form action="{{ route('password.update') }}" class="mt-32 mb-16" method="POST">
                @csrf                <div style="display: flex;align-items:center;flex-direction:column">
                    <img src="https://inexfx.com/images/logo/logo.png" style="width:75%" alt="">
                    <h4 class="text-center">Reset Password</h4>
                    <span style="font-size: 16px;font-weight:600;margin:6px 0 20px 0">Create a New Password</span>
                </div>
                <fieldset class="mt-20 mb-16">
                    <p class="mb-1 text-small">Email Address</p>
                    <div class="box-input" style="padding: 6px 6px 6px 10px">
                        <i class="iconsax" icon-name="mail"></i>
                        <input placeholder="Email Address" name="email"
                            value="mussa@gmail.com" readonly>
                    </div>
                    <!--</div>-->
                </fieldset>
                <fieldset class="mb-16">
                    <p class="mb-1 text-small">Verification Code</p>
                    <div class="box-input">
                        <i class="iconsax" icon-name="password-check"></i>
                        <input type="text" placeholder="Verification code" name="verification_code"
                            value="">
                    </div>
                </fieldset>
                <fieldset class="mb-16">

                    <p class="mb-1 text-small">New Password</p>
                    <div class="box-input">
                        <i class="iconsax" icon-name="key"></i>
                        <div class="box-auth-pass">
                            <input type="password" required placeholder="New Password" class="password-field"
                                name="password" style="" value="">
                            <span class="show-pass" style="">
                                <i class="icon-view"></i>
                                <i class="icon-view-hide"></i>
                            </span>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="mb-16">
                    <p class="mb-1 text-small">Repeat Your Password</p>
                    <div class="box-input">
                        <i class="iconsax" icon-name="key"></i>
                        <div class="box-auth-pass">
                            <input type="password" required placeholder="Repeat Your Password"
                                class="password-field2" name="repeat_password" style=""
                                value="">
                            <span class="show-pass2" style="">
                                <i class="icon-view"></i>
                                <i class="icon-view-hide"></i>
                            </span>
                        </div>
                    </div>
                </fieldset>

                <button class="mt-40 tf-btn lg yl-btn" type="submit">Save New Password</button>
                <p class="mt-20 text-center text-small">I Didn’t Receive the Code? <a
                        href="{{route('password.request')}}"
                        style="font-weight:600;color:#f2b90f;font-size:14px!important">Resend Again</a></p>
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

</body>

</html>
