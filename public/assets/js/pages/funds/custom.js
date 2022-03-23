$(document).ready(function() {
    $(".loader-box").css({
        'height': $('.fund-contents').innerHeight() + "px"
    });
    $(".fund-contents").css("opacity", "0.3");
    $.ajax({
        /* the route pointing to the post function */
        url: '/api/funds/highlights',
        type: 'get',
        /* remind that 'data' is the response of the AjaxController */
        success: function(res) {
            if (res.success) {
                for (var i = 0; i < res.data.length; i++) {
                    var adjustedData = [];
                    var displayData = [res.data[i]['company_name'], res.data[i]['price'], res.data[i]['change_percentage'], res.data[i]['symbol']];
                    if (res.data[i]['chart'] && res.data[i]['chart'].length != 0) {
                        for (var j = 0; j < res.data[i]['chart'].length; j++) {
                            var stock = res.data[i]['chart'][j];
                            var date = new Date(stock['date']);
                            adjustedData[j] = [date.getTime(), Number((stock['fClose']).toFixed(2))]
                        }
                        renderChart(adjustedData, (i + 1), 'USD', displayData, res.data.length);
                    } else {
                        if (i == res.data.length - 1) {
                            $(".fund-contents").css("opacity", "1");
                            $(".loader-box").css('display', 'none');
                        }
                        $.notify('<i class="fa fa-bell-o"></i>You selected one highlighted fund that had no chart info!', {
                            type: 'theme',
                            allow_dismiss: true,
                            delay: 2000,
                            showProgressbar: false,
                            timer: 4000
                        });
                    }
                }
            }
        }
    });
});

function renderChart(adjustedData, index, currency, displayData, counts) {
    var options = {
        series: [{
            name: "Closing Price",
            data: adjustedData
        }],
        stroke: {
            show: true,
            width: 3,
        },
        chart: {
            id: 'area-datetime',
            type: 'area',
            height: 200,
            zoom: {
                autoScaleYaxis: false
            },
            toolbar: {
                show: false
            },
        },
        dataLabels: {
            enabled: false,
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
                show: false,
            },
            axisBorder: {
                show: false
            },
            labels: {
                show: false
            }
        },
        yaxis: {
            labels: {
                show: false
            }
        },
        tooltip: {
            x: {
                format: 'yyyy-MM-dd'
            },
            y: {
                formatter: function(val) {
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
                        height: 180
                    }
                }
            },
            {
                breakpoint: 1238,
                options: {
                    chart: {
                        height: 160
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
                        height: 140
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
                        height: 120
                    }

                }
            }
        ],

        colors: [appConfig.fund],
    };
    var charttimeline = new ApexCharts(document.querySelector("#chart-timeline-dashboard" + index), options);
    charttimeline.render();
    $("#h_stock_title" + index).html(displayData[0]);
    $("#h_stock_title" + index).attr('title', displayData[0]);
    $("#h_stock_link" + index).attr('href', '/funds/' + displayData[3]);
    $("#h_stock_title" + index).tooltip();
    $("#current_stock_price" + index).html(formatPrice(displayData[1], currency));
    $("#current_stock_percentage" + index).html(formatPercentage(displayData[2]));
    if (displayData[2] >= 0)
        $("#current_stock_percentage" + index).addClass("font-primary");
    else
        $("#current_stock_percentage" + index).addClass("font-danger");
    if (index == counts) {
        $(".fund-contents").css("opacity", "1");
        $(".loader-box").css('display', 'none');
    }
}

function exchangeOption(obj) {
    var exchange = obj.value;
    $('#ex').attr('value', exchange);
    $('#search_btn').click();
}
