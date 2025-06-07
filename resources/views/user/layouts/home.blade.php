@extends('user.layouts.app')

@section('title', 'Assets Dashboard - Soria10')

@push('styles')
    <style>
        /* Styles from your Nyundo Traders example, adapted for the card */
        .coins-table {
            width: 100%;
            border-collapse: collapse;
            color: #eaecef;
            /* Ensure text is visible */
        }

        .coins-table th,
        .coins-table td {
            padding: 10px 8px;
            /* Adjusted padding */
            text-align: left;
            border-bottom: 1px solid #2b3139;
            /* Match card border */
            font-size: 0.9em;
        }

        .coins-table th {
            color: #848e9c;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.8em;
        }

        .coins-table td {
            vertical-align: middle;
        }

        .coins-table a {
            text-decoration: none;
            /* This removes the underline */
            color: inherit;
            /* This makes the text inside the link keep its original color */
        }

        .coins-table .coin-market-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .coins-table .coin-market-info img {
            height: 28px;
            /* Adjusted icon size */
            width: 28px;
            background: #fff;
            /* If icons have transparent parts */
            border-radius: 50%;
        }

        .coins-table .coin-name-full {
            font-weight: 500;
            color: #eaecef;
            font-size: 0.95em;
        }

        .coins-table .coin-volume {
            font-size: 0.8em;
            color: #848e9c;
        }

        .coins-table .price-col {
            text-align: right;
            font-weight: 500;
        }

        .coins-table .percent-col {
            text-align: right;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 4px;
            /* Space between arrow and text */
        }

        .coins-table .percent-col svg {
            /* Ensure SVGs are sized correctly */
            width: 14px;
            height: 14px;
            vertical-align: middle;
        }

        .coins-table .success-color span {
            color: #0ecb81;
        }

        .coins-table .error-color span {
            color: #f6465d;
        }

        /* Override for card-body padding if table is direct child */
        .card-body.no-padding {
            padding: 0;
        }

        .coins-list .coin-item {
            /* Keep original coin item styles if used elsewhere or as fallback */
            /* ... your existing .coin-item styles ... */
        }
    </style>
@endpush

