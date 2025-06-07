
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Soria10</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: #0b0e11;
            color: #eaecef;
            min-height: 100vh;
            font-size: 14px;
            line-height: 1.5;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-card-container {
            background: #1e2329;
            border-radius: 8px;
            border: 1px solid #2b3139;
            padding: 30px 35px;
            width: 100%;
            max-width: 420px;
            /* Login card can be a bit narrower than signup */
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
            position: relative;
            /* text-align: center; No longer needed here if header handles it */
        }

        .login-card-container::before {
            /* Accent border top */
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: #f0b90b;
            border-radius: 8px 8px 0 0;
        }

        /* New header style for Login, similar to Register page's .signup-header */
        .login-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 25px;
            /* Space before form fields */
        }

        .login-header .form-logo {
            /* Class for logo inside the form header */
            max-width: 60%;
            /* Adjust as needed, slightly less than signup potentially */
            height: auto;
            margin-bottom: 15px;
        }

        .login-header h2 {
            /* Title inside the login-header */
            color: #f0b90b;
            /* margin-bottom: 25px; This margin is now on .login-header */
            font-size: 1.8em;
            /* Kept from original login title */
            font-weight: 600;
            text-align: center;
        }

        .login-header h2 i {
            margin-right: 8px;
        }

        fieldset {
            /* fieldset is used in login, form-group in signup */
            border: none;
            padding: 0;
            margin-bottom: 18px;
        }

        fieldset.mb-12 {
            margin-bottom: 12px !important;
        }

        label.label-ip {
            /* Not used with visible text in login, but kept for structure */
            display: block;
        }

        .box-input {
            position: relative;
        }

        .box-input input[type="text"],
        .box-input input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            background: #0b0e11;
            border: 1px solid #2b3139;
            border-radius: 4px;
            color: #eaecef;
            font-size: 1em;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .box-auth-pass input[type="password"] {
            padding-right: 40px;
        }

        .box-input input[type="text"]:focus,
        .box-input input[type="password"]:focus {
            outline: none;
            border-color: #f0b90b;
            box-shadow: 0 0 0 3px rgba(240, 185, 11, 0.25);
        }

        .box-input input::placeholder {
            color: #565f6b;
        }

        .box-auth-pass {
            position: relative;
        }

        .show-pass {
            /* Class for password toggle on login page */
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #848e9c;
            font-size: 1.1em;
        }

        .show-pass:hover {
            color: #f0b90b;
        }

        .show-pass .icon-view-hide {
            /* Initially hide the "hide" icon */
            display: none;
        }

        .forgot-password-container {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 25px;
            margin-top: 5px;
        }

        .forgot-password-container a {
            color: #848e9c;
            text-decoration: none;
            font-size: 0.9em;
            transition: color 0.2s;
        }

        .forgot-password-container a:hover {
            color: #f0b90b;
            text-decoration: underline;
        }

        button.tf-btn {
            /* Login button */
            width: 100%;
            padding: 12px 15px;
            background: #f0b90b;
            color: #1e2329;
            border: none;
            border-radius: 4px;
            font-size: 1em;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.1s;
            margin-top: 0;
        }

        button.tf-btn:hover {
            background: #d8a40a;
        }

        button.tf-btn:active {
            transform: scale(0.98);
        }

        button.tf-btn i {
            margin-right: 8px;
        }

        .signup-link-container {
            /* "Don't have an account?" link section */
            margin-top: 25px;
            text-align: center;
            font-size: 0.9em;
            color: #848e9c;
        }

        .signup-link-container a {
            color: #f0b90b;
            font-weight: 600;
            text-decoration: none;
        }

        .signup-link-container a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .login-header .form-logo {
                max-width: 50%;
                /* Adjust logo size for small screens */
            }

            .login-header h2 {
                font-size: 1.6em;
            }

            .login-card-container {
                padding: 25px 20px;
            }

            .box-input input[type="text"],
            .box-input input[type="password"] {
                padding: 10px 12px;
            }

            .box-auth-pass input[type="password"] {
                padding-right: 35px;
            }

            .show-pass {
                right: 10px;
            }

            button.tf-btn {
                padding: 10px 12px;
            }

            .forgot-password-container,
            .signup-link-container {
                font-size: 0.85em;
            }

            .alert-error {
                color: #f6465d;
                background-color: rgba(246, 70, 93, 0.1);
                border: 1px solid rgba(246, 70, 93, 0.3);
            }

            .alert-error ul {
                list-style-position: inside;
                padding-left: 5px;
                margin-bottom: 0;
            }

            .alert-error li {
                margin-bottom: 5px;
            }

            .alert-error li:last-child {
                margin-bottom: 0;
            }

            .alert-success {
                color: #0ecb81;
                background-color: rgba(14, 203, 129, 0.1);
                border: 1px solid rgba(14, 203, 129, 0.3);
            }


        }
    </style>
