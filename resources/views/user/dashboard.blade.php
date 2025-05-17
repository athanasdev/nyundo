<!DOCTYPE html>
<html lang="en">

@include('user.common.head')

<body style="overflow-x: hidden">
    <!-- preloade -->
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
    <!-- /preload -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <style>
        svg {
            margin-top: -3px;
            height: 16px !important;
            width: 16px !important;
        }

        .text-small {
            font-size: 14px !important;
            color: #7e8088 !important;
        }

        .top--crypto-card {
            padding: 8px;
            border-radius: 10px;
            background: #222531;
            width: calc((100%) / 3);
        }

        td {
            padding: 6px;
        }

        .success-color {
            background: transparent !important;
        }

        .error-color {
            background: transparent !important;
        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
    <div class="header-style2 fixed-top" style="padding: 0px">
        <div
            style="display: flex;flex-direction:row;align-items:center;gap:10px;justify-content:space-between;width:100%;padding:10px 16px;border-bottom:1px solid #858CA2;background:#1e2730">
            <div class="">
                <a href="" class="text-button" style="font-size: 20px;font-weight:600">Inex Markets</a>
            </div>
            <div style="display:flex;flex-direction:row;column-gap:10px;align-items:center">
                <a href="#" class="system-mode-toggle">
                    <div class="d-row align-center account-mode" style="column-gap:4px">
                        <i class="iconsax" icon-name="setting-1"></i>
                        <span style="font-size:14px">Real</span>
                    </div>
                </a>
                <a href="https://inexfx.com/vip" class="text-button">
                    <img src="https://inexfx.com/diamond-icon.svg" alt="" style="width: 25px;height:25px">
                </a>
                <a href="https://jivo.chat/mYllXH6MUc" class="text-button">
                    <svg style="height:24px!important;width:24px!important" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-headset">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M4 14v-3a8 8 0 1 1 16 0v3" />
                        <path d="M18 19c0 1.657 -2.686 3 -6 3" />
                        <path d="M4 14a2 2 0 0 1 2 -2h1a2 2 0 0 1 2 2v3a2 2 0 0 1 -2 2h-1a2 2 0 0 1 -2 -2v-3z" />
                        <path d="M15 14a2 2 0 0 1 2 -2h1a2 2 0 0 1 2 2v3a2 2 0 0 1 -2 2h-1a2 2 0 0 1 -2 -2v-3z" />
                    </svg>
                </a>
                <a href="{{ route('my-account') }}" class="text-button">
                    <img src="https://inexfx.com/avatar.png" alt=""
                        style="width: 35px;height:35px;border-radius:50%">
                </a>
            </div>
        </div>
    </div>

    <div class="pb-80" style="padding: 65px 20px 80px 10px">
        <div class="swiper mySwiper" style="height:160px!important;border-radius:6px">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <a href="https://inexfx.com/ai-trading">
                        <img src="https://inexfx.com/ai-trade-poster.png" alt="">
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="https://inexfx.com/my-team">
                        <img src="https://inexfx.com/invite-banner.png" alt="">
                    </a>
                </div>
                <div class="swiper-slide">
                    <img src="https://inexfx.com/zero-know.png" alt="">
                </div>
                <div class="swiper-slide">
                    <img src="https://inexfx.com/signal-time.png" alt="">
                </div>
                <div class="swiper-slide">
                    <a href="https://t.me/inexchannel" target="_blank">
                        <img src="https://inexfx.com/join-channel.png" alt="">
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="">
                        <img src="https://inexfx.com/customer-support.png" alt="">
                    </a>
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>

        @include('user.components.menu-header')


        <a href="https://inexfx.com/my-team">
            <div style="margin-top:15px">
                <img src="https://inexfx.com/deposit-bonus.png" style="border-radius:6px">
            </div>
        </a>
        <a href="https://inexfx.com/deposit">
            <div style="margin-top:15px">
                <img src="https://inexfx.com/deposit-now.png" style="border-radius:6px">
            </div>
        </a>
        <div class="tf-container" style="padding-left:0px">
            <div class="pb-12">
                <div class="wrap-filter-swiper">
                    <div class="swiper-wrapper1 menu-tab-v3 mt-12" role="tablist" style="gap: 0;border-bottom:none">
                        <div class="swiper-slide1 nav-link active" data-bs-toggle="tab" data-bs-target="#favorites"
                            role="tab" aria-controls="favorites" aria-selected="true">
                            Favorites </div>
                    </div>
                    <!-- </div> -->
                </div>
                <div class="tab-content mt-8" style="padding-left:10px">
                    <div class="tab-pane fade show active" id="favorites" role="tabpanel">
                        <table style="width: 100%;border-collapse:collapse">
                            <thead>
                                <th style="text-align:center">#</th>
                                <th>Market Cap</th>
                                <th style="text-align: center">Price</th>
                                <th style="text-align: right">24h %</th>
                            </thead>
                            <tbody>
                                <tr style="height: 45px">
                                    <td style="vertical-align:middle;text-align:center">1</td>
                                    <td>
                                        <a href="https://inexfx.com/explore-quote/BTC">
                                            <div style="display:flex;align-items:center;column-gap:8px">
                                                <img src="https://inexfx.com/icons/btc.png"
                                                    style="height: 35px;width:35px;background:#ffffff;border-radius:50%"
                                                    alt="">
                                                <div style="display:flex;flex-direction:column">
                                                    <span
                                                        style="font-weight:500;color:#ffffff;font-size:12px">BTC/USDT</span>
                                                    <span style="font-size: 11px;color:#85A7BB"
                                                        class="BTC-volume">0.0000</span>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td style="text-align: center;vertical-align:middle">
                                        <span class="BTC-price" style="color: #ffffff;font-weight:500">0000</span>
                                    </td>
                                    <td style="text-align: right;vertical-align:middle">
                                        <div style="display:flex;align-items:center;justify-content:flex-end">
                                        </div>
                                        <span
                                            style="font-size: 10px;column-gap:2px;display: flex;flex-direction: row;align-items: flex-end;justify-content: flex-end;"
                                            class="text-primary d-flex align-items-center BTC-percent">0.00%</span>
                                    </td>
                                </tr>
                                <tr style="height: 45px">
                                    <td style="vertical-align:middle;text-align:center">2</td>
                                    <td>
                                        <a href="https://inexfx.com/explore-quote/ETH">
                                            <div style="display:flex;align-items:center;column-gap:8px">
                                                <img src="https://inexfx.com/icons/eth.png"
                                                    style="height: 35px;width:35px;background:#ffffff;border-radius:50%"
                                                    alt="">
                                                <div style="display:flex;flex-direction:column">
                                                    <span
                                                        style="font-weight:500;color:#ffffff;font-size:12px">ETH/USDT</span>
                                                    <span style="font-size: 11px;color:#85A7BB"
                                                        class="ETH-volume">0.0000</span>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td style="text-align: center;vertical-align:middle">
                                        <span class="ETH-price" style="color: #ffffff;font-weight:500">0000</span>
                                    </td>
                                    <td style="text-align: right;vertical-align:middle">
                                        <div style="display:flex;align-items:center;justify-content:flex-end">
                                        </div>
                                        <span
                                            style="font-size: 10px;column-gap:2px;display: flex;flex-direction: row;align-items: flex-end;justify-content: flex-end;"
                                            class="text-primary d-flex align-items-center ETH-percent">0.00%</span>
                                    </td>
                                </tr>
                                <tr style="height: 45px">
                                    <td style="vertical-align:middle;text-align:center">3</td>
                                    <td>
                                        <a href="https://inexfx.com/explore-quote/BNB">
                                            <div style="display:flex;align-items:center;column-gap:8px">
                                                <img src="https://inexfx.com/icons/bnb.png"
                                                    style="height: 35px;width:35px;background:#ffffff;border-radius:50%"
                                                    alt="">
                                                <div style="display:flex;flex-direction:column">
                                                    <span
                                                        style="font-weight:500;color:#ffffff;font-size:12px">BNB/USDT</span>
                                                    <span style="font-size: 11px;color:#85A7BB"
                                                        class="BNB-volume">0.0000</span>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td style="text-align: center;vertical-align:middle">
                                        <span class="BNB-price" style="color: #ffffff;font-weight:500">0000</span>
                                    </td>
                                    <td style="text-align: right;vertical-align:middle">
                                        <div style="display:flex;align-items:center;justify-content:flex-end">
                                        </div>
                                        <span
                                            style="font-size: 10px;column-gap:2px;display: flex;flex-direction: row;align-items: flex-end;justify-content: flex-end;"
                                            class="text-primary d-flex align-items-center BNB-percent">0.00%</span>
                                    </td>
                                </tr>
                                <tr style="height: 45px">
                                    <td style="vertical-align:middle;text-align:center">4</td>
                                    <td>
                                        <a href="https://inexfx.com/explore-quote/SOL">
                                            <div style="display:flex;align-items:center;column-gap:8px">
                                                <img src="https://inexfx.com/icons/sol.png"
                                                    style="height: 35px;width:35px;background:#ffffff;border-radius:50%"
                                                    alt="">
                                                <div style="display:flex;flex-direction:column">
                                                    <span
                                                        style="font-weight:500;color:#ffffff;font-size:12px">SOL/USDT</span>
                                                    <span style="font-size: 11px;color:#85A7BB"
                                                        class="SOL-volume">0.0000</span>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td style="text-align: center;vertical-align:middle">
                                        <span class="SOL-price" style="color: #ffffff;font-weight:500">0000</span>
                                    </td>
                                    <td style="text-align: right;vertical-align:middle">
                                        <div style="display:flex;align-items:center;justify-content:flex-end">
                                        </div>
                                        <span
                                            style="font-size: 10px;column-gap:2px;display: flex;flex-direction: row;align-items: flex-end;justify-content: flex-end;"
                                            class="text-primary d-flex align-items-center SOL-percent">0.00%</span>
                                    </td>
                                </tr>
                                <tr style="height: 45px">
                                    <td style="vertical-align:middle;text-align:center">5</td>
                                    <td>
                                        <a href="https://inexfx.com/explore-quote/XRP">
                                            <div style="display:flex;align-items:center;column-gap:8px">
                                                <img src="https://inexfx.com/icons/xrp.png"
                                                    style="height: 35px;width:35px;background:#ffffff;border-radius:50%"
                                                    alt="">
                                                <div style="display:flex;flex-direction:column">
                                                    <span
                                                        style="font-weight:500;color:#ffffff;font-size:12px">XRP/USDT</span>
                                                    <span style="font-size: 11px;color:#85A7BB"
                                                        class="XRP-volume">0.0000</span>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td style="text-align: center;vertical-align:middle">
                                        <span class="XRP-price" style="color: #ffffff;font-weight:500">0000</span>
                                    </td>
                                    <td style="text-align: right;vertical-align:middle">
                                        <div style="display:flex;align-items:center;justify-content:flex-end">
                                        </div>
                                        <span
                                            style="font-size: 10px;column-gap:2px;display: flex;flex-direction: row;align-items: flex-end;justify-content: flex-end;"
                                            class="text-primary d-flex align-items-center XRP-percent">0.00%</span>
                                    </td>
                                </tr>
                                <tr style="height: 45px">
                                    <td style="vertical-align:middle;text-align:center">6</td>
                                    <td>
                                        <a href="https://inexfx.com/explore-quote/ADA">
                                            <div style="display:flex;align-items:center;column-gap:8px">
                                                <img src="https://inexfx.com/icons/ada.png"
                                                    style="height: 35px;width:35px;background:#ffffff;border-radius:50%"
                                                    alt="">
                                                <div style="display:flex;flex-direction:column">
                                                    <span
                                                        style="font-weight:500;color:#ffffff;font-size:12px">ADA/USDT</span>
                                                    <span style="font-size: 11px;color:#85A7BB"
                                                        class="ADA-volume">0.0000</span>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td style="text-align: center;vertical-align:middle">
                                        <span class="ADA-price" style="color: #ffffff;font-weight:500">0000</span>
                                    </td>
                                    <td style="text-align: right;vertical-align:middle">
                                        <div style="display:flex;align-items:center;justify-content:flex-end">
                                        </div>
                                        <span
                                            style="font-size: 10px;column-gap:2px;display: flex;flex-direction: row;align-items: flex-end;justify-content: flex-end;"
                                            class="text-primary d-flex align-items-center ADA-percent">0.00%</span>
                                    </td>
                                </tr>
                                <tr style="height: 45px">
                                    <td style="vertical-align:middle;text-align:center">7</td>
                                    <td>
                                        <a href="https://inexfx.com/explore-quote/DOGE">
                                            <div style="display:flex;align-items:center;column-gap:8px">
                                                <img src="https://inexfx.com/icons/doge.png"
                                                    style="height: 35px;width:35px;background:#ffffff;border-radius:50%"
                                                    alt="">
                                                <div style="display:flex;flex-direction:column">
                                                    <span
                                                        style="font-weight:500;color:#ffffff;font-size:12px">DOGE/USDT</span>
                                                    <span style="font-size: 11px;color:#85A7BB"
                                                        class="DOGE-volume">0.0000</span>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td style="text-align: center;vertical-align:middle">
                                        <span class="DOGE-price" style="color: #ffffff;font-weight:500">0000</span>
                                    </td>
                                    <td style="text-align: right;vertical-align:middle">
                                        <div style="display:flex;align-items:center;justify-content:flex-end">
                                        </div>
                                        <span
                                            style="font-size: 10px;column-gap:2px;display: flex;flex-direction: row;align-items: flex-end;justify-content: flex-end;"
                                            class="text-primary d-flex align-items-center DOGE-percent">0.00%</span>
                                    </td>
                                </tr>
                                <tr style="height: 45px">
                                    <td style="vertical-align:middle;text-align:center">8</td>
                                    <td>
                                        <a href="https://inexfx.com/explore-quote/AVAX">
                                            <div style="display:flex;align-items:center;column-gap:8px">
                                                <img src="https://inexfx.com/icons/avax.png"
                                                    style="height: 35px;width:35px;background:#ffffff;border-radius:50%"
                                                    alt="">
                                                <div style="display:flex;flex-direction:column">
                                                    <span
                                                        style="font-weight:500;color:#ffffff;font-size:12px">AVAX/USDT</span>
                                                    <span style="font-size: 11px;color:#85A7BB"
                                                        class="AVAX-volume">0.0000</span>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td style="text-align: center;vertical-align:middle">
                                        <span class="AVAX-price" style="color: #ffffff;font-weight:500">0000</span>
                                    </td>
                                    <td style="text-align: right;vertical-align:middle">
                                        <div style="display:flex;align-items:center;justify-content:flex-end">
                                        </div>
                                        <span
                                            style="font-size: 10px;column-gap:2px;display: flex;flex-direction: row;align-items: flex-end;justify-content: flex-end;"
                                            class="text-primary d-flex align-items-center AVAX-percent">0.00%</span>
                                    </td>
                                </tr>
                                <tr style="height: 45px">
                                    <td style="vertical-align:middle;text-align:center">9</td>
                                    <td>
                                        <a href="https://inexfx.com/explore-quote/DOT">
                                            <div style="display:flex;align-items:center;column-gap:8px">
                                                <img src="https://inexfx.com/icons/dot.png"
                                                    style="height: 35px;width:35px;background:#ffffff;border-radius:50%"
                                                    alt="">
                                                <div style="display:flex;flex-direction:column">
                                                    <span
                                                        style="font-weight:500;color:#ffffff;font-size:12px">DOT/USDT</span>
                                                    <span style="font-size: 11px;color:#85A7BB"
                                                        class="DOT-volume">0.0000</span>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td style="text-align: center;vertical-align:middle">
                                        <span class="DOT-price" style="color: #ffffff;font-weight:500">0000</span>
                                    </td>
                                    <td style="text-align: right;vertical-align:middle">
                                        <div style="display:flex;align-items:center;justify-content:flex-end">
                                        </div>
                                        <span
                                            style="font-size: 10px;column-gap:2px;display: flex;flex-direction: row;align-items: flex-end;justify-content: flex-end;"
                                            class="text-primary d-flex align-items-center DOT-percent">0.00%</span>
                                    </td>
                                </tr>
                                <tr style="height: 45px">
                                    <td style="vertical-align:middle;text-align:center">10</td>
                                    <td>
                                        <a href="https://inexfx.com/explore-quote/LINK">
                                            <div style="display:flex;align-items:center;column-gap:8px">
                                                <img src="https://inexfx.com/icons/link.png"
                                                    style="height: 35px;width:35px;background:#ffffff;border-radius:50%"
                                                    alt="">
                                                <div style="display:flex;flex-direction:column">
                                                    <span
                                                        style="font-weight:500;color:#ffffff;font-size:12px">LINK/USDT</span>
                                                    <span style="font-size: 11px;color:#85A7BB"
                                                        class="LINK-volume">0.0000</span>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td style="text-align: center;vertical-align:middle">
                                        <span class="LINK-price" style="color: #ffffff;font-weight:500">0000</span>
                                    </td>
                                    <td style="text-align: right;vertical-align:middle">
                                        <div style="display:flex;align-items:center;justify-content:flex-end">
                                        </div>
                                        <span
                                            style="font-size: 10px;column-gap:2px;display: flex;flex-direction: row;align-items: flex-end;justify-content: flex-end;"
                                            class="text-primary d-flex align-items-center LINK-percent">0.00%</span>
                                    </td>
                                </tr>
                                <tr style="height: 45px">
                                    <td style="vertical-align:middle;text-align:center">11</td>
                                    <td>
                                        <a href="https://inexfx.com/explore-quote/LTC">
                                            <div style="display:flex;align-items:center;column-gap:8px">
                                                <img src="https://inexfx.com/icons/ltc.png"
                                                    style="height: 35px;width:35px;background:#ffffff;border-radius:50%"
                                                    alt="">
                                                <div style="display:flex;flex-direction:column">
                                                    <span
                                                        style="font-weight:500;color:#ffffff;font-size:12px">LTC/USDT</span>
                                                    <span style="font-size: 11px;color:#85A7BB"
                                                        class="LTC-volume">0.0000</span>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td style="text-align: center;vertical-align:middle">
                                        <span class="LTC-price" style="color: #ffffff;font-weight:500">0000</span>
                                    </td>
                                    <td style="text-align: right;vertical-align:middle">
                                        <div style="display:flex;align-items:center;justify-content:flex-end">
                                        </div>
                                        <span
                                            style="font-size: 10px;column-gap:2px;display: flex;flex-direction: row;align-items: flex-end;justify-content: flex-end;"
                                            class="text-primary d-flex align-items-center LTC-percent">0.00%</span>
                                    </td>
                                </tr>
                                <tr style="height: 45px">
                                    <td style="vertical-align:middle;text-align:center">12</td>
                                    <td>
                                        <a href="https://inexfx.com/explore-quote/TST">
                                            <div style="display:flex;align-items:center;column-gap:8px">
                                                <img src="https://inexfx.com/icons/matic.png"
                                                    style="height: 35px;width:35px;background:#ffffff;border-radius:50%"
                                                    alt="">
                                                <div style="display:flex;flex-direction:column">
                                                    <span
                                                        style="font-weight:500;color:#ffffff;font-size:12px">TST/USDT</span>
                                                    <span style="font-size: 11px;color:#85A7BB"
                                                        class="TST-volume">0.0000</span>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td style="text-align: center;vertical-align:middle">
                                        <span class="TST-price" style="color: #ffffff;font-weight:500">0000</span>
                                    </td>
                                    <td style="text-align: right;vertical-align:middle">
                                        <div style="display:flex;align-items:center;justify-content:flex-end">
                                        </div>
                                        <span
                                            style="font-size: 10px;column-gap:2px;display: flex;flex-direction: row;align-items: flex-end;justify-content: flex-end;"
                                            class="text-primary d-flex align-items-center TST-percent">0.00%</span>
                                    </td>
                                </tr>
                                <tr style="height: 45px">
                                    <td style="vertical-align:middle;text-align:center">13</td>
                                    <td>
                                        <a href="https://inexfx.com/explore-quote/TRX">
                                            <div style="display:flex;align-items:center;column-gap:8px">
                                                <img src="https://inexfx.com/icons/trx.png"
                                                    style="height: 35px;width:35px;background:#ffffff;border-radius:50%"
                                                    alt="">
                                                <div style="display:flex;flex-direction:column">
                                                    <span
                                                        style="font-weight:500;color:#ffffff;font-size:12px">TRX/USDT</span>
                                                    <span style="font-size: 11px;color:#85A7BB"
                                                        class="TRX-volume">0.0000</span>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td style="text-align: center;vertical-align:middle">
                                        <span class="TRX-price" style="color: #ffffff;font-weight:500">0000</span>
                                    </td>
                                    <td style="text-align: right;vertical-align:middle">
                                        <div style="display:flex;align-items:center;justify-content:flex-end">
                                        </div>
                                        <span
                                            style="font-size: 10px;column-gap:2px;display: flex;flex-direction: row;align-items: flex-end;justify-content: flex-end;"
                                            class="text-primary d-flex align-items-center TRX-percent">0.00%</span>
                                    </td>
                                </tr>
                                <tr style="height: 45px">
                                    <td style="vertical-align:middle;text-align:center">14</td>
                                    <td>
                                        <a href="https://inexfx.com/explore-quote/SHIB">
                                            <div style="display:flex;align-items:center;column-gap:8px">
                                                <img src="https://inexfx.com/icons/shib.png"
                                                    style="height: 35px;width:35px;background:#ffffff;border-radius:50%"
                                                    alt="">
                                                <div style="display:flex;flex-direction:column">
                                                    <span
                                                        style="font-weight:500;color:#ffffff;font-size:12px">SHIB/USDT</span>
                                                    <span style="font-size: 11px;color:#85A7BB"
                                                        class="SHIB-volume">0.0000</span>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td style="text-align: center;vertical-align:middle">
                                        <span class="SHIB-price" style="color: #ffffff;font-weight:500">0000</span>
                                    </td>
                                    <td style="text-align: right;vertical-align:middle">
                                        <div style="display:flex;align-items:center;justify-content:flex-end">
                                        </div>
                                        <span
                                            style="font-size: 10px;column-gap:2px;display: flex;flex-direction: row;align-items: flex-end;justify-content: flex-end;"
                                            class="text-primary d-flex align-items-center SHIB-percent">0.00%</span>
                                    </td>
                                </tr>
                                <tr style="height: 45px">
                                    <td style="vertical-align:middle;text-align:center">15</td>
                                    <td>
                                        <a href="https://inexfx.com/explore-quote/UNI">
                                            <div style="display:flex;align-items:center;column-gap:8px">
                                                <img src="https://inexfx.com/icons/uni.png"
                                                    style="height: 35px;width:35px;background:#ffffff;border-radius:50%"
                                                    alt="">
                                                <div style="display:flex;flex-direction:column">
                                                    <span
                                                        style="font-weight:500;color:#ffffff;font-size:12px">UNI/USDT</span>
                                                    <span style="font-size: 11px;color:#85A7BB"
                                                        class="UNI-volume">0.0000</span>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td style="text-align: center;vertical-align:middle">
                                        <span class="UNI-price" style="color: #ffffff;font-weight:500">0000</span>
                                    </td>
                                    <td style="text-align: right;vertical-align:middle">
                                        <div style="display:flex;align-items:center;justify-content:flex-end">
                                        </div>
                                        <span
                                            style="font-size: 10px;column-gap:2px;display: flex;flex-direction: row;align-items: flex-end;justify-content: flex-end;"
                                            class="text-primary d-flex align-items-center UNI-percent">0.00%</span>
                                    </td>
                                </tr>
                                <tr style="height: 45px">
                                    <td style="vertical-align:middle;text-align:center">16</td>
                                    <td>
                                        <a href="https://inexfx.com/explore-quote/BCH">
                                            <div style="display:flex;align-items:center;column-gap:8px">
                                                <img src="https://inexfx.com/icons/bch.png"
                                                    style="height: 35px;width:35px;background:#ffffff;border-radius:50%"
                                                    alt="">
                                                <div style="display:flex;flex-direction:column">
                                                    <span
                                                        style="font-weight:500;color:#ffffff;font-size:12px">BCH/USDT</span>
                                                    <span style="font-size: 11px;color:#85A7BB"
                                                        class="BCH-volume">0.0000</span>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td style="text-align: center;vertical-align:middle">
                                        <span class="BCH-price" style="color: #ffffff;font-weight:500">0000</span>
                                    </td>
                                    <td style="text-align: right;vertical-align:middle">
                                        <div style="display:flex;align-items:center;justify-content:flex-end">
                                        </div>
                                        <span
                                            style="font-size: 10px;column-gap:2px;display: flex;flex-direction: row;align-items: flex-end;justify-content: flex-end;"
                                            class="text-primary d-flex align-items-center BCH-percent">0.00%</span>
                                    </td>
                                </tr>
                                <tr style="height: 45px">
                                    <td style="vertical-align:middle;text-align:center">17</td>
                                    <td>
                                        <a href="https://inexfx.com/explore-quote/ICP">
                                            <div style="display:flex;align-items:center;column-gap:8px">
                                                <img src="https://inexfx.com/icons/icp.png"
                                                    style="height: 35px;width:35px;background:#ffffff;border-radius:50%"
                                                    alt="">
                                                <div style="display:flex;flex-direction:column">
                                                    <span
                                                        style="font-weight:500;color:#ffffff;font-size:12px">ICP/USDT</span>
                                                    <span style="font-size: 11px;color:#85A7BB"
                                                        class="ICP-volume">0.0000</span>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td style="text-align: center;vertical-align:middle">
                                        <span class="ICP-price" style="color: #ffffff;font-weight:500">0000</span>
                                    </td>
                                    <td style="text-align: right;vertical-align:middle">
                                        <div style="display:flex;align-items:center;justify-content:flex-end">
                                        </div>
                                        <span
                                            style="font-size: 10px;column-gap:2px;display: flex;flex-direction: row;align-items: flex-end;justify-content: flex-end;"
                                            class="text-primary d-flex align-items-center ICP-percent">0.00%</span>
                                    </td>
                                </tr>
                                <tr style="height: 45px">
                                    <td style="vertical-align:middle;text-align:center">18</td>
                                    <td>
                                        <a href="https://inexfx.com/explore-quote/XLM">
                                            <div style="display:flex;align-items:center;column-gap:8px">
                                                <img src="https://inexfx.com/icons/xlm.png"
                                                    style="height: 35px;width:35px;background:#ffffff;border-radius:50%"
                                                    alt="">
                                                <div style="display:flex;flex-direction:column">
                                                    <span
                                                        style="font-weight:500;color:#ffffff;font-size:12px">XLM/USDT</span>
                                                    <span style="font-size: 11px;color:#85A7BB"
                                                        class="XLM-volume">0.0000</span>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td style="text-align: center;vertical-align:middle">
                                        <span class="XLM-price" style="color: #ffffff;font-weight:500">0000</span>
                                    </td>
                                    <td style="text-align: right;vertical-align:middle">
                                        <div style="display:flex;align-items:center;justify-content:flex-end">
                                        </div>
                                        <span
                                            style="font-size: 10px;column-gap:2px;display: flex;flex-direction: row;align-items: flex-end;justify-content: flex-end;"
                                            class="text-primary d-flex align-items-center XLM-percent">0.00%</span>
                                    </td>
                                </tr>
                                <tr style="height: 45px">
                                    <td style="vertical-align:middle;text-align:center">19</td>
                                    <td>
                                        <a href="https://inexfx.com/explore-quote/ATOM">
                                            <div style="display:flex;align-items:center;column-gap:8px">
                                                <img src="https://inexfx.com/icons/atom.png"
                                                    style="height: 35px;width:35px;background:#ffffff;border-radius:50%"
                                                    alt="">
                                                <div style="display:flex;flex-direction:column">
                                                    <span
                                                        style="font-weight:500;color:#ffffff;font-size:12px">ATOM/USDT</span>
                                                    <span style="font-size: 11px;color:#85A7BB"
                                                        class="ATOM-volume">0.0000</span>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td style="text-align: center;vertical-align:middle">
                                        <span class="ATOM-price" style="color: #ffffff;font-weight:500">0000</span>
                                    </td>
                                    <td style="text-align: right;vertical-align:middle">
                                        <div style="display:flex;align-items:center;justify-content:flex-end">
                                        </div>
                                        <span
                                            style="font-size: 10px;column-gap:2px;display: flex;flex-direction: row;align-items: flex-end;justify-content: flex-end;"
                                            class="text-primary d-flex align-items-center ATOM-percent">0.00%</span>
                                    </td>
                                </tr>
                                <tr style="height: 45px">
                                    <td style="vertical-align:middle;text-align:center">20</td>
                                    <td>
                                        <a href="https://inexfx.com/explore-quote/ETC">
                                            <div style="display:flex;align-items:center;column-gap:8px">
                                                <img src="https://inexfx.com/icons/etc.png"
                                                    style="height: 35px;width:35px;background:#ffffff;border-radius:50%"
                                                    alt="">
                                                <div style="display:flex;flex-direction:column">
                                                    <span
                                                        style="font-weight:500;color:#ffffff;font-size:12px">ETC/USDT</span>
                                                    <span style="font-size: 11px;color:#85A7BB"
                                                        class="ETC-volume">0.0000</span>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td style="text-align: center;vertical-align:middle">
                                        <span class="ETC-price" style="color: #ffffff;font-weight:500">0000</span>
                                    </td>
                                    <td style="text-align: right;vertical-align:middle">
                                        <div style="display:flex;align-items:center;justify-content:flex-end">
                                        </div>
                                        <span
                                            style="font-size: 10px;column-gap:2px;display: flex;flex-direction: row;align-items: flex-end;justify-content: flex-end;"
                                            class="text-primary d-flex align-items-center ETC-percent">0.00%</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('user.components.footer')

    @include('user.common.script')
    
    <script>
        $('.system-mode-toggle').on('click', function() {
            var mode = "1";
            if (mode == '1') {
                Swal.fire({
                    title: "Switch to Demo account",
                    text: "You are about to switch to demo account are you sure?",
                    icon: 'info',
                    showCancelButton: true,
                    showConfirmButton: true,
                }).then(function(result) {
                    if (result.isConfirmed) {
                        window.location.href = "https://inexfx.com/switch-to-demo";
                    } else if (result.isDismissed) {
                        Swal.fire({
                            title: "Action dismissed",
                            text: "You choose to stay in Real account",
                            icon: 'info',
                        });
                    }
                });
            } else if (mode == 0) {
                Swal.fire({
                    title: "Switch to Real account",
                    text: "You are about to switch to real account are you sure?",
                    icon: 'info',
                    showCancelButton: true,
                    showConfirmButton: true,
                }).then(function(result) {
                    if (result.isConfirmed) {
                        window.location.href = "https://inexfx.com/switch-to-real";
                    } else if (result.isDismissed) {
                        Swal.fire({
                            title: "Action dismissed",
                            text: "You choose to stay in Demo account",
                            icon: 'info',
                        });
                    }
                });
            }
        });
    </script>
    <script>
        const allArrays = [
            ...["BTCUSDT", "ETHUSDT", "BNBUSDT", "SOLUSDT", "XRPUSDT", "ADAUSDT", "DOGEUSDT", "AVAXUSDT", "DOTUSDT",
                "LINKUSDT", "LTCUSDT", "TSTUSDT", "TRXUSDT", "SHIBUSDT", "UNIUSDT", "BCHUSDT", "ICPUSDT", "XLMUSDT",
                "ATOMUSDT", "ETCUSDT"
            ]
        ].filter((value, index, self) => {
            return self.indexOf(value) === index;
        });

        const streamName = allArrays.map(s => `${s.toLowerCase()}@ticker`).join('/');
        const ws = new WebSocket(`wss://stream.binance.com:9443/stream?streams=${streamName}`);
        ws.onopen = () => {};

        ws.onmessage = (event) => {
            const response = JSON.parse(event.data);
            const element = response.data;
            if (!element || !element.s) return; // Ensure the symbol exists
            const symbol = element.s.replace('USDT', '');
            const price = parseFloat(element.c).toFixed(2);
            const priceChange = element.P;
            const priceChangeAmount = parseFloat(element.p).toFixed(2);

            var upArrow =
                `<svg fill="none" height="20" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg" id="fi_12220906"><path d="m13.207 8c-.3751-.37494-.8837-.58557-1.414-.58557-.5304 0-1.039.21063-1.414.58557l-5.58603 5.586c-.27962.2797-.47003.636-.54717 1.0239-.07713.3879-.03752.79.11382 1.1554s.40761.6777.73643.8975.71542.3371 1.11092.3372h11.17203c.3955-.0001.7821-.1174 1.1109-.3372s.5851-.5321.7364-.8975c.1514-.3654.191-.7675.1138-1.1554-.0771-.3879-.2675-.7442-.5471-1.0239z" fill="#26de81"></path></svg>`;
            var downArrow = `<svg fill="none" height="20" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg" id="fi_12220902"><path d="m19.434 8.235c-.1513-.36556-.4077-.67802-.7366-.89785-.329-.21984-.7158-.33717-1.1114-.33715h-11.172c-.3955.00008-.78209.11743-1.11091.3372s-.5851.53209-.73644.89749-.19095.76747-.11381 1.15537c.07713.38791.26754.74420.54716 1.02394l5.586 5.586c.3751.3749.8837.5856 1.414.5856s1.0389-.2107 1.414-.5856l5.586-5.586c.2797-.2796.4702-.63584.5474-1.02369.0773-.38785.0378-.78989-.1134-1.15531z" fill="#ff231f"></path></svg>
                    `;

            function updateElementsByClass(className, newValue) {
                const elements = document.getElementsByClassName(className);
                Array.from(elements).forEach(element => {
                    element.innerHTML = newValue;
                });
            }

            function updateClassList(className, addClassName, removeClassName) {
                const elements = document.getElementsByClassName(className);
                Array.from(elements).forEach(element => {
                    element.classList.add(addClassName);
                    element.classList.remove(removeClassName);
                });
            }

            ws.onmessage = (event) => {
                const response = JSON.parse(event.data);
                const element = response.data;
                if (!element || !element.s) return;

                const symbol = element.s.replace('USDT', '');
                const price = parseFloat(element.c).toFixed(2);
                const priceChange = parseFloat(element.P).toFixed(3);
                const volume = parseFloat(element.v).toFixed(0);

                const upArrow =
                    `<svg fill="none" height="20" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg" id="fi_12220906"><path d="m13.207 8c-.3751-.37494-.8837-.58557-1.414-.58557-.5304 0-1.039.21063-1.414.58557l-5.58603 5.586c-.27962.2797-.47003.636-.54717 1.0239-.07713.3879-.03752.79.11382 1.1554s.40761.6777.73643.8975.71542.3371 1.11092.3372h11.17203c.3955-.0001.7821-.1174 1.1109-.3372s.5851-.5321.7364-.8975c.1514-.3654.191-.7675.1138-1.1554-.0771-.3879-.2675-.7442-.5471-1.0239z" fill="#26de81"></path></svg>`;
                const downArrow =
                    `<svg fill="none" height="20" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg" id="fi_12220902"><path d="m19.434 8.235c-.1513-.36556-.4077-.67802-.7366-.89785-.329-.21984-.7158-.33717-1.1114-.33715h-11.172c-.3955.00008-.78209.11743-1.11091.3372s-.5851.53209-.73644.89749-.19095.76747-.11381 1.15537c.07713.38791.26754.74420.54716 1.02394l5.586 5.586c.3751.3749.8837.5856 1.414.5856s1.0389-.2107 1.414-.5856l5.586-5.586c.2797-.2796.4702-.63584.5474-1.02369.0773-.38785.0378-.78989-.1134-1.15531z" fill="#ff231f"></path></svg>`;

                updateElementsByClass(`${symbol}-price`, `${price} USDT`);

                const percentContent = priceChange >= 0 ?
                    `${upArrow}<span>${priceChange}%</span>` :
                    `${downArrow}<span>${priceChange}%</span>`;
                updateElementsByClass(`${symbol}-percent`, percentContent);
                updateElementsByClass(`${symbol}-volume`, volume);

                if (priceChange < 0) {
                    updateClassList(`${symbol}-percent`, 'error-color', 'success-color');
                } else {
                    updateClassList(`${symbol}-percent`, 'success-color', 'error-color');
                }
            };

        };

        ws.onerror = (error) => console.error("WebSocket Error:", error);

        ws.onclose = () => {
            console.warn("WebSocket Closed. Reconnecting in 3 seconds...");
            setTimeout(() => location.reload(), 3000);
        };



        var swiper = new Swiper(".mySwiper", {
            direction: "vertical",
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,


            },
        });
    </script>
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

    {{-- <script>
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey) {
                e.preventDefault();
                console.log('Blocked a Ctrl combination:', e.key);
            }
        });
    </script> --}}


</body>

</html>
