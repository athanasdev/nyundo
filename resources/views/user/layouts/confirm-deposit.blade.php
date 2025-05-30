@extends('user.layouts.app')

@section('title', 'Payment Details ')

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
    #paymentAddressInput { /* Changed ID from paymentAddress */
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
    #copyAddressButton { /* Changed ID from copyButton */
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
    .copy-feedback { /* Changed ID to copyFeedbackDisplay */
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
        #paymentAddressInput { font-size: 0.8em;} /* Updated ID */
        #copyAddressButton { padding: 10px 15px; font-size: 0.85em;} /* Updated ID */
    }
</style>
{{-- Font Awesome is in main layout, qrcode.min.js needs to be included --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
@endpush

@section('content')
<div class="payment-page-container">
    <div class="page-title-header">
        {{-- Optional page-specific title --}}
        {{-- <i class="fas fa-shield-alt"></i> TradePro Secure Payment Instruction --}}
    </div>

    <div class="payment-card-container">
        <h2><i class="fas fa-coins"></i> Crypto Deposit</h2>

        <div class="instructions">
            Please send exactly <strong><span id="payAmountDisplay">0.00</span> <span id="payCurrencyDisplay">COIN</span></strong> to the address below.
            <br><small>Order ID: <span id="orderIdInfoDisplay">N/A</span></small>
        </div>

        <div id="qrcode-box">
            {{-- QR Code will be generated here by JavaScript --}}
        </div>

        <div class="address-container">
            <input type="text" id="paymentAddressInput" readonly value="Waiting for address...">
            <button id="copyAddressButton"><i class="fas fa-copy"></i> Copy</button>
        </div>
        <div id="copyFeedbackDisplay" class="copy-feedback"></div>

        <div class="payment-details">
            <p><strong>Network:</strong> <span id="networkTypeDisplay">N/A</span></p>
            <p><strong>Payment ID:</strong> <span id="paymentIdInfoDisplay">N/A</span></p>
            <p><strong>Status:</strong> <span id="paymentStatusValue" class="status-waiting">Waiting</span></p>
            <p><strong>Expires:</strong> <span id="expirationDateDisplay">N/A</span></p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const paymentData = @json($paymentData);

    document.addEventListener('DOMContentLoaded', function() {
        if (!paymentData) {
            console.error("Payment data not found in Blade view!");
            const container = document.querySelector('.payment-card-container');
            if (container) {
                const instructions = container.querySelector('.instructions');
                if (instructions) instructions.innerHTML = '<p style="color: #f6465d;">Error: Payment details are missing.</p>';
                document.getElementById('qrcode-box')?.remove();
                container.querySelector('.address-container')?.remove();
                container.querySelector('.payment-details')?.remove();
            }
            return;
        }

        const paymentAddress = paymentData.pay_address || 'N/A';
        const payAmount = parseFloat(paymentData.pay_amount) || 0;
        const payCurrency = paymentData.pay_currency ? paymentData.pay_currency.toUpperCase() : 'COIN';
        const orderId = paymentData.order_id || 'N/A';
        const network = paymentData.network || 'N/A';
        const paymentId = paymentData.payment_id || 'N/A';
        const status = paymentData.status || 'waiting';
        const expiresAt = paymentData.expires_at || 'N/A';

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
        if (qrBox) {
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
                feedback.textContent = "Address copied!";
                setTimeout(() => {
                    copyBtn.classList.remove("copied");
                    feedback.textContent = "";
                }, 2000);
            });
        });
    });
</script>
@endpush

