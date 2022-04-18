@extends('layouts.dashboard')
@section('title', array_get($data, 'name'))

@push('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/chartist.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/prism.css')}}">
@endpush

@section('content')
<div class="col-md-12 bond-details dashboard-content-wrapper">
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
    <div class="row">
        <div class="col">
            <div class="card income-card">
                <div class="card-header">
                    <div class="header-top d-flex justify-content-between">
                        <div class="title-content">
                            <h5>{{ array_get($data, 'name') }}</h5>
                            <div class="center-content">
                                <p class="d-sm-flex align-items-center">
                                    <span class="font-primary m-r-10 f-22 f-w-700" id="current_bond_price"></span>
                                    @if((float)array_get($data, 'changePercentage', 'null') >= 0)
                                    <span class="font-primary" id="current_bond_percentage"></span>
                                    @else
                                    <span class="font-danger" id="current_bond_percentage"></span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-danger-gradien" type="button" data-bs-toggle="modal" data-bs-target="#buySharesModal">Buy Shares</button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="loader-box chart-loader justify-content-center align-items-center" style="inset:0px; position:absolute; z-index:10; display:flex;">
                        <div class="loader-19"></div>
                    </div>
                    <div class="chart-content">
                        <div id="chart-timeline-dashboard" class="d-flex justify-content-center align-items-center" style="min-height: 440px;">
                        </div>
                        <div class="d-flex justify-content-end p-10" id="range_btn_group">
                            <div class="btn-group btn-group-square" id="range_group" role="group">
                                <!-- <button class="btn btn-outline-dark active" type="button" onclick="updateChart('1d', this)" style="padding: 0.3rem 0.8rem;">1d</button> -->
                                <button class="btn btn-outline-dark active" type="button" onclick="updateChart('1m', this)" style="padding: 0.3rem 0.8rem;">1m</button>
                                <button class="btn btn-outline-dark" type="button" onclick="updateChart('3m', this)" style="padding: 0.3rem 0.8rem;">3m</button>
                                <button class="btn btn-outline-dark" type="button" onclick="updateChart('6m', this)" style="padding: 0.3rem 0.8rem;">6m</button>
                                <button class="btn btn-outline-dark" type="button" onclick="updateChart('ytd', this)" style="padding: 0.3rem 0.8rem;">ytd</button>
                                <button class="btn btn-outline-dark" type="button" onclick="updateChart('1y', this)" style="padding: 0.3rem 0.8rem;">1y</button>
                                <button class="btn btn-outline-dark" type="button" onclick="updateChart('2y', this)" style="padding: 0.3rem 0.8rem;">2y</button>
                                <button class="btn btn-outline-dark" type="button" onclick="updateChart('5y', this)" style="padding: 0.3rem 0.8rem;">5y</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(array_get($data, 'source') != 'custom')
    <div class="row">
        <div class="col">
            <h2 class="title">Bond Details</h2>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    @if(array_get($data, 'exchange') == 'XTB')
                    <div class="row">
                        <div class="col-lg-4 col-md-12">
                            <h4>Bond Code</h4>
                            <h6>{{ array_get($data, 'symbol', '-') }}</h6>
                        </div>
                        <div class="col-lg-8 col-md-12 d-flex flex-column justify-content-between">
                            <div class="row">
                                <div class="col-sm-6 col-md-4 col-xs-12">
                                    <div class="detail">
                                        <strong>Latest Price</strong>
                                        <span>{{ '$'.array_get($data, 'price', '-') }}</span>
                                    </div>
                                    <div class="detail">
                                        <strong>Maturity Date</strong>
                                        <span>{{ array_get($data, 'dateMaturity', '-') }}</span>
                                    </div>
                                    <div class="detail">
                                        <strong>Nexr Ex.Date</strong>
                                        <span>{{ array_get($data, 'dateNextEx', '-') }}</span>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-4 col-xs-12">
                                    <div class="detail">
                                        <strong>Coupon PA</strong>
                                        <span>{{ array_get($data, 'couponPa', '-').'%' }}</span>
                                    </div>
                                    <div class="detail">
                                        <strong>Coupon Type</strong>
                                        <span>{{ array_get($data, 'couponType', '-') }}</span>
                                    </div>
                                    <div class="detail">
                                        <strong>YTM</strong>
                                        <span>{{ array_get($data, 'ytm', '-') }}</span>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-4 col-xs-12">
                                    <div class="detail">
                                        <strong>Running/Current Yield</strong>
                                        <span>{{ '$'.array_get($data, 'currentYield', '-') }}</span>
                                    </div>
                                    <div class="detail">
                                        <strong>Trading Margin</strong>
                                        <span>{{ '$'.array_get($data, 'tradingMargin', '-') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @elseif(array_get($data, 'exchange') == 'ETB')
                    <div class="row">
                        <div class="col-lg-4 col-md-12">
                            <h4>Bond Name</h4>
                            <h6>{{ (array_get($data, 'bondName'))?array_get($data, 'bondName', '-'):"No Bond Name." }}</h6>
                        </div>
                        <div class="col-lg-8 col-md-12 d-flex flex-column justify-content-between">
                            <div class="row">
                                <div class="col-sm-6 col-md-4 col-xs-12">
                                    <div class="detail">
                                        <strong>Latest Price</strong>
                                        <span>{{ '$'.array_get($data, 'price', '-') }}</span>
                                    </div>
                                    <div class="detail">
                                        <strong>Coupon Percent</strong>
                                        <span>{{ array_get($data, 'couponPercent', '-').'%' }}</span>
                                    </div>
                                    <div class="detail">
                                        <strong>Maturity Date</strong>
                                        <span>{{ array_get($data, 'dateMaturity', '-') }}</span>
                                    </div>
                                    <div class="detail">
                                        <strong>Nexr Ex.Date</strong>
                                        <span>{{ array_get($data, 'dateNextEx', '-') }}</span>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-4 col-xs-12">
                                    <div class="detail">
                                        <strong>Pay Frequency</strong>
                                        <span>{{ array_get($data, 'payFrequency', '-') }}</span>
                                    </div>
                                    <div class="detail">
                                        <strong>Payment Type</strong>
                                        <span>{{ array_get($data, 'paymentType', '-') }}</span>
                                    </div>
                                    <div class="detail">
                                        <strong>Price Ask</strong>
                                        <span>{{ (array_get($data, 'priceAsk'))?'$'.array_get($data, 'priceAsk', '-'):"-" }}</span>
                                    </div>
                                    <div class="detail">
                                        <strong>Bid Price</strong>
                                        <span>{{ (array_get($data, 'priceBid'))?'$'.array_get($data, 'priceBid', '-'):"-" }}</span>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-4 col-xs-12">
                                    <div class="detail">
                                        <strong>Status Code</strong>
                                        <span>{{ array_get($data, 'statusCode', '-') }}</span>
                                    </div>
                                    <div class="detail">
                                        <strong>Volume</strong>
                                        <span>{{ array_get($data, 'volume', '-') }}</span>
                                    </div>
                                    <div class="detail">
                                        <strong>Face Value</strong>
                                        <span>{{ array_get($data, 'faceValue', '-') }}</span>
                                    </div>
                                    <div class="detail">
                                        <strong>Yield Percent</strong>
                                        <span>{{ array_get($data, 'yieldPercent', '-') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="row link">
                        <div class="col d-flex justify-content-end m-t-25">
                            <a href=" {{ array_get($data, 'link') }}" target="_blank">Click here for more information about this bond</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if(array_get($data, 'source') == 'custom')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <h4>Bond Name</h4>
                    <h6>{{ (array_get($data, 'name', '-'))?array_get($data, 'name', '-'):"No Bond Name" }}</h6>
                    <hr class="d-lg-none d-xl-none">
                </div>

                <div class="col-lg-6 d-flex flex-column justify-content-between">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="detail">
                                <strong>Latest Price</strong>
                                <span>{{ array_get($data, 'price', '-') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail">
                                <strong>Market Price</strong>
                                <span>{{ array_get($data, 'institutionalPrice', '-') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(array_get($data, 'link'))
    <div class="row link">
        <div class="col d-flex justify-content-end">
            <a href="{{ array_get($data, 'link') }}" target="_blank">Click here for more information about this bond</a>
        </div>
    </div>
    @endif
    @endif
    <div class="col-xl-12 box-col-12 des-xl-100 mt-3">
        <div class="card news-container">
            <div class="card-header d-flex justify-content-between">
                <div class="header-top d-sm-flex align-items-center">
                    <h5>Recent News</h5>
                </div>
                <a href="/news?symbols={{implode(',', $news_symbols)}}" class="btn btn-outline-success btn-xs" style="line-height: 20px;">See More</a>
            </div>
            <div class="card-body">
                <div class="loader-box news-loader justify-content-center align-items-center w-full" style="inset:0px; position:absolute; z-index:10; display:flex; height:initial;">
                    <div class="loader-19"></div>
                </div>
                <div class="row news-content" style="min-height: 440px;">
                    <div class="col-xl-3 col-md-6 des-xl-50 news-0" style="display: none;">
                        <a href="" class="news-link-0" target="_blank">
                            <div class="prooduct-details-box">
                                <div class="media" style="text-align: center; padding:10px 0px; min-height:410px;">
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
                                <div class="media" style="text-align: center; padding:10px 0px; min-height:410px;">
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
                                <div class="media" style="text-align: center; padding:10px 0px; min-height:410px;">
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
                                <div class="media" style="text-align: center; padding:10px 0px; min-height:410px;">
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
    <div class="modal fade" id="buySharesModal" tabindex="-1" role="dialog" aria-labelledby="Document Modal Label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buy Shares from {{array_get($data, "symbol")}}</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Below you will find the most recent information about the bond you would like to buy shares from</h6>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>
                                    <strong>Symbol</strong>
                                </td>
                                <td>{{array_get($data, "symbol")}}</td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Issuer/Description</strong>
                                </td>
                                <td>{{array_get($data, "name")}}</td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Retail Price</strong>
                                </td>
                                <td>${{array_get($data, "price")}}</td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Market Price</strong>
                                </td>
                                <td>{{ '$'.array_get($data, 'institutionalPrice', '-') }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="form-group">
                        <label class="form-label">Shares</label>
                        <input type="number" class="form-control" placeholder="Enter the amount of shares" required id="shares_amount">
                        <small>Your account manager will contact you as soon as possible to confirm best price.</small>
                    </div>
                    <div class="alert-wrapper"></div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary btn-rounded btn-animated" onclick="buyShares(this)">
                            Buy
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script src="{{asset('assets/js/chart/apex-chart/apex-chart.js')}}"></script>
<script src="{{asset('assets/js/notify/bootstrap-notify.min.js')}}"></script>
<script src="{{asset('assets/js/tooltip-init.js')}}"></script>
<script>
    $(document).ready(function() {
        var identifier = "{{ array_get($data, 'identifier') }}";
        $(".chart-loader").css({
            'top': $('.card-header').innerHeight() + "px",
            'height': $('.chart-content').innerHeight() + "px"
        });
        $(".chart-content").css("opacity", "0.3");
        renderChart('1m');

    });

    function renderChart(range) {
        $.ajax({
            url: '/api/bonds/chart/{{ array_get($data, "symbol") }}/' + range,
            type: 'get',
            success: function(res) {
                debugger;
                if (res.success && res.data.length != 0) {
                    var times = 1;
                    var currency = "USD";
                    var adjustedData = [];
                    for (var i = 0; i < res.data.length; i++) {
                        var date = new Date(res.data[i]['date']);
                        adjustedData[i] = [date.getTime(), Number((res.data[i]['fClose'] * times).toFixed(2))]
                    }
                    var options = {
                        series: [{
                            name: "Closing Price",
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
                            min: adjustedData[0][0],
                            tickAmount: 6,
                            axisTicks: {
                                show: true,
                            },
                            axisBorder: {
                                show: true
                            },
                        },
                        tooltip: {
                            x: {
                                format: 'yyyy-MM-dd'
                            },
                            y: {
                                formatter: function(val) {
                                    return formatPrice(val, currency);
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

                        colors: [appConfig.bond],
                    };
                    $("#chart-timeline-dashboard").empty();
                    var charttimeline = new ApexCharts(document.querySelector("#chart-timeline-dashboard"), options);
                    charttimeline.render();
                    $(".chart-content").css("opacity", "1");
                    $(".chart-loader").css('display', 'none');
                } else {
                    $("#chart-timeline-dashboard").empty();
                    $("#chart-timeline-dashboard").html("<h3>No Chart Data!</h3>");
                    $(".chart-content").css("opacity", "1");
                    $(".chart-loader").css('display', 'none');
                }
            }
        });
    }

    function buyShares(obj) {
        var shares_amount = $("#shares_amount").val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        var institutionalPrice = "{{ array_get($data, 'institutionalPrice', '-') }}";
        institutionalPrice = institutionalPrice.replace("$", "");
        institutionalPrice = institutionalPrice.replace("p", "");
        institutionalPrice = Number(institutionalPrice);

        if (Number(shares_amount) == 0) {
            $(".alert-wrapper").html('<div class="alert alert-danger dark alert-dismissible fade show" id="zero_shares_alert" role="alert">The shares must be at least 1.<button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" style="top: 0px; right:0px;"></button></div>');
        } else {
            $(obj).attr('onclick', '');
            $(obj).html('<i class="fa fa-spin fa-spinner"></i>');
            $.ajax({
                    method: 'post',
                    url: '/api/bonds/{{array_get($data, "symbol")}}/buy',
                    data: {
                        shares: shares_amount,
                        price: "{{array_get($data, 'price')}}",
                        institutionalPrice: institutionalPrice,
                        _token: csrf_token
                    },
                })
                .then(response => {
                    $(obj).attr('onclick', 'buyShares(this)');
                    $(obj).html('Buy');
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

    function updateChart(range, obj) {
        $("#range_group button").removeClass("active");
        $(obj).addClass("active");
        $(".loader-box").css({
            'display': 'flex',
            'top': $('.card-header').innerHeight() + "px",
            'height': $('.chart-content').innerHeight() + "px"
        });
        $(".chart-content").css("opacity", "0.3");
        renderChart(range);
    }

    $("#current_bond_price").html(formatPrice(Number("{{ array_get($data, 'price') }}"), "USD"));
    $("#current_bond_percentage").html(formatPercentage(Number("{{ array_get($data, 'changePercentage', 'null') }}")));
</script>
@endpush
@endsection