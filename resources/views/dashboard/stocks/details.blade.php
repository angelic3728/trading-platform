@extends('layouts.dashboard')
@section('title', array_get($data, 'company_name'))

@push('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/chartist.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/prism.css')}}">
@endpush

@section('content')
<div class="container stock-details">
    <div class="row">
        <div class="col">
            <div class="card income-card">
                <div class="card-header">
                    <div class="header-top d-flex justify-content-between">
                        <div class="title-content">
                            <h5>{{ array_get($data, 'company_name') }}</h5>
                            <div class="center-content">
                                <p class="d-sm-flex align-items-center">
                                    <span class="font-primary m-r-10 f-22 f-w-700" id="current_stock_price"></span>
                                    @if((float)array_get($data, 'change_percentage', 'null') >= 0)
                                    <span class="font-primary" id="current_stock_percentage"></span>
                                    @else
                                    <span class="font-danger" id="current_stock_percentage"></span>
                                    @endif
                                    @if(array_get($data, 'exchange') == 'LSE')
                                    <i class="fa fa-info-circle" style="color: #3458ff; padding: 4px; font-size: 18px;" data-container="body" data-bs-toggle="tooltip" data-bs-placement="top" title="This stock has no real time pricing at the moment. All prices are based on the last closing price.">
                                    </i>
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
                    <div class="loader-box chart-loader justify-content-center align-items-center w-full" style="inset:0px; position:absolute; z-index:10; display:flex;">
                        <div class="loader-19"></div>
                    </div>
                    <div class="chart-content">
                        <div id="chart-timeline-dashboard" style="min-height: 440px;">
                        </div>
                        <div class="d-flex justify-content-end p-10" id="range_btn_group">
                            <div class="btn-group btn-group-square" id="range_group" role="group">
                                @if(array_get($data, 'exchange') == 'NYSE')
                                <button class="btn btn-outline-dark" type="button" onclick="updateChart('1d', this)">1d</button>
                                @endif
                                <button class="btn btn-outline-dark active" type="button" onclick="updateChart('1m', this)">1m</button>
                                <button class="btn btn-outline-dark" type="button" onclick="updateChart('3m', this)">3m</button>
                                <button class="btn btn-outline-dark" type="button" onclick="updateChart('6m', this)">6m</button>
                                <button class="btn btn-outline-dark" type="button" onclick="updateChart('ytd', this)">ytd</button>
                                <button class="btn btn-outline-dark" type="button" onclick="updateChart('1y', this)">1y</button>
                                <button class="btn btn-outline-dark" type="button" onclick="updateChart('2y', this)">2y</button>
                                <button class="btn btn-outline-dark" type="button" onclick="updateChart('5y', this)">5y</button>
                            </div>
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
                    <h6>Below you will find the most recent information about the stock you would like to buy shares from</h6>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>
                                    <strong>Symbol</strong>:
                                </td>
                                <td>{{array_get($data, "symbol")}}</td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Company</strong>:
                                </td>
                                <td>{{array_get($data, "company_name")}}</td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Retail Price</strong>:
                                </td>
                                @if(array_get($data, 'currency') == 'USD')
                                <td>${{array_get($data, "price")}}</td>
                                @else
                                <td>{{array_get($data, "price")}}p</td>
                                @endif
                            </tr>
                            <tr>
                                <td>
                                    <strong>Institutional Price</strong>:
                                </td>
                                <td>{{ array_get($data, 'numbers.institutional_price', '-') }}</td>
                            </tr>
                        </tbody>
                    </table>
                    @if(array_get($data, 'exchange') == 'LSE')
                    <small class="d-block mb-3">We don't have real time prices for this stock at the moment. All prices here are based on the last close price. When submitting an trade, we will confirm the actual price with you.</small>
                    @endif
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

    @if(array_get($data, 'source') == 'iex')
    <div class="row">
        <div class="col">
            <h2 class="title">Stock Details</h2>
        </div>
    </div>
    @if(array_get($data, 'exchange') == 'NYSE')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <h4>Company Information</h4>
                            <p>{{ array_get($data, 'company.description', '-') }}</p>
                        </div>

                        <div class="col-lg-6 d-flex flex-column justify-content-between">
                            <div class="row">
                                <div class="col-sm-6 col-md-4">
                                    <div class="detail">
                                        <strong>Latest Price</strong>
                                        <span>{{ array_get($data, 'numbers.latest_price', '-') }}</span>
                                    </div>
                                    <div class="detail">
                                        <strong>Market Cap</strong>
                                        <span>{{ array_get($data, 'numbers.market_cap', '-') }}</span>
                                    </div>
                                    <div class="detail">
                                        <strong>P/E Ratio</strong>
                                        <span>{{ array_get($data, 'numbers.pe_ratio', '-') }}</span>
                                    </div>
                                    <div class="detail">
                                        <strong>Exchange</strong>
                                        <span>{{ array_get($data, 'company.exchange', '-') }}</span>
                                    </div>
                                    <div class="detail">
                                        <strong>Sector</strong>
                                        <span>{{ array_get($data, 'company.sector', '-') }}</span>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-4">
                                    <div class="detail">
                                        <strong>Previous Close</strong>
                                        <span>{{ array_get($data, 'numbers.previous_close', '-') }}</span>
                                    </div>
                                    <div class="detail">
                                        <strong>Volume</strong>
                                        <span>{{ array_get($data, 'numbers.volume', '-') }}</span>
                                    </div>
                                    <div class="detail">
                                        <strong>Latest EPS</strong>
                                        <span>{{ array_get($data, 'numbers.latest_eps', '-') }}</span>
                                    </div>
                                    <div class="detail">
                                        <strong>Industry</strong>
                                        <span>{{ array_get($data, 'company.industry', '-') }}</span>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-4">
                                    <div class="detail">
                                        <strong>Institutional Price</strong>
                                        <span>{{ array_get($data, 'numbers.institutional_price', '-') }}</span>
                                    </div>
                                    <div class="detail">
                                        <strong>AVG Total Volume</strong>
                                        <span>{{ array_get($data, 'numbers.avg_total_volume', '-') }}</span>
                                    </div>
                                    <div class="detail">
                                        <strong>Latest EPS Date</strong>
                                        <span>{{ array_get($data, 'numbers.latest_eps_date', '-') }}</span>
                                    </div>
                                    <div class="detail">
                                        <strong>Website</strong>
                                        <a href="{{ array_get($data, 'company.website', '-') }}" target="_blank">{{ array_get($data, 'company.website', '-') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="row link">
                        <div class="col text-right">
                            <a href="{{ array_get($data, 'link') }}" target="_blank">Click here for more information about this stock</a>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    @elseif(array_get($data, 'exchange') == 'LSE')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <h4>Company Information</h4>
                            <p>{{ array_get($data, 'company.description', '-') }}</p>
                            <hr class="d-lg-none d-xl-none">
                        </div>

                        <div class="col-lg-6 d-flex flex-column justify-content-between">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="detail">
                                        <strong>Latest Price</strong>
                                        <span>{{ array_get($data, 'numbers.latest_price', '-') }}</span>
                                    </div>
                                    <div class="detail">
                                        <strong>AVG Total Volume</strong>
                                        <span>{{ array_get($data, 'numbers.avg_total_volume', '-') }}</span>
                                    </div>
                                    <div class="detail">
                                        <strong>Exchange</strong>
                                        <span>{{ array_get($data, 'company.exchange', '-') }}</span>
                                    </div>
                                    <div class="detail">
                                        <strong>Sector</strong>
                                        <span>{{ array_get($data, 'company.sector', '-') }}</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="detail">
                                        <strong>Institutional Price</strong>
                                        <span>{{ array_get($data, 'numbers.institutional_price', '-') }}</span>
                                    </div>
                                    <div class="detail">
                                        <strong>Industry</strong>
                                        <span>{{ array_get($data, 'company.industry', '-') }}</span>
                                    </div>
                                    <div class="detail">
                                        <strong>Website</strong>
                                        <a href="{{ array_get($data, 'company.website', '-') }}" target="_blank">{{ array_get($data, 'company.website', '-') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row link">
                        <div class="col">
                            <hr>
                        </div>
                    </div>

                    <!-- <div class="row link">
                        <div class="col d-flex justify-content-end">
                            <a href="{{ array_get($data, 'link') }}" target="_blank">Click here for more information about this stock</a>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    @endif

    @if(array_get($data, 'exchange') == 'NYSE')
    <div class="row">
        <div class="col">
            <h2 class="title">Recent News</h2>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="loader-box news-loader justify-content-center align-items-center w-full" style="inset:0px; position:absolute; z-index:10; display:flex;">
                <div class="loader-19"></div>
            </div>
            <div class="row news-content" style="min-height: 440px;">
                <div class="col-xl-4 col-md-6">
                    <a href="" class="news-link-0">
                        <div class="prooduct-details-box">
                            <div class="media">
                                <img class="align-self-center img-fluid news-img-0" src="" alt="#">
                                <div class="media-body">
                                    <p class="news-date-0 text-dark mb-0"></p>
                                    <h6 class="news-headline-0"></h6>
                                    <div class="summary news-summary-0"></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-4 col-md-6">
                    <a href="" class="news-link-1">
                        <div class="prooduct-details-box">
                            <div class="media">
                                <img class="align-self-center img-fluid news-img-1" src="" alt="#">
                                <div class="media-body">
                                    <p class="news-date-1 text-dark mb-0"></p>
                                    <h6 class="news-headline-1"></h6>
                                    <div class="summary news-summary-1"></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-4 col-md-6">
                    <a href="" class="news-link-2">
                        <div class="prooduct-details-box">
                            <div class="media">
                                <img class="align-self-center img-fluid news-img-2" src="" alt="#">
                                <div class="media-body">
                                    <p class="news-date-2 text-dark mb-0"></p>
                                    <h6 class="news-headline-2"></h6>
                                    <div class="summary news-summary-2"></div>
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
    @endif
    @endif
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
        $(".news-loader").css({
            'height': $('.news-content').innerHeight() + "px"
        });
        $(".chart-content").css("opacity", "0.3");
        $(".news-content").css("opacity", "0.3");
        renderChart('1m');

        $.ajax({
            method: 'get',
            url: '/api/news?symbols=' + identifier + '&&limit=3',
            success: function(res) {
                if (res.success) {
                    var artiles = res.data;
                    if (artiles.length > 0) {
                        for (var i = 0; i < artiles.length; i++) {
                            $('.news-img-' + i).attr('src', artiles[i]['image']);
                            $('.news-link-' + i).attr('href', artiles[i]['url']);
                            $('.news-date-' + i).html(dateStr(new Date(artiles[i].datetime)));
                            $('.news-headline-' + i).html(artiles[i]['headline']);
                            if (artiles[i]['summary'].length > 150)
                                $('.news-summary-' + i).html(artiles[i]['summary'].substr(0, 150 - 3) + "...");
                            else
                                $('.news-summary-' + i).html(artiles[i]['summary']);
                        }
                    } else {
                        $('.news-content').css('display', 'none');
                        $('.no-news').css('display', 'block');
                    }
                    $(".news-content").css("opacity", "1");
                    $(".news-loader").css('display', 'none');
                }
            }
        });
    });

    function renderChart(range) {
        $.ajax({
            url: '/api/stocks/chart/{{ array_get($data, "symbol") }}/' + range,
            type: 'get',
            success: function(res) {
                var times = 1;
                var currency = "{{ array_get($data, 'currency') }}";
                if ("{{array_get($data, 'exchange') == 'LSE'}}")
                    times = 100;
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
                                if (currency == "GBP")
                                    return formatPrice(val / 100, currency)
                                else
                                    return formatPrice(val, currency)
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
                $("#chart-timeline-dashboard").empty();
                var charttimeline = new ApexCharts(document.querySelector("#chart-timeline-dashboard"), options);
                charttimeline.render();
                $(".chart-content").css("opacity", "1");
                $(".chart-loader").css('display', 'none');
            }
        });
    }

    function buyShares(obj) {
        var shares_amount = $("#shares_amount").val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        var institutional_price = "{{ array_get($data, 'numbers.institutional_price', '-') }}";
        institutional_price = institutional_price.replace("$", "");
        institutional_price = institutional_price.replace("p", "");
        institutional_price = Number(institutional_price);

        if (Number(shares_amount) == 0) {
            $(".alert-wrapper").html('<div class="alert alert-danger dark alert-dismissible fade show" id="zero_shares_alert" role="alert">The shares must be at least 1.<button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" style="top: 0px; right:0px;"></button></div>');
        } else {
            $(obj).attr('onclick', '');
            $(obj).html('<i class="fa fa-spin fa-spinner"></i>');
            $.ajax({
                    method: 'post',
                    url: '/api/stocks/{{array_get($data, "symbol")}}/buy',
                    data: {
                        shares: shares_amount,
                        price: "{{array_get($data, 'price')}}",
                        institutional_price: institutional_price,
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

    function dateStr(obj) {
        var mm = obj.getMonth() + 1; // getMonth() is zero-based
        var dd = obj.getDate();

        return [obj.getFullYear(),
            (mm > 9 ? '' : '0') + mm,
            (dd > 9 ? '' : '0') + dd
        ].join(' : ');
    };

    function formatPrice(price, currency) {
        switch (currency) {
            case 'USD':
                return "$" + Number(price).toFixed(2);
                break;

            case 'GBP':
                return Number((price * 100)).toFixed(2) + 'p';
                break;

            default:
                return price;
                break;
        }
    };

    function formatPercentage(percentage) {
        return (Number(percentage) * 100).toFixed(2) + "%";
    }

    $("#current_stock_price").html(formatPrice("{{ array_get($data, 'price') }}", "{{ array_get($data, 'currency') }}"));
    $("#current_stock_percentage").html(formatPercentage("{{ array_get($data, 'change_percentage', 'null') }}"));
</script>
@endpush
@endsection