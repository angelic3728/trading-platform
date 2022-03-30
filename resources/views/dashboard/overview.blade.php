@extends('layouts.dashboard')

@section('title', 'Dashboard')

@push('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/chartist.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/date-picker.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/prism.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vector-map.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/scrollable.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/owlcarousel.css')}}">
@endpush
@section('content')
<!-- Container-fluid starts-->
<div class="container-fluid dashboard-default-sec" style="padding: 0px;">
    <div class="row dashboard-content-wrapper">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-xl-12">
                    <div class="d-flex justify-content-center align-items-center" id="ad1_container">
                        <a href="{{$ads[0]['link']}}#" target="_blank">
                            <img src="{{ 'storage/'.$ads[0]['source'] }}" class="img-fluid" alt="">
                        </a>
                    </div>
                </div>
                <div class="d-flex justify-content-center align-items-center" id="ad2_container">
                    <ul>
                        <li>
                            <a href="{{$ads[0]['link']}}#" target="_blank">
                                <img src="{{ 'storage/'.$ads[1]['source'] }}" class="img-fluid" alt="">
                            </a>
                        </li>
                    </ul>
                    <a href="javascript:void(0)" onclick="hide_ad()" style="position: absolute; top:10px; right:10px;"><i class="fa fa-times fs-5"></i></a>
                </div>
                <div class="col-xl-5 box-col-12 des-xl-100">
                    <div class="row">
                        <div class="col-xl-12 col-md-6 box-col-6">
                            <div class="card profile-greeting p-t-25 p-b-25">
                                <div class="card-header">
                                    <div class="header-top">
                                        <div class="setting-list bg-primary position-unset">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body text-center p-t-0">
                                    <h3 class="font-light">Welcome back {{auth()->user()->first_name}}!</h3>
                                    <p class="font-light" style="font-size: 11px;">Your account manager is available from 05:00am to 17:00pm Monday to Friday. If you need to speak to somebody outside of these hours, please click below.</p>
                                    <a class="btn btn-light" href="#">Click Here</a>
                                </div>
                                <div class="confetti">
                                    <div class="confetti-piece"></div>
                                    <div class="confetti-piece"></div>
                                    <div class="confetti-piece"></div>
                                    <div class="confetti-piece"></div>
                                    <div class="confetti-piece"></div>
                                    <div class="confetti-piece"></div>
                                    <div class="confetti-piece"></div>
                                    <div class="confetti-piece"></div>
                                    <div class="confetti-piece"></div>
                                    <div class="confetti-piece"></div>
                                    <div class="confetti-piece"></div>
                                    <div class="confetti-piece"></div>
                                    <div class="confetti-piece"></div>
                                    <div class="code-box-copy">
                                        <button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#profile-greeting" title="Copy"><i class="icofont icofont-copy-alt"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-3 col-sm-6 box-col-3 rate-sec">
                            <div class="card income-card card-primary  p-t-10 p-b-10">
                                <div class="card-body text-center">
                                    <div class="round-box">
                                        <a href="javascript:void(0)">
                                            <i class="fa fa-money fs-4"></i>
                                        </a>
                                    </div>
                                    <h5>
                                        @if(auth()->user()->getBalance() && auth()->user()->getBalance()->currency == 'USD')
                                        <span class="f-w-600">$</span>
                                        @endif
                                        @if(auth()->user()->getBalance() && auth()->user()->getBalance()->currency == 'EUR')
                                        <span class="f-w-600">€</span>
                                        @endif
                                        @if(auth()->user()->getBalance() && auth()->user()->getBalance()->currency == 'GBP')
                                        <span class="f-w-600">£</span>
                                        @endif
                                        @if(auth()->user()->getBalance() && auth()->user()->getBalance()->currency == 'AUD')
                                        <span class="f-w-600">A$</span>
                                        @endif
                                        <span class="counter" id="total_profile_value"></span>
                                    </h5>
                                    <p>Total Portfolio Value</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-3 col-sm-6 box-col-3 rate-sec">
                            <div class="card income-card card-secondary p-t-10 p-b-10">
                                <div class="card-body text-center">
                                    <div class="round-box">
                                        <a href="javascript:void(0)">
                                            <i class="fa fa-credit-card-alt fs-4"></i>
                                        </a>
                                    </div>
                                    <h5>
                                        @if(auth()->user()->getBalance() && auth()->user()->getBalance()->currency == 'USD')
                                        <span class="f-w-600">$</span>
                                        @endif
                                        @if(auth()->user()->getBalance() && auth()->user()->getBalance()->currency == 'EUR')
                                        <span class="f-w-600">€</span>
                                        @endif
                                        @if(auth()->user()->getBalance() && auth()->user()->getBalance()->currency == 'GBP')
                                        <span class="f-w-600">£</span>
                                        @endif
                                        @if(auth()->user()->getBalance() && auth()->user()->getBalance()->currency == 'AUD')
                                        <span class="f-w-600">A$</span>
                                        @endif
                                        @if(auth()->user()->getBalance())
                                        <span class="counter" id="cash_on_account"></span>
                                        @else
                                        <span>0</span>
                                        @endif
                                    </h5>
                                    <p>Cash On Account</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-7 box-col-12 des-xl-100 dashboard-sec">
                    <div class="card income-card">
                        <div class="card-header">
                            <div class="header-top d-sm-flex align-items-center">
                                <h5>Account performance</h5>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="tabbed-card">
                                <ul class="pull-right nav nav-tabs border-tab nav-success" id="chart_tab" role="tablist" style="z-index: 7;">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#stock_chart" role="tab" aria-controls="stock-chart" aria-selected="false" style="cursor: pointer;">
                                            <i class="icofont icofont-ui-home"></i>
                                            Stocks
                                        </a>
                                        <div class="material-border"></div>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#fund_chart" role="tab" aria-controls="fund-chart" aria-selected="true" style="cursor: pointer;">
                                            <i class="fa fa-cloud"></i>
                                            Funds
                                        </a>
                                        <div class="material-border"></div>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#crypto_chart" role="tab" aria-controls="crypto-chart" aria-selected="true" style="cursor: pointer;">
                                            <i class="fa fa-btc"></i>
                                            Cryptos
                                        </a>
                                        <div class="material-border"></div>
                                    </li>
                                </ul>
                                <div class="tab-content p-t-50 sm:p-t-0">
                                    <div class="tab-pane fade active show" id="stock_chart" role="tabpanel" aria-labelledby="stock-chart">
                                        <div id="chart-timeline-dashbord1"></div>
                                    </div>
                                    <div class="tab-pane fade" id="fund_chart" role="tabpanel" aria-labelledby="fund-chart">
                                        <div id="chart-timeline-dashbord2"></div>
                                    </div>
                                    <div class="tab-pane fade" id="crypto_chart" role="tabpanel" aria-labelledby="crypto-chart">
                                        <div id="chart-timeline-dashbord3"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="row">
                <div class="col-xl-8 box-col-12 des-xl-100">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="pull-left">My Portfolio</h5>
                                </div>
                                <div class="card-body">
                                    <div class="tabbed-card">
                                        <ul class="pull-right nav nav-tabs border-tab nav-success" id="portfolio-tab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-bs-toggle="tab" href="#stock_portfolio" role="tab" aria-controls="stock-portfolio" aria-selected="false" style="cursor: pointer;">
                                                    <i class="icofont icofont-ui-home"></i>
                                                    Stocks
                                                </a>
                                                <div class="material-border"></div>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" href="#fund_portfolio" role="tab" aria-controls="fund-portfolio" aria-selected="true" style="cursor: pointer;">
                                                    <i class="fa fa-cloud"></i>
                                                    Funds
                                                </a>
                                                <div class="material-border"></div>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" href="#crypto_portfolio" role="tab" aria-controls="fund-portfolio" aria-selected="true" style="cursor: pointer;">
                                                    <i class="fa fa-btc"></i>
                                                    Cryptos
                                                </a>
                                                <div class="material-border"></div>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="portfolio_content">
                                            <div class="tab-pane fade active show" id="stock_portfolio" role="tabpanel" aria-labelledby="stock-portfolio">
                                                <div class="vertical-scroll scroll-demo p-0" style="height: 350px;">
                                                    <div class="table-responsive">
                                                        <table class="table table-responsive table-responsive-sm">
                                                            <thead>
                                                                <tr>
                                                                    <th style="font-size:13px;">Company</th>
                                                                    <th style="font-size:13px;">Last Price</th>
                                                                    <th style="font-size:13px;">Change</th>
                                                                    <th style="font-size:13px;">Institutional Price</th>
                                                                    <th style="font-size:13px;">Shares</th>
                                                                    <th style="font-size:13px;">Value</th>
                                                                    <th class="text-center table-secondary" style="right: 0px; min-width:140px;">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if(count($transactions) != 0)
                                                                @foreach($transactions as $transaction)
                                                                @if($transaction->wherefrom == 0)
                                                                <tr>
                                                                    <td class="d-flex flex-column">
                                                                        <span class="f-w-600">{{$transaction->symbol}}</span>
                                                                        <small style="text-overflow: ellipsis; overflow: hidden; white-space: nowrap; max-width:150px;">{{$transaction->company_name}}</small>
                                                                    </td>
                                                                    <td style="vertical-align: middle;">{{ ($transaction->latest_price)?$transaction->stock->formatPrice($transaction->latest_price):"-"}}</td>
                                                                    <td style="vertical-align: middle;">
                                                                        <span class="{{($transaction->change_percentage > 0)?'text-success f-w-600':'text-danger f-w-600'}}">
                                                                            {{ ($transaction->change_percentage)?(($transaction->change_percentage*100)."%"):"-"}}
                                                                        </span>
                                                                    </td>
                                                                    <td style="vertical-align: middle;">{{ ($transaction->institutional_price) ? $transaction->stock->formatPrice($transaction->institutional_price):"-"}}</td>
                                                                    <td style="vertical-align: middle;">{{$transaction->shares}}</td>
                                                                    <td style="vertical-align: middle;">{{ ($transaction->latest_price)?$transaction->stock->formatPrice(round($transaction->latest_price*$transaction->shares, 2)):"-" }}</td>
                                                                    <td class="text-center table-secondary" style="right: 0px; min-width:140px;">
                                                                        <button class="btn btn-pill btn-outline-primary btn-xs md:me-1" onclick="openTradeModel('buy', '{{$transaction->symbol}}', '{{$transaction->company_name}}', '{{$transaction->latest_price}}', '{{ $transaction->institutional_price }}', '{{ $transaction->gcurrency }}', '{{$transaction->shares}}', '{{$transaction->wherefrom}}', '{{$transaction->stock->exchange}}')">Buy</button>
                                                                        <button class="btn btn-pill btn-outline-danger btn-xs md:ms-1" onclick="openTradeModel('sell', '{{$transaction->symbol}}', '{{$transaction->company_name}}', '{{$transaction->latest_price}}', '{{ $transaction->institutional_price }}', '{{ $transaction->gcurrency }}', '{{$transaction->shares}}', '{{$transaction->wherefrom}}', '{{$transaction->stock->exchange}}')">Sell</button>
                                                                    </td>
                                                                </tr>
                                                                @endif
                                                                @endforeach
                                                                @else
                                                                <tr>
                                                                    <td colspan="7" class="text-center">No Data!</td>
                                                                </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="fund_portfolio" role="tabpanel" aria-labelledby="fund-portfolio">
                                                <div class="vertical-scroll scroll-demo p-0" style="height: 350px;">
                                                    <div class="table-responsive">
                                                        <table class="table table-responsive table-responsive-sm">
                                                            <thead>
                                                                <tr>
                                                                    <th style="font-size:13px;">Company</th>
                                                                    <th style="font-size:13px;">Last Price</th>
                                                                    <th style="font-size:13px;">Change</th>
                                                                    <th style="font-size:13px;">Institutional Price</th>
                                                                    <th style="font-size:13px;">Shares</th>
                                                                    <th style="font-size:13px;">Value</th>
                                                                    <th class="text-center table-secondary" style="right: 0px; width:140px;">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if(count($transactions) != 0)
                                                                @foreach($transactions as $transaction)
                                                                @if($transaction->wherefrom == 1)
                                                                <tr>
                                                                    <td class="d-flex flex-column">
                                                                        <span class="f-w-600">{{$transaction->symbol}}</span>
                                                                        <small style="text-overflow: ellipsis; overflow: hidden; white-space: nowrap; max-width:150px;">{{$transaction->company_name}}</small>
                                                                    </td>
                                                                    <td style="vertical-align: middle;">{{ ($transaction->latest_price)?$transaction->fund->formatPrice($transaction->latest_price):"-"}}</td>
                                                                    <td style="vertical-align: middle;">
                                                                        <span class="{{($transaction->change_percentage > 0)?'text-success f-w-600':'text-danger f-w-600'}}">
                                                                            {{ ($transaction->change_percentage)?(($transaction->change_percentage*100)."%"):"-"}}
                                                                        </span>
                                                                    </td>
                                                                    <td style="vertical-align: middle;">{{ ($transaction->institutional_price) ? $transaction->fund->formatPrice($transaction->institutional_price):"-"}}</td>
                                                                    <td style="vertical-align: middle;">{{ $transaction->shares }}</td>
                                                                    <td style="vertical-align: middle;">{{ ($transaction->latest_price)?$transaction->fund->formatPrice(round($transaction->latest_price*$transaction->shares, 2)):"-" }}</td>
                                                                    <td class="text-center table-secondary" style="right: 0px; width:140px;">
                                                                        <button class="btn btn-pill btn-outline-primary btn-xs md:me-1" onclick="openTradeModel('buy', '{{$transaction->symbol}}', '{{$transaction->company_name}}', '{{$transaction->latest_price}}', '{{ $transaction->institutional_price }}', '{{ $transaction->gcurrency }}', '{{$transaction->shares}}', '{{$transaction->wherefrom}}', '{{$transaction->fund->exchange}}')">Buy</button>
                                                                        <button class="btn btn-pill btn-outline-danger btn-xs md:ms-1" onclick="openTradeModel('sell', '{{$transaction->symbol}}', '{{$transaction->company_name}}', '{{$transaction->latest_price}}', '{{ $transaction->institutional_price }}', '{{ $transaction->gcurrency }}', '{{$transaction->shares}}', '{{$transaction->wherefrom}}', '{{$transaction->fund->exchange}}')">Sell</button>
                                                                    </td>
                                                                </tr>
                                                                @endif
                                                                @endforeach
                                                                @else
                                                                <tr>
                                                                    <td colspan="7" class="text-center">No Data!</td>
                                                                </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="crypto_portfolio" role="tabpanel" aria-labelledby="crypto-portfolio">
                                                <div class="sm:vertical-scroll scroll-demo p-0" style="height: 350px;">
                                                    <div class="table-responsive">
                                                        <table class="table table-responsive table-responsive-sm">
                                                            <thead>
                                                                <tr>
                                                                    <th style="font-size:13px;">Company</th>
                                                                    <th style="font-size:13px;">Last Price</th>
                                                                    <th style="font-size:13px;">Change</th>
                                                                    <th style="font-size:13px;">Institutional Price</th>
                                                                    <th style="font-size:13px;">Amount</th>
                                                                    <th style="font-size:13px;">Value</th>
                                                                    <th class="text-center table-secondary" style="right: 0px; width:140px;">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if(count($transactions) != 0)
                                                                @foreach($transactions as $transaction)
                                                                @if($transaction->wherefrom == 2)
                                                                <tr>
                                                                    <td class="d-flex flex-column">
                                                                        <span class="f-w-600">{{$transaction->symbol}}</span>
                                                                        <small style="text-overflow: ellipsis; overflow: hidden; white-space: nowrap; max-width:150px;">{{$transaction->name}}</small>
                                                                    </td>
                                                                    <td style="vertical-align: middle;">{{ ($transaction->latest_price)?$transaction->crypto->formatPrice($transaction->latest_price):"-"}}</td>
                                                                    <td style="vertical-align: middle;">
                                                                        <span class="{{($transaction->change_percentage > 0)?'text-success f-w-600':'text-danger f-w-600'}}">
                                                                            {{ ($transaction->change_percentage)?(($transaction->change_percentage)."%"):"-"}}
                                                                        </span>
                                                                    </td>
                                                                    <td style="vertical-align: middle;">{{ ($transaction->institutional_price) ? $transaction->institutional_price:"-"}}</td>
                                                                    <td style="vertical-align: middle;">{{ $transaction->shares }}</td>
                                                                    <td style="vertical-align: middle;">{{ ($transaction->latest_price)?$transaction->crypto->formatPrice(round($transaction->latest_price*$transaction->shares, 2)):"-" }}</td>
                                                                    <td class="text-center table-secondary" style="right: 0px; width:140px;">
                                                                        <button class="btn btn-pill btn-outline-primary btn-xs md:me-1" onclick="openTradeModel('buy', '{{$transaction->symbol}}', '{{$transaction->name}}', '{{$transaction->latest_price}}', '{{ $transaction->institutional_price }}', '{{ $transaction->gcurrency }}', '{{$transaction->shares}}', '{{$transaction->wherefrom}}')">Buy</button>
                                                                        <button class="btn btn-pill btn-outline-danger btn-xs md:ms-1" onclick="openTradeModel('sell', '{{$transaction->symbol}}', '{{$transaction->name}}', '{{$transaction->latest_price}}', '{{ $transaction->institutional_price }}', '{{ $transaction->gcurrency }}', '{{$transaction->shares}}', '{{$transaction->wherefrom}}')">Sell</button>
                                                                    </td>
                                                                </tr>
                                                                @endif
                                                                @endforeach
                                                                @else
                                                                <tr>
                                                                    <td colspan="7" class="text-center">No Data!</td>
                                                                </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="tradeModal" tabindex="-1" role="dialog" aria-labelledby="Trade Shares Modal" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 id="modal_title" class="modal-title">Buy Shares from</h5>
                                                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h6>Below you will find the most recent information about the stock you would like to <span id="trade_type">buy</span> shares from</h6>
                                                            <table class="table">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <strong>Symbol</strong>
                                                                        </td>
                                                                        <td><strong id="trade_symbol"></strong></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <strong>Company</strong>
                                                                        </td>
                                                                        <td><strong id="trade_company"></strong></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <strong>Retail Price</strong>
                                                                        </td>
                                                                        <td><strong id="trade_price"></strong></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <strong>Institutional Price</strong>
                                                                        </td>
                                                                        <td><strong id="trade_institutional_price"></strong></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <small id="trade_is_xnys" class="d-block mb-3">We don't have real time prices for this stock at the moment. All prices here are based on the last close price. When submitting an trade, we will confirm the actual price with you.</small>
                                                            <div class="form-group">
                                                                <label class="form-label text-primary" id="shares-label">Shares</label>
                                                                <input type="number" class="form-control" placeholder="Enter the amount of shares" required id="shares_amount">
                                                                <small class="text-info">Your account manager will contact you as soon as possible to confirm best price.</small>
                                                            </div>
                                                            <div class="alert-wrapper mb-2"></div>
                                                            <div class="d-flex justify-content-end">
                                                                <button type="button" class="btn btn-primary btn-rounded btn-animated" id="trade_btn" onclick="confirmTrade(this)">
                                                                    BUY
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 box-col-12 des-xl-100">
                    <div class="row">
                        <div class="col-xl-12 box-col-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="header-top d-sm-flex align-items-center">
                                        <h5>Monthly Account Performance</h5>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div id="month_profit_dash"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12 box-col-12 des-xl-100">
            <div class="row">
                <div class="col-xl-6 box-col-12 des-xl-100">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-top d-sm-flex align-items-center">
                                <h5>Available XTB's</h5>
                            </div>
                            <a class="btn btn-outline-success btn-xs" href="{{ route('xtbs') }}">see more</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="vertical-scroll scroll-demo p-0">
                                <div class="table-responsive">
                                    <table class="table table-responsive table-responsive-sm">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Name</th>
                                                <th class="text-center">COUPON P.A</th>
                                                <th class="text-center">PRICE</th>
                                                <th class="text-center">YTM</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($xtbs) != 0)
                                            @foreach($xtbs as $xtb)
                                            <tr>
                                                <td class="text-center text-nowrap text-secondary f-w-600">
                                                    <span class="f-w-600">{{ $xtb->asx_code }}</span>
                                                    <small style="text-overflow: ellipsis; overflow: hidden; white-space: nowrap; max-width:150px;">{{$xtb->bond_issuer}}</small>
                                                </td>
                                                <td class="text-center text-nowrap text-info">{{ ($xtb->coupon_pa && $xtb->coupon_pa != "")?$xtb->coupon_pa:"-" }}</td>
                                                <td class="text-center text-nowrap text-success fw-bold">{{ "$".$xtb->xtb_price }}</td>
                                                <td class="text-center text-nowrap text-primary">{{ ($xtb->ytm !="")?$xtb->ytm."%":"-" }}</td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td colspan="4" class="text-center">No Data!</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 box-col-12 des-xl-100">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-top d-sm-flex align-items-center">
                                <h5>Top Cryptocurrencies</h5>
                            </div>
                            <a class="btn btn-outline-success btn-xs" href="{{ route('cryptos.search') }}">see more</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="vertical-scroll scroll-demo p-0">
                                <table class="table table-responsive table-responsive-sm table-sm">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Logo</th>
                                            <th class="text-center">Coin</th>
                                            <th class="text-center">Current Price</th>
                                            <th class="text-center">Market Cap</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($top_cryptos) != 0)
                                        @foreach($top_cryptos as $top_crypto)
                                        <tr>
                                            <td class="text-center" style="vertical-align: middle;"><img src="{{ $top_crypto['image'] }}" width="30" alt=""></td>
                                            <td class="d-flex flex-column text-center">
                                                <span class="f-w-600">{{$top_crypto['symbol']}}</span>
                                                <small>
                                                    {{$top_crypto['name']}}
                                                </small>
                                            </td>
                                            <td class="text-center" style="vertical-align: middle;">{{ '$'.number_format($top_crypto['current_price'], 2) }}</td>
                                            <td class="text-center" style="vertical-align: middle;">{{ number_format($top_crypto['market_cap'], 0) }}</td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="4" class="text-center">No Data!</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12 box-col-12 des-xl-100">
                    <div class="card">
                        <div class="card-header pb-1">
                            <div class="header-top">
                                <h5>Highlighted Stocks, Funds and Cryptos</h5>
                            </div>
                        </div>
                        <div class="card-body col-sm-12">
                            <div class="owl-carousel owl-theme" id="owl-carousel-14">
                                <div class="item">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="owl-carousel-16 owl-carousel owl-theme" id="stock_carousel">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="owl-carousel-16 owl-carousel owl-theme" id="fund_carousel">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="owl-carousel-16 owl-carousel owl-theme" id="crypto_carousel">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 box-col-12 des-xl-100">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-top d-sm-flex align-items-center">
                                <h5>Recent Activity</h5>
                            </div>
                            <a class="btn btn-outline-success btn-xs" href="{{ route('transactions') }}">see more</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="vertical-scroll scroll-demo p-0">
                                <div class="table-responsive">
                                    <table class="table table-responsive table-responsive-sm">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Symbol</th>
                                                <th class="text-center">Type</th>
                                                <th class="text-center">Price</th>
                                                <th class="text-center">Shares</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($transactions) != 0)
                                            @foreach($transactions->take(5) as $transaction)
                                            <tr>
                                                <td class="text-center f-w-600">{{ $transaction->symbol }}</td>
                                                <td class="text-center">{{ $transaction->type }}</td>
                                                <td class="text-center">{{ $transaction->wherefrom=="0"?$transaction->stock->formatPrice($transaction->price):($transaction->wherefrom=="1"?$transaction->fund->formatPrice($transaction->price):$transaction->crypto->formatPrice($transaction->price))}}</td>
                                                <td class="text-center">{{ $transaction->shares }}</td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td colspan="4" class="text-center">No Data!</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 box-col-12 des-xl-100">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-top d-sm-flex align-items-center">
                                <h5>Recent Document</h5>
                            </div>
                            <a class="btn btn-outline-success btn-xs" href="{{ route('documents.index') }}">see more</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="vertical-scroll scroll-demo p-0">
                                <div class="table-responsive">
                                    <table class="table table-responsive table-responsive-sm">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Type</th>
                                                <th class="text-center f-w-600">Title</th>
                                                <th class="text-center">Provided by</th>
                                                <th class="text-center">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($documents) != 0)
                                            @foreach($documents as $document)
                                            <tr>
                                                <td class="text-center">{{ $document->type }}</td>
                                                <td class="text-center">{{ $document->title }}</td>
                                                <td class="text-center">{{ $document->provider->first_name }} {{ $document->provider->last_name }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('documents.download', ['id' => $document->id]) }}" target="_blank">Download</a>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td colspan="4" class="text-center">No Data!</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12 box-col-12 des-xl-100">
                    <div class="card news-container">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-top d-sm-flex align-items-center">
                                <h5>Recent News</h5>
                            </div>
                            <a href="/news?symbols={{implode(',', $news_symbols)}}" class="btn btn-outline-success btn-xs">See More</a>
                        </div>
                        <div class="card-body">
                            <div class="loader-box news-loader justify-content-center align-items-center w-full" style="inset:0px; position:absolute; z-index:10; display:flex; height:initial;">
                                <div class="loader-19"></div>
                            </div>
                            <div class="row news-content" style="min-height: 440px;">
                                <div class="col-xl-3 col-md-6 news-0" style="display: none;">
                                    <a href="" class="news-link-0" target="_blank">
                                        <div class="prooduct-details-box">
                                            <div class="chart-wrapper media sm:w-auto" style="text-align: center; padding:10px 0px;">
                                                <img class="align-self-center img-fluid news-img-0" src="" style="max-height: 180px;" alt="#">
                                                <div class="media-body">
                                                    <p class="news-date-0 text-dark mb-0"></p>
                                                    <h6 class="news-headline-0"></h6>
                                                    <div class="summary news-summary-0"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-3 col-md-6 news-1" style="display: none;">
                                    <a href="" class="news-link-1" target="_blank">
                                        <div class="prooduct-details-box">
                                            <div class="chart-wrapper media" style="text-align: center; padding:10px 0px;">
                                                <img class="align-self-center img-fluid news-img-1" src="" style="max-height: 180px;" alt="#">
                                                <div class="media-body">
                                                    <p class="news-date-1 text-dark mb-0"></p>
                                                    <h6 class="news-headline-1"></h6>
                                                    <div class="summary news-summary-1"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-3 col-md-6 news-2" style="display: none;">
                                    <a href="" class="news-link-2" target="_blank">
                                        <div class="prooduct-details-box">
                                            <div class="chart-wrapper media" style="text-align: center; padding:10px 0px;">
                                                <img class="align-self-center img-fluid news-img-2" src="" style="max-height: 180px;" alt="#">
                                                <div class="media-body">
                                                    <p class="news-date-2 text-dark mb-0"></p>
                                                    <h6 class="news-headline-2"></h6>
                                                    <div class="summary news-summary-2"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-3 col-md-6 news-3" style="display: none;">
                                    <a href="" class="news-link-3" target="_blank">
                                        <div class="prooduct-details-box">
                                            <div class="chart-wrapper media" style="text-align: center; padding:10px 0px;">
                                                <img class="align-self-center img-fluid news-img-3" src="" style="max-height: 180px;" alt="#">
                                                <div class="media-body">
                                                    <p class="news-date-3 text-dark mb-0"></p>
                                                    <h6 class="news-headline-3"></h6>
                                                    <div class="summary news-summary-3"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="row no-news" style="display: none;">
                                <div class="col-sm-12">
                                    <div class="alert alert-light dark alert-dismissible fade show" id="zero_shares_alert" role="alert">
                                        There are no recent news.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<!-- Container-fluid Ends-->
