@extends('user.layouts.app')

@section('title', 'Withdraw Funds - Soria10')

@push('styles')
    <style>
        .withdraw-panel-card {
            max-width: 650px;
            /* Slightly wider for more details */
            margin-left: auto;
            margin-right: auto;
            margin-top: 20px;
        }

        /* Error/Success Message Styling (assuming these are globally available or can be added here) */
        .alert-error,
        .alert-success {
            padding: 12px 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            font-size: 0.9em;
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

        /* Form Group Styling (consistent with deposit page) */
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #c1c8d1;
            font-size: 0.9em;
            font-weight: 500;
        }

        .form-group input[type="number"],
        .form-group input[type="password"],
        .form-group input[type="text"],
        /* For read-only address */
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border-radius: 4px;
            border: 1px solid #2b3139;
            background-color: #0b0e11;
            color: #eaecef;
            font-size: 1em;
            box-sizing: border-box;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #f0b90b;
            box-shadow: 0 0 0 3px rgba(240, 185, 11, 0.25);
        }

        .form-group input[readonly] {
            background-color: #222531;
            /* Slightly different for readonly */
            cursor: default;
        }

        .form-group small.note {
            font-size: 0.8em;
            color: #848e9c;
            display: block;
            margin-top: 6px;
        }

        .address-display-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .address-display-group input[type="text"] {
            flex-grow: 1;
        }

        .copy-btn-sm {
            padding: 10px 15px;
            /* Match input height better */
            background: #2b3139;
            color: #f0b90b;
            border: 1px solid #f0b90b;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.85em;
            white-space: nowrap;
        }

        .copy-btn-sm:hover {
            background: #363d47;
        }

        .copy-btn-sm.copied {
            background: #0ecb81;
            color: #fff;
            border-color: #0ecb81;
        }


        /* Calculation Summary Box */
        .withdrawal-summary {
            background-color: #222531;
            /* Darker background for summary */
            border: 1px solid #2b3139;
            border-radius: 4px;
            padding: 15px;
            margin-top: 10px;
            /* Space above the summary if amount is entered */
            margin-bottom: 20px;
            font-size: 0.9em;
        }

        .withdrawal-summary p {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            color: #c1c8d1;
        }

        .withdrawal-summary p:last-child {
            margin-bottom: 0;
        }

        .withdrawal-summary strong {
            color: #eaecef;
            font-weight: 500;
        }

        .withdrawal-summary span.value {
            font-weight: 600;
            color: #f0b90b;
            /* Accent for values */
        }

        .withdrawal-summary span.fee-value {
            color: #f6465d;
            /* Red for fee */
        }

        .withdrawal-summary span.receivable-value {
            color: #0ecb81;
            /* Green for receivable */
            font-size: 1.1em;
            /* Make receivable slightly larger */
        }

        .submit-btn {
            /* Consistent with deposit page */
            width: 100%;
            padding: 12px 15px;
            background-color: #f0b90b;
            color: #1e2329;
            border: none;
            border-radius: 4px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.1s;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .submit-btn:hover {
            background-color: #d8a40a;
        }

        .submit-btn:active {
            transform: scale(0.98);
        }

        .submit-btn i {
            margin-right: 8px;
        }

        .form-footer-note {
            text-align: center;
            margin-top: 20px;
            font-size: 0.8em;
            color: #848e9c;
        }

        .card-title i {
            color: #f0b90b;
        }
    </style>
@endpush

@section('content')
    <div class="withdraw-panel-card card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-paper-plane"></i> Initiate Withdrawal</h3>
        </div>
        <div class="card-body">

            @if ($errors->any())
                <div class="alert-error flex items-start space-x-2">
                    <span class="mt-1">⚠️</span>
                    <ul style="list-style-type: none;" class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="alert-error flex items-center space-x-2">
                    <span>❌</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success flex items-center space-x-2">
                    <span>✅</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="form-group">
                <label>Available Balance:</label>
                <input type="text" readonly value="${{ number_format(Auth::user()->balance ?? 0, 2) }} USDT"
                    style="font-weight: bold; color: #0ecb81;">
            </div>

            {{-- Assume user has one primary withdrawal address for a given currency, e.g., USDT TRC20 --}}
            {{-- In a real app, you might fetch this from user's profile or a dedicated addresses table --}}
            @php
                $userWithdrawalAddress = Auth::user()->withdrawal_address ?? 'YOUR_USDT_TRC20_ADDRESS_NOT_SET';
                // $withdrawalCurrency = 'USDT (TRC20)'; // Example
            @endphp
            <div class="form-group">
                <label for="withdrawal_address">Your Withdrawal Address (USDT TRC20):</label>
                <div class="address-display-group">
                    <input type="text" name="withdrawal_address" id="withdrawal_address_display"
                        value="{{ $userWithdrawalAddress }}" readonly>
                    <a href="{{ route('withdrawal.address.edit') }}" class="copy-btn-sm" id="copyWithdrawalAddressBtn"
                        onclick="copyWithdrawalAddr()">
                        <i class="fas fa-exchange-alt"></i> Change
                    </a>
                </div>
                <small id="copyWithdrawalFeedback" class="note" style="height: 1em;"></small>
            </div>

            {{-- @include('user.common.alert'); --}}

            <form method="POST" action="{{ route('withdraw.request') }}"> {{-- Define this route --}}
                @csrf

                <div class="form-group">
                    <label for="amount_to_withdraw">Amount to Withdraw (USD):</label>
                    <input type="number" id="amount_to_withdraw" name="amount" value="{{ old('amount') }}" step="0.01"
                        min="10" {{-- Example minimum withdrawal --}} placeholder="Enter amount" required>
                    <small class="note">Minimum withdrawal: $20.00. A 5% fee applies.</small>
                </div>

                <div class="withdrawal-summary" id="withdrawalSummaryBox" style="display: none;">
                    <p><strong>Withdrawal Amount:</strong> <span class="value">$<span id="summaryAmount">0.00</span></span>
                    </p>
                    <p><strong>Withdrawal Fee (5%):</strong> <span class="fee-value">$<span
                                id="summaryFee">0.00</span></span></p>
                    <hr style="border-color: #2b3139; margin: 5px 0;">
                    <p><strong>You Will Receive:</strong> <span class="receivable-value">$<span
                                id="summaryReceivable">0.00</span> USDT</span></p>
                </div>

                <div class="form-group">
                    <label for="security_pin">Withdrawal PIN / Security Password:</label>
                    <input type="password" name="withdraw_password" id="withdraw_password"
                        placeholder="Enter your PIN/Password" required>
                </div>

                {{-- Hidden field for the currency being withdrawn, if needed by backend --}}
                <input type="hidden" name="withdraw_currency" value="USDTTRC20">


                <button type="submit" class="submit-btn">
                    <i class="fas fa-paper-plane"></i> Request Withdrawal
                </button>
            </form>

            <div class="mt-4">
                <h5 style="color: #c1c8d1; font-size: 0.9em; margin-bottom:10px; text-align:left;">Important Notes:</h5>
                <ul style="font-size: 0.85em; color: #848e9c; text-align:left; padding-left: 20px;">
                    <li>Ensure your withdrawal address is correct and on the TRC20 network for USDT.</li>
                    <li>Withdrawals are processed within 24 hours.</li>
                    <li>You can make one withdrawal request per day.</li>
                    <li>One day before making a withdrawal ,you should not trading.</li>
                    <li>For assistance, contact <a href="#" style="color:#f0b90b;">Customer Support</a>.</li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const amountInput = document.getElementById('amount_to_withdraw') as HTMLInputElement | null;
            const summaryBox = document.getElementById('withdrawalSummaryBox');
            const summaryAmountEl = document.getElementById('summaryAmount');
            const summaryFeeEl = document.getElementById('summaryFee');
            const summaryReceivableEl = document.getElementById('summaryReceivable');
            const copyWithdrawalAddressBtn = document.getElementById('copyWithdrawalAddressBtn');
            const withdrawalAddressInput = document.getElementById(
                'withdrawal_address_display') as HTMLInputElement | null;
            const copyWithdrawalFeedback = document.getElementById('copyWithdrawalFeedback');

            const WITHDRAWAL_FEE_PERCENT = 0.05; // 5%

            function calculateWithdrawal() {
                if (!amountInput || !summaryBox || !summaryAmountEl || !summaryFeeEl || !summaryReceivableEl)
                    return;

                let amount = parseFloat(amountInput.value);
                if (isNaN(amount) || amount <= 0) {
                    summaryBox.style.display = 'none';
                    return;
                }

                // Optionally enforce minimum here or rely on form validation
                const minValue = parseFloat(amountInput.min);
                if (!isNaN(minValue) && amount < minValue) {
                    // Could show an inline error or just let HTML5 validation handle it on submit
                }


                const fee = amount * WITHDRAWAL_FEE_PERCENT;
                const receivable = amount - fee;

                summaryAmountEl.textContent = amount.toFixed(2);
                summaryFeeEl.textContent = fee.toFixed(2);
                summaryReceivableEl.textContent = receivable.toFixed(2);
                summaryBox.style.display = 'block';
            }

            if (amountInput) {
                amountInput.addEventListener('input', calculateWithdrawal);
                amountInput.addEventListener('blur', function() { // Format to 2 decimal places on blur
                    let value = parseFloat(this.value);
                    if (!isNaN(value)) {
                        const minValue = parseFloat(this.min);
                        if (!isNaN(minValue) && value < minValue && this.value !==
                            "") { // only apply min if not empty
                            value = minValue;
                        }
                        this.value = value.toFixed(2);
                        calculateWithdrawal(); // Recalculate after formatting
                    } else if (this.value === "") {
                        if (summaryBox) summaryBox.style.display = 'none';
                    }
                });
                if (amountInput.value) { // Initial calculation if value pre-filled
                    calculateWithdrawal();
                }
            }

            if (copyWithdrawalAddressBtn && withdrawalAddressInput && copyWithdrawalFeedback) {
                copyWithdrawalAddressBtn.addEventListener('click', function() {
                    if (!withdrawalAddressInput.value || withdrawalAddressInput.value ===
                        'YOUR_USDT_TRC20_ADDRESS_NOT_SET') {
                        copyWithdrawalFeedback.textContent = 'No address set to copy.';
                        copyWithdrawalFeedback.style.color = '#f6465d';
                        setTimeout(() => {
                            copyWithdrawalFeedback.textContent = '';
                        }, 3000);
                        return;
                    }
                    withdrawalAddressInput.select();
                    withdrawalAddressInput.setSelectionRange(0, 99999); // For mobile

                    navigator.clipboard.writeText(withdrawalAddressInput.value).then(() => {
                        copyWithdrawalFeedback.textContent = 'Address Copied!';
                        copyWithdrawalFeedback.style.color = '#0ecb81';
                        copyWithdrawalAddressBtn.innerHTML = '<i class="fas fa-check"></i> Copied';
                        copyWithdrawalAddressBtn.classList.add('copied');
                        setTimeout(() => {
                            copyWithdrawalFeedback.textContent = '';
                            copyWithdrawalAddressBtn.innerHTML =
                                '<i class="fas fa-copy"></i> Copy';
                            copyWithdrawalAddressBtn.classList.remove('copied');
                        }, 2500);
                    }).catch(err => {
                        copyWithdrawalFeedback.textContent = 'Failed to copy.';
                        copyWithdrawalFeedback.style.color = '#f6465d';
                        console.error('Failed to copy address: ', err);
                        setTimeout(() => {
                            copyWithdrawalFeedback.textContent = '';
                        }, 3000);
                    });
                });
            }
        });
    </script>
    <script>
        document.getElementById('amount').addEventListener('input', function() {
            const amount = parseFloat(this.value);
            const feePercentage = {{ $setting->withdraw_fee_percentage ?? 5 }};
            const fee = amount * feePercentage / 100;
            const net = amount - fee;

            if (!isNaN(amount)) {
                document.getElementById('feeDisplay').innerText =
                    `Fee: ${fee.toFixed(2)} | You will receive: ${net.toFixed(2)}`;
            } else {
                document.getElementById('feeDisplay').innerText = '';
            }
        });
    </script>
    <p id="feeDisplay" class="text-muted mt-2"></p>
@endpush
