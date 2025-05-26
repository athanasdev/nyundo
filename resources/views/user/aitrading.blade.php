<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover">
    <title>Nyundo | smart trade and earn</title>

    <link rel="shortcut icon" href="{{ asset('images/logo/favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="{{ asset('client/css/styles.css') }}" />
    <link rel="stylesheet" href=" /css/swiper-bundle.min.css">
    <link href="https://iconsax.gitlab.io/i/icons.css" rel="stylesheet">
    <link rel="stylesheet" href=" /css/countrySelect.css">

    <style>
        .account-mode {
            background: #8b9cb5;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: 700;
        }

        /* Styles from the invest.blade.php that might conflict or need to be present */
        .badge {
            display: inline-block;
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            font-weight: 700;
            line-height: 1;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.25rem;
        }

        .bg-success {
            background-color: #198754 !important;
        }

        .bg-danger {
            background-color: #dc3545 !important;
        }

        .bg-info {
            background-color: #0dcaf0 !important;
        }

        .bg-primary {
            background-color: #0d6efd !important;
        }

        .alert {
            position: relative;
            padding: 1rem 1rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: 0.25rem;
        }

        .alert-success {
            color: #0f5132;
            background-color: #d1e7dd;
            border-color: #badbcc;
        }

        .alert-danger {
            color: #842029;
            background-color: #f8d7da;
            border-color: #f5c2c7;
        }

        .alert-info {
            color: #055160;
            background-color: #cff4fc;
            border-color: #b6effb;
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: 0.25rem;
        }

        .card-header {
            padding: 0.5rem 1rem;
            margin-bottom: 0;
            background-color: rgba(0, 0, 0, 0.03);
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        }

        .card-body {
            flex: 1 1 auto;
            padding: 1rem 1rem;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            vertical-align: top;
            border-color: #dee2e6;
        }

        .table th,
        .table td {
            padding: 0.5rem 0.5rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .table-striped>tbody>tr:nth-of-type(odd)>* {
            --bs-table-accent-bg: var(--bs-table-striped-bg);
            color: var(--bs-table-striped-color);
        }

        .text-danger {
            color: #dc3545 !important;
        }

        .form-label {
            margin-bottom: 0.5rem;
        }

        .form-control {
            display: block;
            width: 100%;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border-radius: 0.25rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .btn {
            display: inline-block;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            text-align: center;
            text-decoration: none;
            vertical-align: middle;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
            background-color: transparent;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            border-radius: 0.25rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .btn-primary {
            color: #fff;
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .mb-3 {
            margin-bottom: 1rem !important;
        }

        .mb-4 {
            margin-bottom: 1.5rem !important;
        }
    </style>
    {{-- <script src="//code.jivosite.com/widget/Cr6CmJv8z9" async></script> --}}

</head>

<body style="overflow-x: hidden">


    <div class="preloader preload-container">
        <div class="preload-logo " style="display: flex; flex-direction: column; align-items: center;">
            <div class="lds-ring" style="margin-bottom: 10px">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>

        </div>
    </div>
    <style>
        .fixed-top {
            display: none;
        }

        .ai-info {
            background: #89898930;
            color: #fff;
            padding: 10px;
            border-radius: 10px;
        }

        .ai-area {
            padding: 15px;
            margin-top: 10px;
            border: 1px solid #7e808830;
            border-radius: 10px;
        }

        .more-coins {
            background: #29313c;
            padding: 2px 4px;
            border-radius: 5px;
        }

        .subscribe-btn {
            background: #16262f;
            color: #fbfdff;
            font-weight: 700;
            font-size: 14px;
            width: 100%;
            border-radius: 10px;
            margin-top: 20px;
        }

        .inactive-subscription {
            background: #f6465d30;
            color: #f6465d;
            padding: 4px 10px;
            font-weight: 700;
            border-radius: 4px;
        }

        .active-subscription {
            background: #1dbf6f30;
            color: #1dbf6f;
            padding: 4px 10px;
            font-weight: 700;
            border-radius: 4px;
        }
    </style>
    <div class="tp-80 pb-80 mx-2">
        <div class="header fixed-top bg-surface d-flex justify-content-center align-items-center">
            <a href="#" class="left back-btn"><i class="iconsax back-icon-ct" icon-name="arrow-left"></i></a>
            <h3 style="font-size:16px!important;font-weight:600">AI Trading Bot</h3>
            <div style="position:absolute;right:20px">
                <a href="#" class="system-mode-toggle">

                </a>
            </div>
        </div>

        <div class="tf-container">
            <div class="pt-55" style="margin-bottom: 20px">
                <img src="{{ asset('images/trading_bot2.png') }}" style="border-radius: 10px" alt="">
            </div>
            <div class="ai-info d-row" style="column-gap:4px">
                <h2>AI Trading</h2>
            </div>

            <div class="ai-area">
                <div class="">
                    <div class="d-row align-center justify-space">
                        <div class="d-col">
                            <span style="color:#fff;font-weight:600;font-size:16px">Automation Trading
                                Bot</span>

                        </div>
                        <span id="toggle-trading-form" class="inactive-subscription"
                            style="cursor: pointer;">Activate</span>
                    </div>
                    <div class="hr"></div>
                    <div class="">

                        <div id="trading-section" class="container mt-4">

                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            @if (session('info'))
                                <div class="alert alert-info">{{ session('info') }}</div>
                            @endif

                            <div class="card mb-4">
                                <div class="card-header">Current Siginal Status</div>
                                <div class="card-body">
                                    @if ($activeGameSetting)
                                        <p>Siginal Time Range</p>
                                        {{-- <p><strong>Siginal Active:</strong> <span class="badge bg-success">YES</span></p> --}}
                                        <p><strong>Trading Window:</strong>
                                            {{ \Carbon\Carbon::parse($activeGameSetting->start_time)->format('h:i A') }}
                                            -
                                            {{ \Carbon\Carbon::parse($activeGameSetting->end_time)->format('h:i A') }}
                                        </p>
                                        <p><strong>Daily Earning Percentage:</strong>
                                            {{ number_format($activeGameSetting->earning_percentage, 2) }}%</p>
                                        <p><strong>Your Current Balance:</strong>
                                            ${{ number_format(auth()->user()->balance, 2) }}
                                        </p>

                                        <hr>
                                        <h4>Make a trading</h4>
                                        <form action="{{ route('user.game.invest') }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="amount" class="form-label">Trade Amount (USD)</label>
                                                <input type="number" step="0.01" name="amount" id="amount"
                                                    class="form-control" required min="10"
                                                    max="{{ auth()->user()->balance }}">
                                                @error('amount')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <button type="submit" class="btn btn subscribe-btn">Trade Now</button>
                                        </form>
                                    @else
                                        <p class="text-warning">The siginal is currently closed for trade or no
                                            active siginal
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">Your Active Order</div>
                                <div class="card-body">
                                    @if ($userInvestments->isEmpty())
                                        <p>You have no active order yet.</p>
                                    @else
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Amount</th>
                                                        <th>Daily Profit</th>
                                                        <th>Status</th>
                                                        <th>Trading Date</th>
                                                        <th>Next Payout Eligible</th>
                                                        <th>Total Profit Paid</th>
                                                        <th>Principal Returned</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($userInvestments as $investment)
                                                        <tr>
                                                            <td>{{ $investment->id }}</td>
                                                            <td>${{ number_format($investment->amount, 2) }}</td>
                                                            <td>${{ number_format($investment->daily_profit_amount, 2) }}
                                                            </td>
                                                            <td><span
                                                                    class="badge bg-primary">{{ $investment->status }}</span>
                                                            </td>
                                                            <td>{{ $investment->investment_date->format('Y-m-d') }}
                                                            </td>
                                                            <td>
                                                                @if ($investment->next_payout_eligible_date)
                                                                    {{ $investment->next_payout_eligible_date->format('Y-m-d') }}
                                                                @else
                                                                    N/A
                                                                @endif
                                                            </td>
                                                            <td>${{ number_format($investment->total_profit_paid_out, 2) }}
                                                            </td>
                                                            <td>
                                                                @if ($investment->principal_returned)
                                                                    <span class="badge bg-success">Yes</span>
                                                                @else
                                                                    <span class="badge bg-danger">No</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="mt-3">

                    </div>

                    <div class="hr">

                    </div>
                    <hr>

                    <div class="d-col">
                        <span style="color: #fff; font-weight:600; font-size:16px">Why Choose Our AI Trading
                            Bot?</span>

                        <div class="d-row" style="column-gap:6px; margin-top:10px; color:white">
                            <i class="iconsax" icon-name="bar-graph-3" style="font-size: 20px"></i>
                            <span>Trade smarter, not harder. Our AI bot executes trades automatically—even while you
                                sleep—so you never miss an opportunity due to timing or hesitation.</span>
                        </div>

                        <div class="d-row" style="column-gap:6px; margin-top:10px; color:white">
                            <i class="iconsax" icon-name="pie-chart" style="font-size: 20px"></i>
                            <span>Make decisions with precision. Built for accuracy, the bot minimizes human error and
                                ensures each trade is calculated and strategic.</span>
                        </div>

                        <div class="d-row" style="column-gap:6px; margin-top:10px; color:white">
                            <i class="iconsax" icon-name="trend-up" style="font-size: 20px"></i>
                            <span>Grow your portfolio with confidence. Our AI is constantly optimizing for maximum
                                returns and reduced risk—helping you stay on the path to long-term success.</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @include('user.components.footer');
    @include('user.common.script');
    <script>
        const handleSwalButtons = () => {
            const actions = document.querySelector('.swal2-actions');
            if (!actions) return;

            const buttons = actions.querySelectorAll('button');
            const visibleButtons = Array.from(buttons).filter(btn => btn.style.display !== 'none');

            buttons.forEach(btn => btn.classList.remove('only-visible-button'));

            if (visibleButtons.length === 1) {
                visibleButtons[0].classList.add('only-visible-button');
            }
        };

        const swalConfig = Swal.mixin({
            didRender: () => {
                handleSwalButtons();
            }
        });

        window.Swal = swalConfig;

        function copy(text, message) {
            navigator.clipboard.writeText(text).then(
                function() {
                    Swal.fire({
                        icon: 'success',
                        title: message,
                        showConfirmButton: true,
                        confirmButtonText: 'Okay',
                    });
                },
                function(err) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error copying text',
                        text: err,
                        showConfirmButton: true,
                        confirmButtonText: 'Okay',
                    });
                });
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButton = document.getElementById('toggle-trading-form');
            const tradingSection = document.getElementById('trading-section');

            toggleButton.addEventListener('click', function() {
                const isVisible = tradingSection.style.display === 'block';
                tradingSection.style.display = isVisible ? 'none' : 'block';
                toggleButton.textContent = isVisible ? 'Inactive' : 'Close';
            });
        });
    </script>

</body>

</html>
