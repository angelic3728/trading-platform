@extends('layouts.dashboard')
@section('title', array_get($data, 'name'))

@push('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/chartist.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/prism.css')}}">
@endpush

@section('content')
<div class="row dashboard-content-wrapper">
    <div class="col-md-12 crypto-details">
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
                                        <span class="font-primary m-r-10 f-22 f-w-700" id="current_crypto_price"></span>
                                        @if((float)array_get($data, 'change_percentage', 'null') >= 0)
                                        <span class="font-primary" id="current_crypto_percentage"></span>
                                        @else
                                        <span class="font-danger" id="current_crypto_percentage"></span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <button class="btn btn-danger-gradien" type="button" data-bs-toggle="modal" data-bs-target="#buyCryptosModal" style="white-space: nowrap;">Buy Units</button>
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
                                    <button class="btn btn-outline-dark" type="button" onclick="updateChart('1d', this)" style="padding: 0.3rem 0.8rem;">1d</button>
                                    <button class="btn btn-outline-dark active" type="button" onclick="updateChart('5d', this)" style="padding: 0.3rem 0.8rem;">5d</button>
                                    <button class="btn btn-outline-dark" type="button" onclick="updateChart('1m', this)" style="padding: 0.3rem 0.8rem;">1m</button>
                                    <button class="btn btn-outline-dark" type="button" onclick="updateChart('6m', this)" style="padding: 0.3rem 0.8rem;">6m</button>
                                    <button class="btn btn-outline-dark" type="button" onclick="updateChart('ytd', this)" style="padding: 0.3rem 0.8rem;">ytd</button>
                                    <button class="btn btn-outline-dark" type="button" onclick="updateChart('1y', this)" style="padding: 0.3rem 0.8rem;">1y</button>
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
                <h2 class="title">Crypto Details</h2>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <h4>Crypto Information</h4>
                                <div class="crypto-information">
                                    {{ array_get($data, "info.description", "-") }}
                                </div>
                                <hr class="d-lg-none">
                            </div>

                            <div class="col-lg-6 d-flex flex-column justify-content-between">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="detail">
                                            <strong>Latest Price</strong>
                                            <span>{{ '$'.array_get($data, 'price', '-') }}</span>
                                        </div>
                                        <div class="detail">
                                            <strong>Market Cap</strong>
                                            <span>{{ array_get($data, 'numbers.market_cap', '-') }}</span>
                                        </div>
                                        <div class="detail">
                                            <strong>ATH</strong>
                                            <span>{{ array_get($data, 'numbers.ath', '-') }}</span>
                                        </div>
                                        <div class="detail">
                                            <strong>Total Volume</strong>
                                            <span>{{ array_get($data, 'numbers.total_volume', '-') }}</span>
                                        </div>
                                        <div class="detail">
                                            <strong>Total Supply</strong>
                                            <span>{{ array_get($data, 'numbers.total_supply', '-') }}</span>
                                        </div>
                                        <div class="detail">
                                            <strong>Circulating Supply</strong>
                                            <span>{{ array_get($data, 'numbers.circulating_supply', '-') }}</span>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="detail">
                                            <strong>Institutional Price</strong>
                                            <span>{{ array_get($data, 'numbers.institutional_price', '-') }}</span>
                                        </div>
                                        <div class="detail">
                                            <strong>Genesis Date</strong>
                                            <span>{{ array_get($data, 'info.genesis_date', '-') }}</span>
                                        </div>
                                        <div class="detail">
                                            <strong>Block Time</strong>
                                            <span>{{ array_get($data, 'info.block_time', '-') }}</span>
                                        </div>
                                        <div class="detail">
                                            <strong>Hashing Algorithm</strong>
                                            <span>{{ array_get($data, 'info.hashing_algorithm', '-') }}</span>
                                        </div>
                                        <div class="detail">
                                            <strong>Website</strong>
                                            <a href="{{ array_get($data, 'info.website', '-') }}" target="_blank">{{ array_get($data, 'info.website', '-') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row link">
                            <div class="col d-flex justify-content-end" style="text-align: right; padding-top:10px;">
                                <a href=" {{ array_get($data, 'link') }}" target="_blank" style="font-size: 12px;">Click here for more information about this bond</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <hr>
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
                        <h4>Company Information</h4>
                        <p>{{ (array_get($data, 'company.description', '-'))?array_get($data, 'company.description', '-'):"No Information." }}</p>
                        <hr class="d-lg-none d-xl-none">
                    </div>

                    <div class="col-lg-6 d-flex flex-column justify-content-between">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="detail">
                                    <strong>Latest Price</strong>
                                    <span>{{ array_get($data, 'numbers.latest_price', '-') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail">
                                    <strong>Institutional Price</strong>
                                    <span>{{ array_get($data, 'numbers.institutional_price', '-') }}</span>
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
                <a href="{{ array_get($data, 'link') }}" target="_blank">Click here for more information about this crypto</a>
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
        <div class="modal fade" id="buyCryptosModal" tabindex="-1" role="dialog" aria-labelledby="Document Modal Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Buy units from {{array_get($data, "name")}}</h5>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h6>Below you will find the most recent information about the crypto you would like to buy units from.</h6>
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
                                        <strong>Crypto Name</strong>
                                    </td>
                                    <td>{{array_get($data, "name")}}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Retail Price</strong>
                                    </td>
                                    <td>${{(array_get($data, "price")*1>1)?number_format(array_get($data, "price"), 2):((array_get($data, "price")*1>0.1)?number_format(array_get($data, "price"), 3):number_format(array_get($data, "price"), 6))}}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Institutional Price</strong>
                                    </td>
                                    <td>{{ array_get($data, 'numbers.institutional_price', '-') }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row mt-3">
                            <div class="form-group col-sm-7 m-b-0">
                                <label class="form-label m-b-0" for="">Pay Amount</label>
                                <input type="number" class="form-control" placeholder="Enter the amount of $" required id="shares_amount" onchange="buyInputHandle(this)" onkeyup="buyInputHandle(this)">
                            </div>
                            <div class="col-sm-5">
                                <label class="form-label m-b-0" style="color:#24695c !important;">Local Currency</label>
                                <label for="" style="width: 100%;">
                                    <span style="float: left; padding-top:6px; padding-right:5px;">$</span>
                                    <input type="number" class="form-control" required id="local_calc_amount" style="width: 84%;" disabled="">
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-12" style="color:#24695c !important;">
                            <p>Number of shares: <span id="calc_shares">0</span></p>
                        </div>
                        <small style="color:#24695c">Your account manager will contact you as soon as possible to confirm best price.</small>
                        <div class="alert-wrapper"></div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-primary btn-rounded btn-animated" onclick="buyCryptos(this)">
                                Buy
                            </button>
                        </div>
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
        var intro = $('.crypto-information').text();
        $('.crypto-information').html(intro);

        $(".chart-loader").css({
            'top': $('.card-header').innerHeight() + "px",
            'height': $('.chart-content').innerHeight() + "px"
        });
        $(".chart-content").css("opacity", "0.3");
        renderChart('5d');

    });

    function renderChart(range) {
        $.ajax({
            url: '/api/cryptos/chart/{{ array_get($data, "symbol") }}/' + range,
            type: 'get',
            success: function(res) {
                if (res.success && res.data.length != 0) {
                    var adjustedData = [];
                    for (var i = 0; i < res.data.length; i++) {
                        var date = new Date(res.data[i][0]);
                        var unit_price = 0;
                        if (Number(res.data[i][1] * 1) > 10) {
                            unit_price = Number((res.data[i][1] * 1).toFixed(2))
                        } else if (Number(res.data[i][1] * 1) > 1) {
                            unit_price = Number((res.data[i][1] * 1).toFixed(3))
                        } else if (Number(res.data[i][1] * 1) > 0.1) {
                            unit_price = Number((res.data[i][1] * 1).toFixed(4))
                        } else if (Number(res.data[i][1] * 1) > 0.01) {
                            unit_price = Number((res.data[i][1] * 1).toFixed(5))
                        } else if (Number(res.data[i][1] * 1) > 0.001) {
                            unit_price = Number((res.data[i][1] * 1).toFixed(6))
                        } else if (Number(res.data[i][1] * 1) > 0.0001) {
                            unit_price = Number((res.data[i][1] * 1).toFixed(7))
                        } else {
                            unit_price = Number((res.data[i][1] * 1).toFixed(8))
                        }
                        adjustedData[i] = [date.getTime(), unit_price]
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
                        yaxis: {
                            tickAmount: 5
                        },
                        tooltip: {
                            x: {
                                format: 'yyyy-MM-dd HH:mm'
                            },
                            y: {
                                formatter: function(val) {
                                    return formatPrice(val, 'USD');
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

                        colors: [appConfig.crypto],
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

    function buyCryptos(obj) {
        var shares_amount = $("#calc_shares").text();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        var institutional_price = "{{ array_get($data, 'numbers.institutional_price', '-') }}";
        institutional_price = institutional_price.replace(/[^\d.]/g, '');
        institutional_price = Number(institutional_price);

        if (Number(shares_amount) == 0) {
            $(".alert-wrapper").html('<div class="alert alert-danger dark alert-dismissible fade show" id="zero_shares_alert" role="alert">The shares must be at least 1.<button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" style="top: 0px; right:0px;"></button></div>');
        } else {
            $(obj).attr('onclick', '');
            $(obj).html('<i class="fa fa-spin fa-spinner"></i>');
            $.ajax({
                    method: 'post',
                    url: '/api/cryptos/{{array_get($data, "symbol")}}/buy',
                    data: {
                        shares: shares_amount,
                        price: "{{array_get($data, 'price')}}",
                        institutional_price: institutional_price,
                        _token: csrf_token
                    },
                })
                .then(response => {
                    $('#buyCryptosModal').modal('hide');
                    $(obj).attr('onclick', 'buyCryptos(this)');
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

    function buyInputHandle(obj, currency_rate, inst_price) {
        var currency_rate = '{{$currency_rate}}';
        var inst_price = '{{ array_get($data, "numbers.institutional_price", 0) }}';
        inst_price = inst_price.replace(/[^\d.]/g, '');
        var current_val = obj.value;
        if (Number(inst_price) == 0) {
            $("#trade_btn").attr("disabled", "");
            $("#trade_btn").attr("onclick", "");
            $(".alert-wrapper").html(
                '<div class="alert alert-danger dark alert-dismissible fade show" id="zero_shares_alert" role="alert">You can\'t buy it.<button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" style="top: 0px; right:0px;"></button></div>'
            );
        } else {
            $('#local_calc_amount').val((current_val * currency_rate).toFixed(2));
            $('#calc_shares').text((current_val / inst_price).toFixed());
        }
    }

    var current_price = Number("{{ array_get($data, 'price', 0) }}");
    $("#current_crypto_price").html(formatPrice(current_price, "USD"));
    $("#current_crypto_percentage").html(formatPercentage("{{ array_get($data, 'change_percentage', 0) }}" / 100));
</script>
@endpush
@endsection