@push('scripts')
<script>
    var chartData = {!! $transactions->map(function($transaction) { return ['id' => $transaction->id, 'realPrice' => $transaction->realPrice, 'created_at' => $transaction->created_at, 'wherefrom' => $transaction->wherefrom, 'type' => $transaction->type];}) -> toJson() !!};
    var all_highlights = {!!json_encode($all_highlights) !!}; 
    var total_value = "{{ $total_transaction_price }}";
    $('#total_profile_value').text(formatPrice(Number(total_value)));
    $('#cash_on_account').text(formatPrice(Number('{{ auth()->user()->getBalance()->amount }}')));
</script>
<script src="{{asset('assets/js/prism/prism.min.js')}}"></script>
<script src="{{asset('assets/js/clipboard/clipboard.min.js')}}"></script>
<script src="{{asset('assets/js/counter/jquery.waypoints.min.js')}}"></script>
<script src="{{asset('assets/js/counter/jquery.counterup.min.js')}}"></script>
<script src="{{asset('assets/js/counter/counter-custom.js')}}"></script>
<script src="{{asset('assets/js/scrollable/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('assets/js/scrollable/scrollable-custom.js')}}"></script>
<script src="{{asset('assets/js/dashboard/default.js')}}"></script>
<script src="{{asset('assets/js/notify/index.js')}}"></script>
<script src="{{asset('assets/js/owlcarousel/owl.carousel.js')}}"></script>
<script src="{{asset('assets/js/pages/dashboard/custom.js')}}"></script>
@endpush
@endsection
