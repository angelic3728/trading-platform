$(document).ready(function() {
    var monthProfits = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

    for (var i = 0; i < chartData.length; i++) {
        var current_date = new Date();
        var action_date = new Date(chartData[i]["created_at"]);
        if (action_date.getFullYear() == current_date.getFullYear()) {
            if (chartData[i]["type"] == "buy") {
                monthProfits[Number(action_date.getMonth())] = Number(
                    (
                        monthProfits[Number(action_date.getMonth())] +
                        Number(chartData[i]["realPrice"])
                    ).toFixed(2)
                );
            } else {
                monthProfits[Number(action_date.getMonth())] = Number(
                    (
                        monthProfits[Number(action_date.getMonth())] -
                        Number(chartData[i]["realPrice"])
                    ).toFixed(2)
                );
            }
        }
    }

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
        total1 =
            stockData[i]["type"] == "buy"
                ? total1 + Number(stockData[i]["realPrice"])
                : total1 - Number(stockData[i]["realPrice"]);
        adjustedStockData[i] = [
            stockData[i]["created_at"],
            Number(total1.toFixed())
        ];
    }

    for (var i = 0; i < mfdData.length; i++) {
        total2 =
            mfdData[i]["type"] == "buy"
                ? total2 + Number(mfdData[i]["realPrice"])
                : total2 - number(mfdData[i]["realPrice"]);
        adjustedMfdData[i] = [
            mfdData[i]["created_at"],
            Number(total2.toFixed())
        ];
    }

    renderChart(adjustedStockData, "#chart-timeline-dashbord1");
    renderChart(adjustedMfdData, "#chart-timeline-dashbord2");
    renderBarChart(monthProfits, "#month_profit_dash");
});

function renderChart(adjustedData, obj) {
    var options = {
        series: [
            {
                name: "Total Price",
                data: adjustedData
            }
        ],
        chart: {
            id: "area-datetime",
            type: "area",
            height: 425,
            zoom: {
                autoScaleYaxis: true
            },
            toolbar: {
                show: false
            }
        },
        dataLabels: {
            enabled: false
        },
        markers: {
            size: 0,
            style: "hollow"
        },
        xaxis: {
            type: "datetime",
            min: adjustedData[0]["created_at"],
            tickAmount: 6,
            axisTicks: {
                show: true
            },
            axisBorder: {
                show: true
            }
        },
        yaxis: {
            formatter: function(val) {
                return val.toFixed(2);
            }
        },
        tooltip: {
            x: {
                format: "yyyy-MM-dd"
            },
            y: {
                formatter: function(val) {
                    return "$" + val;
                }
            }
        },
        fill: {
            type: "gradient",
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.7,
                opacityTo: 0.9,
                stops: [0, 100]
            }
        },
        responsive: [
            {
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
                            bottom: 5
                        }
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
                            bottom: 10
                        }
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

        colors: [vihoAdminConfig.primary]
    };
    var charttimeline = new ApexCharts(document.querySelector(obj), options);
    charttimeline.render();
}

function renderBarChart(data, obj) {
    var options = {
        chart: {
            height: 350,
            type: "bar",
            toolbar: {
                show: false
            }
        },
        plotOptions: {
            bar: {
                horizontal: false,
                endingShape: "rounded",
                columnWidth: "55%"
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 2,
            colors: ["transparent"]
        },
        series: [
            {
                name: "Monthly Payment",
                data: data
            }
        ],
        xaxis: {
            categories: [
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "May",
                "Jun",
                "Jul",
                "Aug",
                "Sep",
                "Oct",
                "Nov",
                "Dec"
            ]
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
                    return "$ " + val;
                }
            }
        },
        colors: [vihoAdminConfig.secondary]
    };

    var barChart = new ApexCharts(document.querySelector(obj), options);

    barChart.render();
}

