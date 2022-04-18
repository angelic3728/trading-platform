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
        return v.wherefrom == 0;
    });
    var fundData = $.grep(chartData, function(v) {
        return v.wherefrom == 1;
    });
    var bondData = $.grep(chartData, function(v) {
        return v.wherefrom == 2;
    });
    var cryptoData = $.grep(chartData, function(v) {
        return v.wherefrom == 3;
    });

    stockData = stockData.reverse();
    fundData = fundData.reverse();
    bondData = bondData.reverse();
    cryptoData = cryptoData.reverse();

    adjustedStockData = [];
    adjustedFundData = [];
    adjustedBondData = [];
    adjustedCryptoData = [];
    total1 = 0;
    total2 = 0;
    total3 = 0;
    total4 = 0;

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

    for (var i = 0; i < fundData.length; i++) {
        total2 =
            fundData[i]["type"] == "buy"
                ? total2 + Number(fundData[i]["realPrice"])
                : total2 - number(fundData[i]["realPrice"]);
        adjustedFundData[i] = [
            fundData[i]["created_at"],
            Number(total2.toFixed())
        ];
    }

    for (var i = 0; i < bondData.length; i++) {
        total3 =
            bondData[i]["type"] == "buy"
                ? total3 + Number(bondData[i]["realPrice"])
                : total3 - number(bondData[i]["realPrice"]);
        adjustedBondData[i] = [
            bondData[i]["created_at"],
            Number(total3.toFixed())
        ];
    }

    for (var i = 0; i < cryptoData.length; i++) {
        total4 =
            cryptoData[i]["type"] == "buy"
                ? total4 + Number(cryptoData[i]["realPrice"])
                : total4 - number(cryptoData[i]["realPrice"]);
        adjustedCryptoData[i] = [
            cryptoData[i]["created_at"],
            Number(total4.toFixed())
        ];
    }

    if (stockData.length != 0)
        renderChart(
            adjustedStockData,
            "#chart-timeline-dashbord1",
            appConfig.primary
        );
    else $("#chart-timeline-dashbord1").append("<div class='d-flex justify-content-center align-items-center' style='min-height:440px;'><h4>No Chart Data!</h4></div>");

    if (fundData.length != 0)
        renderChart(
            adjustedFundData,
            "#chart-timeline-dashbord2",
            appConfig.fund
        );
    else $("#chart-timeline-dashbord2").append("<div class='d-flex justify-content-center align-items-center' style='min-height:440px;'><h4>No Chart Data!</h4></div>");

    if (bondData.length != 0)
        renderChart(
            adjustedBondData,
            "#chart-timeline-dashbord3",
            appConfig.bond
        );
    else $("#chart-timeline-dashbord3").append("<div class='d-flex justify-content-center align-items-center' style='min-height:440px;'><h4>No Chart Data!</h4></div>");

    if (cryptoData.length != 0)
        renderChart(
            adjustedCryptoData,
            "#chart-timeline-dashbord4",
            appConfig.crypto
        );
    else $("#chart-timeline-dashbord4").append("<div class='d-flex justify-content-center align-items-center' style='min-height:440px;'><h4>No Chart Data!</h4></div>");

    if ((!stockData || stockData.length == 0) && (fundData || fundData.length == 0) && (bondData || bondData.length == 0) && (cryptoData || crytoData.length == 0))
        $("#month_profit_dash").append("<div class='d-flex justify-content-center align-items-center' style='min-height:470px;'><h4>No Chart Data!</h4></div>");
    else renderBarChart(monthProfits, "#month_profit_dash");

    if (all_highlights.length != 0) {
        for (var i = 0; i < all_highlights.length; i++) {
            if (all_highlights[i]["wherefrom"] == "stock") {
                var stock_carousel = $("#stock_carousel");
                var item = $("<div>")
                    .appendTo(stock_carousel)
                    .attr("class", "item");
                var card = $("<div>")
                    .appendTo(item)
                    .attr("class", "card");
                var chart_content = $("<div>")
                    .appendTo(card)
                    .attr("class", "chart-content");
                $("<div>")
                    .appendTo(chart_content)
                    .attr("id", "highlight_chart_" + i);
                var detail_content = $("<div>")
                    .appendTo(card)
                    .attr("class", "d-flex-column p-2");
                var title = $("<a>")
                    .appendTo(detail_content)
                    .attr("href", "/stocks/" + all_highlights[i]["symbol"]);
                var h6 = $("<h6>")
                    .appendTo(title)
                    .attr({
                        title: all_highlights[i]["company_name"],
                        style:
                            "text-overflow: ellipsis; overflow: hidden; white-space: nowrap;"
                    })
                    .text(all_highlights[i]["company_name"]);
                h6.tooltip();
                var center_content = $("<div>")
                    .appendTo(detail_content)
                    .attr("class", "center-content");
                var smalls = $("<p>")
                    .appendTo(center_content)
                    .attr("class", "d-sm-flex align-items-end");
                $("<span>")
                    .appendTo(smalls)
                    .attr("class", "font-primary m-r-10 f-16 f-w-700")
                    .text(
                        formatPrice(
                            all_highlights[i]["price"],
                            all_highlights[i]["gcurrency"]
                        )
                    );
                var percent = $("<span>")
                    .appendTo(smalls)
                    .text(
                        formatPercentage(all_highlights[i]["change_percentage"])
                    );
                if (all_highlights[i]["change_percentage"] >= 0)
                    percent.addClass("font-primary");
                else percent.addClass("font-danger");
                if (
                    all_highlights[i]["chart"] &&
                    all_highlights[i]["chart"].length != 0
                ) {
                    var adjustedData = [];
                    for (
                        var j = 0;
                        j < all_highlights[i]["chart"].length;
                        j++
                    ) {
                        var unit = all_highlights[i]["chart"][j];
                        var date = new Date(unit["date"]);
                        adjustedData[j] = [
                            date.getTime(),
                            Number(unit["fClose"].toFixed(2))
                        ];
                    }
                    renderChart(
                        adjustedData,
                        "#highlight_chart_" + i,
                        appConfig.primary,
                        false,
                        2,
                        200
                    );
                } else {
                    $("#highlight_chart_" + i).text("No Chart Data!");
                }
            } else if (all_highlights[i]["wherefrom"] == "fund") {
                var fund_carousel = $("#fund_carousel");
                var item = $("<div>")
                    .appendTo(fund_carousel)
                    .attr("class", "item");
                var card = $("<div>")
                    .appendTo(item)
                    .attr("class", "card");
                var chart_content = $("<div>")
                    .appendTo(card)
                    .attr("class", "chart-content");
                $("<div>")
                    .appendTo(chart_content)
                    .attr("id", "highlight_chart_" + i);
                var detail_content = $("<div>")
                    .appendTo(card)
                    .attr("class", "d-flex-column p-2");
                var title = $("<a>")
                    .appendTo(detail_content)
                    .attr("href", "/funds/" + all_highlights[i]["symbol"]);
                var h6 = $("<h6>")
                    .appendTo(title)
                    .attr({
                        title: all_highlights[i]["company_name"],
                        style:
                            "text-overflow: ellipsis; overflow: hidden; white-space: nowrap;"
                    })
                    .text(all_highlights[i]["company_name"]);
                h6.tooltip();
                var center_content = $("<div>")
                    .appendTo(detail_content)
                    .attr("class", "center-content");
                var smalls = $("<p>")
                    .appendTo(center_content)
                    .attr("class", "d-sm-flex align-items-end");
                $("<span>")
                    .appendTo(smalls)
                    .attr("class", "font-primary m-r-10 f-16 f-w-700")
                    .text(
                        formatPrice(
                            all_highlights[i]["price"],
                            all_highlights[i]["gcurrency"]
                        )
                    );
                var percent = $("<span>")
                    .appendTo(smalls)
                    .text(
                        formatPercentage(all_highlights[i]["change_percentage"])
                    );
                if (all_highlights[i]["change_percentage"] >= 0)
                    percent.addClass("font-primary");
                else percent.addClass("font-danger");
                if (
                    all_highlights[i]["chart"] &&
                    all_highlights[i]["chart"].length != 0
                ) {
                    var adjustedData = [];
                    for (
                        var j = 0;
                        j < all_highlights[i]["chart"].length;
                        j++
                    ) {
                        var unit = all_highlights[i]["chart"][j];
                        var date = new Date(unit["date"]);
                        adjustedData[j] = [date.getTime(), Number(((all_highlights[i]['exchange'] == 'NAS' || all_highlights[i]['data_source'] == 'asx') ? unit['adjClose'] * 1 : unit['fClose'] * 1).toFixed(2))];
                    }
                    renderChart(
                        adjustedData,
                        "#highlight_chart_" + i,
                        appConfig.fund,
                        false,
                        2,
                        200
                    );
                } else {
                    $("#highlight_chart_" + i).text("No Chart Data!");
                }
            } else if (all_highlights[i]["wherefrom"] == "bond") {
                var bond_carousel = $("#bond_carousel");
                var item = $("<div>")
                    .appendTo(bond_carousel)
                    .attr("class", "item");
                var card = $("<div>")
                    .appendTo(item)
                    .attr("class", "card");
                var chart_content = $("<div>")
                    .appendTo(card)
                    .attr("class", "chart-content");
                $("<div>")
                    .appendTo(chart_content)
                    .attr("id", "highlight_chart_" + i);
                var detail_content = $("<div>")
                    .appendTo(card)
                    .attr("class", "d-flex-column p-2");
                var title = $("<a>")
                    .appendTo(detail_content)
                    .attr("href", "/funds/" + all_highlights[i]["symbol"]);
                var h6 = $("<h6>")
                    .appendTo(title)
                    .attr({
                        title: all_highlights[i]["name"],
                        style:
                            "text-overflow: ellipsis; overflow: hidden; white-space: nowrap;"
                    })
                    .text(all_highlights[i]["name"]);
                h6.tooltip();
                var center_content = $("<div>")
                    .appendTo(detail_content)
                    .attr("class", "center-content");
                var smalls = $("<p>")
                    .appendTo(center_content)
                    .attr("class", "d-sm-flex align-items-end");
                $("<span>")
                    .appendTo(smalls)
                    .attr("class", "font-primary m-r-10 f-16 f-w-700")
                    .text(
                        formatPrice(
                            Number(all_highlights[i]["price"]),
                            all_highlights[i]["gcurrency"]
                        )
                    );
                var percent = $("<span>")
                    .appendTo(smalls)
                    .text(
                        formatPercentage(all_highlights[i]["change_percentage"])
                    );
                if (all_highlights[i]["change_percentage"] >= 0)
                    percent.addClass("font-primary");
                else percent.addClass("font-danger");
                if (
                    all_highlights[i]["chart"] &&
                    all_highlights[i]["chart"].length != 0
                ) {
                    var adjustedData = [];
                    for (
                        var j = 0;
                        j < all_highlights[i]["chart"].length;
                        j++
                    ) {
                        var unit = all_highlights[i]["chart"][j];
                        var date = new Date(unit["date"]);
                        adjustedData[j] = [date.getTime(), Number((unit['fClose'] * 1).toFixed(2))];
                    }
                    renderChart(
                        adjustedData,
                        "#highlight_chart_" + i,
                        appConfig.bond,
                        false,
                        3,
                        200
                    );
                } else {
                    $("#highlight_chart_" + i).text("No Chart Data!");
                }
            } else if (all_highlights[i]["wherefrom"] == "crypto") {
                var crypto_carousel = $("#crypto_carousel");
                var item = $("<div>")
                    .appendTo(crypto_carousel)
                    .attr("class", "item");
                var card = $("<div>")
                    .appendTo(item)
                    .attr("class", "card");
                var chart_content = $("<div>")
                    .appendTo(card)
                    .attr("class", "chart-content");
                $("<div>")
                    .appendTo(chart_content)
                    .attr("id", "highlight_chart_" + i);
                var detail_content = $("<div>")
                    .appendTo(card)
                    .attr("class", "d-flex-column p-2");
                var title = $("<a>")
                    .appendTo(detail_content)
                    .attr("href", "/cryptos/" + all_highlights[i]["symbol"]);
                var h6 = $("<h6>")
                    .appendTo(title)
                    .attr({
                        title: all_highlights[i]["name"],
                        style:
                            "text-overflow: ellipsis; overflow: hidden; white-space: nowrap;"
                    })
                    .text(all_highlights[i]["name"]);
                h6.tooltip();
                var center_content = $("<div>")
                    .appendTo(detail_content)
                    .attr("class", "center-content");
                var smalls = $("<p>")
                    .appendTo(center_content)
                    .attr("class", "d-sm-flex align-items-end");
                $("<span>")
                    .appendTo(smalls)
                    .attr("class", "font-primary m-r-10 f-16 f-w-700")
                    .text(
                        formatPrice(
                            all_highlights[i]["price"],
                            'USD'
                        )
                    );
                var percent = $("<span>")
                    .appendTo(smalls)
                    .text(
                        formatPercentage(all_highlights[i]["change_percentage"]/100)
                    );
                if (all_highlights[i]["change_percentage"] >= 0)
                    percent.addClass("font-primary");
                else percent.addClass("font-danger");
                if (
                    all_highlights[i]["chart"] &&
                    all_highlights[i]["chart"].length != 0
                ) {
                    var adjustedData = [];
                    for (
                        var j = 0;
                        j < all_highlights[i]["chart"].length;
                        j++
                    ) {
                        var unit = all_highlights[i]["chart"][j];
                        var date = new Date(unit[0]);
                        var unit_price = 0;
                        if (Number(unit[1] * 1) > 10) {
                            unit_price = Number((unit[1] * 1).toFixed(2));
                        } else if (Number(unit[1] * 1) > 1) {
                            unit_price = Number((unit[1] * 1).toFixed(3));
                        } else if (Number(unit[1] * 1) > 0.1) {
                            unit_price = Number((unit[1] * 1).toFixed(4));
                        } else if (Number(unit[1] * 1) > 0.01) {
                            unit_price = Number((unit[1] * 1).toFixed(5));
                        } else if (Number(unit[1] * 1) > 0.001) {
                            unit_price = Number((unit[1] * 1).toFixed(6));
                        } else if (Number(unit[1] * 1) > 0.0001) {
                            unit_price = Number((unit[1] * 1).toFixed(7));
                        } else {
                            unit_price = Number((unit[1] * 1).toFixed(10));
                        }
                        adjustedData[j] = [date.getTime(), unit_price];
                    }
                    renderChart(
                        adjustedData,
                        "#highlight_chart_" + i,
                        appConfig.crypto,
                        false,
                        2,
                        200
                    );
                } else {
                    $("#highlight_chart_" + i).text("No Chart Data!");
                }
            }
        }

        $("#owl-carousel-14").owlCarousel({
            items: 1,
            margin: 10,
            autoHeight: true,
            nav: false
        });
        $(".owl-carousel-16").owlCarousel({
            items: 4,
            margin: 10,
            autoHeight: true,
            nav: false,
            dots: false,
            responsive: {
                320: {
                    items: 1,
                    mergeFit: true
                },
                480: {
                    items: 2,
                    mergeFit: true
                },
                1280: {
                    items: 2,
                    mergeFit: true
                },
                1670: {
                    items: 4,
                    mergeFit: true
                }
            }
        });
    }
});

