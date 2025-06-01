@extends('user.layouts.app')

@section('title', 'Initiate Deposit - CoinTrades')

@push('styles')
<style>

    .deposit-panel-card {
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
        margin-top: 20px;
    }

    .alert-error {
        color: #f6465d;
        background-color: rgba(246, 70, 93, 0.1);
        border: 1px solid rgba(246, 70, 93, 0.3);
        padding: 12px 15px;
        margin-bottom: 20px;
        border-radius: 4px;
        font-size: 0.9em;
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
        padding: 12px 15px;
        margin-bottom: 20px;
        border-radius: 4px;
        font-size: 0.9em;
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
    .form-group input[type="email"],
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
    .form-group select option {
        background-color: #1e2329;
        color: #eaecef;
    }

    .form-group small.note,
    p.form-footer-note {
        font-size: 0.8em;
        color: #848e9c;
        display: block;
        margin-top: 6px;
    }
    p.form-footer-note {
        text-align: center;
        margin-top: 20px;
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
    .card-title i {
        color: #f0b90b;
    }
</style>
@endpush

@section('content')
<div class="deposit-panel-card card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-money-check-alt"></i> Initiate Your Deposit</h3>
    </div>
    <div class="card-body">

        @if ($errors->any())
            <div class="alert-error">
                <strong>Please correct the following errors:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('error'))
            <div class="alert-error">
                {{ session('error') }}
            </div>
        @endif
         @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('payments.create') }}">
            @csrf
            <div class="form-group">
                <label for="price_amount">Amount (USD):</label>
                <input type="number" id="price_amount" name="price_amount" step="0.01" min="10" required>
                <small class="note">This is the equivalent value in USD you wish to deposit. Minimum $10.00.</small>
            </div>
            <input type="hidden" name="price_currency" value="usd">
            <input type="hidden" name="order_description" value="deposit">
            <input type="hidden" name="ipn_callback_url" value="{{ url('/ipn-callback') }}"> {{-- Using url() helper for full URL --}}

            <div class="form-group">
                <label for="customer_email">Your Email:</label>
                <input type="email" id="customer_email" name="customer_email" value="{{ old('customer_email', auth()->user() ? auth()->user()->email : '') }}" required>
                <small class="note">Email address for transaction communication.</small>
            </div>

            <div class="form-group">
                <label for="order_id">Order Reference:</label>
                <input type="text" id="order_id" name="order_id" value="{{ uniqid() }}" placeholder="order ID (optional)" readonly>

            </div>

            <div class="form-group">
                <label for="pay_currency">Pay With (Cryptocurrency):</label>
                <select id="pay_currency" name="pay_currency" required>
                    <option value="usdttrc20" {{ old('pay_currency', 'USDT.TRC20') == 'USDT.TRC20' ? 'selected' : '' }}>USDT (TRC20 Network)</option>
                </select>
                 <small class="note"><strong>Important:</strong> Please ensure you select <strong>USDT (TRC20 Network)</strong>. Using other networks or coins may result in loss of funds.</small>
            </div>

            <button type="submit" class="submit-btn">
                <i class="fas fa-arrow-circle-right"></i> Proceed to Payment
            </button>
        </form>
        <p class="form-footer-note">You will be redirected to your payment gateway to complete your transaction.</p>
    </div>
</div>
@endsection

@push('scripts')

@endpush