function confirmTrade(
    obj,
    type,
    symbol,
    price,
    institutional_price,
    current_shares,
    is_fund
) {
    var shares_amount = $("#shares_amount").val();
    var csrf_token = $('meta[name="csrf-token"]').attr("content");

    if (Number(shares_amount) == 0) {
        $(".alert-wrapper").html(
            '<div class="alert alert-danger dark alert-dismissible fade show" id="zero_shares_alert" role="alert">The shares must be at least 1.<button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" style="top: 0px; right:0px;"></button></div>'
        );
    } else if (
        type.toLowerCase() == "sell" &&
        Number(shares_amount) > current_shares
    )
        $(".alert-wrapper").html(
            '<div class="alert alert-danger dark alert-dismissible fade show" id="zero_shares_alert" role="alert">The shares you want to sell must be equal or less than your current shares.<button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" style="top: 0px; right:0px;"></button></div>'
        );
    else {
        $(obj).attr("onclick", "");
        $(obj).html('<i class="fa fa-spin fa-spinner"></i>');
        var url =
            is_fund == 0
                ? "/api/stocks/" + symbol + "/" + type.toLowerCase()
                : "/api/mfds/" + symbol + "/" + type.toLowerCase();
        $.ajax({
            method: "post",
            url: url,
            data: {
                shares: shares_amount,
                price: price,
                institutional_price: institutional_price,
                _token: csrf_token
            }
        }).then(response => {
            $(obj).attr("onclick", "buyShares(this)");
            $(obj).html(type.toLowerCase() == "buy" ? "BUY" : "SELL");
            if (response.success) {
                $.notify(
                    '<i class="fa fa-star-o"></i>Successfully confirmed!',
                    {
                        type: "theme",
                        allow_dismiss: true,
                        delay: 2000,
                        showProgressbar: false,
                        timer: 1000
                    }
                );
            } else {
                $.notify('<i class="fa fa-bell-o"></i>', {
                    type: "theme",
                    allow_dismiss: true,
                    delay: 2000,
                    showProgressbar: false,
                    timer: 1000
                });
            }
        });
    }
}

function openTradeModel(
    type,
    symbol,
    company_name,
    price,
    institutional_price,
    currency,
    shares,
    is_fund,
    exchange
) {
    $("#shares_amount").val("");
    if (type == "buy") {
        $("#modal_title").text("Buy shares from " + symbol);
        $("#trade_type").text("buy");
        $("#trade_btn").text("BUY");
        $("#trade_btn").removeClass("btn-danger");
        $("#trade_btn").addClass("btn-primary");
    } else {
        $("#modal_title").text("Sell shares from " + symbol);
        $("#trade_type").text("sell");
        $("#trade_btn").text("SELL");
        $("#trade_btn").removeClass("btn-primary");
        $("#trade_btn").addClass("btn-danger");
    }

    $("#trade_symbol").text(symbol);
    $("#trade_company").text(company_name);
    $("#trade_price").text(formatPrice(Number(price), currency));
    $("#trade_institutional_price").text(
        formatPrice(Number(institutional_price), currency)
    );

    if (exchange.toLowerCase() == "xnys")
        $("#trade_is_xnys").css("display", "none");
    else $("#trade_is_xnys").css("display", "block");

    $("#shares-label").text("Shares (Current Shares: " + shares + ")");
    $("#trade_btn").attr(
        "onclick",
        'confirmTrade(this, "' +
            type +
            '", "' +
            symbol +
            '", ' +
            price +
            ", " +
            institutional_price +
            ", " +
            shares +
            ", " +
            is_fund +
            ")"
    );
    $("#tradeModal").modal("show");
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

function hide_ad() {
    $("#ad1_container").removeClass("d-flex");
    $("#ad1_container").addClass("d-none");
    $("#ad2_container").removeClass("d-flex");
    $("#ad2_container").addClass("d-none");
    $(".dashboard-content-wrapper").css("margin-right", "-12px");
    $(".dashboard-content-wrapper").css("padding-top", "0px");
}
