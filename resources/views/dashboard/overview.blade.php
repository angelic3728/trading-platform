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
                        @if($ads[0])
                        <a href="{{$ads[0]['link']}}#" target="_blank">
                            <img src="{{ '/storage/'.$ads[0]['source'] }}" class="img-fluid" alt="">
                        </a>
                        @else
                        <b>No Advertising.</b>
                        @endif
                    </div>
                </div>
                <div class="d-flex justify-content-center align-items-center" id="ad2_container">
                    <ul>
                        <li>
                            @if($ads[1])
                            <a href="{{$ads[1]['link']}}#" target="_blank">
                                <img src="{{ '/storage/'.$ads[1]['source'] }}" class="img-fluid" alt="">
                            </a>
                            @else
                            <b>No Advertising.</b>
                            @endif
                        </li>
                    </ul>
                    <a href="javascript:void(0)" onclick="hide_ad()" style="position: absolute; top:10px; right:10px;"><i class="fa fa-times fs-5"></i></a>
                </div>
                <div class="col-xl-5 box-col-12 des-xl-100">
                    <div class="row">
                        <div class="col-xl-12 col-md-6 box-col-6">
                            <div class="card profile-greeting p-t-25 p-b-25">
                                <div class="card-body text-center" style="padding: 10px!important;">
                                    <h3 class="font-light f-w-600">Welcome back {{auth()->user()->first_name}}!</h3>
                                    <p class="font-light" style="font-size: 11px;">Your account manager is available from 05:00am to 17:00pm Monday to Friday. If you need to speak to somebody outside of these hours, please click below.</p>
                                    <a class="btn btn-light" href="mailto://{{ config('app.email') }}">Click Here</a>
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
                        <div class="col-xl-6 col-md-3 col-sm-6 rate-sec amount-board">
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
                                    <p>Portfolio Value</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-3 col-sm-6 rate-sec amount-board">
                            <div class="card income-card card-secondary p-t-10 p-b-10">
                                <div class="card-body text-center">
                                    <div class="round-box">
                                        <a href="javascript:void(0)">
                                            <i class="fa fa-credit-card-alt fs-4"></i>
                                        </a>
                                    </div>
                                    <h5>
                                        @if($user_currency)
                                        <span class="f-w-600">$</span>
                                        @endif
                                        @if($user_currency == 'EUR')
                                        <span class="f-w-600">€</span>
                                        @endif
                                        @if($user_currency == 'GBP')
                                        <span class="f-w-600">£</span>
                                        @endif
                                        @if($user_currency == 'AUD')
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
                        <div class="card-header p-t-20">
                            <div class="header-top d-sm-flex align-items-center">
                                <h5 class="md:d-block lg:d-none"><span>Performance</span></h5>
                            </div>
                        </div>
                        <div class="card-body p-t-5">
                            <div class="tabbed-card">
                                <ul class="pull-right nav nav-tabs border-tab nav-success" id="chart_tab" role="tablist" style="z-index: 7;">
                                    <li class="nav-item">
                                        <a class="nav-link f-w-500 active" data-bs-toggle="tab" href="#stock_chart" role="tab" aria-controls="stock-chart" aria-selected="false" style="cursor: pointer;">
                                            <i class="icofont icofont-ui-home"></i>
                                            Stocks
                                        </a>
                                        <div class="material-border"></div>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link f-w-500" data-bs-toggle="tab" href="#fund_chart" role="tab" aria-controls="fund-chart" aria-selected="true" style="cursor: pointer;">
                                            <i class="fa fa-cloud"></i>
                                            Funds
                                        </a>
                                        <div class="material-border"></div>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link f-w-500" data-bs-toggle="tab" href="#bond_chart" role="tab" aria-controls="crypto-chart" aria-selected="true" style="cursor: pointer;">
                                            <i class="fa fa-certificate"></i>
                                            Bonds
                                        </a>
                                        <div class="material-border"></div>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link f-w-500" data-bs-toggle="tab" href="#crypto_chart" role="tab" aria-controls="crypto-chart" aria-selected="true" style="cursor: pointer;">
                                            <i class="fa fa-btc"></i>Cryptos
                                        </a>
                                        <div class="material-border"></div>
                                    </li>
                                </ul>
                                <div class="tab-content p-t-20 sm:p-t-0">
                                    <div class="tab-pane fade active show" id="stock_chart" role="tabpanel" aria-labelledby="stock-chart">
                                        <div id="chart-timeline-dashboard1">
                                            <div class="d-flex justify-content-center align-items-center" style="min-height: 355px; width:100%">
                                                <div class="loader-box">
                                                    <div class="loader-19"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="fund_chart" role="tabpanel" aria-labelledby="fund-chart">
                                        <div id="chart-timeline-dashboard2">
                                            <div class="d-flex justify-content-center align-items-center" style="min-height: 355px; width:100%">
                                                <div class="loader-box">
                                                    <div class="loader-19"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="bond_chart" role="tabpanel" aria-labelledby="crypto-chart">
                                        <div id="chart-timeline-dashboard3">
                                            <div class="d-flex justify-content-center align-items-center" style="min-height: 355px; width:100%">
                                                <div class="loader-box">
                                                    <div class="loader-19"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="crypto_chart" role="tabpanel" aria-labelledby="crypto-chart">
                                        <div id="chart-timeline-dashboard4">
                                            <div class="d-flex justify-content-center align-items-center" style="min-height: 355px; width:100%">
                                                <div class="loader-box">
                                                    <div class="loader-19"></div>
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
        <div class="col-xl-12 p-t-10">
            <div class="row">
                <div class="col-xl-8 box-col-12 des-xl-100">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header p-t-20">
                                    <h5 class="pull-left"><span>My Portfolio</span></h5>
                                </div>
                                <div class="card-body p-t-5">
                                    <div class="tabbed-card">
                                        <ul class="pull-right nav nav-tabs border-tab nav-success" id="portfolio-tab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link f-w-500 active" data-bs-toggle="tab" href="#stock_portfolio" role="tab" aria-controls="stock-portfolio" aria-selected="false" style="cursor: pointer;">
                                                    <i class="icofont icofont-ui-home"></i>
                                                    Stocks
                                                </a>
                                                <div class="material-border"></div>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link f-w-500" data-bs-toggle="tab" href="#fund_portfolio" role="tab" aria-controls="fund-portfolio" aria-selected="true" style="cursor: pointer;">
                                                    <i class="fa fa-cloud"></i>
                                                    Funds
                                                </a>
                                                <div class="material-border"></div>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link f-w-500" data-bs-toggle="tab" href="#bond_portfolio" role="tab" aria-controls="bond-portfolio" aria-selected="true" style="cursor: pointer;">
                                                    <i class="fa fa-certificate"></i>
                                                    Bonds
                                                </a>
                                                <div class="material-border"></div>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link f-w-500" data-bs-toggle="tab" href="#crypto_portfolio" role="tab" aria-controls="fund-portfolio" aria-selected="true" style="cursor: pointer;">
                                                    <i class="fa fa-btc"></i>
                                                    Cryptos
                                                </a>
                                                <div class="material-border"></div>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="portfolio_content">
                                            <div class="tab-pane fade active show" id="stock_portfolio" role="tabpanel" aria-labelledby="stock-portfolio">
                                                <div class="table-responsive d-none d-sm-block" style="height: 350px; width:100%;">
                                                    <table style="white-space: nowrap;" class="table table-responsive-sm d-none d-sm-table">
                                                        <thead>
                                                            <tr>
                                                                <th style="font-size:13px;">Company</th>
                                                                <th style="font-size:13px; min-width:100px;">Last Price</th>
                                                                <th style="font-size:13px;">Change</th>
                                                                <th style="font-size:13px; min-width:100px;">Inst. Price</th>
                                                                <th style="font-size:13px;">Shares</th>
                                                                <th style="font-size:13px;">Value</th>
                                                                <th class="text-center table-secondary" style="right: 0px; width:120px; position: sticky;">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if(count($myPortfolios) != 0)
                                                            @foreach($myPortfolios as $myPortfolio)
                                                            @if($myPortfolio->wherefrom == 0)
                                                            <tr>
                                                                <td class="py-03">
                                                                    <a href="{{ route('stocks.show', ['symbol' => $myPortfolio->symbol]) }}" style="color:#24695c;">
                                                                        <span class="f-w-600">{{$myPortfolio->symbol}}</span>
                                                                        <p style="text-overflow: ellipsis; overflow: hidden; white-space: nowrap; max-width:150px;" class="f-w-400">{{$myPortfolio->company_name}}</p>
                                                                    </a>
                                                                </td>
                                                                <td class="py-03" style="vertical-align: middle;">{{ ($myPortfolio->latest_price)?$myPortfolio->stock->formatPrice($myPortfolio->latest_price):"-"}}</td>
                                                                <td class="py-03" style="vertical-align: middle;">
                                                                    <span class="{{($myPortfolio->change_percentage > 0)?'text-success f-w-600':'text-danger f-w-600'}}">
                                                                        {{ ($myPortfolio->change_percentage)?(number_format($myPortfolio->change_percentage*100, 2)."%"):"-"}}
                                                                    </span>
                                                                </td>
                                                                <td class="py-03" style="vertical-align: middle;">{{ ($myPortfolio->institutional_price) ? $myPortfolio->stock->formatPrice($myPortfolio->institutional_price):"-"}}</td>
                                                                <td class="py-03" style="vertical-align: middle;">{{ (fmod($myPortfolio->shares, 1) !== 0.000)?$myPortfolio->shares:number_format($myPortfolio->shares, 0) }}</td>
                                                                <td class="py-03" style="vertical-align: middle;">{{ ($myPortfolio->latest_price)?$myPortfolio->stock->formatPrice(round($myPortfolio->latest_price*$myPortfolio->shares, 2)):"-" }}</td>
                                                                <td class="py-03" class="text-center table-secondary" style="max-width:90px; text-align:center; vertical-align:middle; background-color:#e2e3e5; position: sticky; right:0px; white-space:initial;">
                                                                    <button class="btn btn-pill btn-outline-primary btn-xs md:me-1" onclick="openTradeModal('buy', '{{$myPortfolio->symbol}}', '{{$myPortfolio->company_name}}', '{{$myPortfolio->latest_price}}', '{{ $myPortfolio->institutional_price }}', '{{ $myPortfolio->gcurrency }}', '{{$myPortfolio->shares}}', '{{$myPortfolio->wherefrom}}', '{{$myPortfolio->stock->exchange}}', '{{$currency_rate}}')">Buy</button>
                                                                    <button class="btn btn-pill btn-outline-danger btn-xs md:ms-1" onclick="openTradeModal('sell', '{{$myPortfolio->symbol}}', '{{$myPortfolio->company_name}}', '{{$myPortfolio->latest_price}}', '{{ $myPortfolio->institutional_price }}', '{{ $myPortfolio->gcurrency }}', '{{$myPortfolio->shares}}', '{{$myPortfolio->wherefrom}}', '{{$myPortfolio->stock->exchange}}', '{{$currency_rate}}')">Sell</button>
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
                                                <div class="table-responsive d-sm-none"  style="height: 400px; width:100%;">
                                                    <table style="white-space: nowrap;" class="table table-responsive-sm d-sm-none">
                                                        <thead>
                                                            <tr>
                                                                <th style="font-size:13px;">Company</th>
                                                                <th style="font-size:13px; min-width:100px;">Last Price</th>
                                                                <th style="font-size:13px;">Change</th>
                                                                <th style="font-size:13px; min-width:100px;">Inst. Price</th>
                                                                <th style="font-size:13px;">Shares</th>
                                                                <th style="font-size:13px;">Value</th>
                                                                <th class="text-center table-secondary" style="right: 0px; max-width:90px; position: sticky; white-space:initial;">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="d-sm-none">
                                                            @if(count($myPortfolios) != 0)
                                                            <?php $cnt = 0 ?>
                                                            @foreach($myPortfolios as $myPortfolio)
                                                            @if($myPortfolio->wherefrom == 0)
                                                            <?php $cnt++; ?>
                                                            <tr>
                                                                <td class="py-03">
                                                                    <a href="{{ route('stocks.show', ['symbol' => $myPortfolio->symbol]) }}" style="color:#24695c;">
                                                                        <span class="f-w-600">{{$myPortfolio->symbol}}</span>
                                                                        <p style="text-overflow: ellipsis; overflow: hidden; white-space: nowrap; max-width:150px;" class="f-w-400">{{$myPortfolio->company_name}}</p>
                                                                    </a>
                                                                </td>
                                                                <td class="py-03" style="vertical-align: middle;">{{ ($myPortfolio->latest_price)?$myPortfolio->stock->formatPrice($myPortfolio->latest_price):"-"}}</td>
                                                                <td class="py-03" style="vertical-align: middle;">
                                                                    <span class="{{($myPortfolio->change_percentage > 0)?'text-success f-w-600':'text-danger f-w-600'}}">
                                                                        {{ ($myPortfolio->change_percentage)?(number_format($myPortfolio->change_percentage*100, 2)."%"):"-"}}
                                                                    </span>
                                                                </td>
                                                                <td class="py-03" style="vertical-align: middle;">{{ ($myPortfolio->institutional_price) ? $myPortfolio->stock->formatPrice($myPortfolio->institutional_price):"-"}}</td>
                                                                <td class="py-03" style="vertical-align: middle;">{{ (fmod($myPortfolio->shares, 1) !== 0.000)?$myPortfolio->shares:number_format($myPortfolio->shares, 0) }}</td>
                                                                <td class="py-03" style="vertical-align: middle;">{{ ($myPortfolio->latest_price)?$myPortfolio->stock->formatPrice(round($myPortfolio->latest_price*$myPortfolio->shares, 2)):"-" }}</td>
                                                                <td class="py-03" class="text-center table-secondary" style="max-width:90px; text-align:center; vertical-align:middle; background-color:#e2e3e5; position: sticky; right:0px; white-space:initial;">
                                                                    <button class="btn btn-pill btn-outline-primary btn-xs md:me-1" onclick="openTradeModal('buy', '{{$myPortfolio->symbol}}', '{{$myPortfolio->company_name}}', '{{$myPortfolio->latest_price}}', '{{ $myPortfolio->institutional_price }}', '{{ $myPortfolio->gcurrency }}', '{{$myPortfolio->shares}}', '{{$myPortfolio->wherefrom}}', '{{$myPortfolio->stock->exchange}}', '{{$currency_rate}}')">Buy</button>
                                                                    <button class="btn btn-pill btn-outline-danger btn-xs md:ms-1" onclick="openTradeModal('sell', '{{$myPortfolio->symbol}}', '{{$myPortfolio->company_name}}', '{{$myPortfolio->latest_price}}', '{{ $myPortfolio->institutional_price }}', '{{ $myPortfolio->gcurrency }}', '{{$myPortfolio->shares}}', '{{$myPortfolio->wherefrom}}', '{{$myPortfolio->stock->exchange}}', '{{$currency_rate}}')">Sell</button>
                                                                </td>
                                                            </tr>
                                                            @if ($cnt == 5)
                                                                @break
                                                            @endif
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
                                            <div class="tab-pane fade" id="fund_portfolio" role="tabpanel" aria-labelledby="fund-portfolio">
                                                <div class="table-responsive d-none d-sm-block" style="height: 350px; width:100%;">
                                                    <table style="white-space: nowrap;" class="table table-responsive-sm">
                                                        <thead>
                                                            <tr>
                                                                <th style="font-size:13px;">Company</th>
                                                                <th style="font-size:13px; min-width:100px;">Last Price</th>
                                                                <th style="font-size:13px;">Change</th>
                                                                <th style="font-size:13px; min-width:100px;">Inst. Price</th>
                                                                <th style="font-size:13px;">Shares</th>
                                                                <th style="font-size:13px;">Value</th>
                                                                <th class="text-center table-secondary" style="right: 0px; width:120px; position: sticky;">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if(count($myPortfolios) != 0)
                                                            @foreach($myPortfolios as $myPortfolio)
                                                            @if($myPortfolio->wherefrom == 1)
                                                            <tr>
                                                                <td class="py-03">
                                                                    <a href="{{ route('funds.show', ['symbol' => $myPortfolio->symbol]) }}" style="color:#24695c;">
                                                                        <span class="f-w-600">{{$myPortfolio->symbol}}</span>
                                                                        <p style="text-overflow: ellipsis; overflow: hidden; white-space: nowrap; max-width:150px;" class="f-w-400">{{$myPortfolio->company_name}}</p>
                                                                    </a>
                                                                </td>
                                                                <td class="py-03" style="vertical-align: middle;">{{ ($myPortfolio->latest_price)?$myPortfolio->fund->formatPrice($myPortfolio->latest_price):"-"}}</td>
                                                                <td class="py-03" style="vertical-align: middle;">
                                                                    <span class="{{($myPortfolio->change_percentage > 0)?'text-success f-w-600':'text-danger f-w-600'}}">
                                                                        {{ ($myPortfolio->change_percentage)?(number_format($myPortfolio->change_percentage*100, 2)."%"):"-"}}
                                                                    </span>
                                                                </td>
                                                                <td class="py-03" style="vertical-align: middle;">{{ ($myPortfolio->institutional_price) ? $myPortfolio->fund->formatPrice($myPortfolio->institutional_price):"-"}}</td>
                                                                <td class="py-03" style="vertical-align: middle;">{{ (fmod($myPortfolio->shares, 1) !== 0.000)?$myPortfolio->shares:number_format($myPortfolio->shares, 0) }}</td>
                                                                <td class="py-03" style="vertical-align: middle;">{{ ($myPortfolio->latest_price)?$myPortfolio->fund->formatPrice(round($myPortfolio->latest_price*$myPortfolio->shares, 2)):"-" }}</td>
                                                                <td class="py-03" class="text-center table-secondary" style="width:120px; text-align:center; vertical-align:middle; background-color:#e2e3e5; position: sticky; right:0px;">
                                                                    <button class="btn btn-pill btn-outline-primary btn-xs md:me-1" onclick="openTradeModal('buy', '{{$myPortfolio->symbol}}', '{{$myPortfolio->company_name}}', '{{$myPortfolio->latest_price}}', '{{ $myPortfolio->institutional_price }}', '{{ $myPortfolio->gcurrency }}', '{{$myPortfolio->shares}}', '{{$myPortfolio->wherefrom}}', '{{$myPortfolio->fund->exchange}}', '{{$currency_rate}}')">Buy</button>
                                                                    <button class="btn btn-pill btn-outline-danger btn-xs md:ms-1" onclick="openTradeModal('sell', '{{$myPortfolio->symbol}}', '{{$myPortfolio->company_name}}', '{{$myPortfolio->latest_price}}', '{{ $myPortfolio->institutional_price }}', '{{ $myPortfolio->gcurrency }}', '{{$myPortfolio->shares}}', '{{$myPortfolio->wherefrom}}', '{{$myPortfolio->fund->exchange}}', '{{$currency_rate}}')">Sell</button>
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
                                                <div class="table-responsive d-sm-none" style="height: 400px; width:100%;">
                                                    <table style="white-space: nowrap;" class="table table-responsive-sm">
                                                        <thead>
                                                            <tr>
                                                                <th style="font-size:13px;">Company</th>
                                                                <th style="font-size:13px; min-width:100px;">Last Price</th>
                                                                <th style="font-size:13px;">Change</th>
                                                                <th style="font-size:13px; min-width:100px;">Inst. Price</th>
                                                                <th style="font-size:13px;">Shares</th>
                                                                <th style="font-size:13px;">Value</th>
                                                                <th class="text-center table-secondary" style="right: 0px; max-width:90px; position: sticky; white-space:initial;">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if(count($myPortfolios) != 0)
                                                            <?php $cnt = 0 ?>
                                                            @foreach($myPortfolios as $myPortfolio)
                                                            @if($myPortfolio->wherefrom == 1)
                                                            <?php $cnt++; ?>
                                                            <tr>
                                                                <td class="py-03">
                                                                    <a href="{{ route('funds.show', ['symbol' => $myPortfolio->symbol]) }}" style="color:#24695c;">
                                                                        <span class="f-w-600">{{$myPortfolio->symbol}}</span>
                                                                        <p style="text-overflow: ellipsis; overflow: hidden; white-space: nowrap; max-width:150px;" class="f-w-400">{{$myPortfolio->company_name}}</p>
                                                                    </a>
                                                                </td>
                                                                <td class="py-03" style="vertical-align: middle;">{{ ($myPortfolio->latest_price)?$myPortfolio->fund->formatPrice($myPortfolio->latest_price):"-"}}</td>
                                                                <td class="py-03" style="vertical-align: middle;">
                                                                    <span class="{{($myPortfolio->change_percentage > 0)?'text-success f-w-600':'text-danger f-w-600'}}">
                                                                        {{ ($myPortfolio->change_percentage)?(number_format($myPortfolio->change_percentage*100, 2)."%"):"-"}}
                                                                    </span>
                                                                </td>
                                                                <td class="py-03" style="vertical-align: middle;">{{ ($myPortfolio->institutional_price) ? $myPortfolio->fund->formatPrice($myPortfolio->institutional_price):"-"}}</td>
                                                                <td class="py-03" style="vertical-align: middle;">{{ (fmod($myPortfolio->shares, 1) !== 0.000)?$myPortfolio->shares:number_format($myPortfolio->shares, 0) }}</td>
                                                                <td class="py-03" style="vertical-align: middle;">{{ ($myPortfolio->latest_price)?$myPortfolio->fund->formatPrice(round($myPortfolio->latest_price*$myPortfolio->shares, 2)):"-" }}</td>
                                                                <td class="py-03" class="text-center table-secondary" style="max-width:90px; text-align:center; vertical-align:middle; background-color:#e2e3e5; position: sticky; right:0px; white-space:initial">
                                                                    <button class="btn btn-pill btn-outline-primary btn-xs md:me-1" onclick="openTradeModal('buy', '{{$myPortfolio->symbol}}', '{{$myPortfolio->company_name}}', '{{$myPortfolio->latest_price}}', '{{ $myPortfolio->institutional_price }}', '{{ $myPortfolio->gcurrency }}', '{{$myPortfolio->shares}}', '{{$myPortfolio->wherefrom}}', '{{$myPortfolio->fund->exchange}}', '{{$currency_rate}}')">Buy</button>
                                                                    <button class="btn btn-pill btn-outline-danger btn-xs md:ms-1" onclick="openTradeModal('sell', '{{$myPortfolio->symbol}}', '{{$myPortfolio->company_name}}', '{{$myPortfolio->latest_price}}', '{{ $myPortfolio->institutional_price }}', '{{ $myPortfolio->gcurrency }}', '{{$myPortfolio->shares}}', '{{$myPortfolio->wherefrom}}', '{{$myPortfolio->fund->exchange}}', '{{$currency_rate}}')">Sell</button>
                                                                </td>
                                                            </tr>
                                                            @if ($cnt == 5)
                                                                @break
                                                            @endif
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
                                            <div class="tab-pane fade" id="bond_portfolio" role="tabpanel" aria-labelledby="bond-portfolio">
                                                <div class="table-responsive d-none d-sm-block" style="height: 350px; width:100%;">
                                                    <table style="white-space: nowrap;" class="table table-responsive-sm">
                                                        <thead>
                                                            <tr>
                                                                <th style="font-size:13px;">Bond</th>
                                                                <th style="font-size:13px; min-width:100px;">Unit Price</th>
                                                                <th style="font-size:13px;">Change</th>
                                                                <th style="font-size:13px; min-width:100px;">Mkt Price</th>
                                                                <th style="font-size:13px;">Units</th>
                                                                <th style="font-size:13px;">Value</th>
                                                                <th class="text-center table-secondary" style="right: 0px; width:120px; position: sticky;">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if(count($myPortfolios) != 0)
                                                            <?php $cnt = 0 ?>
                                                            @foreach($myPortfolios as $myPortfolio)
                                                            @if($myPortfolio->wherefrom == 2)
                                                            <?php $cnt++; ?>
                                                            <tr>
                                                                <td class="py-03">
                                                                    <a href="{{ route('bonds.show', ['symbol' => $myPortfolio->symbol]) }}" style="color:#24695c;">
                                                                        <span class="f-w-600">{{$myPortfolio->symbol}}</span>
                                                                        <p style="text-overflow: ellipsis; overflow: hidden; white-space: nowrap; max-width:150px;" class="f-w-400">{{$myPortfolio->name}}</p>
                                                                    </a>
                                                                </td>
                                                                <td class="py-03" style="vertical-align: middle;">{{ ($myPortfolio->latest_price)?$myPortfolio->bond->formatPrice($myPortfolio->latest_price):"-"}}</td>
                                                                <td class="py-03" style="vertical-align: middle;">
                                                                    <span class="{{($myPortfolio->change_percentage > 0)?'text-success f-w-600':'text-danger f-w-600'}}">
                                                                        {{ ($myPortfolio->change_percentage)?(number_format($myPortfolio->change_percentage*100, 2)."%"):"-"}}
                                                                    </span>
                                                                </td>
                                                                <td class="py-03" style="vertical-align: middle;">{{ ($myPortfolio->institutional_price) ? $myPortfolio->bond->formatPrice($myPortfolio->institutional_price):"-"}}</td>
                                                                <td class="py-03" style="vertical-align: middle;">{{ (fmod($myPortfolio->shares, 1) !== 0.000)?$myPortfolio->shares:number_format($myPortfolio->shares, 0) }}</td>
                                                                <td class="py-03" style="vertical-align: middle;">{{ ($myPortfolio->latest_price)?$myPortfolio->bond->formatPrice(round($myPortfolio->latest_price*$myPortfolio->shares, 2)):"-" }}</td>
                                                                <td class="py-03" class="text-center table-secondary" style="width:120px; text-align:center; vertical-align:middle; background-color:#e2e3e5; position: sticky; right:0px; white-space:initial;">
                                                                    <button class="btn btn-pill btn-outline-primary btn-xs md:me-1" onclick="openTradeModal('buy', '{{$myPortfolio->symbol}}', '{{$myPortfolio->name}}', '{{$myPortfolio->latest_price}}', '{{ $myPortfolio->institutional_price }}', '{{ $myPortfolio->gcurrency }}', '{{$myPortfolio->shares}}', '{{$myPortfolio->wherefrom}}', '{{$myPortfolio->bond->exchange}}', '{{$currency_rate}}')">Buy</button>
                                                                    <button class="btn btn-pill btn-outline-danger btn-xs md:ms-1" onclick="openTradeModal('sell', '{{$myPortfolio->symbol}}', '{{$myPortfolio->name}}', '{{$myPortfolio->latest_price}}', '{{ $myPortfolio->institutional_price }}', '{{ $myPortfolio->gcurrency }}', '{{$myPortfolio->shares}}', '{{$myPortfolio->wherefrom}}', '{{$myPortfolio->bond->exchange}}', '{{$currency_rate}}')">Sell</button>
                                                                </td>
                                                            </tr>
                                                            @if ($cnt == 5)
                                                                @break
                                                            @endif
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
                                                <div class="table-responsive d-sm-none" style="height: 400px; width:100%;">
                                                    <table style="white-space: nowrap;" class="table table-responsive-sm">
                                                        <thead>
                                                            <tr>
                                                                <th style="font-size:13px;">Bond</th>
                                                                <th style="font-size:13px; min-width:100px;">Unit Price</th>
                                                                <th style="font-size:13px;">Change</th>
                                                                <th style="font-size:13px; min-width:100px;">Mkt Price</th>
                                                                <th style="font-size:13px;">Units</th>
                                                                <th style="font-size:13px;">Value</th>
                                                                <th class="text-center table-secondary" style="right: 0px; max-width:90px; position: sticky; white-space:initial;">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if(count($myPortfolios) != 0)
                                                            @foreach($myPortfolios as $myPortfolio)
                                                            @if($myPortfolio->wherefrom == 2)
                                                            <tr>
                                                                <td class="py-03">
                                                                    <a href="{{ route('bonds.show', ['symbol' => $myPortfolio->symbol]) }}" style="color:#24695c;">
                                                                        <span class="f-w-600">{{$myPortfolio->symbol}}</span>
                                                                        <p style="text-overflow: ellipsis; overflow: hidden; white-space: nowrap; max-width:150px;" class="f-w-400">{{$myPortfolio->name}}</p>
                                                                    </a>
                                                                </td>
                                                                <td class="py-03" style="vertical-align: middle;">{{ ($myPortfolio->latest_price)?$myPortfolio->bond->formatPrice($myPortfolio->latest_price):"-"}}</td>
                                                                <td class="py-03" style="vertical-align: middle;">
                                                                    <span class="{{($myPortfolio->change_percentage > 0)?'text-success f-w-600':'text-danger f-w-600'}}">
                                                                        {{ ($myPortfolio->change_percentage)?(number_format($myPortfolio->change_percentage*100, 2)."%"):"-"}}
                                                                    </span>
                                                                </td>
                                                                <td class="py-03" style="vertical-align: middle;">{{ ($myPortfolio->institutional_price) ? $myPortfolio->bond->formatPrice($myPortfolio->institutional_price):"-"}}</td>
                                                                <td class="py-03" style="vertical-align: middle;">{{ (fmod($myPortfolio->shares, 1) !== 0.000)?$myPortfolio->shares:number_format($myPortfolio->shares, 0) }}</td>
                                                                <td class="py-03" style="vertical-align: middle;">{{ ($myPortfolio->latest_price)?$myPortfolio->bond->formatPrice(round($myPortfolio->latest_price*$myPortfolio->shares, 2)):"-" }}</td>
                                                                <td class="py-03" class="text-center table-secondary" style="max-width:90px; text-align:center; vertical-align:middle; background-color:#e2e3e5; position: sticky; right:0px; white-space:initial;">
                                                                    <button class="btn btn-pill btn-outline-primary btn-xs md:me-1" onclick="openTradeModal('buy', '{{$myPortfolio->symbol}}', '{{$myPortfolio->name}}', '{{$myPortfolio->latest_price}}', '{{ $myPortfolio->institutional_price }}', '{{ $myPortfolio->gcurrency }}', '{{$myPortfolio->shares}}', '{{$myPortfolio->wherefrom}}', '{{$myPortfolio->bond->exchange}}', '{{$currency_rate}}')">Buy</button>
                                                                    <button class="btn btn-pill btn-outline-danger btn-xs md:ms-1" onclick="openTradeModal('sell', '{{$myPortfolio->symbol}}', '{{$myPortfolio->name}}', '{{$myPortfolio->latest_price}}', '{{ $myPortfolio->institutional_price }}', '{{ $myPortfolio->gcurrency }}', '{{$myPortfolio->shares}}', '{{$myPortfolio->wherefrom}}', '{{$myPortfolio->bond->exchange}}', '{{$currency_rate}}')">Sell</button>
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
                                            <div class="tab-pane fade" id="crypto_portfolio" role="tabpanel" aria-labelledby="crypto-portfolio">
                                                <div class="table-responsive d-none d-sm-block" style="height: 350px; width:100%;">
                                                    <table style="white-space: nowrap;" class="table table-responsive-sm">
                                                        <thead>
                                                            <tr>
                                                                <th style="font-size:13px;">Coin</th>
                                                                <th style="font-size:13px; min-width:100px;">Last Price</th>
                                                                <th style="font-size:13px;">Change</th>
                                                                <th style="font-size:13px; min-width:100px;">Inst. Price</th>
                                                                <th style="font-size:13px;">Units</th>
                                                                <th style="font-size:13px;">Value</th>
                                                                <th class="text-center table-secondary" style="position:sticky; right: 0px; width:120px;">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if(count($myPortfolios) != 0)
                                                            @foreach($myPortfolios as $myPortfolio)
                                                            @if($myPortfolio->wherefrom == 3)
                                                            <tr>
                                                                <td class="py-03">
                                                                    <a href="{{ route('cryptos.show', ['symbol' => $myPortfolio->symbol]) }}" style="color:#24695c;">
                                                                        <span class="f-w-600">{{$myPortfolio->symbol}}</span>
                                                                        <p style="text-overflow: ellipsis; overflow: hidden; white-space: nowrap; max-width:150px;" class="f-w-400">{{$myPortfolio->name}}</p>
                                                                    </a>
                                                                </td>
                                                                <td class="py-03" style="vertical-align: middle;">{{ ($myPortfolio->latest_price)?$myPortfolio->crypto->formatPrice($myPortfolio->latest_price):"-"}}</td>
                                                                <td class="py-03" style="vertical-align: middle;">
                                                                    <span class="{{($myPortfolio->change_percentage > 0)?'text-success f-w-600':'text-danger f-w-600'}}">
                                                                        {{ ($myPortfolio->change_percentage)?(number_format($myPortfolio->change_percentage*1, 2)."%"):"-"}}
                                                                    </span>
                                                                </td>
                                                                <td class="py-03" style="vertical-align: middle;">{{ ($myPortfolio->institutional_price) ? $myPortfolio->institutional_price:"-"}}</td>
                                                                <td class="py-03" style="vertical-align: middle;">{{ (fmod($myPortfolio->shares, 1) !== 0.000)?$myPortfolio->shares:number_format($myPortfolio->shares, 0) }}</td>
                                                                <td class="py-03" style="vertical-align: middle;">{{ ($myPortfolio->latest_price)?$myPortfolio->crypto->formatPrice(round($myPortfolio->latest_price*$myPortfolio->shares, 2)):"-" }}</td>
                                                                <td class="py-03" class="text-center table-secondary" style="width:120px; text-align:center; vertical-align:middle; background-color:#e2e3e5; position:sticky; right:0px;">
                                                                    <button class="btn btn-pill btn-outline-primary btn-xs md:me-1" onclick="openTradeModal('buy', '{{$myPortfolio->symbol}}', '{{$myPortfolio->name}}', '{{$myPortfolio->latest_price}}', '{{ $myPortfolio->institutional_price }}', '{{ $myPortfolio->gcurrency }}', '{{$myPortfolio->shares}}', '{{$myPortfolio->wherefrom}}', 'crypto', '{{$currency_rate}}')">Buy</button>
                                                                    <button class="btn btn-pill btn-outline-danger btn-xs md:ms-1" onclick="openTradeModal('sell', '{{$myPortfolio->symbol}}', '{{$myPortfolio->name}}', '{{$myPortfolio->latest_price}}', '{{ $myPortfolio->institutional_price }}', '{{ $myPortfolio->gcurrency }}', '{{$myPortfolio->shares}}', '{{$myPortfolio->wherefrom}}', 'crypto', '{{$currency_rate}}')">Sell</button>
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
                                                <div class="table-responsive d-sm-none" style="height: 400px; width:100%;">
                                                    <table style="white-space: nowrap;" class="table table-responsive-sm">
                                                        <thead>
                                                            <tr>
                                                                <th style="font-size:13px;">Coin</th>
                                                                <th style="font-size:13px; min-width:100px;">Last Price</th>
                                                                <th style="font-size:13px;">Change</th>
                                                                <th style="font-size:13px; min-width:100px;">Inst. Price</th>
                                                                <th style="font-size:13px;">Units</th>
                                                                <th style="font-size:13px;">Value</th>
                                                                <th class="text-center table-secondary" style="position: sticky; right: 0px; max-width:90px; white-space:initial;">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if(count($myPortfolios) != 0)
                                                            <?php $cnt = 0 ?>
                                                            @foreach($myPortfolios as $myPortfolio)
                                                            @if($myPortfolio->wherefrom == 3)
                                                            <?php $cnt++; ?>
                                                            <tr>
                                                                <td class="py-03">
                                                                    <a href="{{ route('cryptos.show', ['symbol' => $myPortfolio->symbol]) }}" style="color:#24695c;">
                                                                        <span class="f-w-600">{{$myPortfolio->symbol}}</span>
                                                                        <p style="text-overflow: ellipsis; overflow: hidden; white-space: nowrap; max-width:150px;" class="f-w-400">{{$myPortfolio->name}}</p>
                                                                    </a>
                                                                </td>
                                                                <td class="py-03" style="vertical-align: middle;">{{ ($myPortfolio->latest_price)?$myPortfolio->crypto->formatPrice($myPortfolio->latest_price):"-"}}</td>
                                                                <td class="py-03" style="vertical-align: middle;">
                                                                    <span class="{{($myPortfolio->change_percentage > 0)?'text-success f-w-600':'text-danger f-w-600'}}">
                                                                        {{ ($myPortfolio->change_percentage)?(number_format($myPortfolio->change_percentage*1, 2)."%"):"-"}}
                                                                    </span>
                                                                </td>
                                                                <td class="py-03" style="vertical-align: middle;">{{ ($myPortfolio->institutional_price) ? $myPortfolio->institutional_price:"-"}}</td>
                                                                <td class="py-03" style="vertical-align: middle;">{{ (fmod($myPortfolio->shares, 1) !== 0.000)?$myPortfolio->shares:number_format($myPortfolio->shares, 0) }}</td>
                                                                <td class="py-03" style="vertical-align: middle;">{{ ($myPortfolio->latest_price)?$myPortfolio->crypto->formatPrice(round($myPortfolio->latest_price*$myPortfolio->shares, 2)):"-" }}</td>
                                                                <td class="py-03" class="text-center table-secondary" style="max-width:90px; text-align:center; vertical-align:middle; background-color:#e2e3e5; position: sticky; right:0px; white-space:initial;">
                                                                    <button class="btn btn-pill btn-outline-primary btn-xs md:me-1" onclick="openTradeModal('buy', '{{$myPortfolio->symbol}}', '{{$myPortfolio->name}}', '{{$myPortfolio->latest_price}}', '{{ $myPortfolio->institutional_price }}', '{{ $myPortfolio->gcurrency }}', '{{$myPortfolio->shares}}', '{{$myPortfolio->wherefrom}}', 'crypto', '{{$currency_rate}}')">Buy</button>
                                                                    <button class="btn btn-pill btn-outline-danger btn-xs md:ms-1" onclick="openTradeModal('sell', '{{$myPortfolio->symbol}}', '{{$myPortfolio->name}}', '{{$myPortfolio->latest_price}}', '{{ $myPortfolio->institutional_price }}', '{{ $myPortfolio->gcurrency }}', '{{$myPortfolio->shares}}', '{{$myPortfolio->wherefrom}}', 'crypto', '{{$currency_rate}}')">Sell</button>
                                                                </td>
                                                            </tr>
                                                            @if ($cnt == 5)
                                                                @break
                                                            @endif
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
                                            <div class="modal fade" id="tradeModal" tabindex="-1" role="dialog" aria-labelledby="Trade Shares Modal" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 id="modal_title" class="modal-title"></h5>
                                                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h6>Below you will find the most recent information about the <span id="wherefrom_home" class="f-w-600">stock</span> you would like to <span id="trade_type" class="f-w-600">buy shares</span> from.</h6>
                                                            <table style="white-space: nowrap;" class="table">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <strong>Symbol</strong>
                                                                        </td>
                                                                        <td><strong id="trade_symbol"></strong></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <strong>Company/Name</strong>
                                                                        </td>
                                                                        <td><strong id="trade_company" style="text-overflow: ellipsis; overflow: hidden; white-space: nowrap; max-width:200px;"></strong></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <strong id="home_last_price_label">Retail Price</strong>
                                                                        </td>
                                                                        <td><strong id="trade_price"></strong></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <strong id="home_inst_price_label">Institutional Price</strong>
                                                                        </td>
                                                                        <td><strong id="trade_institutional_price"></strong></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <small id="trade_is_xnys" class="d-block mb-3">Our platform includes both real time pricing and end of day pricing. When submitting a trade, we will confirm the actual price with you.</small>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-sm-7">
                                                                        <label class="form-label" id="shares-label" style="color:#24695c !important;">Shares</label>
                                                                        <input type="number" class="form-control" placeholder="Enter the amount of $" required id="shares_amount" style="width: 90%; margin-bottom:10px;">
                                                                    </div>
                                                                    <div class="col-sm-5">
                                                                        <label class="form-label" id="shares-label" style="color:#24695c !important;">Local Currency</label>
                                                                        <label for="" style="width: 100%;">
                                                                            @if($user_currency == 'AUD')
                                                                            <span style="float: left; padding-top:6px; padding-right:5px;">A$</span>
                                                                            @elseif($user_currency == 'GBP')
                                                                            <span style="float: left; padding-top:6px; padding-right:5px;">£</span>
                                                                            @elseif($user_currency == 'EUR')
                                                                            <span style="float: left; padding-top:6px; padding-right:5px;">€</span>
                                                                            @else
                                                                            <span style="float: left; padding-top:6px; padding-right:5px;">$</span>
                                                                            @endif
                                                                            <input type="number" class="form-control" required id="local_calc_amount" style="width: 84%;" disabled="">
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-sm-12" style="color:#24695c !important;"><p>Number of shares: <span id="calc_shares">23</span></p></div>
                                                                </div>
                                                                <small class="text-info" style="color:#24695c!important">Your account manager will contact you as soon as possible to confirm best price.</small>
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
                                <div class="card-header p-t-20 p-b-15">
                                    <div class="header-top d-sm-flex align-items-center">
                                        <h5><span>Monthly Account Performance</span></h5>
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
                                <h5><span>Available Bonds</span></h5>
                            </div>
                            <a class="btn btn-outline-success btn-xs" href="{{ route('bonds.search') }}">see more</a>
                        </div>
                        <div class="card-body p-0">
                        <div class="table-responsive" style="height: 390px; width:100%; overflow:hidden;">
                            <table style="white-space: nowrap;" class="table table-responsive-sm  table-sm">
                                <thead>
                                    <tr>
                                    <th style="padding:8px 32px;">Name</th>
                                    <th class="text-center"  style="padding:8px;">Bond Type</th>
                                    <th class="text-center"  style="padding:8px;">Price</th>
                                    <th class="text-center d-none d-sm-table-cell"  style="padding:8px;">Coupon</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($bonds) != 0)
                                    @foreach($bonds as $bond)
                                    <tr>
                                        <td class="text-nowrap" style="color:#24695c; vertical-align: middle; padding:8px 32px;">
                                            <span class="f-w-600">{{ $bond->symbol }}</span>
                                            <p style="text-overflow: ellipsis; overflow: hidden; white-space: nowrap; max-width:150px;">{{$bond->name}}</p>
                                        </td>
                                        <td class="text-center text-nowrap" style="vertical-align: middle; padding:8px;">{{ $bond->exchange }}</td>
                                        <td class="text-center text-nowrap" style="vertical-align: middle; padding:8px;">{{ "A$".$bond->price }}</td>
                                        <td class="text-center text-nowrap d-none d-sm-table-cell" style="vertical-align: middle; padding:8px;">{{ $bond->coupon_pa }}</td>
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
                <div class="col-xl-6 box-col-12 des-xl-100">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-top d-sm-flex align-items-center">
                                <h5><span>Top Cryptocurrencies</span></h5>
                            </div>
                            <a class="btn btn-outline-success btn-xs" href="{{ route('cryptos.search') }}">see more</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive" style="height: 390px; width:100%; overflow-y:hidden; overflow-x:hidden;">
                                <table style="white-space: nowrap;" class="table table-responsive-sm table-sm">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="padding: 8px 16px;">Logo</th>
                                            <th class="text-center" style="padding: 8px 16px;">Coin</th>
                                            <th class="text-center" style="padding: 8px 16px;">Current Price</th>
                                            <th class="text-center d-none d-sm-table-cell" style="padding: 8px 16px;">Market Cap</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($top_cryptos) != 0)
                                        @foreach($top_cryptos as $top_crypto)
                                        <tr>
                                            <td class="text-center" style="vertical-align: middle; padding: 8px 16px;"><img src="{{ $top_crypto['image'] }}" width="30" alt=""></td>
                                            <td class="text-center" style="padding: 8px 16px;">
                                                <span class="f-w-600">{{$top_crypto['symbol']}}</span>
                                                <p>
                                                    {{$top_crypto['name']}}
                                                </p>
                                            </td>
                                            <td class="text-center" style="vertical-align: middle; padding: 8px 16px;">{{ '$'.number_format($top_crypto['current_price'], 2) }}</td>
                                            <td class="text-center d-none d-sm-table-cell" style="vertical-align: middle; padding: 8px 16px;">{{ number_format($top_crypto['market_cap'], 0) }}</td>
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
                                <h5><span>Highlighted Stocks, Funds, Bonds and Cryptos</span></h5>
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
                                            <div class="owl-carousel-16 owl-carousel owl-theme" id="bond_carousel">
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
                            <div class="owl-carousel owl-theme" id="owl-carousel-15">
                                <div class="item">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="owl-carousel-16 owl-carousel owl-theme" id="highlight_carousel1">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="owl-carousel-16 owl-carousel owl-theme" id="highlight_carousel2">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="owl-carousel-16 owl-carousel owl-theme" id="highlight_carousel3">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="owl-carousel-16 owl-carousel owl-theme" id="highlight_carousel4">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="owl-carousel-16 owl-carousel owl-theme" id="highlight_carousel5">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="owl-carousel-16 owl-carousel owl-theme" id="highlight_carousel6">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="owl-carousel-16 owl-carousel owl-theme" id="highlight_carousel7">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="owl-carousel-16 owl-carousel owl-theme" id="highlight_carousel8">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="owl-carousel-16 owl-carousel owl-theme" id="highlight_carousel9">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="owl-carousel-16 owl-carousel owl-theme" id="highlight_carousel10">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="owl-carousel-16 owl-carousel owl-theme" id="highlight_carousel11">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="owl-carousel-16 owl-carousel owl-theme" id="highlight_carousel12">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="owl-carousel-16 owl-carousel owl-theme" id="highlight_carousel13">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="owl-carousel-16 owl-carousel owl-theme" id="highlight_carousel14">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="owl-carousel-16 owl-carousel owl-theme" id="highlight_carousel15">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="owl-carousel-16 owl-carousel owl-theme" id="highlight_carousel16">
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
                                <h5><span>Recent Activity</span></h5>
                            </div>
                            <a class="btn btn-outline-success btn-xs" href="{{ route('transactions') }}">see more</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive" style="height: 317px; width:100%;">
                                <table style="white-space: nowrap;" class="table table-responsive-sm">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Symbol</th>
                                            <th class="text-center">Type</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">Shares/Units</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($transactions) != 0)
                                        @foreach($transactions->take(5) as $transaction)
                                        <tr>
                                            <td class="text-center f-w-600">{{ $transaction->symbol }}</td>
                                            <td class="text-center">{{ $transaction->type }}</td>
                                            <td class="text-center">{{ $transaction->wherefrom=="0"?$transaction->stock->formatPrice($transaction->price):($transaction->wherefrom=="1"?$transaction->fund->formatPrice($transaction->price):($transaction->wherefrom=="2"?$transaction->bond->formatPrice($transaction->price):$transaction->crypto->formatPrice($transaction->price)))}}</td>
                                            <td class="py-03 text-center" style="vertical-align: middle;">{{ (fmod($transaction->shares, 1) !== 0.000)?number_format($transaction->shares, 3):number_format($transaction->shares, 0) }}</td>
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
                <div class="col-xl-6 box-col-12 des-xl-100">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-top d-sm-flex align-items-center">
                                <h5><span>Recent Document</span></h5>
                            </div>
                            <a class="btn btn-outline-success btn-xs" href="{{ route('documents.index') }}">see more</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive" style="height: 317px; width:100%; overflow-x:hidden;">
                                <table style="white-space: nowrap;" class="table table-responsive-sm">
                                    <thead>
                                        <tr>
                                            <th class="text-center d-none d-sm-block">Type</th>
                                            <th class="text-center f-w-600">Title</th>
                                            <th class="text-center">Provided by</th>
                                            <th class="text-center"><i class="fa fa-download"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($documents) != 0)
                                        @foreach($documents as $document)
                                        <tr>
                                            <td class="text-center d-none d-sm-block">{{ $document->type }}</td>
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
                <div class="col-xl-12 box-col-12 des-xl-100">
                    <div class="card news-container">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-top d-sm-flex align-items-center">
                                <h5><span>Recent News</span></h5>
                            </div>
                            <a href="/news?symbols={{implode(',', $news_symbols)}}" class="btn btn-outline-success btn-xs">See More</a>
                        </div>
                        <div class="card-body">
                            <div class="loader-box news-loader justify-content-center align-items-center w-full" style="inset:0px; position:absolute; z-index:10; display:flex; height:initial;">
                                <div class="loader-19"></div>
                            </div>
                            <div class="row news-content" style="min-height: 440px;">
                                <div class="col-xl-3 col-md-6 des-xl-50 news-0" style="display: none;">
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
                                <div class="col-xl-3 col-md-6 des-xl-50 news-1" style="display: none;">
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
                                <div class="col-xl-3 col-md-6 des-xl-50 news-2" style="display: none;">
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
                                <div class="col-xl-3 col-md-6 des-xl-50 news-3" style="display: none;">
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
    var news_symbols = {!!json_encode($news_symbols) !!}
    var total_value = "{{ $total_transaction_price }}";
    var currency_rate = "{{ $currency_rate }}";
    var user_currency = "{{ $user_currency }}";

    $('#total_profile_value').text(formatPrice(Number(total_value*currency_rate)));
    $('#cash_on_account').text(formatPrice(Number('{{ (auth()->user()->getBalance())?auth()->user()->getBalance()->amount:0 }}')));
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