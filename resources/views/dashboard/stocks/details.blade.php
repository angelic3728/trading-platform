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
                    <div id="chart-timeline-dashbord"></div>
                </div>
            </div>
            <!-- <stock-chart
                    company-name="{{ array_get($data, 'company_name') }}"
                    symbol="{{ array_get($data, 'symbol') }}"
                    currency="{{ array_get($data, 'currency') }}"
                    :price="{{ array_get($data, 'price') }}"
                    exchange="{{ array_get($data, 'exchange') }}"
                    source="{{ array_get($data, 'source') }}"
                    link="{{ array_get($data, 'link') }}"
                    :change-percentage="{{ array_get($data, 'change_percentage', 'null') }}"
                /> -->
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

                    <div class="row link">
                        <div class="col text-right">
                            <a href="{{ array_get($data, 'link') }}" target="_blank">Click here for more information about this stock</a>
                        </div>
                    </div>
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
    var options = {
        series: [{
            name: "Closing Price",
            data: [
                [1327359600000, 65.95],
                [1327446000000, 65.34],
                [1327532400000, 65.18],
                [1327618800000, 65.05],
                [1327878000000, 65.00],
                [1327964400000, 63.95],
                [1328050800000, 62.24],
                [1328137200000, 63.29],
                [1328223600000, 65.85],
                [1328482800000, 60.86],
                [1328569200000, 62.28],
                [1328655600000, 59.10],
                [1328742000000, 59.65],
                [1328828400000, 59.21],
                [1329087600000, 60.35],
                [1329174000000, 60.44],
                [1329260400000, 60.46],
                [1329346800000, 60.86],
                [1329433200000, 65.75],
                [1329778800000, 65.54],
                [1329865200000, 65.33],
                [1329951600000, 65.97],
                [1330038000000, 60.41],
                [1330297200000, 60.27],
                [1330383600000, 60.27],
                [1331161200000, 59.05],
                [1331247600000, 59.64],
                [1331506800000, 59.56],
                [1331593200000, 59.22],
                [1331679600000, 58.77],
                [1331766000000, 58.17],
                [1331852400000, 58.82],
                [1332111600000, 58.51],
                [1332198000000, 58.16],
                [1332284400000, 58.56],
                [1332370800000, 55.71],
                [1332457200000, 55.81],
                [1332712800000, 55.40],
                [1332799200000, 55.63],
                [1332885600000, 55.46],
                [1332972000000, 54.48],
                [1333058400000, 54.31],
                [1333317600000, 54.70],
                [1333404000000, 55.31],
                [1333490400000, 55.46],
                [1333576800000, 55.59],
                [1333922400000, 56.22],
                [1335477600000, 56.58],
                [1335736800000, 56.55],
                [1335823200000, 56.77],
                [1335909600000, 56.76],
                [1335996000000, 56.32],
                [1336082400000, 57.61],
                [1336341600000, 57.52],
                [1336428000000, 57.67],
                [1336514400000, 57.52],
                [1336600800000, 57.92],
                [1336687200000, 58.20],
                [1336946400000, 58.23],
                [1337032800000, 58.33],
                [1337119200000, 58.36],
                [1337205600000, 58.01],
                [1337292000000, 58.31],
                [1337551200000, 55.01],
                [1337637600000, 55.01],
                [1337724000000, 55.18],
                [1337810400000, 55.54],
                [1337896800000, 53.60],
                [1338242400000, 53.05],
                [1338328800000, 53.29],
                [1338415200000, 53.05],
                [1338501600000, 50.82],
                [1338760800000, 50.31],
                [1338847200000, 50.70],
                [1338933600000, 50.69],
                [1339020000000, 50.32],
                [1339106400000, 49.65],
                [1339365600000, 49.13],
                [1339452000000, 49.77],
                [1339538400000, 49.79],
                [1339624800000, 49.67],
                [1339711200000, 49.39],
                [1339970400000, 49.63],
                [1340056800000, 49.89],
                [1340143200000, 48.99],
                [1340229600000, 48.23],
                [1340316000000, 48.57],
                [1340575200000, 48.84],
                [1340661600000, 48.07],
                [1340748000000, 48.41],
                [1340834400000, 48.17],
                [1340920800000, 48.37],
                [1341180000000, 48.19],
                [1341266400000, 45.51],
                [1341439200000, 45.53],
                [1341525600000, 45.37],
                [1341784800000, 45.43],
                [1341871200000, 45.44],
                [1341957600000, 45.20],
                [1342044000000, 43.14],
                [1342130400000, 43.65],
                [1342389600000, 43.40],
                [1342476000000, 43.65],
                [1342562400000, 43.43],
                [1342648800000, 43.89],
                [1342735200000, 40.38],
                [1342994400000, 40.64],
                [1343080800000, 40.02],
                [1343167200000, 40.33],
                [1343253600000, 40.95],
                [1343340000000, 40.89],
                [1343599200000, 40.01],
                [1343685600000, 40.88],
                [1343772000000, 40.69],
                [1343858400000, 40.58],
                [1343944800000, 40.02],
                [1344204000000, 41.14],
                [1344290400000, 41.37],
                [1344376800000, 41.51],
                [1344463200000, 41.65],
                [1344549600000, 41.64],
                [1344808800000, 41.27],
                [1344895200000, 41.10],
                [1344981600000, 41.91],
                [1345068000000, 41.65],
                [1345154400000, 40.80],
                [1345413600000, 40.92],
                [1345500000000, 40.75],
                [1345586400000, 40.84],
                [1345672800000, 40.50],
                [1345759200000, 40.26],
                [1346018400000, 42.32],
                [1346104800000, 42.06],
                [1346191200000, 42.96],
                [1346277600000, 42.46],
                [1346364000000, 42.27],
                [1346709600000, 42.43],
                [1346796000000, 42.26],
                [1346882400000, 42.79],
                [1346968800000, 43.46],
                [1347228000000, 43.13],
                [1347314400000, 40.43],
                [1347400800000, 40.42],
                [1347487200000, 40.81],
                [1347573600000, 40.34],
                [1347832800000, 40.41],
                [1347919200000, 38.57],
                [1348005600000, 38.12],
                [1348092000000, 38.53],
                [1348178400000, 38.83],
                [1348437600000, 38.41],
                [1348524000000, 38.90],
                [1348610400000, 40.53],
                [1348696800000, 40.80],
                [1348783200000, 40.44],
                [1349042400000, 40.62],
                [1349128800000, 40.57],
                [1349215200000, 40.60],
                [1349301600000, 40.68],
                [1349388000000, 40.47],
                [1349647200000, 43.23],
                [1349733600000, 43.68],
                [1349820000000, 43.51],
                [1349906400000, 43.78],
                [1349992800000, 43.94],
                [1350252000000, 43.33],
                [1350338400000, 43.24],
                [1350424800000, 43.44],
                [1350511200000, 43.48],
                [1350597600000, 43.24],
                [1350856800000, 43.49],
                [1350943200000, 43.31],
                [1351029600000, 45.36],
                [1351116000000, 45.40],
                [1351202400000, 45.01],
                [1351638000000, 45.02],
                [1351724400000, 45.36],
                [1351810800000, 45.39],
                [1352070000000, 45.24],
                [1352156400000, 45.39],
                [1352242800000, 45.47],
                [1352329200000, 45.98],
                [1352415600000, 48.90],
                [1352674800000, 48.70],
                [1352761200000, 48.54],
                [1352847600000, 48.23],
                [1352934000000, 48.64],
                [1353020400000, 48.65],
                [1353279600000, 48.92],
                [1353366000000, 48.64],
                [1353452400000, 48.84],
                [1353625200000, 48.40],
                [1353884400000, 48.30],
                [1355353200000, 55.53],
                [1355439600000, 55.56],
                [1355698800000, 55.42],
                [1355785200000, 58.49],
                [1355871600000, 58.09],
                [1355958000000, 58.87],
                [1356044400000, 58.71],
                [1356303600000, 58.53],
                [1356476400000, 58.55],
                [1356562800000, 60.30],
                [1356649200000, 60.90],
                [1356908400000, 60.68],
                [1357081200000, 60.34],
                [1357167600000, 60.75],
                [1357254000000, 60.13],
                [1357513200000, 60.94],
                [1357599600000, 60.14],
                [1357686000000, 60.66],
                [1357772400000, 63.62],
                [1357858800000, 65.09],
                [1358118000000, 63.16],
                [1358204400000, 63.15],
                [1358290800000, 65.88],
                [1358377200000, 60.73],
                [1358463600000, 60.98],
                [1358809200000, 60.95],
                [1358895600000, 60.25],
                [1358982000000, 60.10],
                [1359068400000, 60.32],
                [1359327600000, 60.24],
                [1359414000000, 60.52],
                [1359500400000, 60.94],
                [1359586800000, 60.83],
                [1359673200000, 60.34],
                [1359932400000, 60.10],
                [1360018800000, 63.51],
                [1360105200000, 63.40],
                [1360191600000, 63.20],
                [1360278000000, 63.20],
                [1360537200000, 64.64],
                [1360623600000, 64.89],
                [1360710000000, 64.81],
                [1360796400000, 65.61],
                [1360882800000, 65.63],
                [1361228400000, 65.99],
                [1361314800000, 66.77],
                [1361401200000, 66.34],
                [1361487600000, 66.55],
                [1361746800000, 67.11],
                [1361833200000, 67.59],
                [1361919600000, 67.60]
            ]
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
            min: new Date('01 Apr 2012').getTime(),
            tickAmount: 6,
            axisTicks: {
                show: false,
            },
            axisBorder: {
                show: false
            },
        },
        tooltip: {
            x: {
                format: 'dd MMM yyyy'
            },
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
    var charttimeline = new ApexCharts(document.querySelector("#chart-timeline-dashbord"), options);
    charttimeline.render();

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
    debugger;
    $("#current_stock_percentage").html(formatPercentage("{{ array_get($data, 'change_percentage', 'null') }}"));
</script>
<!-- <script src="{{asset('assets/js/notify/index.js')}}"></script>
<script src="{{asset('assets/js/datepicker/date-picker/datepicker.js')}}"></script>
<script src="{{asset('assets/js/datepicker/date-picker/datepicker.en.js')}}"></script>
<script src="{{asset('assets/js/datepicker/date-picker/datepicker.custom.js')}}"></script> -->
@endpush
@endsection