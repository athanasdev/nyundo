@extends('user.layouts.app') {{-- Assuming this is your correct layout path --}}

@section('title', 'Setup Withdrawal Details - CoinTrades')

@push('styles')
<style>
    .setup-panel-card { /* Specific card class for this page */
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
        margin-top: 20px; /* Or adjust as per your layout's main content padding */
    }

    /* Error & Success Message Styling (consistent with other forms) */
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
    .alert-info { /* For informational messages like "Please set up..." */
        color: #f0b90b; /* Using accent color for info */
        background-color: rgba(240, 185, 11, 0.1);
        border-color: rgba(240, 185, 11, 0.3);
    }


    /* Form Group Styling (TradePro style) */
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
    .form-group input[type="email"] /* Just in case */ {
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
    /* For Laravel validation error highlighting */
    .form-control.is-invalid {
        border-color: #f6465d;
    }
    .invalid-feedback {
        display: block; /* Ensure it's visible */
        width: 100%;
        margin-top: .25rem;
        font-size: .875em; /* Bootstrap's default is 0.875em */
        color: #f6465d;
    }


    /* Helper Note Styling */
    .form-group small.note {
        font-size: 0.8em;
        color: #848e9c;
        display: block;
        margin-top: 6px;
    }

    /* Submit Button Styling (TradePro style) */
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

    /* Ensure card title icon matches accent color if not covered by layout */
    .card-title i {
        color: #f0b90b;
    }
</style>
@endpush

@section('content')
<div class="setup-panel-card card"> {{-- Base .card styles from layout, .setup-panel-card for specifics --}}
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-wallet"></i> Setup Withdrawal Address & PIN</h3>
    </div>
    <div class="card-body">
        {{-- Displaying Laravel Session Info/Error Messages --}}
        @if (session('info'))
            <div class="alert alert-info">{{ session('info') }}</div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        {{-- Displaying Laravel Validation Errors --}}
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

        <p class="mb-3 text-muted" style="font-size:0.9em; text-align:left;">
            Please set your USDT (TRC20) withdrawal address and a secure withdrawal PIN.
            This PIN will be required for all future withdrawals.
        </p>

        <form method="POST" action="{{ route('withdraw.setup.store') }}">
            @csrf

            <div class="form-group">
                <label for="withdrawal_address">USDT (TRC20) Withdrawal Address:</label>
                <input type="text" id="withdrawal_address" name="withdrawal_address"
                       class="form-control @error('withdrawal_address') is-invalid @enderror" {{-- Added form-control for Bootstrap compatibility if used by error styling --}}
                       value="{{ old('withdrawal_address', $currentAddress ?? '') }}"
                       placeholder="Enter your USDT TRC20 wallet address" required>
                @error('withdrawal_address')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
                <small class="note">Ensure this is a valid TRC20 address for USDT.</small>
            </div>

            <div class="form-group">
                <label for="withdrawal_pin">Create Withdrawal PIN:</label>
                <input type="password" id="withdrawal_pin" name="withdrawal_pin"
                       class="form-control @error('withdrawal_pin') is-invalid @enderror"
                       placeholder="Enter a 4-6 digit PIN" required
                       minlength="4" maxlength="6" pattern="\d*">
                @error('withdrawal_pin')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
                <small class="note">Choose a secure PIN (e.g., 4-6 digits, numbers only).</small>
            </div>

            <div class="form-group">
                <label for="withdrawal_pin_confirmation">Confirm Withdrawal PIN:</label>
                <input type="password" id="withdrawal_pin_confirmation" name="withdrawal_pin_confirmation"
                       class="form-control" {{-- No need for @error here, 'confirmed' rule handles it on withdrawal_pin --}}
                       placeholder="Re-enter your PIN" required>

            </div>

            <button type="submit" class="submit-btn mt-3"> {{-- Added mt-3 for spacing --}}
                <i class="fas fa-save"></i> Save Details
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>

</script>
@endpush