</head>

<body>



    <div class="login-card-container">
        <form action="{{ route('user.login') }}" method="POST">
            <div class="login-header">
                @csrf
                <img src="{{ asset('images/logo/logo.png') }}" alt="TradePro Logo" class="form-logo">
                <h2><i class="fas fa-sign-in-alt"></i> Sign In</h2>


            </div>
            @include('user.common.alert')

            <fieldset>
                <div class="box-input">
                    <input type="text" name="username" placeholder="Username" required tabindex="-1">
                </div>
            </fieldset>

            <fieldset class="mb-12">
                <div class="box-input">
                    <div class="box-auth-pass">
                        <input type="password" name="password" required placeholder="Password" class="password-field"
                            id="loginPassword" tabindex="-1">
                        <span class="show-pass" data-target="loginPassword">
                            <i class="fas fa-eye icon-view"></i>
                            <i class="fas fa-eye-slash icon-view-hide"></i>
                        </span>
                    </div>
                </div>
            </fieldset>

            <div class="forgot-password-container">
                <a href="{{ route('password.request') }}">Forgot Password?</a>
            </div>

            <button class="tf-btn lg yl-btn" type="submit">
                <i class="fas fa-paper-plane"></i> Login
            </button>

            <p class="signup-link-container">
                I don’t have an account?
                <a href="{{ route('register') }}">Sign Up</a>
            </p>
        </form>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordToggles = document.querySelectorAll('.show-pass');

            passwordToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const targetInputId = this.getAttribute('data-target');
                    const targetInput = document.getElementById(targetInputId);
                    const iconView = this.querySelector('.icon-view');
                    const iconViewHide = this.querySelector('.icon-view-hide');

                    if (targetInput.type === 'password') {
                        targetInput.type = 'text';
                        iconView.style.display = 'none';
                        iconViewHide.style.display = 'inline';
                    } else {
                        targetInput.type = 'password';
                        iconView.style.display = 'inline';
                        iconViewHide.style.display = 'none';
                    }
                });
            });

            // Optional: Basic form submission handler (for demonstration or simple client validation)
            const loginForm = document.querySelector('.login-card-container form');
            if (loginForm) {
                loginForm.addEventListener('submit', function(event) {
                    // const username = loginForm.querySelector('input[name="username"]').value;
                    // if (!username) {
                    //     // alert('Please enter your username.');
                    //     // event.preventDefault(); // Stop submission if needed
                    // }
                    // console.log('Login attempt...');
                });
            }
        });
    </script>
    <script>
        // Function to format currency
        const formatCurrency = (value, minDigits = 2, maxDigits = 2) =>
            `$${Number(value).toLocaleString('en-US', { minimumFractionDigits: minDigits, maximumFractionDigits: maxDigits })}`;

        // Function to format percentage
        const formatPercentage = (value) => `${Number(value) >= 0 ? '+' : ''}${Number(value).toFixed(2)}%`;

        // Function to update the global header display
        function updateGlobalHeaderDisplay(totalBalance, pnlToday) {
            const userBalanceEl = document.getElementById('userBalanceDisplay');
            if (userBalanceEl) {
                userBalanceEl.textContent = formatCurrency(totalBalance);
                userBalanceEl.className = `balance-amount ${Number(totalBalance) >= 0 ? 'positive' : 'negative'}`;
            }
        }

        // Prevent Ctrl key combinations (like Ctrl + C, Ctrl + V, Ctrl + X, etc.)
        document.addEventListener('keydown', function(e) {
            // Check if Ctrl key (or Command key on Mac) is pressed
            if (e.ctrlKey || e.metaKey) {
                // Prevent common Ctrl key combinations
                if (['c', 'v', 'x', 'a', 'z'].includes(e.key.toLowerCase())) {
                    e.preventDefault(); // Prevent the default action (e.g., copying, pasting)
                    // alert(`The '${e.key.toUpperCase()}' shortcut is disabled for security reasons.`);
                }
            }
        });

        // Add event listeners for Deposit/Withdraw buttons if they trigger modals/JS actions

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

</body>

</html>
