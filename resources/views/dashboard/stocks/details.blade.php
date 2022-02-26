@extends('layouts.dashboard')
@section('title', array_get($data, 'company_name'))

@push('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/chartist.css')}}">
@endpush

@section('content')
<div class="container stock-details">
    <div class="row">
        <div class="col">
            <div class="card income-card">
                <div class="card-header">
                    <div class="header-top">
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
                </div>
                <div class="card-body p-0">
                    <div class="loader-box justify-content-center align-items-center w-full" style="inset:0px; position:absolute; z-index:10; display:flex;">
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

                    <div class="row link">
                        <div class="col">
                            <hr>
                        </div>
                    </div>

                    <div class="row link">
                        <div class="col text-right">
                            <a href="{{ array_get($data, 'link') }}" target="_blank">Click here for more information about this stock</a>
                        </div>
                    </div>
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
    <news symbols="{{ array_get($data, 'identifier') }}"></news>
    @endif
    @endif
</div>
@push('scripts')
<script src="{{asset('assets/js/chart/apex-chart/apex-chart.js')}}"></script>
<script src="{{asset('assets/js/tooltip-init.js')}}"></script>
<script>
    $(document).ready(function() {
        $(".loader-box").css({
            'top': $('.card-header').innerHeight() + "px",
            'height': $('.chart-content').innerHeight() + "px"
        });
        $(".chart-content").css("opacity", "0.3");
        renderChart('1m');
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
                debugger;
                var charttimeline = new ApexCharts(document.querySelector("#chart-timeline-dashboard"), options);
                charttimeline.render();
                $(".chart-content").css("opacity", "1");
                $(".loader-box").css('display', 'none');
            }
        });
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