@section('content')
    <div id="assets-page-content">
        <div class="dashboard-grid">
            <div class="main-content">

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="fab fa-bitcoin"></i>
                            Top Cryptocurrencies
                        </div>
                    </div>
                    <div class="card-body no-padding"> {{-- Remove padding if table touches edges --}}
                        <table class="coins-table" id="realtimeCoinsTable">
                            <thead>
                                <tr>
                                    <th style="text-align:center; width: 5%;">#</th>
                                    <th style="width: 35%;">Market</th>
                                    <th style="text-align: right; width: 30%;">Price</th>
                                    <th style="text-align: right; width: 30%;">24h % Change</th>
                                </tr>
                            </thead>
                            <tbody id="coinsTableBody">
                                {{-- Rows will be injected by JavaScript --}}
                                <tr>
                                    <td colspan="4" style="text-align:center; padding: 20px; color: #848e9c;">Connecting
                                        to live market data...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- <div class="sidebar">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="fas fa-bolt"></i>
                            Quick Actions
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="quick-actions">
                            <a href="{{ route('deposit.form') }}" class="action-btn buy">
                                <i class="fas fa-arrow-down"></i>
                                Depost
                            </a>
                            @php
                                $user = Auth::user();
                                $needsSetup = is_null($user->withdrawal_address) || is_null($user->withdrawal_pin_hash);
                            @endphp

                            <a href="{{ $needsSetup ? route('withdraw.setup') : route('withdraw') }}"
                                class="action-btn sell">
                                <i class="fas fa-arrow-right"></i>
                                Withdraw
                            </a>

                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="fas fa-wallet"></i>
                            Portfolio
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="portfolioListContainer">
                            <p style="padding: 10px 0; text-align: center; color: #848e9c;">Loading portfolio...</p>
                        </div>
                    </div>
                </div>
            </div> --}}

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // SVG arrows from your script
        const upArrowSVG =
            `<svg fill="none" height="16" viewBox="0 0 20 20" width="16" xmlns="http://www.w3.org/2000/svg"><path d="m13.207 8c-.3751-.37494-.8837-.58557-1.414-.58557-.5304 0-1.039.21063-1.414.58557l-5.58603 5.586c-.27962.2797-.47003.636-.54717 1.0239-.07713.3879-.03752.79.11382 1.1554s.40761.6777.73643.8975.71542.3371 1.11092.3372h11.17203c.3955-.0001.7821-.1174 1.1109-.3372s.5851-.5321.7364-.8975c.1514-.3654.191-.7675.1138-1.1554-.0771-.3879-.2675-.7442-.5471-1.0239z" fill="#26de81" transform="rotate(180 10 10)"></path></svg>`;
        const downArrowSVG =
            `<svg fill="none" height="16" viewBox="0 0 20 20" width="16" xmlns="http://www.w3.org/2000/svg"><path d="m19.434 8.235c-.1513-.36556-.4077-.67802-.7366-.89785-.329-.21984-.7158-.33717-1.1114-.33715h-11.172c-.3955.00008-.78209.11743-1.11091.3372s-.5851.53209-.73644.89749-.19095.76747-.11381 1.15537c.07713.38791.26754.74420.54716 1.02394l5.586 5.586c.3751.3749.8837.5856 1.414.5856s1.0389-.2107 1.414-.5856l5.586-5.586c.2797-.2796.4702-.63584.5474-1.02369.0773-.38785.0378-.78989-.1134-1.15531z" fill="#ff231f"></path></svg>`;

        const symbolsToStream = [
            "BTCUSDT", "ETHUSDT", "BNBUSDT", "SOLUSDT", "XRPUSDT", "ADAUSDT", "DOGEUSDT", "AVAXUSDT", "DOTUSDT",
            "LINKUSDT", "LTCUSDT", "TRXUSDT", "SHIBUSDT", "UNIUSDT", "BCHUSDT", "ICPUSDT", "XLMUSDT",
            "ATOMUSDT", "ETCUSDT"
        ].filter((value, index, self) => self.indexOf(value) === index);

        // This object will store the latest data for each coin from the WebSocket
        let liveCoinData = {};

        // Initial portfolio data (values will be updated by live prices)
        let assetPagePortfolioData = [{
                symbol: 'BTC',
                amount: 0.5,
                value: 0,
                avgBuyPrice: 40000
            },
            {
                symbol: 'ETH',
                amount: 2.5,
                value: 0,
                avgBuyPrice: 2800
            },
            {
                symbol: 'BNB',
                amount: 10,
                value: 0,
                avgBuyPrice: 300
            }
        ];

        const coinsTableBodyEl = document.getElementById('coinsTableBody');
        const portfolioListEl = document.getElementById('portfolioListContainer');

        function getCoinIconPath(symbolBase) {
            // Assuming icons are in public/icons/ and named like btc.png, eth.png
            // You might need a more robust mapping if names differ significantly
            return `{{ asset('icons/') }}/${symbolBase.toLowerCase()}.png`;
        }

        function initializeCoinsTable() {
            if (!coinsTableBodyEl) return;
            let tableHtml = '';
            symbolsToStream.forEach((fullSymbol, index) => {
                const symbolBase = fullSymbol.replace('USDT', '');
                const coinName = symbolBase; // Simplified name, can be enhanced
                const iconPath = getCoinIconPath(symbolBase);

                // Initialize liveCoinData entry
                liveCoinData[symbolBase] = {
                    price: 0,
                    change: 0,
                    volume: 0,
                    name: coinName, // Store a display name
                    iconPath: iconPath // Store icon path
                };

                tableHtml += `
                <tr style="height: 45px" id="row-${symbolBase}">
                    <td style="vertical-align:middle;text-align:center">${index + 1}</td>
                    <td>
                        <a href="#"> {{-- Replace with actual link: {{ route('explore.quote', ['symbol' => $symbolBase]) }} --}}
                            <div class="coin-market-info">
                                <img src="${iconPath}"
                                     style="height: 28px;width:28px;background:#ffffff;border-radius:50%"
                                     alt="${symbolBase}"
                                     onerror="this.style.display='none'; this.parentElement.insertAdjacentHTML('afterbegin', '<div class=\\'coin-icon ${symbolBase.toLowerCase()}\\'>${symbolBase.substring(0,3)}</div>')">
                                <div style="display:flex;flex-direction:column">
                                    <span style="font-weight:500;color:#eaecef;font-size:12px">${symbolBase}/USDT</span>
                                    <span style="font-size: 11px;color:#848e9c" class="${symbolBase}-volume">0.00</span>
                                </div>
                            </div>
                        </a>
                    </td>
                    <td style="text-align: right;vertical-align:middle">
                        <span class="${symbolBase}-price" style="color: #eaecef;font-weight:500">0.00 USDT</span>
                    </td>
                    <td style="text-align: right;vertical-align:middle">
                        <span style="font-size: 11px;column-gap:2px;display: flex;flex-direction: row;align-items: center;justify-content: flex-end;"
                              class="${symbolBase}-percent success-color">
                              ${upArrowSVG}<span>0.00%</span>
                        </span>
                    </td>
                </tr>
            `;
            });
            coinsTableBodyEl.innerHTML = tableHtml;
        }

        function updateElementsByClass(className, newValue, isHtml = false) {
            const elements = document.getElementsByClassName(className);
            Array.from(elements).forEach(element => {
                if (isHtml) {
                    element.innerHTML = newValue;
                } else {
                    element.textContent = newValue;
                }
            });
        }

        function updateClassList(className, addClassName, removeClassName) {
            const elements = document.getElementsByClassName(className);
            Array.from(elements).forEach(element => {
                element.classList.add(addClassName);
                element.classList.remove(removeClassName);
            });
        }

        function renderPortfolio() {
            if (!portfolioListEl) return;
            let totalPortfolioValue = 0;

            portfolioListEl.innerHTML = assetPagePortfolioData.map(item => {
                const currentCoinLive = liveCoinData[item.symbol];
                const currentPrice = currentCoinLive ? parseFloat(currentCoinLive.price) : (item.value / (item
                    .amount || 1));

                item.value = currentPrice * item.amount;
                totalPortfolioValue += item.value;

                const pnl = (currentPrice - item.avgBuyPrice) * item.amount;
                const pnlPercentage = (item.avgBuyPrice * item.amount) !== 0 ? (pnl / (item.avgBuyPrice * item
                    .amount)) * 100 : 0;
                const pnlClass = pnl >= 0 ? 'positive' : 'negative';
                const pnlArrow = pnl >= 0 ? upArrowSVG : downArrowSVG;

                return `
            <div class="portfolio-item">
                <div>
                    <strong>${item.symbol}</strong> (${item.amount} coins)<br>
                    <small style="color: #848e9c;">Avg. Buy: ${formatCurrency(item.avgBuyPrice)}</small>
                </div>
                <div style="text-align: right;">
                    <strong>${formatCurrency(item.value)}</strong><br>
                    <small class="${pnlClass}" style="display:flex; align-items:center; justify-content:flex-end; gap:2px;">
                        ${pnlArrow}
                        <span>${pnl >= 0 ? '+' : ''}${formatCurrency(pnl, 2, 2)} (${formatPercentage(pnlPercentage)})</span>
                    </small>
                </div>
            </div>
        `;
            }).join('');

            const simulatedTodayPnl = assetPagePortfolioData.reduce((sum, item) => {
                const currentCoinLive = liveCoinData[item.symbol];
                const currentPrice = currentCoinLive ? parseFloat(currentCoinLive.price) : (item.value / (item
                    .amount || 1));
                return sum + ((currentPrice - item.avgBuyPrice) * item.amount * 0.01); // Example P&L
            }, 0);
            updateGlobalHeaderDisplay(totalPortfolioValue, simulatedTodayPnl);
        }

        document.addEventListener('DOMContentLoaded', function() {
            initializeCoinsTable(); // Create table structure with placeholders
            renderPortfolio(); // Initial render of portfolio (will show 0 values until prices update)

            const streamName = symbolsToStream.map(s => `${s.toLowerCase()}@ticker`).join('/');
            const ws = new WebSocket(`wss://stream.binance.com:9443/stream?streams=${streamName}`);

            ws.onopen = () => {
                console.log("WebSocket connected to Binance stream.");
                if (coinsTableBodyEl.firstChild && coinsTableBodyEl.firstChild.textContent.includes(
                        "Connecting")) {
                    // Optionally update the "Connecting..." message or clear it if table rows are already there.
                    // Since initializeCoinsTable now pre-populates, this might not be needed or could be more specific.
                }
            };

            ws.onmessage = (event) => {
                const response = JSON.parse(event.data);
                const element = response.data;
                if (!element || !element.s) return;

                const symbolBase = element.s.replace('USDT', '');
                const price = parseFloat(element.c);
                const priceChangePercent = parseFloat(element.P);
                const volume = parseFloat(element.v); // Base asset volume

                // Update liveCoinData store
                if (liveCoinData[symbolBase]) {
                    liveCoinData[symbolBase].price = price;
                    liveCoinData[symbolBase].change = priceChangePercent;
                    liveCoinData[symbolBase].volume = volume;
                } else {
                    // This case should ideally not happen if initializeCoinsTable pre-populates all symbolsToStream
                    console.warn(`Received data for unknown symbol: ${symbolBase}`);
                    return; // Or dynamically add a new row if desired
                }

                // Update table cells directly
                updateElementsByClass(`${symbolBase}-price`,
                    `${formatCurrency(price, 2, 4)} USDT`); // Show more precision for price

                const percentContent = priceChangePercent >= 0 ?
                    `${upArrowSVG}<span>${formatPercentage(priceChangePercent)}</span>` :
                    `${downArrowSVG}<span>${formatPercentage(priceChangePercent)}</span>`;
                updateElementsByClass(`${symbolBase}-percent`, percentContent, true); // true for innerHTML
                updateElementsByClass(`${symbolBase}-volume`, Number(volume).toLocaleString('en-US', {
                    maximumFractionDigits: 0
                }));


                if (priceChangePercent < 0) {
                    updateClassList(`${symbolBase}-percent`, 'error-color', 'success-color');
                } else {
                    updateClassList(`${symbolBase}-percent`, 'success-color', 'error-color');
                }

                // Re-render portfolio as it depends on these live prices
                renderPortfolio();
            };

            ws.onerror = (error) => {
                console.error("WebSocket Error:", error);
                if (coinsTableBodyEl) coinsTableBodyEl.innerHTML =
                    `<tr><td colspan="4" style="text-align:center; padding: 20px; color: #f6465d;">Error connecting to live market data.</td></tr>`;
            };

            ws.onclose = () => {
                console.warn("WebSocket Closed. Attempting to reload page in 3 seconds to reconnect...");
                if (coinsTableBodyEl) coinsTableBodyEl.innerHTML =
                    `<tr><td colspan="4" style="text-align:center; padding: 20px; color: #f0b90b;">Connection lost. Reconnecting...</td></tr>`;
                setTimeout(() => location.reload(), 3000);
            };
        });
    </script>
@endpush
