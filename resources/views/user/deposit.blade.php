<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INEX Trading | Initiate Deposit</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #0a0a0a;
            color: #e0e0e0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        .payment-form-container {
            background-color: #1e1e1e;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.5);
            width: 100%;
            max-width: 500px;
        }
        .payment-form-container h3 {
            color: #fff;
            text-align: center;
            margin-bottom: 25px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #b0b0b0;
            font-size: 14px;
        }
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #444;
            background-color: #29313c;
            color: #fff;
            font-size: 16px;
            box-sizing: border-box;
        }
        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #007bff; /* Au rangi yako ya msingi */
        }
        .submit-btn {
            width: 100%;
            padding: 12px;
            background-color: #007bff; /* Rangi ya kitufe chako */
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .submit-btn:hover {
            background-color: #0056b3;
        }
        .note {
            font-size: 12px;
            color: #7e8088;
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>

<body>
    <div class="payment-form-container">
        <h3>Initiate Your Deposit</h3>

        {{-- Hii ni kwa ajili ya kuonyesha makosa ya validation kutoka Laravel --}}
        @if ($errors->any())
            <div style="color: red; margin-bottom: 15px;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Hii ni kwa ajili ya kuonyesha ujumbe wa error kutoka kwa session --}}
        @if (session('error'))
            <div style="color: red; margin-bottom: 15px; background-color: rgba(255,0,0,0.1); padding: 10px; border-radius: 4px;">
                {{ session('error') }}
            </div>
        @endif


        <form method="POST" action="{{ route('coinpayments.create') }}">
            @csrf <div class="form-group">
                <label for="amount">Amount (USD):</label>
                <input type="number" id="amount" name="amount" value="{{ old('amount', '15.00') }}" step="0.01" required>
                <small class="note">This is the equivalent value in USD you wish to deposit.</small>
            </div>

            {{-- Ficha hizi kama hutaki mtumiaji abadilishe --}}
            <input type="hidden" name="currency1" value="USD"> {{-- Sarafu ya bei ya bidhaa yako --}}
            <input type="hidden" name="item_description" value="Account Deposit">

            <div class="form-group">
                <label for="buyer_email">Your Email:</label>
                <input type="email" id="buyer_email" name="buyer_email" value="{{ old('buyer_email', auth()->user() ? auth()->user()->email : '') }}" required>
                 <small class="note">Email address for transaction communication.</small>
            </div>

            <div class="form-group">
                <label for="coin">Pay With (Cryptocurrency):</label>
                <select id="coin" name="coin" required>
                    <option value="USDT.TRC20" {{ old('coin') == 'USDT.TRC20' ? 'selected' : '' }}>USDT (TRC20 Network)</option>
                    <option value="BTC" {{ old('coin') == 'BTC' ? 'selected' : '' }}>Bitcoin (BTC)</option>
                    <option value="LTCT" {{ old('coin') == 'LTCT' ? 'selected' : '' }}>Litecoin Testnet (LTCT for testing)</option>
                    <option value="ETH" {{ old('coin') == 'ETH' ? 'selected' : '' }}>Ethereum (ETH)</option>
                    {{-- Ongeza sarafu nyingine unazokubali --}}
                </select>
                <small class="note">Select the cryptocurrency you will use for payment.</small>
            </div>

            <button type="submit" class="submit-btn">Proceed to CoinPayments</button>
        </form>
        <p class="note">You will be redirected to CoinPayments to complete your transaction.</p>
    </div>

     {{-- Unaweza kuongeza scripts zako hapa --}}
    <script>
        // Mfano: Kuhakikisha thamani ya 'amount' inakuwa na desimali mbili
        const amountInput = document.getElementById('amount');
        if (amountInput) {
            amountInput.addEventListener('blur', function() {
                let value = parseFloat(this.value);
                if (!isNaN(value)) {
                    this.value = value.toFixed(2);
                }
            });
        }
    </script>
</body>
</html>
