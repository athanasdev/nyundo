{{-- resources/views/user/profile/withdrawal-setup.blade.php --}}
@extends('user.layouts.app')

@section('title', __('messages.setup_withdrawal_details_title') . ' - Soria10')

@push('styles')
<style>
    .setup-panel-card {
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
        margin-top: 20px;
    }
    .alert-error, .alert-info, .alert-success {
        padding: 12px 15px;
        margin-bottom: 20px;
        border-radius: 4px;
        font-size: 0.9em;
        border: 1px solid transparent;
    }
    .alert-error {
        color: #f6465d;
        background-color: rgba(246, 70, 93, 0.1);
        border-color: rgba(246, 70, 93, 0.3);
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
        border-color: rgba(14, 203, 129, 0.3);
    }
    .alert-info {
        color: #f0b90b;
        background-color: rgba(240, 185, 11, 0.1);
        border-color: rgba(240, 185, 11, 0.3);
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
    .form-group input[type="text"],
    .form-group input[type="password"],
    .form-group input[type="email"] {
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
    .form-group input:focus {
        outline: none;
        border-color: #f0b90b;
        box-shadow: 0 0 0 3px rgba(240, 185, 11, 0.25);
    }
    .form-control.is-invalid {
        border-color: #f6465d;
    }
    .invalid-feedback {
        display: block;
        width: 100%;
        margin-top: .25rem;
        font-size: .875em;
        color: #f6465d;
    }
    .form-group small.note {
        font-size: 0.8em;
        color: #848e9c;
        display: block;
        margin-top: 6px;
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
    .submit-btn:hover { background-color: #d8a40a; }
    .submit-btn:active { transform: scale(0.98); }
    .submit-btn i { margin-right: 8px; }
    .card-title i { color: #f0b90b; }
</style>
@endpush

@section('content')
    <div class="setup-panel-card card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-wallet"></i> {{ __('messages.setup_withdrawal_address_pin_title') }}</h3>
        </div>
        <div class="card-body">
            @if (session('info'))
                <div class="alert alert-info flex items-center space-x-2">
                    <span>ℹ️</span>
                    <span>{{ session('info') }}</span>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success flex items-center space-x-2">
                    <span>✅</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="alert-error flex items-center space-x-2">
                    <span>❌</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert-error flex items-start space-x-2">
                    <span class="mt-1">⚠️</span>
                    <ul class="list-none m-0 p-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <p class="mb-3 text-muted" style="font-size:0.9em; text-align:left;">
                {{ __('messages.setup_form_instruction_1') }}
                {{ __('messages.setup_form_instruction_2') }}
            </p>

            <form method="POST" action="{{ route('withdraw.setup.store') }}">
                @csrf
                <div class="form-group">
                    <label for="withdrawal_address">{{ __('messages.usdt_trc20_address_label') }}</label>
                    <input type="text" id="withdrawal_address" name="withdrawal_address"
                           class="form-control @error('withdrawal_address') is-invalid @enderror"
                           value="{{ old('withdrawal_address', $currentAddress ?? '') }}"
                           placeholder="{{ __('messages.placeholder_usdt_address') }}" required>
                    @error('withdrawal_address')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                    <small class="note">{{ __('messages.note_valid_trc20_address') }}</small>
                </div>

                <div class="form-group">
                    <label for="withdrawal_pin">{{ __('messages.create_withdrawal_pin_label') }}</label>
                    <input type="password" id="withdrawal_pin" name="withdrawal_pin"
                           class="form-control @error('withdrawal_pin') is-invalid @enderror"
                           placeholder="{{ __('messages.placeholder_4_6_digit_pin') }}" required minlength="4" maxlength="6" pattern="\d*">
                    @error('withdrawal_pin')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                    <small class="note">{{ __('messages.note_secure_pin') }}</small>
                </div>

                <div class="form-group">
                    <label for="withdrawal_pin_confirmation">{{ __('messages.confirm_withdrawal_pin_label') }}</label>
                    <input type="password" id="withdrawal_pin_confirmation" name="withdrawal_pin_confirmation"
                           class="form-control"
                           placeholder="{{ __('messages.placeholder_reenter_pin') }}" required>
                </div>

                <button type="submit" class="submit-btn mt-3">
                    <i class="fas fa-save"></i> {{ __('messages.save_details_button') }}
                </button>
            </form>
        </div>
    </div>
@endsection
