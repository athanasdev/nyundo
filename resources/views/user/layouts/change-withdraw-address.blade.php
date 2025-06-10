{{-- resources/views/user/profile/change-withdrawal-address.blade.php --}}
@extends('user.layouts.app')

@section('title', __('messages.change_withdrawal_address') . ' - Soria10')

@push('styles')
<style>
    .change-address-card {
        max-width: 550px;
        margin-left: auto;
        margin-right: auto;
        margin-top: 30px;
        margin-bottom: 30px;
    }
    .alert-error, .alert-success, .alert-info {
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
    .alert-info {
        color: #848e9c;
        background-color: rgba(132, 142, 156, 0.1);
        border: 1px solid rgba(132, 142, 156, 0.3);
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
    .form-group input[type="password"] {
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
    [dir="rtl"] .submit-btn i { margin-right: 0; margin-left: 8px; }
    .card-title i { color: #f0b90b; margin-right: 8px; }
    [dir="rtl"] .card-title i { margin-right: 0; margin-left: 8px; }
    .current-address-display {
        background-color: #161a1e;
        padding: 10px 15px;
        border-radius: 4px;
        border: 1px solid #2b3139;
        color: #c1c8d1;
        font-size: 0.95em;
        word-break: break-all;
    }
</style>
@endpush

@section('content')
<div class="change-address-card card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-map-marker-alt"></i>
            {{ __('messages.change_withdrawal_address') }}
        </h3>
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

        @if(Auth::user()->withdrawal_address)
            <div class="form-group">
                <label>{{ __('messages.current_withdrawal_address') }}:</label>
                <div class="current-address-display">
                    {{ Auth::user()->withdrawal_address }}
                </div>
            </div>
        @else
            <div class="alert-info">
                {{ __('messages.no_withdrawal_address_set') }}
            </div>
        @endif

        <form method="POST" action="{{ route('withdrawal.address.update') }}">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="new_withdrawal_address">
                    {{ __('messages.new_usdt_trc20_address') }}
                </label>
                <input type="text" id="new_withdrawal_address" name="new_withdrawal_address"
                       value="{{ old('new_withdrawal_address') }}"
                       placeholder="{{ __('messages.placeholder_new_address') }}" required>
                <small class="note">
                    {{ __('messages.note_correct_address') }}
                </small>
            </div>

            <div class="form-group">
                <label for="withdrawal_pin">
                    {{ __('messages.confirm_with_pin') }}
                </label>
                <input type="password" name="withdrawal_pin" id="withdrawal_pin"
                       placeholder="{{ __('messages.placeholder_current_pin') }}" required>
                <small class="note">
                    {{ __('messages.note_pin_required') }}
                </small>
            </div>
            <button type="submit" class="submit-btn">
                <i class="fas fa-save"></i>
                {{ __('messages.update_address_button') }}
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
{{-- No specific JavaScript needed for this basic form submission. --}}
@endpush
