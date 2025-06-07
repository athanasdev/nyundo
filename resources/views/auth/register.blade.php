
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Soria10</title>
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

        .signup-card-container {
            background: #1e2329;
            border-radius: 8px;
            border: 1px solid #2b3139;
            padding: 30px 35px;
            width: 100%;
            max-width: 480px;
            /* Slightly wider for more fields */
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
            position: relative;
        }

        .signup-card-container::before {
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

        .signup-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 25px;
        }

        .signup-header img {
            max-width: 65%;
            /* Control logo size */
            height: auto;
            margin-bottom: 15px;
        }

        .signup-header h4 {
            color: #f0b90b;
            font-size: 1.6em;
            /* Adjusted size */
            font-weight: 600;
            text-align: center;
        }

        .signup-header h4 i {
            margin-right: 8px;
        }

        .form-group {
            /* Replaces fieldset for styling */
            margin-bottom: 18px;
            /* Consistent spacing */
            text-align: left;
        }

        .form-group label.input-label {
            /* Explicit label text */
            display: block;
            color: #848e9c;
            font-size: 0.9em;
            font-weight: 500;
            margin-bottom: 6px;
        }

        /* Styling for the div that directly wraps the input */
        .box-input {
            position: relative;
            /* For password toggle positioning */
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="password"],
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            background: #0b0e11;
            border: 1px solid #2b3139;
            border-radius: 4px;
            color: #eaecef;
            font-size: 1em;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        /* Specific padding for password fields if icon is present */
        .box-auth-pass input[type="password"] {
            padding-right: 40px;
        }


        .form-group input[type="text"]:focus,
        .form-group input[type="email"]:focus,
        .form-group input[type="password"]:focus,
        .form-group select:focus {
            outline: none;
            border-color: #f0b90b;
            box-shadow: 0 0 0 3px rgba(240, 185, 11, 0.25);
        }

        .form-group input::placeholder,
        .form-group select {
            /* For "Choose currency" */
            color: #565f6b;
        }

        .form-group select option {
            background: #1e2329;
            color: #eaecef;
        }


        /* Password visibility toggle */
        .box-auth-pass {
            position: relative;
        }

        .show-pass-toggle {
            /* Replaces .show-pass and .show-pass2 */
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #848e9c;
            font-size: 1.1em;
        }

        .show-pass-toggle:hover {
            color: #f0b90b;
        }


        /* Checkbox styling */
        .terms-group {
            /* Replaces .group-cb */
            display: flex;
            align-items: center;
            margin-top: 12px;
            /* from mt-12 */
            padding: 10px 0;
            /* from style="padding: 10px" - adjusted to remove side padding */
        }

        .terms-group input[type="checkbox"].tf-checkbox {
            appearance: none;
            -webkit-appearance: none;
            width: 18px;
            height: 18px;
            background-color: #0b0e11;
            border: 1px solid #2b3139;
            border-radius: 3px;
            cursor: pointer;
            margin-right: 10px;
            position: relative;
            flex-shrink: 0;
            /* Prevent shrinking */
        }

        .terms-group input[type="checkbox"].tf-checkbox:checked {
            background-color: #f0b90b;
            border-color: #f0b90b;
        }

        .terms-group input[type="checkbox"].tf-checkbox:checked::before {
            content: '\f00c';
            /* Font Awesome check icon */
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            font-size: 12px;
            color: #1e2329;
            /* Dark check for contrast on yellow */
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .terms-group label[for="cb-ip"] {
            /* Style for the "I agree..." label */
            color: #c1c8d1;
            font-size: 0.9em;
            cursor: pointer;
            line-height: 1.3;
        }

        .terms-group label[for="cb-ip"] a {
            color: #f0b90b;
            text-decoration: none;
        }

        .terms-group label[for="cb-ip"] a:hover {
            text-decoration: underline;
        }


        .signup-button {
            /* Replaces .tf-btn.lg.yl-btn */
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
            margin-top: 25px;
            /* from mt-40, adjusted */
            height: 46px;
            /* from style */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .signup-button:hover {
            background: #d8a40a;
        }

        .signup-button:active {
            transform: scale(0.98);
        }

        .signup-button i {
            margin-right: 8px;
        }


        .login-link-container {
            /* Replaces p.mt-20.text-center.text-small */
            margin-top: 20px;
            /* from mt-20 */
            text-align: center;
            font-size: 0.9em;
            /* from text-small */
            color: #848e9c;
        }

        .login-link-container a {
            color: #f0b90b;
            /* from style */
            font-weight: 600;
            /* from style */
            text-decoration: none;
            font-size: 1em;
            /* to inherit from parent or be 14px effectively */
        }

        .login-link-container a:hover {
            text-decoration: underline;
        }


        /* Utility for margins (approximating mt- classes if needed elsewhere) */
        .mt-12 {
            margin-top: 12px;
        }

        .mt-16 {
            margin-top: 16px;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .mt-32 {
            margin-top: 32px;
        }

        .mt-40 {
            margin-top: 40px;
        }

        .mb-16 {
            margin-bottom: 16px;
        }


        /* Responsive design */
        @media (max-width: 480px) {
            .signup-card-container {
                padding: 25px 20px;
            }

            .signup-header h4 {
                font-size: 1.4em;
            }

            .form-group input,
            .form-group select {
                padding: 10px 12px;
            }

            .box-auth-pass input[type="password"] {
                padding-right: 35px;
            }

            .show-pass-toggle {
                right: 10px;
            }

            .signup-button {
                padding: 10px 12px;
            }

            .terms-group label[for="cb-ip"] {
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

    <div class="signup-card-container">
        <form action="{{ route('user.register') }}" method="POST"> @csrf
            <div class="signup-header">
                <img src="{{ asset('images/logo/logo.png') }}" alt="cointradesLogo">
                <h4><i class="fas fa-user-plus"></i> Create Your Account</h4>
            </div>

            @include('user.common.alert')

            <div class="form-group">
                <label class="input-label" for="username">Username</label>
                <div class="box-input">
                    <input type="text" id="username" name="username" placeholder="Choose a unique username"
                        required>
                </div>
            </div>

            <div class="form-group">
                <label class="input-label" for="email">Email Address</label>
                <div class="box-input">
                    <input class="w-100" id="email" type="email" placeholder="Enter your email" name="email"
                        required>
                </div>
            </div>

            <div class="form-group" style="display: none;">
                <label class="input-label" for="currency">Currency</label>
                <div class="box-input">
                    <select name="currency" id="currency" class="w-100" required>
                        <option disabled>Choose currency</option>
                        <option value="usdttrc20" selected>TRC-20(USDT)</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="input-label" for="invitation_code">Invitation Code (Optional)</label>
                <div class="box-input">
                    <input type="text" id="invitation_code" name="invitation_code"
                        placeholder="Enter invitation code" value="{{ $ref ?? old('invitation_code') }}">
                </div>
            </div>

            <div class="form-group">
                <label class="input-label" for="password">Password</label>
                <div class="box-input box-auth-pass">
                    <input type="password" required name="password" id="password"
                        placeholder="8-20 characters, secure!" class="password-field">
                    <span class="show-pass-toggle" data-target="password">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
            </div>

            <div class="form-group">
                <label class="input-label" for="password_confirmation">Confirm Password</label>
                <div class="box-input box-auth-pass">
                    <input type="password" required name="password_confirmation" id="password_confirmation"
                        placeholder="Re-enter your password" class="password-field2">
                    <span class="show-pass-toggle" data-target="password_confirmation">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
            </div>

            <div class="terms-group"> <input type="checkbox" class="tf-checkbox" name="agree" value="1"
                    id="cb-ip" checked required>
                <label for="cb-ip">I agree to the <a href="#terms">Terms and Conditions</a></label>
            </div>

            <button class="signup-button" type="submit">
                <i class="fas fa-check-circle"></i> Create Account
            </button>

            <p class="login-link-container">
                Already have an account?&ensp;
                <a href="{{ route('login') }}">Sign In</a>
            </p>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordToggles = document.querySelectorAll('.show-pass-toggle');

            passwordToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const targetInputId = this.getAttribute('data-target');
                    const targetInput = document.getElementById(targetInputId);
                    const icon = this.querySelector('i');

                    if (targetInput.type === 'password') {
                        targetInput.type = 'text';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else {
                        targetInput.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                });
            });

            // Basic form submission handler (for demonstration)
            const signupForm = document.querySelector('form'); // Assuming only one form
            if (signupForm) {
                signupForm.addEventListener('submit', function(event) {
                    // For a real application, remove preventDefault or handle AJAX submission.
                    // event.preventDefault();

                    const password = document.getElementById('password').value;
                    const passwordConfirmation = document.getElementById('password_confirmation').value;

                    if (password !== passwordConfirmation) {
                        event.preventDefault(); // Stop submission
                        alert('Passwords do not match. Please re-enter.');
                        // Optionally, you can add error styling to the fields here.
                        document.getElementById('password').focus();
                        return false;
                    }

                    if (!document.getElementById('cb-ip').checked) {
                        event.preventDefault(); // Stop submission
                        alert('You must agree to the Terms and Conditions.');
                        return false;
                    }

                    // If client-side validation passes and not preventing default:
                    // alert('Form submitted (for real this time if not prevented)!');
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
