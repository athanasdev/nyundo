<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set New Password - Soria10</title>
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

        .set-password-card-container {
            background: #1e2329;
            border-radius: 8px;
            border: 1px solid #2b3139;
            padding: 30px 35px;
            width: 100%;
            max-width: 480px;
            /* Consistent with signup */
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
            position: relative;
            text-align: center;
        }

        .set-password-card-container::before {
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
            display: flex;
            align-items: center;
            flex-direction: column;
            margin-bottom: 25px;
        }

        .form-header img {
            width: 65%;
            max-width: 180px;
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

        .form-header h4 i.title-icon {
            /* For icon next to title */
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
            margin-bottom: 18px;
            text-align: left;
            /* Align labels to the left */
        }

        /* User's specific margin classes if needed for fine-tuning */
        fieldset.mb-16 {
            margin-bottom: 16px !important;
        }

        fieldset.mt-20 {
            margin-top: 20px !important;
        }


        /* Styling for <p> elements used as labels */
        p.form-label {
            /* Replaces .mb-1.text-small for consistent naming */
            display: block;
            color: #848e9c;
            font-size: 0.9em;
            font-weight: 500;
            margin-bottom: 6px;
        }

        .box-input {
            position: relative;
        }

        /* Adding icon to the left of input field */
        .box-input .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #848e9c;
            font-size: 0.9em;
        }

        .box-input input.has-icon {
            padding-left: 40px;
            /* Make space for the icon */
        }


        .box-input input[type="text"],
        .box-input input[type="email"],
        /* Added email type */
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
            /* Specific to password with toggle */
            padding-right: 40px;
        }

        .box-input input[type="text"]:focus,
        .box-input input[type="email"]:focus,
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

        .show-pass-toggle {
            /* Targets .show-pass and .show-pass2 */
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

        .show-pass-toggle .icon-view-hide {
            display: none;
        }

        button.tf-btn {
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
            /* Was mt-40, adjusted */
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

        .resend-link-container {
            margin-top: 25px;
            /* Was mt-20 */
            text-align: center;
            font-size: 0.9em;
            color: #848e9c;
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

        .resend-link-container a {
            color: #9f9d20c5;
            /* User's specified color */
            font-weight: 600;
            text-decoration: none;
        }

        .resend-link-container a:hover {
            text-decoration: underline;
        }

        /* Responsive design */
        @media (max-width: 480px) {
            .set-password-card-container {
                padding: 25px 20px;
            }

            .form-header h4 {
                font-size: 1.4em;
            }

            .form-header .subtitle {
                font-size: 0.9em;
            }

            .box-input input[type="text"],
            .box-input input[type="email"],
            .box-input input[type="password"] {
                padding: 10px 12px;
            }

            .box-auth-pass input[type="password"] {
                padding-right: 35px;
            }

            .box-input input.has-icon {
                padding-left: 35px;
            }

            .show-pass-toggle {
                right: 10px;
            }

            button.tf-btn {
                padding: 10px 12px;
            }

            .resend-link-container {
                font-size: 0.85em;
            }
        }
    </style>
</head>

<body>

    <div class="set-password-card-container">
        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            <div class="form-header">
                <img src="{{ asset('images/logo/logo.png') }}" alt="TradePro Logo">
                <h4><i class="fas fa-key title-icon"></i>Set New Password</h4> <span class="subtitle">Create a strong
                    and secure new password.</span>
            </div>

            @include('user.common.alert')

            <fieldset class="mt-20 mb-16">
                <p class="form-label">Email Address</p>
                <div class="box-input">

                    <input type="email" placeholder="Email Address" name="email"
                        value="{{ old('email', $request->email ?? '') }}" class="has-icon" required>
                </div>
            </fieldset>

            <fieldset class="mb-16">
                <p class="form-label">Verification Code</p>
                <div class="box-input">
                    <input type="text" placeholder="Enter Verification Code" name="token" class="has-icon"
                        required>
                </div>
            </fieldset>

            <fieldset class="mb-16">
                <p class="form-label">New Password</p>
                <div class="box-input">
                    <i class="fas fa-key input-icon"></i>
                    <div class="box-auth-pass">
                        <input type="password" required placeholder="Enter New Password" class="password-field has-icon"
                            name="password" id="new_password">
                        <span class="show-pass-toggle" data-target="new_password">
                            <i class="fas fa-eye icon-view"></i>
                            <i class="fas fa-eye-slash icon-view-hide"></i>
                        </span>
                    </div>
                </div>
            </fieldset>

            <fieldset class="mb-16">
                <p class="form-label">Confirm New Password</p>
                <div class="box-input">
                    <i class="fas fa-key input-icon"></i>
                    <div class="box-auth-pass">
                        <input type="password" required placeholder="Repeat New Password"
                            class="password-field2 has-icon" name="password_confirmation" id="password_confirmation">
                        <span class="show-pass-toggle" data-target="password_confirmation"> <i
                                class="fas fa-eye icon-view"></i>
                            <i class="fas fa-eye-slash icon-view-hide"></i>
                        </span>
                    </div>
                </div>
            </fieldset>

            <button class="tf-btn lg yl-btn" type="submit"> <i class="fas fa-save"></i> Save New Password
            </button>

            <p class="resend-link-container"> Didn’t Receive the Code?
                <a class="text-warning" href="{{ route('password.request') }}">Resend Again</a>
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
                    const iconView = this.querySelector('.icon-view');
                    const iconViewHide = this.querySelector('.icon-view-hide');

                    if (targetInput && iconView && iconViewHide) { // Check if elements exist
                        if (targetInput.type === 'password') {
                            targetInput.type = 'text';
                            iconView.style.display = 'none';
                            iconViewHide.style.display = 'inline';
                        } else {
                            targetInput.type = 'password';
                            iconView.style.display = 'inline';
                            iconViewHide.style.display = 'none';
                        }
                    }
                });
            });

            const resetForm = document.querySelector('.set-password-card-container form');
            if (resetForm) {
                resetForm.addEventListener('submit', function(event) {
                    const newPassword = document.getElementById('new_password').value;
                    const confirmPassword = document.getElementById('password_confirmation').value;

                    if (newPassword !== confirmPassword) {
                        event.preventDefault(); // Stop submission
                        alert('New passwords do not match. Please re-enter.');
                        // You might want to add error styling to the fields
                        document.getElementById('new_password').focus();
                        return false;
                    }
                    // Add other client-side validations if needed (e.g., password strength)
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
