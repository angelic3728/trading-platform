@extends('layouts.dashboard')

@section('title', 'Dashboard')

@push('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/chartist.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/date-picker.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/prism.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vector-map.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/scrollable.css')}}">
@endpush
@section('content')
<!-- Container-fluid starts-->
<div class="container-fluid dashboard-default-sec">
    <div class="row dashboard-content-wrapper">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-xl-12">
                    <div class="d-flex justify-content-center align-items-center" id="ad1_container">
                        <a href="https://bannerboo.com/" target="_blank">
                            <img src="{{asset('assets/images/pros/horizontal.png')}}" class="img-fluid" alt="">
                        </a>
                    </div>
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
                                    <h5>$ <span class="counter">{{$total_transaction_price}}</span></h5>
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
                                        <span class="f-w-800">$</span>
                                        @endif
                                        @if(auth()->user()->getBalance() && auth()->user()->getBalance()->currency == 'AUD')
                                        <span class="f-w-800">A$</span>
                                        @endif
                                        @if(auth()->user()->getBalance() && auth()->user()->getBalance()->currency == 'GBP')
                                        <span class="f-w-800">£</span>
                                        @endif
                                        @if(auth()->user()->getBalance())
                                        <span class="counter">{{ auth()->user()->getBalance()->amount }}</span>
                                        @else
                                        <span>0</span>
                                        @endif
                                    </h5>
                                    <p>Your Account Balance</p>
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
                                <ul class="pull-right nav nav-tabs border-tab nav-success" id="chart_tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="stock_chart_tab" data-bs-toggle="tab" href="#stock_chart" role="tab" aria-controls="stock-chart" aria-selected="false"><i class="icofont icofont-ui-home"></i>Stocks</a>
                                        <div class="material-border"></div>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="mfd_chart_tab" data-bs-toggle="tab" href="#mfd_chart" role="tab" aria-controls="mfd-chart" aria-selected="true">
                                            <i class="fa fa-cloud"></i>Funds
                                        </a>
                                        <div class="material-border"></div>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade active show" id="stock_chart" role="tabpanel" aria-labelledby="stock-chart">
                                        <div id="chart-timeline-dashbord1"></div>
                                    </div>
                                    <div class="tab-pane fade" id="mfd_chart" role="tabpanel" aria-labelledby="mutualfund-chart">
                                        <div id="chart-timeline-dashbord2"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center align-items-center" id="ad2_container">
                <div class="scrollbar-margins large-margin scroll-demo p-0" style="height: 100%;">
                    <ul>
                        <li>
                            <a href="https://bannerboo.com/" target="_blank">
                                <img src="{{asset('assets/images/pros/vertical1.png')}}" class="img-fluid" alt="">
                            </a>
                        </li>
                        <li class="mt-3">
                            <a href="https://bannerboo.com/" target="_blank">
                                <img src="{{asset('assets/images/pros/vertical2.png')}}" class="img-fluid" alt="">
                            </a>
                        </li>
                    </ul>                
                </div>
                <a href="javascript:void(0)" onclick="hide_ad()" style="position: absolute; top:10px; right:10px;"><i class="fa fa-times fs-5"></i></a>
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
                                                <a class="nav-link active" id="stock_tab" data-bs-toggle="tab" href="#stock_portfolio" role="tab" aria-controls="stock-portfolio" aria-selected="false"><i class="icofont icofont-ui-home"></i>Stocks</a>
                                                <div class="material-border"></div>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="mfd_tab" data-bs-toggle="tab" href="#mfd_portfolio" role="tab" aria-controls="mfd-portfolio" aria-selected="true">
                                                    <i class="fa fa-cloud"></i>Funds
                                                </a>
                                                <div class="material-border"></div>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="portfolio_content">
                                            <div class="tab-pane fade active show" id="stock_portfolio" role="tabpanel" aria-labelledby="stock-portfolio">
                                                <div class="vertical-scroll scroll-demo p-0">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-responsive table-responsive-sm">
                                                            <thead>
                                                                <tr>
                                                                    <th>Company</th>
                                                                    <th>Last Price</th>
                                                                    <th>Change</th>
                                                                    <th>Institutional Price</th>
                                                                    <th>Shares</th>
                                                                    <th>Value</th>
                                                                    <th class="text-center table-secondary" style="right: 0px; min-width:140px;">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($transactions as $transaction)
                                                                @if($transaction->is_fund == 0)
                                                                <tr>
                                                                    <td class="d-flex flex-column">
                                                                        <span class="f-w-600">{{$transaction->symbol}}</span>
                                                                        <small>{{$transaction->company_name}}</small>
                                                                    </td>
                                                                    <td>{{ ($transaction->latest_price)?$transaction->stock->formatPrice($transaction->latest_price):"-"}}</td>
                                                                    <td>
                                                                        <span class="{{($transaction->change_percentage > 0)?'text-success f-w-600':'text-danger f-w-600'}}">
                                                                            {{ ($transaction->change_percentage)?(($transaction->change_percentage*100)."%"):"-"}}
                                                                        </span>
                                                                    </td>
                                                                    <td>{{ ($transaction->institutional_price) ? $transaction->stock->formatPrice($transaction->institutional_price):"-"}}</td>
                                                                    <td>{{$transaction->shares}}</td>
                                                                    <td>{{ ($transaction->latest_price)?round($transaction->price*$transaction->shares, 2):"-" }}</td>
                                                                    <td class="text-center table-secondary" style="right: 0px; min-width:140px;">
                                                                        <button class="btn btn-pill btn-outline-primary btn-xs me-1" onclick="openTradeModel('buy', '{{$transaction->symbol}}', '{{$transaction->company_name}}', '{{$transaction->latest_price}}', '{{ $transaction->institutional_price }}', '{{ $transaction->gcurrency }}', '{{$transaction->shares}}', '{{$transaction->is_fund}}', '{{$transaction->stock->exchange}}')">Buy</button>
                                                                        <button class="btn btn-pill btn-outline-danger btn-xs ms-1" onclick="openTradeModel('sell', '{{$transaction->symbol}}', '{{$transaction->company_name}}', '{{$transaction->latest_price}}', '{{ $transaction->institutional_price }}', '{{ $transaction->gcurrency }}', '{{$transaction->shares}}', '{{$transaction->is_fund}}', '{{$transaction->stock->exchange}}')">Sell</button>
                                                                    </td>
                                                                </tr>
                                                                @endif
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="mfd_portfolio" role="tabpanel" aria-labelledby="mfd-portfolio">
                                                <div class="vertical-scroll scroll-demo p-0">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-responsive table-responsive-sm">
                                                            <thead>
                                                                <tr>
                                                                    <th>Company</th>
                                                                    <th>Last Price</th>
                                                                    <th>Change</th>
                                                                    <th>Institutional Price</th>
                                                                    <th>Shares</th>
                                                                    <th>Value</th>
                                                                    <th class="text-center table-secondary" style="right: 0px; width:140px;">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($transactions as $transaction)
                                                                @if($transaction->is_fund == 1)
                                                                <tr>
                                                                    <td class="d-flex flex-column">
                                                                        <span class="f-w-600">{{$transaction->symbol}}</span>
                                                                        <small>{{$transaction->company_name}}</small>
                                                                    </td>
                                                                    <td>{{ ($transaction->latest_price)?$transaction->mutualFund->formatPrice($transaction->latest_price):"-"}}</td>
                                                                    <td>
                                                                        <span class="{{($transaction->change_percentage > 0)?'text-success f-w-600':'text-danger f-w-600'}}">
                                                                            {{ ($transaction->change_percentage)?(($transaction->change_percentage*100)."%"):"-"}}
                                                                        </span>
                                                                    </td>
                                                                    <td>{{ ($transaction->institutional_price) ? $transaction->mutualFund->formatPrice($transaction->institutional_price):"-"}}</td>
                                                                    <td>{{ $transaction->shares }}</td>
                                                                    <td>{{ ($transaction->latest_price)?round($transaction->price*$transaction->shares, 2):"-" }}</td>
                                                                    <td class="text-center table-secondary" style="right: 0px; width:140px;">
                                                                        <button class="btn btn-pill btn-outline-primary btn-xs me-1" onclick="openTradeModel('buy', '{{$transaction->symbol}}', '{{$transaction->company_name}}', '{{$transaction->latest_price}}', '{{ $transaction->institutional_price }}', '{{ $transaction->gcurrency }}', '{{$transaction->shares}}', '{{$transaction->is_fund}}', '{{$transaction->mutualFund->exchange}}')">Buy</button>
                                                                        <button class="btn btn-pill btn-outline-danger btn-xs ms-1" onclick="openTradeModel('sell', '{{$transaction->symbol}}', '{{$transaction->company_name}}', '{{$transaction->latest_price}}', '{{ $transaction->institutional_price }}', '{{ $transaction->gcurrency }}', '{{$transaction->shares}}', '{{$transaction->is_fund}}', '{{$transaction->mutualFund->exchange}}')">Sell</button>
                                                                    </td>
                                                                </tr>
                                                                @endif
                                                                @endforeach
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
                                    <table class="table table-bordered table-responsive table-responsive-sm">
                                        <thead>
                                            <tr>
                                                <th class="text-center">CODE</th>
                                                <th class="text-center">COUPON P.A</th>
                                                <th class="text-center">PRICE</th>
                                                <th class="text-center">YTM</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($xtbs as $xtb)
                                            <tr>
                                                <td class="text-center text-nowrap text-secondary">{{ $xtb->asx_code }}</td>
                                                <td class="text-center text-nowrap text-info">{{ ($xtb->coupon_pa && $xtb->coupon_pa != "")?$xtb->coupon_pa:"-" }}</td>
                                                <td class="text-center text-nowrap text-success fw-bold">{{ "$".$xtb->xtb_price }}</td>
                                                <td class="text-center text-nowrap text-primary">{{ ($xtb->ytm !="")?$xtb->ytm."%":"-" }}</td>
                                            </tr>
                                            @endforeach
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
                                <h5>Recent Activity</h5>
                            </div>
                            <a class="btn btn-outline-success btn-xs" href="{{ route('transactions') }}">see more</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="vertical-scroll scroll-demo p-0">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-responsive table-responsive-sm">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Symbol</th>
                                                <th class="text-center">Type</th>
                                                <th class="text-center">Price</th>
                                                <th class="text-center">Shares</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($transactions->take(5) as $transaction)
                                            <tr>
                                                <td class="text-center">{{ $transaction->symbol }}</td>
                                                <td class="text-center">{{ $transaction->type }}</td>
                                                <td class="text-center">{{ $transaction->is_fund=="1"?$transaction->mutualFund->formatPrice($transaction->price):$transaction->stock->formatPrice($transaction->price) }}</td>
                                                <td class="text-center">{{ $transaction->shares }}</td>
                                            </tr>
                                            @endforeach
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
                                    <table class="table table-bordered table-responsive table-responsive-sm">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Type</th>
                                                <th class="text-center">Title</th>
                                                <th class="text-center">Provided by</th>
                                                <th class="text-center">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
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
                                    <table class="table table-bordered table-responsive table-responsive-sm">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Type</th>
                                                <th class="text-center">Title</th>
                                                <th class="text-center">Provided by</th>
                                                <th class="text-center">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
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
                                        </tbody>
                                    </table>
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
    var chartData = {!! $transactions->map(function($transaction) { return ['id' => $transaction->id, 'realPrice' => $transaction->realPrice, 'created_at' => $transaction->created_at, 'is_fund' => $transaction->is_fund, 'type' => $transaction->type];}) -> toJson() !!};
