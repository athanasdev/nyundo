@extends('user.layouts.app')

@section('title', __('messages.withdraw_funds_title') . ' - Soria10')

@push('styles')
    <style>
        .withdraw-panel-card {
            max-width: 650px;
            margin-left: auto;
            margin-right: auto;
            margin-top: 20px;
        }
        .alert-error, .alert-success {
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
        .alert-error li { margin-bottom: 5px; }
        .alert-error li:last-child { margin-bottom: 0; }
        .alert-success {
            color: #0ecb81;
            background-color: rgba(14, 203, 129, 0.1);
            border: 1px solid rgba(14, 203, 129, 0.3);
        }
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
        .withdrawal-summary {
            background-color: #222531;
            border: 1px solid #2b3139;
            border-radius: 4px;
            padding: 15px;
            margin-top: 10px;
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
        }
        .withdrawal-summary span.fee-value {
            color: #f6465d;
        }
        .withdrawal-summary span.receivable-value {
            color: #0ecb81;
            font-size: 1.1em;
        }
        .submit-btn {
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
            <h3 class="card-title"><i class="fas fa-paper-plane"></i> {{ __('messages.initiate_withdrawal') }}</h3>
        </div>
        <div class="card-body">

            @if ($errors->any())
                <div class="alert-error flex items-start space-x-2">
                    <ul style="list-style-type: none;" class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            ⚠️ <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="alert-error flex items-center space-x-2">
                    ❌ <span>{{ session('error') }}</span>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success flex items-center space-x-2">
                    ✅<span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="form-group">
                <label>{{ __('messages.available_balance') }}:</label>
                <input type="text" readonly value="${{ number_format(Auth::user()->balance ?? 0, 2) }} USDT"
                       style="font-weight: bold; color: #0ecb81;">
            </div>

            @php
                $userWithdrawalAddress = Auth::user()->withdrawal_address ?? __('messages.address_not_set_placeholder');
            @endphp
            <div class="form-group">
                <label for="withdrawal_address">{{ __('messages.your_withdrawal_address') }}:</label>
                <div class="address-display-group">
                    <input type="text" name="withdrawal_address" id="withdrawal_address_display"
                           value="{{ $userWithdrawalAddress }}" readonly>
                    <a href="{{ route('withdrawal.address.edit') }}" class="copy-btn-sm" id="changeAddressBtn">
                        <i class="fas fa-exchange-alt"></i> {{ __('messages.change_button') }}
                    </a>
                </div>
                <small id="copyWithdrawalFeedback" class="note" style="height: 1em;"></small>
            </div>

            <form method="POST" action="{{ route('withdraw.request') }}">
                @csrf
                <div class="form-group">
                    <label for="amount_to_withdraw">{{ __('messages.amount_to_withdraw') }}:</label>
                    <input type="number" id="amount_to_withdraw" name="amount" value="{{ old('amount') }}" step="0.01"
                           min="10" placeholder="{{ __('messages.enter_amount_placeholder') }}" required>
                    <small class="note">{{ __('messages.withdrawal_fee_note') }}</small>
                </div>

                <div class="withdrawal-summary" id="withdrawalSummaryBox" style="display: none;">
                    <p><strong>{{ __('messages.withdrawal_amount') }}:</strong> <span class="value">$<span id="summaryAmount">0.00</span></span></p>
                    <p><strong>{{ __('messages.withdrawal_fee', ['fee' => 5]) }}:</strong> <span class="fee-value">$<span id="summaryFee">0.00</span></span></p>
                    <hr style="border-color: #2b3139; margin: 5px 0;">
                    <p><strong>{{ __('messages.you_will_receive') }}:</strong> <span class="receivable-value">$<span id="summaryReceivable">0.00</span> USDT</span></p>
                </div>

                <div class="form-group">
                    <label for="withdraw_password">{{ __('messages.withdrawal_pin_label') }}:</label>
                    <input type="password" name="withdraw_password" id="withdraw_password"
                           placeholder="{{ __('messages.enter_pin_placeholder') }}" required>
                </div>

                <input type="hidden" name="withdraw_currency" value="USDTTRC20">

                <button type="submit" class="submit-btn">
                    <i class="fas fa-paper-plane"></i> {{ __('messages.request_withdrawal_button') }}
                </button>
            </form>

            <div class="mt-4">
                <h5 style="color: #c1c8d1; font-size: 0.9em; margin-bottom:10px; text-align:left;">{{ __('messages.important_notes_title') }}:</h5>
                <ul style="font-size: 0.85em; color: #848e9c; text-align:left; padding-left: 20px;">
                    <li>{{ __('messages.withdrawal_note_1') }}</li>
                    <li>{{ __('messages.withdrawal_note_2') }}</li>
                    <li>{{ __('messages.withdrawal_note_3') }}</li>
                    <li>{{ __('messages.withdrawal_note_4') }}</li>
                    <li>{!! __('messages.withdrawal_note_5') !!}</li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const amountInput = document.getElementById('amount_to_withdraw');
            const summaryBox = document.getElementById('withdrawalSummaryBox');
            const summaryAmountEl = document.getElementById('summaryAmount');
            const summaryFeeEl = document.getElementById('summaryFee');
            const summaryReceivableEl = document.getElementById('summaryReceivable');

            const WITHDRAWAL_FEE_PERCENT = {{ $setting->withdraw_fee_percentage ?? 5 }} / 100;

            function calculateWithdrawal() {
                if (!amountInput || !summaryBox || !summaryAmountEl || !summaryFeeEl || !summaryReceivableEl) return;

                let amount = parseFloat(amountInput.value);
                if (isNaN(amount) || amount <= 0) {
                    summaryBox.style.display = 'none';
                    return;
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
                amountInput.addEventListener('blur', function() {
                    let value = parseFloat(this.value);
                    if (!isNaN(value)) {
                        const minValue = parseFloat(this.min);
                        if (!isNaN(minValue) && value < minValue && this.value !== "") {
                            value = minValue;
                        }
                        this.value = value.toFixed(2);
                        calculateWithdrawal();
                    } else if (this.value === "") {
                        if (summaryBox) summaryBox.style.display = 'none';
                    }
                });
                if (amountInput.value) {
                    calculateWithdrawal();
                }
            }
        });
    </script>
@endpush
