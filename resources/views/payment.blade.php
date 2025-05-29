<!DOCTYPE html>
<html>
<head>
    <title>Create Payment</title>
</head>
<body>
    <h1>Make a Payment</h1>

    <form action="{{ url('/nowpayments/create') }}" method="POST">
        @csrf

        <label>Amount (USD):</label><br>
        <input type="number" step="0.01" name="price_amount" ><br><br>

        <label>Price Currency (e.g., usd):</label><br>
        <input type="text" name="price_currency" value="usd"><br><br>

        <label>Pay Currency (e.g., btc):</label><br>
        <input type="text" name="pay_currency" value="usdttrc20"><br><br>

        <label>Order ID:</label><br>
        <input type="text" name="order_id" ><br><br>

        <label>Order Description:</label><br>
        <input type="text" name="order_description" value="deposit"><br><br>

        <label>IPN Callback URL:</label><br>
        <input type="text" name="ipn_callback_url" value="http://localhost:8000/ipn-callback"><br><br>

        <button type="submit">Submit Payment</button>
    </form>

</body>
</html>
