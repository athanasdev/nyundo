<div class="menubar-footer footer-fixed" style="background: #000000; backdrop-filter: blur(6px);">
    <div class="section mt-2 mb-2">
        @if (Session::has('impersonated_by'))
            <div
                style="background-color: #f8f8f8d9; color: #0c0970; padding: 10px; text-align: center; border-radius: 5px; margin-bottom: 20px; font-family: sans-serif;">
                <strong>Impersonating User:</strong> You are currently logged in as **{{ Auth::user()->username }}**.
                <a href="{{ route('impersonate.leave') }}"
                    style="color: #5d0303; text-decoration: underline; margin-left: 15px; font-weight: bold;">
                    Return to Admin Panel
                </a>
            </div>
        @endif

    <br>

    <ul class="inner-bar">
        <li class="active">
            <a href="{{ route('dashboard') }}">
                <i class="iconsax" icon-name="card-coin" style="font-size: 20px"></i>
                Markets </a>
        </li>
        <li>
            <a href="{{ route('assets') }}">
                <i class="iconsax" icon-name="wallet-4" style="font-size: 20px"></i>
                Assets </a>
        </li>
        <li>
            <a href="{{ route('order') }}">
                <i class="iconsax" icon-name="receipt-4" style="font-size: 20px"></i>
                Trades </a>
        </li>
        <li>
            <a href="{{ route('my-account') }}">
                <i class="iconsax" icon-name="user-1" style="font-size: 20px"></i>
                My Account </a>
        </li>
    </ul>
</div>
