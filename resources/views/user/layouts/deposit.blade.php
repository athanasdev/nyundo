@extends('user.layouts.app')

@section('title', __('messages.deposit_page_title') . ' - Soria10')

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
            <h3 class="card-title"><i class="fas fa-money-check-alt"></i> {{ __('messages.initiate_your_deposit') }}</h3>
        </div>
        <div class="card-body">

            @if ($errors->any())
                <div class="alert-error">
                    <strong>{{ __('messages.error_correct_following') }}:</strong>
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

            {{-- <form method="POST" action="{{ route('payments.create') }}">
            @csrf
            <div class="form-group">
                <label for="price_amount">{{ __('messages.amount_usd') }}:</label>
                <input type="number" id="price_amount" name="price_amount" step="0.01" min="15" required>
                <small class="note">{{ __('messages.minimum_deposit_is_15') }}</small>
            </div>
            <input type="hidden" name="price_currency" value="usd">
            <input type="hidden" name="order_description" value="deposit">
            <input type="hidden" name="ipn_callback_url" value="{{ url('/ipn-callback') }}">

            <div class="form-group">
                <label for="customer_email">{{ __('messages.your_email') }}:</label>
                <input type="email" id="customer_email" name="customer_email" value="{{ old('customer_email', auth()->user() ? auth()->user()->email : '') }}" required>
                <small class="note">{{ __('messages.email_for_communication') }}</small>
            </div>

            <div class="form-group">
                <label for="order_id">{{ __('messages.order_reference') }}:</label>
                <input type="text" value="{{ uniqid() }}" placeholder="{{ __('messages.order_id_optional') }}" readonly>
                <input type="hidden" id="order_id" name="order_id" value="{{ Auth::user()->id }}" readonly>
            </div>

            <div class="form-group">
                <label for="pay_currency">{{ __('messages.pay_with_crypto') }}:</label>
                <select id="pay_currency" name="pay_currency" required>
                    <option value="usdttrc20" {{ old('pay_currency', 'USDT.TRC20') == 'USDT.TRC20' ? 'selected' : '' }}>{{ __('messages.usdt_trc20_network') }}</option>
                </select>
                <small class="note"><strong>{{ __('messages.important_note') }}:</strong> {{ __('messages.ensure_usdt_trc20_network') }}</small>
            </div>

            <button type="submit" class="submit-btn">
                <i class="fas fa-arrow-circle-right"></i> {{ __('messages.proceed_to_payment') }}
            </button>
        </form> --}}

            <form method="POST" action="{{ route('payments.create') }}">
                @csrf
                <div class="form-group">
                    <label for="price_amount">{{ __('messages.amount_usd') }}:</label>
                    <input type="number" id="price_amount" name="price_amount" step="0.01" min="15" required>
                    <small class="note">{{ __('messages.minimum_deposit_is_15') }}</small>
                </div>
                <input type="hidden" name="price_currency" value="usd">
                <input type="hidden" name="order_description" value="deposit">
                <input type="hidden" name="ipn_callback_url" value="{{ url('/ipn-callback') }}">

                {{-- START: Hidden Email Section --}}
                <div class="form-group">
                    {{-- The email input is now hidden --}}
                    <input type="hidden" id="customer_email" name="customer_email"
                        value="{{ old('customer_email', auth()->user() ? auth()->user()->email : '') }}" required>
                    {{-- Removed the label and small note as the field is hidden --}}
                </div>
                {{-- END: Hidden Email Section --}}

                {{-- START: Hidden Order Reference Section --}}
                <div class="form-group">
                    {{-- The display input for uniqid() is removed, as it's no longer needed for display --}}
                    {{-- The actual order_id input remains, ensuring it's sent --}}
                    <input type="hidden" id="order_id" name="order_id" value="{{ Auth::user()->id }}" readonly>
                    {{-- Removed the label as the field is hidden --}}
                </div>
                {{-- END: Hidden Order Reference Section --}}

                <div class="form-group">
                    <label for="pay_currency">{{ __('messages.pay_with_crypto') }}:</label>
                    <select id="pay_currency" name="pay_currency" required>
                        <option value="usdttrc20"
                            {{ old('pay_currency', 'USDT.TRC20') == 'USDT.TRC20' ? 'selected' : '' }}>
                            {{ __('messages.usdt_trc20_network') }}</option>
                    </select>
                    <small class="note"><strong>{{ __('messages.important_note') }}:</strong>
                        {{ __('messages.ensure_usdt_trc20_network') }}</small>
                </div>

                <button type="submit" class="submit-btn">
                    <i class="fas fa-arrow-circle-right"></i> {{ __('messages.proceed_to_payment') }}
                </button>
            </form>

            <p class="form-footer-note">{{ __('messages.redirect_to_gateway_note') }}</p>
        </div>
    </div>
@endsection