function renderChart(
    adjustedData,
    obj,
    chart_color,
    lineLabel = true,
    width = 3,
    height = 375
) {
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
            height: height,
            zoom: {
                autoScaleYaxis: true
            },
            toolbar: {
                show: false
            }
        },
        stroke: {
            show: true,
            width: width
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
                show: lineLabel
            },
            axisBorder: {
                show: lineLabel
            },
            labels: {
                show: lineLabel
            }
        },
        yaxis: {
            labels: {
                show: lineLabel
            },
            formatter: function(val) {
                return formatPrice(val, 'USD');
            }
        },
        tooltip: {
            x: {
                format: "yyyy-MM-dd"
            },
            y: {
                formatter: function(val) {
                    return formatPrice(val, 'USD');
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
                        height: height * 0.8
                    }
                }
            },
            {
                breakpoint: 1238,
                options: {
                    chart: {
                        height: 350
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
                        height: (lineLabel)?320:height*0.6
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
                        height: (lineLabel)?280:250
                    }
                }
            }
        ],

        colors: [chart_color]
    };
    var charttimeline = new ApexCharts(document.querySelector(obj), options);
    charttimeline.render();
}

function renderBarChart(data, obj) {
    var options = {
        chart: {
            height: 395,
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
                return formatPrice(val, 'USD');
            }
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return formatPrice(val, 'USD');
                }
            }
        },
        colors: [appConfig.secondary]
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
    wherefrom
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
            wherefrom == 0
                ? "/api/stocks/" + symbol + "/" + type.toLowerCase()
                : (wherefrom == 1?"/api/fund/" + symbol + "/" + type.toLowerCase():wherefrom == 2?"/api/bond/" + symbol + "/" + type.toLowerCase():"/api/crypto/" + symbol + "/" + type.toLowerCase());
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
    wherefrom,
    exchange='crypto'
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

    if (exchange.toLowerCase() == "crypto" || exchange.toLowerCase() == "xnys")
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
            wherefrom +
            ")"
    );
    $("#tradeModal").modal("show");
}
