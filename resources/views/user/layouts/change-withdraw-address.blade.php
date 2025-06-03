{{-- resources/views/user/profile/change-withdrawal-address.blade.php --}}
@extends('user.layouts.app')

@section('title', __('messages.change_withdrawal_address') . ' - Soria10')

@push('styles')
<style>
    .change-address-card {
        max-width: 550px; /* Adjusted width */
        margin-left: auto;
        margin-right: auto;
        margin-top: 30px; /* Added some top margin */
        margin-bottom: 30px;
    }

    /* Reusing alert and form styles from your previous example */
    .alert-error,
    .alert-success,
    .alert-info { /* Added info for current address display */
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
        color: #848e9c; /* Adjusted for info */
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

    .submit-btn:hover {
        background-color: #d8a40a;
    }

    .submit-btn:active {
        transform: scale(0.98);
    }

    .submit-btn i {
        margin-right: 8px; /* RTL: margin-left might be needed */
    }
    [dir="rtl"] .submit-btn i {
        margin-right: 0;
        margin-left: 8px;
    }

    .card-title i {
        color: #f0b90b;
        margin-right: 8px; /* RTL: margin-left */
    }
    [dir="rtl"] .card-title i {
        margin-right: 0;
        margin-left: 8px;
    }
    .current-address-display {
        background-color: #161a1e;
        padding: 10px 15px;
        border-radius: 4px;
        border: 1px solid #2b3139;
        color: #c1c8d1;
        font-size: 0.95em;
        word-break: break-all; /* Break long addresses */
    }
</style>
@endpush

@section('content')
<div class="change-address-card card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-map-marker-alt"></i>
            {{ __('messages.change_withdrawal_address_title') ?? 'Change Withdrawal Address' }}
        </h3>
    </div>
    <div class="card-body">

        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert-error">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert-error">
                <strong>{{ __('messages.errors_found') ?? 'Please correct the following errors:' }}</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(Auth::user()->withdrawal_address)
            <div class="form-group">
                <label>{{ __('messages.current_withdrawal_address') ?? 'Current Withdrawal Address:' }}</label>
                <div class="current-address-display">
                    {{ Auth::user()->withdrawal_address }}
                </div>
            </div>
        @else
            <div class="alert-info">
                {{ __('messages.no_withdrawal_address_set') ?? 'You have not set a withdrawal address yet.' }}
            </div>
        @endif

        <form method="POST" action="{{ route('withdrawal.address.update') }}">
            @csrf
            @method('PATCH') {{-- Or PUT, depending on your route definition conventions --}}

            <div class="form-group">
                <label for="new_withdrawal_address">
                    {{ __('messages.new_withdrawal_address_label') ?? 'New Withdrawal Address (USDT TRC20)' }}
                </label>
                <input type="text" id="new_withdrawal_address" name="new_withdrawal_address"
                       value="{{ old('new_withdrawal_address') }}"
                       placeholder="{{ __('messages.enter_new_address_placeholder') ?? 'Enter your new USDT TRC20 address' }}" required>
                <small class="note">
                    {{ __('messages.ensure_correct_address_note') ?? 'Please ensure the address is correct and on the TRC20 network.' }}
                </small>
            </div>

            <div class="form-group">
                <label for="withdrawal_pin">
                    {{ __('messages.confirm_withdrawal_pin_label') ?? 'Confirm with Withdrawal PIN' }}
                </label>
                <input type="password" name="withdrawal_pin" id="withdrawal_pin"
                       placeholder="{{ __('messages.enter_pin_placeholder') ?? 'Enter your current withdrawal PIN' }}" required>
                <small class="note">
                    {{ __('messages.pin_confirmation_note') ?? 'Your withdrawal PIN is required to change the address.'}}
                </small>
            </div>

            <button type="submit" class="submit-btn">
                <i class="fas fa-save"></i>
                {{ __('messages.update_address_button') ?? 'Update Address' }}
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
{{-- No specific JavaScript needed for this basic form submission. --}}
{{-- You could add client-side validation for the address format if desired. --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form[action="{{ route('withdrawal.address.update') }}"]');
        const newAddressInput = document.getElementById('new_withdrawal_address');

        if (form && newAddressInput) {
            form.addEventListener('submit', function(event) {
                const addressValue = newAddressInput.value;
                if (!addressValue.startsWith('T') || addressValue.length < 34) {
                    // This is a very basic check, real validation should be on the backend
                    // alert('Please enter a valid TRC20 address.');
                    // event.preventDefault(); // Stop submission
                    // You might want to display an error message near the input instead of an alert.
                }
            });
        }
    });
</script>
@endpush
