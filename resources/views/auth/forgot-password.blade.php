<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Soria10</title>
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

        .forgot-password-card-container {
            background: #1e2329;
            border-radius: 8px;
            border: 1px solid #2b3139;
            padding: 30px 35px;
            width: 100%;
            max-width: 450px;
            /* Consistent width, can adjust if needed */
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
            position: relative;
            /* text-align: center; Centering is handled by .form-header for its content */
        }

        .forgot-password-card-container::before {
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

        .form-header {
            /* Consistent header for logo, title, subtitle */
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 25px;
        }

        .form-header img.form-logo {
            /* Added class for consistency */
            width: 65%;
            /* Can be a percentage of the container */
            max-width: 180px;
            /* Or a fixed max for better control */
            height: auto;
            margin-bottom: 15px;
        }

        .form-header h4 {
            color: #f0b90b;
            font-size: 1.6em;
            font-weight: 600;
            text-align: center;
            margin-bottom: 8px;
        }

        .form-header h4 i {
            margin-right: 8px;
        }

        .form-header .subtitle {
            font-size: 0.95em;
            font-weight: 500;
            color: #c1c8d1;
            text-align: center;
            line-height: 1.4;
        }

        fieldset {
            border: none;
            padding: 0;
            margin-bottom: 20px;
        }

        /* label.label-ip can be styled if visible text is used */

        .box-input input[type="email"] {
            /* Specific to email, or use a general class */
            width: 100%;
            padding: 12px 15px;
            background: #0b0e11;
            border: 1px solid #2b3139;
            border-radius: 4px;
            color: #eaecef;
            font-size: 1em;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .box-input input[type="email"]:focus {
            outline: none;
            border-color: #f0b90b;
            box-shadow: 0 0 0 3px rgba(240, 185, 11, 0.25);
        }

        .box-input input::placeholder {
            color: #565f6b;
        }

        button.tf-btn {
            /* Submit button */
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
            margin-top: 5px;
            /* Reduced margin from fieldset to button */
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

        .signin-link-container {
            /* "Remember password?" link section */
            margin-top: 25px;
            text-align: center;
            font-size: 0.9em;
            color: #848e9c;
        }

        .signin-link-container a {
            color: #f0b90b;
            font-weight: 600;
            text-decoration: none;
        }

        .signin-link-container a:hover {
            text-decoration: underline;
        }

        /* Responsive design */
        @media (max-width: 480px) {
            .forgot-password-card-container {
                padding: 25px 20px;
            }

            .form-header img.form-logo {
                max-width: 150px;
                /* Adjust for smaller screens */
            }

            .form-header h4 {
                font-size: 1.4em;
            }

            .form-header .subtitle {
                font-size: 0.9em;
            }

            .box-input input[type="email"] {
                padding: 10px 12px;
            }

            button.tf-btn {
                padding: 10px 12px;
            }

            .signin-link-container {
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



    <div class="forgot-password-card-container">



        <form action="{{ route('password.email') }}" method="POST">
            <div class="form-header">
                @csrf
                <img src="{{ asset('images/logo/logo.png') }}" alt="TradePro Logo" class="form-logo">
                <h4><i class="fas fa-lock-open"></i> Reset Password</h4>
                <span class="subtitle">Enter your email address to receive a reset code.</span>
            </div>

            @include('user.common.alert')

            <fieldset>
                <label class="label-ip" for="email" style="display:none;">Email</label>
                <div class="box-input">
                    <input id="email" class="w-100" type="email" placeholder="Enter your email" name="email"
                        value="{{ old('email') }}" required> {{-- value attribute for Laravel old input --}}
                </div>
            </fieldset>

            <button class="tf-btn lg yl-btn" type="submit">
                <i class="fas fa-paper-plane"></i> Send Reset Code
            </button>

            <p class="signin-link-container">
                Remember your password?
                <a href="{{ route('login') }}">Sign In</a>
            </p>
        </form>
    </div>

    <script>
        // No specific JavaScript needed for this page's core functionality if using HTML5 validation.
        // Example for more complex client-side validation if needed:
        /*
        document.addEventListener('DOMContentLoaded', function () {
            const forgotPasswordForm = document.querySelector('.forgot-password-card-container form');
            if (forgotPasswordForm) {
                forgotPasswordForm.addEventListener('submit', function(event) {
                    const emailInput = forgotPasswordForm.querySelector('input[name="email"]');
                    // A simple check for non-empty; HTML5 'required' handles this better.
                    // For more complex validation (e.g., email format), you might add JS.
                    if (!emailInput.value.includes('@')) { // Very basic email check
                        // alert('Please enter a valid email address.');
                        // event.preventDefault(); // Stop submission
                    }
                    // console.log('Forgot password form submitted for:', emailInput.value);
                });
            }
        });
        */
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
