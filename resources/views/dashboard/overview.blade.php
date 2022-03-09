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
@yield('breadcrumb-list')
<!-- Container-fluid starts-->
<div class="container-fluid dashboard-default-sec">
    <div class="row">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-xl-5 box-col-12 des-xl-100">
                    <div class="row">
                        <div class="col-xl-12 col-md-6 box-col-6 des-xl-50">
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
                        <div class="col-xl-6 col-md-3 col-sm-6 box-col-3 des-xl-25 rate-sec">
                            <div class="card income-card card-primary  p-t-10 p-b-10">
                                <div class="card-body text-center">
                                    <div class="round-box">
                                        <a href="javascript:void(0)">
                                            <i class="fa fa-money fs-4"></i>
                                        </a>
                                    </div>
                                    <h5>$ {{$total_transaction_price}}</h5>
                                    <p>Total Portfolio Value</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-3 col-sm-6 box-col-3 des-xl-25 rate-sec">
                            <div class="card income-card card-secondary p-t-10 p-b-10">
                                <div class="card-body text-center">
                                    <div class="round-box">
                                        <a href="javascript:void(0)">
                                            <i class="fa fa-credit-card-alt fs-4"></i>
                                        </a>
                                    </div>
                                    <h5>{{ auth()->user()->getBalance() }}</h5>
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
                                            <i class="fa fa-cloud"></i>Mutual Funds
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
                                                    <i class="fa fa-cloud"></i>Mutual Funds
                                                </a>
                                                <div class="material-border"></div>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="portfolio_content">
                                            <div class="tab-pane fade active show" id="stock_portfolio" role="tabpanel" aria-labelledby="stock-portfolio">
                                                <div class="scroll-bar-wrap">
                                                    <div class="both-side-scroll scroll-demo p-0">
                                                        <div class="horz-scroll-content">
                                                            <table class="table table-striped table-bordered" style="min-width: 1200px;">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-center">Symbol</th>
                                                                        <th class="text-center">Company Name</th>
                                                                        <th class="text-center">Last Price</th>
                                                                        <th class="text-center">Change Percentage</th>
                                                                        <th class="text-center">Institutional Price</th>
                                                                        <th class="text-center">Shares</th>
                                                                        <th class="text-center">Value</th>
                                                                        <th class="text-center position-sticky table-secondary" style="right: 0px; width:150px;">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($transactions as $transaction)
                                                                    @if($transaction->is_fund == 0)
                                                                    <tr>
                                                                        <td class="text-center">{{$transaction->symbol}}</td>
                                                                        <td class="text-center">{{$transaction->company_name}}</td>
                                                                        <td class="text-center fw-bold">{{ ($transaction->latest_price)?$transaction->stock->formatPrice($transaction->latest_price):"-"}}</td>
                                                                        <td class="text-center">{{ ($transaction->change_percentage)?(($transaction->change_percentage*100)."%"):"-"}}</td>
                                                                        <td class="text-center fw-bold">{{ ($transaction->institutional_price) ? $transaction->stock->formatPrice($transaction->institutional_price):"-"}}</td>
                                                                        <td class="text-center">{{$transaction->shares}}</td>
                                                                        <td class="text-center">{{ ($transaction->latest_price)?round($transaction->price*$transaction->shares, 2):"-" }}</td>
                                                                        <td class="text-center position-sticky table-secondary" style="right: 0px; width:150px;">
                                                                            <div>
                                                                                <button class="btn btn-pill btn-outline-primary btn-xs me-1" onclick="openTradeModel('buy', '{{$transaction->symbol}}', '{{$transaction->company_name}}', '{{$transaction->price}}', '{{ $transaction->institutional_price }}', '{{ $transaction->gcurrency }}', '{{$transaction->shares}}', '{{$transaction->is_fund}}', '{{$transaction->stock->exchange}}')">Buy</button>
                                                                                <button class="btn btn-pill btn-outline-danger btn-xs ms-1" onclick="openTradeModel('sell', '{{$transaction->symbol}}', '{{$transaction->company_name}}', '{{$transaction->price}}', '{{ $transaction->institutional_price }}', '{{ $transaction->gcurrency }}', '{{$transaction->shares}}', '{{$transaction->is_fund}}', '{{$transaction->stock->exchange}}')">Sell</button>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    @endif
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="mfd_portfolio" role="tabpanel" aria-labelledby="mfd-portfolio">
                                                <div class="scroll-bar-wrap">
                                                    <div class="both-side-scroll scroll-demo p-0">
                                                        <div class="horz-scroll-content">
                                                            <table class="table table-striped table-bordered" style="min-width: 1200px;">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-center">Symbol</th>
                                                                        <th class="text-center">Company Name</th>
                                                                        <th class="text-center">Last Price</th>
                                                                        <th class="text-center">Change Percentage</th>
                                                                        <th class="text-center">Institutional Price</th>
                                                                        <th class="text-center">Shares</th>
                                                                        <th class="text-center">Value</th>
                                                                        <th class="text-center position-sticky table-secondary" style="right: 0px; width:150px;">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($transactions as $transaction)
                                                                    @if($transaction->is_fund == 1)
                                                                    <tr>
                                                                        <td class="text-center">{{ $transaction->symbol }}</td>
                                                                        <td class="text-center">{{ $transaction->company_name }}</td>
                                                                        <td class="text-center fw-bold">{{ ($transaction->latest_price)?$transaction->mutualFund->formatPrice($transaction->latest_price):"-"}}</td>
                                                                        <td class="text-center">{{ ($transaction->change_percentage)?(($transaction->change_percentage*100)."%"):"-"}}</td>
                                                                        <td class="text-center fw-bold">{{ ($transaction->institutional_price) ? $transaction->mutualFund->formatPrice($transaction->institutional_price):"-"}}</td>
                                                                        <td class="text-center">{{ $transaction->shares }}</td>
                                                                        <td class="text-center">{{ ($transaction->latest_price)?round($transaction->price*$transaction->shares, 2):"-" }}</td>
                                                                        <td class="text-center position-sticky table-secondary" style="right: 0px; width:150px;">
                                                                            <div>
                                                                                <button class="btn btn-pill btn-outline-primary btn-xs me-1" onclick="openTradeModel('buy', '{{$transaction->symbol}}', '{{$transaction->company_name}}', '{{$transaction->price}}', '{{ $transaction->institutional_price }}', '{{ $transaction->gcurrency }}', '{{$transaction->shares}}', '{{$transaction->is_fund}}', '{{$transaction->mutualFund->exchange}}')">Buy</button>
                                                                                <button class="btn btn-pill btn-outline-danger btn-xs ms-1" onclick="openTradeModel('sell', '{{$transaction->symbol}}', '{{$transaction->company_name}}', '{{$transaction->price}}', '{{ $transaction->institutional_price }}', '{{ $transaction->gcurrency }}', '{{$transaction->shares}}', '{{$transaction->is_fund}}', '{{$transaction->mutualFund->exchange}}')">Sell</button>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    @endif
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
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
                        <div class="col-xl-12 box-col-6 des-xl-50">
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
                <div class="col-xl-4 col-50 box-col-6 des-xl-50">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-top d-sm-flex align-items-center">
                                <h5>Available XTB's</h5>
                            </div>
                            <a class="btn btn-outline-success btn-xs" href="{{ route('xtbs') }}">see more</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="scroll-bar-wrap">
                                <div class="horizontal-scroll scroll-demo p-0">
                                    <div class="horz-scroll-content">
                                        <table class="table table-striped table-bordered" style="min-width: 1200px;">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">ASX CODE</th>
                                                    <th class="text-center">BOND ISSUER</th>
                                                    <th class="text-center">MATURITY DATE</th>
                                                    <th class="text-center">COUPON TYPE</th>
                                                    <th class="text-center">NEXT EX.DATE</th>
                                                    <th class="text-center">COUPON P.A</th>
                                                    <th class="text-center">XTB PRICE</th>
                                                    <th class="text-center">YTM</th>
                                                    <th class="text-center">RUNNING CURRENT YIELD</th>
                                                    <th class="text-center">TRADING MARGIN</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($xtbs as $xtb)
                                                <tr>
                                                    <td class="text-center text-nowrap text-secondary">{{ $xtb->asx_code }}</td>
                                                    <td class="text-center text-nowrap"><a href="https://xtbs.com.au/xtbs-profile/{{ $xtb->asx_code }}" target="_blank">{{ $xtb->bond_issuer }}</a></td>
                                                    <td class="text-center">{{ $xtb->maturity_date }}</td>
                                                    <td class="text-center text-nowrap text-secondary">{{ ($xtb->coupon_type == "")?$xtb->coupon_type:"-" }}</td>
                                                    <td class="text-center text-center text-nowrap text-secondary">{{ $xtb->next_ex_date }}</td>
                                                    <td class="text-center text-nowrap text-info">{{ ($xtb->coupon_pa && $xtb->coupon_pa != "")?$xtb->coupon_pa:"-" }}</td>
                                                    <td class="text-center text-nowrap text-success fw-bold">{{ "$".$xtb->xtb_price }}</td>
                                                    <td class="text-center text-nowrap text-primary">{{ ($xtb->ytm !="")?$xtb->ytm."%":"-" }}</td>
                                                    <td class="text-center text-nowrap text-dark">{{ $xtb->current_yield."%" }}</td>
                                                    <td class="text-center text-nowrap text-danger">{{ ($xtb->trading_margin !="")?$xtb->trading_margin."%":"-" }}</td>
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
                <div class="col-xl-4 col-50 box-col-6 des-xl-50">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-top d-sm-flex align-items-center">
                                <h5>Recent Account Activity</h5>
                            </div>
                            <a class="btn btn-outline-success btn-xs" href="{{ route('transactions') }}">see more</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="scroll-bar-wrap">
                                <div class="horizontal-scroll scroll-demo p-0">
                                    <div class="horz-scroll-content">
                                        <table class="table table-striped table-bordered" style="min-width: 1200px;">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Symbol</th>
                                                    <th class="text-center">Type</th>
                                                    <th class="text-center">Company Name</th>
                                                    <th class="text-center">Price</th>
                                                    <th class="text-center">Shares</th>
                                                    <th class="text-center">Date</th>
                                                    <th class="text-center">Market</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($transactions->take(5) as $transaction)
                                                <tr>
                                                    <td class="text-center">{{ $transaction->symbol }}</td>
                                                    <td class="text-center">{{ $transaction->type }}</td>
                                                    <td class="text-center">
                                                        <small>{{ $transaction->company_name }}</small>
                                                    </td>
                                                    <td class="text-center">{{ $transaction->is_fund=="1"?$transaction->mutualFund->formatPrice($transaction->price):$transaction->stock->formatPrice($transaction->price) }}</td>
                                                    <td class="text-center">{{ $transaction->shares }}</td>
                                                    <td class="text-center">{{ $transaction->created_at }}</td>
                                                    <td class="text-center">{{ $transaction->is_fund=="1"?"Mutual Fund":"Stock" }}</td>
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
                <div class="col-xl-4 box-col-6 des-xl-50">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-top d-sm-flex align-items-center">
                                <h5>Recent Document</h5>
                            </div>
                            <a class="btn btn-outline-success btn-xs" href="{{ route('documents.index') }}">see more</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="scroll-bar-wrap">
                                <div class="horizontal-scroll scroll-demo p-0">
                                    <div class="horz-scroll-content">
                                        <table class="table table-striped table-bordered" style="min-width: 1200px;">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Type</th>
                                                    <th class="text-center">Title</th>
                                                    <th class="text-center">Description</th>
                                                    <th class="text-center">Provided by</th>
                                                    <th class="text-center">Date</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($documents as $document)
                                                <tr>
                                                    <td class="text-center">{{ $document->type }}</td>
                                                    <td class="text-center">{{ $document->title }}</td>
                                                    <td class="text-center">{{ $document->description }}</td>
                                                    <td class="text-center">{{ $document->provider->first_name }} {{ $document->provider->last_name }}</td>
                                                    <td class="text-center">{{ $document->created_at }}</td>
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
</div>
<!-- Container-fluid Ends-->
@push('scripts')
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
<script>
    $(document).ready(function() {
        var chartData = {!! $transactions->map(function($transaction) { return ['id' => $transaction->id, 'realPrice' => $transaction->realPrice, 'created_at' => $transaction->created_at, 'is_fund' => $transaction->is_fund, 'type' => $transaction->type];}) -> toJson() !!};
        var monthProfits = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        for (var i = 0; i < chartData.length; i++) {
            var current_date = new Date();
            var action_date = new Date(chartData[i]['created_at']);
            if (action_date.getFullYear() == current_date.getFullYear()) {
                if (chartData[i]['type'] == 'buy') {
                    monthProfits[Number(action_date.getMonth())] = Number((monthProfits[Number(action_date.getMonth())] + Number(chartData[i]['realPrice'])).toFixed(2));
                } else {
                    monthProfits[Number(action_date.getMonth())] = Number((monthProfits[Number(action_date.getMonth())] - Number(chartData[i]['realPrice'])).toFixed(2));
                }
            }

        };

        var stockData = $.grep(chartData, function(v) {
            return v.is_fund == 0;
        });
        var mfdData = $.grep(chartData, function(v) {
            return v.is_fund == 1;
        });

        stockData = stockData.reverse();
        mfdData = mfdData.reverse();

        adjustedStockData = [];
        adjustedMfdData = [];
        total1 = 0;
        total2 = 0;

        for (var i = 0; i < stockData.length; i++) {
            total1 = (stockData[i]['type'] == 'buy') ? total1 + Number(stockData[i]['realPrice']) : total1 - Number(stockData[i]['realPrice']);
            adjustedStockData[i] = [stockData[i]['created_at'], Number(total1.toFixed())];
        }

        for (var i = 0; i < mfdData.length; i++) {
            total2 = (mfdData[i]['type'] == 'buy') ? total2 + Number(mfdData[i]['realPrice']) : total2 - number(mfdData[i]['realPrice']);
            adjustedMfdData[i] = [mfdData[i]['created_at'], Number(total2.toFixed())];
        }

        renderChart(adjustedStockData, '#chart-timeline-dashbord1');
        renderChart(adjustedMfdData, '#chart-timeline-dashbord2');
        renderBarChart(monthProfits, '#month_profit_dash');
    });

    function renderChart(adjustedData, obj) {
        var options = {
            series: [{
                name: "Total Price",
                data: adjustedData
            }],
            chart: {
                id: 'area-datetime',
                type: 'area',
                height: 425,
                zoom: {
                    autoScaleYaxis: true
                },
                toolbar: {
                    show: false
                },
            },
            dataLabels: {
                enabled: false
            },
            markers: {
                size: 0,
                style: 'hollow',
            },
            xaxis: {
                type: 'datetime',
                min: adjustedData[0]['created_at'],
                tickAmount: 6,
                axisTicks: {
                    show: true,
                },
                axisBorder: {
                    show: true
                },
            },
            yaxis: {
                formatter: function(val) {
                    return val.toFixed(2);
                }
            },
            tooltip: {
                x: {
                    format: 'yyyy-MM-dd'
                },
                y: {
                    formatter: function(val) {
                        return '$' + val;
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.9,
                    stops: [0, 100]
                }
            },
            responsive: [{
                    breakpoint: 1366,
                    options: {
                        chart: {
                            height: 350
                        }
                    }
                },
                {
                    breakpoint: 1238,
                    options: {
                        chart: {
                            height: 300
                        },
                        grid: {
                            padding: {
                                bottom: 5,
                            },
                        }
                    }
                },
                {
                    breakpoint: 992,
                    options: {
                        chart: {
                            height: 300
                        }
                    }
                },
                {
                    breakpoint: 551,
                    options: {
                        grid: {
                            padding: {
                                bottom: 10,
                            },
                        }
                    }
                },
                {
                    breakpoint: 535,
                    options: {
                        chart: {
                            height: 250
                        }

                    }
                }
            ],

            colors: [vihoAdminConfig.primary],
        };
        var charttimeline = new ApexCharts(document.querySelector(obj), options);
        charttimeline.render();
    }

    function renderBarChart(data, obj) {
        var options = {
            chart: {
                height: 350,
                type: 'bar',
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    endingShape: 'rounded',
                    columnWidth: '55%',
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            series: [{
                name: 'Monthly Payment',
                data: data
            }],
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            },
            yaxis: {
                formatter: function(val) {
                    return val.toFixed(2);
                }
            },
            fill: {
                opacity: 1

            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return "$ " + val
                    }
                }
            },
            colors: [vihoAdminConfig.secondary]
        }

        var barChart = new ApexCharts(
            document.querySelector(obj),
            options
        );

        barChart.render();
    }

    function confirmTrade(obj, type, symbol, price, institutional_price, current_shares, is_fund) {
        var shares_amount = $("#shares_amount").val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');

        if (Number(shares_amount) == 0) {
            $(".alert-wrapper").html('<div class="alert alert-danger dark alert-dismissible fade show" id="zero_shares_alert" role="alert">The shares must be at least 1.<button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" style="top: 0px; right:0px;"></button></div>');
        } else if (type.toLowerCase() == 'sell' && Number(shares_amount) > current_shares)
            $(".alert-wrapper").html('<div class="alert alert-danger dark alert-dismissible fade show" id="zero_shares_alert" role="alert">The shares you want to sell must be equal or less than your current shares.<button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" style="top: 0px; right:0px;"></button></div>');

        else {
            $(obj).attr('onclick', '');
            $(obj).html('<i class="fa fa-spin fa-spinner"></i>');
            var url = is_fund == 0 ? '/api/stocks/' + symbol + '/' + type.toLowerCase() : '/api/mfds/' + symbol + '/' + type.toLowerCase();
            $.ajax({
                    method: 'post',
                    url: url,
                    data: {
                        shares: shares_amount,
                        price: price,
                        institutional_price: institutional_price,
                        _token: csrf_token
                    },
                })
                .then(response => {
                    $(obj).attr('onclick', 'buyShares(this)');
                    $(obj).html(type.toLowerCase() == 'buy' ? 'BUY' : 'SELL');
                    if (response.success) {
                        $.notify('<i class="fa fa-star-o"></i>Successfully confirmed!', {
                            type: 'theme',
                            allow_dismiss: true,
                            delay: 2000,
                            showProgressbar: false,
                            timer: 1000
                        });
                    } else {
                        $.notify('<i class="fa fa-bell-o"></i>', {
                            type: 'theme',
                            allow_dismiss: true,
                            delay: 2000,
                            showProgressbar: false,
                            timer: 1000
                        });
                    }
                })
        }
    }

    function openTradeModel(type, symbol, company_name, price, institutional_price, currency, shares, is_fund, exchange) {
        $("#shares_amount").val("");
        if (type == "buy") {
            $('#modal_title').text('Buy shares from ' + symbol);
            $('#trade_type').text('buy');
            $('#trade_btn').text("BUY");
            $('#trade_btn').removeClass('btn-danger');
            $('#trade_btn').addClass('btn-primary');
        } else {
            $('#modal_title').text('Sell shares from ' + symbol);
            $('#trade_type').text('sell');
            $('#trade_btn').text("SELL");
            $('#trade_btn').removeClass('btn-primary');
            $('#trade_btn').addClass('btn-danger');
        }

        $('#trade_symbol').text(symbol);
        $('#trade_company').text(company_name);
        $('#trade_price').text(formatPrice(Number(price), currency));
        $('#trade_institutional_price').text(formatPrice(Number(institutional_price), currency));

        if (exchange.toLowerCase() == 'xnys')
            $('#trade_is_xnys').css('display', 'none');
        else
            $('#trade_is_xnys').css('display', 'block');

        $('#shares-label').text('Shares (Current Shares: ' + shares + ")");
        $('#trade_btn').attr('onclick', 'confirmTrade(this, "' + type + '", "' + symbol + '", ' + price + ', ' + institutional_price + ', ' + shares + ', ' + is_fund + ')');
        $('#tradeModal').modal('show');
    }

    // format Price and Percentage functions
    function formatPrice(price, currency) {
        switch (currency) {
            case "USD":
                return "$" + Number(price).toFixed(2);
                break;

            case "GBP":
                return Number(price * 100).toFixed(2) + "p";
                break;

            case "EUR":
                return Number(price.toFixed(2)) + "€";
                break;

            case "AUD":
                return "A$" + Number(price.toFixed(2)) + "€";
                break;

            case "CAD":
                return "C$" + Number(price.toFixed(2));
                break;

            default:
                return price;
                break;
        }
    }

    function formatPercentage(percentage) {
        return (Number(percentage) * 100).toFixed(2) + "%";
    }
</script>
@endpush
@endsection