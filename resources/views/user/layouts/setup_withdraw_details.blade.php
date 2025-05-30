@extends('layouts.app')

@section('title', 'Setup Withdrawal Details - CoinTrades')

@push('styles')
    {{-- You can reuse the styles from withdraw_blade.php or deposit_blade.php --}}
    <style>
        .setup-panel-card {
            max-width: 600px; margin-left: auto; margin-right: auto; margin-top: 20px;
        }
        /* ... other necessary styles from your existing forms ... */
    </style>
@endpush

@section('content')
<div class="setup-panel-card card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-wallet"></i> Setup Withdrawal Address & PIN</h3>
    </div>
    <div class="card-body">
        @if ($errors->any())
            {{-- Error display --}}
        @endif
        @if (session('status'))
            {{-- Success/Status display --}}
        @endif

        <p class="mb-3 text-muted" style="font-size:0.9em;">
            Please set your USDT (TRC20) withdrawal address and a secure withdrawal PIN.
            This PIN will be required for all future withdrawals.
        </p>

        <form method="POST" action="{{ route('withdraw.setup.store') }}"> {{-- Define this route --}}
            @csrf

            <div class="form-group">
                <label for="withdrawal_address">USDT (TRC20) Withdrawal Address:</label>
                <input type="text" id="withdrawal_address" name="withdrawal_address"
                       value="{{ old('withdrawal_address') }}"
                       placeholder="Enter your USDT TRC20 wallet address" required>
                <small class="note">Ensure this is a valid TRC20 address for USDT.</small>
            </div>

            <div class="form-group">
                <label for="withdrawal_pin">Create Withdrawal PIN:</label>
                <input type="password" id="withdrawal_pin" name="withdrawal_pin"
                       placeholder="Enter a 4-6 digit PIN" required
                       minlength="4" maxlength="6" pattern="\d*"> {{-- Example: only digits --}}
                <small class="note">Choose a secure PIN (e.g., 4-6 digits).</small>
            </div>

            <div class="form-group">
                <label for="withdrawal_pin_confirmation">Confirm Withdrawal PIN:</label>
                <input type="password" id="withdrawal_pin_confirmation" name="withdrawal_pin_confirmation"
                       placeholder="Re-enter your PIN" required>
            </div>

            <button type="submit" class="submit-btn">
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
