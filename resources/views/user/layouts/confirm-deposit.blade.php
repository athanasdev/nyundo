@extends('user.layouts.app')

@section('title', __('messages.payment_details_title'))

@push('styles')
<style>
    /* Deposit Page Specific Styles */
    .payment-page-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
        padding-top: 20px;
    }

    .page-title-header {
        width: 100%;
        max-width: 450px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 20px;
        font-weight: 600;
        color: #f0b90b;
        margin-bottom: 24px;
    }
    .page-title-header i {
        font-size: 24px;
    }

    .payment-card-container {
        background: #1e2329;
        border-radius: 8px;
        border: 1px solid #2b3139;
        padding: 25px 30px;
        text-align: center;
        width: 100%;
        max-width: 450px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        position: relative;
    }

    .payment-card-container::before { /* Accent border top */
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: #f0b90b;
        border-radius: 8px 8px 0 0;
    }

    .payment-card-container h2 { /* Title inside the card */
        color: #f0b90b;
        margin-bottom: 15px;
        font-size: 1.7em;
        font-weight: 600;
    }

    .instructions {
        font-size: 0.95em;
        color: #c1c8d1;
        margin-bottom: 25px;
        padding: 12px 15px;
        background: rgba(240, 185, 11, 0.05);
        border-radius: 4px;
        border-left: 3px solid #f0b90b;
        text-align: left;
    }
    .instructions strong {
        color: #f0b90b;
        font-weight: 600;
    }

    #qrcode-box {
        width: 200px;
        height: 200px;
        margin: 0 auto 25px auto;
        border: 1px solid #2b3139;
        padding: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #ffffff;
        border-radius: 6px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .address-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border: 1px solid #2b3139;
        border-radius: 4px;
        padding: 0;
        margin-bottom: 15px;
        background: #0b0e11;
        overflow: hidden;
    }
    .address-container:focus-within {
        border-color: #f0b90b;
        box-shadow: 0 0 0 2px rgba(240, 185, 11, 0.3);
    }
    #paymentAddressInput {
        flex-grow: 1;
        padding: 12px 15px;
        border: none;
        outline: none;
        font-size: 0.9em;
        background-color: transparent;
        color: #eaecef;
        font-family: 'SF Mono', 'Courier New', monospace;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    #copyAddressButton {
        padding: 12px 18px;
        background: #f0b90b;
        color: #1e2329;
        border: none;
        cursor: pointer;
        font-size: 0.9em;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: background-color 0.2s, opacity 0.2s;
    }
    #copyAddressButton:hover {
        background: #d8a40a;
        opacity: 0.95;
    }
    #copyAddressButton.copied {
        background: #0ecb81;
        color: #fff;
    }
    .copy-feedback {
        margin-top: 0;
        margin-bottom: 15px;
        font-size: 0.85em;
        color: #0ecb81;
        height: 1.2em;
        font-weight: 500;
    }

    .payment-details {
        margin-top: 20px;
        padding: 15px;
        background: rgba(43, 49, 57, 0.5);
        border-radius: 4px;
        border: 1px solid #2b3139;
    }
    .payment-details p {
        margin: 8px 0;
        font-size: 0.9em;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #c1c8d1;
    }
    .payment-details strong {
        color: #eaecef;
        font-weight: 500;
    }
    .payment-details span#paymentStatusValue,
    .payment-details span {
        color: #f0b90b;
        font-weight: 500;
    }

    #paymentStatusValue.status-waiting {
        background-color: rgba(240, 185, 11, 0.2);
        color: #f0b90b;
        padding: 3px 8px; border-radius: 3px; font-size: 0.85em; text-transform: capitalize;
    }
    #paymentStatusValue.status-confirmed,
    #paymentStatusValue.status-completed {
        background-color: rgba(14, 203, 129, 0.2);
        color: #0ecb81;
        padding: 3px 8px; border-radius: 3px; font-size: 0.85em; text-transform: capitalize;
    }
    #paymentStatusValue.status-failed,
    #paymentStatusValue.status-expired {
        background-color: rgba(246, 70, 93, 0.2);
        color: #f6465d;
        padding: 3px 8px; border-radius: 3px; font-size: 0.85em; text-transform: capitalize;
    }

    @media (max-width: 480px) {
        .page-title-header { margin-bottom: 15px; font-size: 18px; }
        .payment-card-container { padding: 20px; }
        #qrcode-box { width: 170px; height: 170px; }
        .payment-card-container h2 { font-size: 1.4em; }
        #paymentAddressInput { font-size: 0.8em;}
        #copyAddressButton { padding: 10px 15px; font-size: 0.85em;}
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
@endpush

@section('content')
<div class="payment-page-container">
    <div class="payment-card-container">
        <h2><i class="fas fa-coins"></i> {{ __('messages.crypto_deposit_title') }}</h2>

        <div class="instructions">
            {{ __('messages.payment_instruction_line_1') }} <strong><span id="payAmountDisplay">0.00</span> <span id="payCurrencyDisplay">COIN</span></strong> {{ __('messages.payment_instruction_line_2') }}
            <br><small>{{ __('messages.order_id') }}: <span id="orderIdInfoDisplay">{{ __('messages.not_applicable') }}</span></small>
        </div>

        <div id="qrcode-box">
            {{-- QR Code will be generated here by JavaScript --}}
        </div>

        <div class="address-container">
            <input type="text" id="paymentAddressInput" readonly value="{{ __('messages.waiting_for_address') }}...">
            <button id="copyAddressButton"><i class="fas fa-copy"></i> {{ __('messages.copy_button') }}</button>
        </div>
        <div id="copyFeedbackDisplay" class="copy-feedback"></div>

        <div class="payment-details">
            <p><strong>{{ __('messages.network') }}:</strong> <span id="networkTypeDisplay">{{ __('messages.not_applicable') }}</span></p>
            <p><strong>{{ __('messages.payment_id') }}:</strong> <span id="paymentIdInfoDisplay">{{ __('messages.not_applicable') }}</span></p>
            <p><strong>{{ __('messages.status') }}:</strong> <span id="paymentStatusValue" class="status-waiting">{{ __('messages.status_waiting') }}</span></p>
            <p><strong>{{ __('messages.expires') }}:</strong> <span id="expirationDateDisplay">{{ __('messages.not_applicable') }}</span></p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const paymentData = @json($paymentData);
    const lang = {
        copied_feedback: "{{ __('messages.copied_feedback') }}",
        error_details_missing: "{{ __('messages.error_payment_details_missing') }}",
        not_applicable: "{{ __('messages.not_applicable') }}"
    };

    document.addEventListener('DOMContentLoaded', function() {
        if (!paymentData) {
            console.error("Payment data not found in Blade view!");
            const container = document.querySelector('.payment-card-container');
            if (container) {
                const instructions = container.querySelector('.instructions');
                if (instructions) instructions.innerHTML = `<p style="color: #f6465d;">${lang.error_details_missing}</p>`;
                document.getElementById('qrcode-box')?.remove();
                container.querySelector('.address-container')?.remove();
                container.querySelector('.payment-details')?.remove();
            }
            return;
        }

        const paymentAddress = paymentData.pay_address || lang.not_applicable;
        const payAmount = parseFloat(paymentData.price_amount) || 0;
        const payCurrency = paymentData.pay_currency ? paymentData.pay_currency.toUpperCase() : 'COIN';
        const orderId = paymentData.order_id || lang.not_applicable;
        const network = paymentData.network || lang.not_applicable;
        const paymentId = paymentData.payment_id || lang.not_applicable;
        const status = paymentData.status || 'waiting';
        const expiresAt = paymentData.valid_until || lang.not_applicable;

        // Set field values
        document.getElementById('payAmountDisplay').textContent = payAmount.toFixed(8);
        document.getElementById('payCurrencyDisplay').textContent = payCurrency;
        document.getElementById('orderIdInfoDisplay').textContent = orderId;
        document.getElementById('paymentAddressInput').value = paymentAddress;
        document.getElementById('networkTypeDisplay').textContent = network;
        document.getElementById('paymentIdInfoDisplay').textContent = paymentId;
        document.getElementById('expirationDateDisplay').textContent = expiresAt;

        // Set status style and text
        const statusEl = document.getElementById('paymentStatusValue');
        statusEl.textContent = status.charAt(0).toUpperCase() + status.slice(1);
        statusEl.className = '';
        statusEl.classList.add('status-' + status.toLowerCase());

        // Generate QR Code
        const qrBox = document.getElementById("qrcode-box");
        if (qrBox && paymentAddress !== lang.not_applicable) {
            new QRCode(qrBox, {
                text: paymentAddress,
                width: 180,
                height: 180,
                colorDark : "#000000",
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.H
            });
        }

        // Copy Button Logic
        const copyBtn = document.getElementById("copyAddressButton");
        const addressInput = document.getElementById("paymentAddressInput");
        const feedback = document.getElementById("copyFeedbackDisplay");

        copyBtn?.addEventListener("click", function() {
            addressInput.select();
            addressInput.setSelectionRange(0, 99999); // for mobile
            navigator.clipboard.writeText(addressInput.value).then(() => {
                copyBtn.classList.add("copied");
                feedback.textContent = lang.copied_feedback;
                setTimeout(() => {
                    copyBtn.classList.remove("copied");
                    feedback.textContent = "";
                }, 2000);
            });
        });
    });
</script>
@endpush
