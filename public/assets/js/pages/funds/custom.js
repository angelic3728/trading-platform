$(document).ready(function() {
    $(".loader-box").css({
        height: $(".fund-contents").innerHeight() + "px"
    });
    $(".fund-contents").css("opacity", "0.3");
    $.ajax({
        /* the route pointing to the post function */
        url: "/api/funds/highlights",
        type: "get",
        /* remind that 'data' is the response of the AjaxController */
        success: function(res) {
            if (res.success) {
                for (var i = 0; i < res.data.length; i++) {
                    if (window.innerWidth > 575) {
                        var adjustedData = [];
                        var displayData = [
                            res.data[i]["company_name"],
                            res.data[i]["price"],
                            res.data[i]["change_percentage"],
                            res.data[i]["symbol"]
                        ];
                        if (
                            res.data[i]["chart"] &&
                            res.data[i]["chart"].length != 0
                        ) {
                            for (
                                var j = 0;
                                j < res.data[i]["chart"].length;
                                j++
                            ) {
                                var fund = res.data[i]["chart"][j];
                                var date = new Date(fund["date"]);
                                adjustedData[j] = [
                                    date.getTime(),
                                    Number(
                                        (res.data[i]["exchange"] == "NAS" ||
                                        (res.data[i]["data_source"] &&
                                            res.data[i]["data_source"] == "asx")
                                            ? fund["adjClose"] * 1
                                            : fund["fClose"] * 1
                                        ).toFixed(2)
                                    )
                                ];
                            }
                            renderChart(
                                adjustedData,
                                i + 1,
                                res.data[i]["gcurrency"],
                                displayData,
                                res.data.length
                            );
                        } else {
                            if (i == res.data.length - 1) {
                                $(".fund-contents").css("opacity", "1");
                                $(".loader-box").css("display", "none");
                            }
                            $.notify(
                                '<i class="fa fa-bell-o"></i>You selected one highlighted fund that had no chart info!',
                                {
                                    type: "theme",
                                    allow_dismiss: true,
                                    delay: 2000,
                                    showProgressbar: false,
                                    timer: 4000
                                }
                            );
                        }
                    } else {
                        var fund_carousel = $("#fund_carousel" + i);
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
                            .attr("href", "/funds/" + res.data[i]["symbol"]);
                        $("<h6>")
                            .appendTo(title)
                            .attr({
                                style:
                                    "text-overflow: ellipsis; overflow: hidden; white-space: nowrap;"
                            })
                            .text(res.data[i]["company_name"]);
                        var center_content = $("<div>")
                            .appendTo(detail_content)
                            .attr("class", "center-content");
                        var smalls = $("<p>")
                            .appendTo(center_content)
                            .attr("class", "d-sm-flex align-items-end");
                        $("<span>")
                            .appendTo(smalls)
                            .attr("class", "font-primary m-r-10 f-16 f-w-700")
                            .text(formatPrice(res.data[i]["price"], "USD"));
                        var percent = $("<span>")
                            .appendTo(smalls)
                            .text(
                                formatPercentage(
                                    res.data[i]["change_percentage"] / 100
                                )
                            );
                        if (res.data[i]["change_percentage"] >= 0)
                            percent.addClass("font-primary");
                        else percent.addClass("font-danger");
                        if (
                            res.data[i]["chart"] &&
                            res.data[i]["chart"].length != 0
                        ) {
                            var adjustedData = [];
                            for (
                                var j = 0;
                                j < res.data[i]["chart"].length;
                                j++
                            ) {
                                var unit = res.data[i]["chart"][j];
                                var date = new Date(unit["date"]);
                                var unit_price = Number(
                                    (unit["fClose"] * 1).toFixed(2)
                                );
                                adjustedData[j] = [date.getTime(), unit_price];
                            }

                            renderSChart(
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

                        $("#owl-carousel-14").owlCarousel({
                            items: 1,
                            margin: 10,
                            autoHeight: true,
                            nav: false
                        });
                        $(".owl-carousel-16").owlCarousel({
                            items: 1,
                            margin: 10,
                            autoHeight: true,
                            nav: false,
                            dots: false
                        });
                    }
                }
            }
        }
    });
});

function renderChart(adjustedData, index, currency, displayData, counts) {
    var options = {
        series: [
            {
                name: "Closing Price",
                data: adjustedData
            }
        ],
        stroke: {
            show: true,
            width: 3
        },
        chart: {
            id: "area-datetime",
            type: "area",
            height: 200,
            zoom: {
                autoScaleYaxis: false
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
            min: adjustedData[0][0],
            tickAmount: 6,
            axisTicks: {
                show: false
            },
            axisBorder: {
                show: false
            },
            labels: {
                show: false
            }
        },
        yaxis: {
            tickAmount: 5,
            labels: {
                show: false
            }
        },
        tooltip: {
            x: {
                format: "yyyy-MM-dd"
            },
            y: {
                formatter: function(val) {
                    return formatPrice(val, currency);
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
                            bottom: 5
                        }
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
                            bottom: 10
                        }
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

        colors: [appConfig.fund]
    };
    var charttimeline = new ApexCharts(
        document.querySelector("#chart-timeline-dashboard" + index),
        options
    );
    charttimeline.render();
    $("#h_stock_title" + index).html(displayData[0]);
    $("#h_stock_title" + index).attr("title", displayData[0]);
    $("#h_stock_link" + index).attr("href", "/funds/" + displayData[3]);
    $("#h_stock_title" + index).tooltip();
    $("#current_stock_price" + index).html(
        formatPrice(displayData[1], currency)
    );
    $("#current_stock_percentage" + index).html(
        formatPercentage(displayData[2])
    );
    if (displayData[2] >= 0)
        $("#current_stock_percentage" + index).addClass("font-primary");
    else $("#current_stock_percentage" + index).addClass("font-danger");
    if (index == counts) {
        $(".fund-contents").css("opacity", "1");
        $(".loader-box").css("display", "none");
    }
}

function renderSChart(
    adjustedData,
    obj,
    chart_color,
    lineLabel = true,
    width = 3,
    height = 200
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
            min: 0,
            tickAmount: 5
        },
        yaxis: {
            labels: {
                show: lineLabel
            },
            formatter: function(val) {
                if (user_currency != "GBP")
                    return formatPrice(val, user_currency);
                else return "£" + formatPrice(val);
            }
        },
        tooltip: {
            x: {
                format: "yyyy-MM-dd"
            },
            y: {
                formatter: function(val) {
                    if (user_currency != "GBP")
                        return formatPrice(val, user_currency);
                    else return "£" + formatPrice(val);
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
                        height: lineLabel ? 320 : height * 0.6
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

        colors: [chart_color]
    };
    var charttimeline = new ApexCharts(document.querySelector(obj), options);
    charttimeline.render();
    if (obj == "#highlight_chart_3") {
        $(".fund-contents").css("opacity", "1");
        $(".loader-box").css("display", "none");
    }
}

function exchangeOption(obj) {
    var exchange = obj.value;
    $("#ex").attr("value", exchange);
    $("#search_btn").click();
}
