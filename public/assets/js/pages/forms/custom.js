$(document).ready(function() {
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
                            unit_price = Number((unit[1] * 1).toFixed(8));
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
    height = 425
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