</script>
<script src="{{asset('assets/js/chart/chartist/chartist.js')}}"></script>
<script src="{{asset('assets/js/chart/chartist/chartist-plugin-tooltip.js')}}"></script>
<script src="{{asset('assets/js/chart/apex-chart/apex-chart.js')}}"></script>
<script src="{{asset('assets/js/chart/apex-chart/stock-prices.js')}}"></script>
<script src="{{asset('assets/js/prism/prism.min.js')}}"></script>
<script src="{{asset('assets/js/clipboard/clipboard.min.js')}}"></script>
<script src="{{asset('assets/js/counter/jquery.waypoints.min.js')}}"></script>
<script src="{{asset('assets/js/counter/jquery.counterup.min.js')}}"></script>
<script src="{{asset('assets/js/counter/counter-custom.js')}}"></script>
<script src="{{asset('assets/js/custom-card/custom-card.js')}}"></script>
<script src="{{asset('assets/js/notify/bootstrap-notify.min.js')}}"></script>
<script src="{{asset('assets/js/vector-map/jquery-jvectormap-2.0.2.min.js')}}"></script>
<script src="{{asset('assets/js/vector-map/map/jquery-jvectormap-world-mill-en.js')}}"></script>
<script src="{{asset('assets/js/scrollable/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('assets/js/scrollable/scrollable-custom.js')}}"></script>
<script src="{{asset('assets/js/dashboard/default.js')}}"></script>
<script src="{{asset('assets/js/notify/index.js')}}"></script>
<script src="{{asset('assets/js/datepicker/date-picker/datepicker.js')}}"></script>
<script src="{{asset('assets/js/datepicker/date-picker/datepicker.en.js')}}"></script>
<script src="{{asset('assets/js/datepicker/date-picker/datepicker.custom.js')}}"></script>
<script src="{{asset('assets/js/pages/common.js')}}"></script>
<script src="{{asset('assets/js/pages/dashboard/custom.js')}}"></script>
@endpush
@endsection
