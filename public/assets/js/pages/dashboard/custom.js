$(document).ready(function() {
    var monthProfits = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    for (var i = 0; i < chartData.length; i++) {
        var current_date = new Date();
        var action_date = new Date(chartData[i]["created_at"]);
        if (action_date.getFullYear() == current_date.getFullYear()) {
            if (chartData[i]["type"] == "buy") {
                for (
                    var j = Number(action_date.getMonth());
                    j < Number(current_date.getMonth()) + 1;
                    j++
                ) {
                    debugger;
                    monthProfits[j] = Number(
                        (
                            monthProfits[j] +
                            chartData[i]["realPrice"] * currency_rate
                        ).toFixed(2)
                    );
                }
            } else {
                for (
                    var j = Number(action_date.getMonth());
                    j < Number(current_date.getMonth()) + 1;
                    j++
                ) {
                    debugger;
                    monthProfits[j] = Number((monthProfits[j] - chartData[i]["realPrice"] * currency_rate).toFixed(2));
                }
            }
        }
    }

    renderBarChart(monthProfits, "#month_profit_dash");

    $.ajax({
        url: "/api/dashboard/performance/7d",
        type: "get",
        success: function(res) {
            if (res.success) {
                if (res.stock_data.length != 0) {
                    var stock_data = res.stock_data;
                    for (var i = 0; i < stock_data.length; i++) {
                        var date = new Date(stock_data[i][0]);
                        stock_data[i][0] = date.getTime();
                        stock_data[i][1] = Number(
                            (stock_data[i][1] * currency_rate).toFixed(2)
                        );
                    }
                    $('#chart-timeline-dashboard1').empty();
                    renderChart(
                        stock_data,
                        "#chart-timeline-dashboard1",
                        appConfig.primary
                    );
                } else
                    $("#chart-timeline-dashboard1").append(
                        "<div class='d-flex justify-content-center align-items-center' style='width:100%'><h4>No Chart Data!</h4></div>"
                    );

                if (res.fund_data.length != 0) {
                    var fund_data = res.fund_data;
                    for (var i = 0; i < fund_data.length; i++) {
                        var date = new Date(fund_data[i][0]);
                        fund_data[i][0] = date.getTime();
                        fund_data[i][1] = Number(
                            (fund_data[i][1] * currency_rate).toFixed(2)
                        );
                    }
                    $('#chart-timeline-dashboard2').empty();
                    renderChart(
                        fund_data,
                        "#chart-timeline-dashboard2",
                        appConfig.fund
                    );
                } else
                    $("#chart-timeline-dashboard2").append(
                        "<div class='d-flex justify-content-center align-items-center' style='width:100%'><h4>No Chart Data!</h4></div>"
                    );

                if (res.bond_data.length != 0) {
                    var bond_data = res.bond_data;
                    for (var i = 0; i < bond_data.length; i++) {
                        var date = new Date(bond_data[i][0]);
                        bond_data[i][0] = date.getTime();
                        bond_data[i][1] = Number(
                            (bond_data[i][1] * currency_rate).toFixed(2)
                        );
                    }
                    $('#chart-timeline-dashboard3').empty();
                    renderChart(
                        bond_data,
                        "#chart-timeline-dashboard3",
                        appConfig.bond
                    );
                } else
                    $("#chart-timeline-dashboard3").append(
                        "<div class='d-flex justify-content-center align-items-center' style='width:100%'><h4>No Chart Data!</h4></div>"
                    );

                if (res.crypto_data.length != 0) {
                    var crypto_data = res.crypto_data;
                    for (var i = 0; i < crypto_data.length; i++) {
                        var date = new Date(crypto_data[i][0]);
                        crypto_data[i][0] = date.getTime();
                        if (crypto_data[i][1] > 1)
                            crypto_data[i][1] = Number(
                                (crypto_data[i][1] * currency_rate).toFixed(2)
                            );
                        else if (crypto_data[i][1] > 0.1)
                            crypto_data[i][1] = Number(
                                (crypto_data[i][1] * currency_rate).toFixed(3)
                            );
                        else if (crypto_data[i][1] > 0.01)
                            crypto_data[i][1] = Number(
                                (crypto_data[i][1] * currency_rate).toFixed(4)
                            );
                        else if (crypto_data[i][1] > 0.001)
                            crypto_data[i][1] = Number(
                                (crypto_data[i][1] * currency_rate).toFixed(5)
                            );
                        else if (crypto_data[i][1] > 0.0001)
                            crypto_data[i][1] = Number(
                                (crypto_data[i][1] * currency_rate).toFixed(6)
                            );
                        else if (crypto_data[i][1] > 0.00001)
                            crypto_data[i][1] = Number(
                                (crypto_data[i][1] * currency_rate).toFixed(7)
                            );
                        else
                            crypto_data[i][1] = Number(
                                (crypto_data[i][1] * currency_rate).toFixed(10)
                            );
                    }
                    $('#chart-timeline-dashboard4').empty();
                    renderChart(
                        crypto_data,
                        "#chart-timeline-dashboard4",
                        appConfig.crypto
                    );
                } else
                    $("#chart-timeline-dashboard4").append(
                        "<div class='d-flex justify-content-center align-items-center' style='width:100%'><h4>No Chart Data!</h4></div>"
                    );
            } else {
            }
        }
    });

    if (all_highlights.length != 0) {
        for (var i = 0; i < all_highlights.length; i++) {
            if (window.innerWidth > 575) {
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
                            style:
                                "text-overflow: ellipsis; overflow: hidden; white-space: nowrap;"
                        })
                        .text(all_highlights[i]["company_name"]);
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
                            formatPercentage(
                                all_highlights[i]["change_percentage"]
                            )
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
                            formatPercentage(
                                all_highlights[i]["change_percentage"]
                            )
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
                                Number(
                                    (all_highlights[i]["exchange"] == "NAS" ||
                                    all_highlights[i]["data_source"] == "asx"
                                        ? unit["adjClose"] * 1
                                        : unit["fClose"] * 1
                                    ).toFixed(2)
                                )
                            ];
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
                                all_highlights[i]["price"],
                                all_highlights[i]["gcurrency"]
                            )
                        );
                    var percent = $("<span>")
                        .appendTo(smalls)
                        .text(
                            formatPercentage(
                                all_highlights[i]["change_percentage"]
                            )
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
                                Number((unit["fClose"] * 1).toFixed(2))
                            ];
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
                        .attr(
                            "href",
                            "/cryptos/" + all_highlights[i]["symbol"]
                        );
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
                        .text(formatPrice(all_highlights[i]["price"], "USD"));
                    var percent = $("<span>")
                        .appendTo(smalls)
                        .text(
                            formatPercentage(
                                all_highlights[i]["change_percentage"] / 100
                            )
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
            } else {
                var index = i + 1;
                var highlight_carousel = $("#highlight_carousel" + index);
                var item = $("<div>")
                    .appendTo(highlight_carousel)
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
                    .attr(
                        "href",
                        "/" +
                            all_highlights[i]["wherefrom"] +
                            "/" +
                            all_highlights[i]["symbol"]
                    );
                var h6 = $("<h6>")
                    .appendTo(title)
                    .attr({
                        style:
                            "text-overflow: ellipsis; overflow: hidden; white-space: nowrap;"
                    })
                    .text(
                        all_highlights[i]["wherefrom"] == "stock" ||
                            all_highlights[i]["wherefrom"] == "fund"
                            ? all_highlights[i]["company_name"]
                            : all_highlights[i]["name"]
                    );
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
                    if (all_highlights[i]["wherefrom"] == "stock") {
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
                    } else if (all_highlights[i]["wherefrom"] == "fund") {
                        for (
                            var j = 0;
                            j < all_highlights[i]["chart"].length;
                            j++
                        ) {
                            var unit = all_highlights[i]["chart"][j];
                            var date = new Date(unit["date"]);
                            adjustedData[j] = [
                                date.getTime(),
                                Number(
                                    (all_highlights[i]["exchange"] == "NAS" ||
                                    all_highlights[i]["data_source"] == "asx"
                                        ? unit["adjClose"] * 1
                                        : unit["fClose"] * 1
                                    ).toFixed(2)
                                )
                            ];
                        }
                        renderChart(
                            adjustedData,
                            "#highlight_chart_" + i,
                            appConfig.fund,
                            false,
                            2,
                            200
                        );
                    } else if (all_highlights[i]["wherefrom"] == "bond") {
                        for (
                            var j = 0;
                            j < all_highlights[i]["chart"].length;
                            j++
                        ) {
                            var unit = all_highlights[i]["chart"][j];
                            var date = new Date(unit["date"]);
                            adjustedData[j] = [
                                date.getTime(),
                                Number((unit["fClose"] * 1).toFixed(2))
                            ];
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
                    }
                } else {
                    $("#highlight_chart_" + i).text("No Chart Data!");
                }
            }
        }

        if (window.innerWidth > 575) {
            $("#owl-carousel-14").owlCarousel({
                items: 1,
                margin: 10,
                autoHeight: true,
                nav: false
            });
        } else {
            $("#owl-carousel-15").owlCarousel({
                items: 1,
                margin: 10,
                autoHeight: true,
                nav: false
            });
        }

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
    height = window.innerWidth > 1580
        ? 340
        : window.innerWidth > 575
        ? 288
        : 310
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
            tickAmount: 7,
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
            tickAmount: 5,
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
}

function renderBarChart(data, obj) {
    var options = {
        chart: {
            height: 385,
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
                name: "Month Value",
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
                if (user_currency != "GBP")
                    return formatPrice(val, user_currency);
                else return "£" + formatPrice(val);
            }
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    if (user_currency != "GBP")
                        return formatPrice(val, user_currency);
                    else return "£" + formatPrice(val);
                }
            }
        },
        responsive: [
            {
                breakpoint: 575,
                options: {
                    chart: {
                        height: 250
                    }
                }
            }
        ],
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
                : wherefrom == 1
                ? "/api/fund/" + symbol + "/" + type.toLowerCase()
                : wherefrom == 2
                ? "/api/bond/" + symbol + "/" + type.toLowerCase()
                : "/api/crypto/" + symbol + "/" + type.toLowerCase();
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
            $("#tradeModal").modal("hide");
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

function openTradeModal(
    type,
    symbol,
    company_name,
    price,
    institutional_price,
    currency,
    shares,
    wherefrom,
    exchange,
    currency_rate
) {
    $("#shares_amount").val("");
    if (type == "buy") {
        if (wherefrom == 0 || wherefrom == 1) {
            $("#trade_type").text("buy shares");
        } else $("#trade_type").text("buy units");
        $("#shares_amount").attr("placeholder", "Enter the amount of $");
        $("#trade_btn").text("BUY");
        $("#trade_btn").removeClass("btn-danger");
        $("#trade_btn").addClass("btn-primary");
    } else {
        $("#trade_type").text("sell");
        if (wherefrom == 0 || wherefrom == 1) {
            $("#trade_type").text("sell shares");
            $("#shares_amount").attr("placeholder", "Enter the amount of shares");
        }
        else {
            $("#trade_type").text("sell units");
            $("#shares_amount").attr("placeholder", "Enter the amount of units");
        }
        $("#trade_btn").text("SELL");
        $("#trade_btn").removeClass("btn-primary");
        $("#trade_btn").addClass("btn-danger");
    }

    if (wherefrom == 0) $("#wherefrom_home").text("stock");
    else if (wherefrom == 1) $("#wherefrom_home").text("fund");
    else if (wherefrom == 2) $("#wherefrom_home").text("bond");
    else if (wherefrom == 3) $("#wherefrom_home").text("crypto");

    if (wherefrom == 2 || wherefrom == 3) {
        $("#home_last_price_label").text("Unit Price");
        if (wherefrom == 2) $("#home_inst_price_label").text("Market Price");
        else $("#home_inst_price_label").text("Institutional Price");
        $("#shares-label").text("Units (Current Units: " + shares + ")");
        if (type == "buy") $("#modal_title").text("Buy units from " + symbol);
        else $("#modal_title").text("Sell units from " + symbol);
    } else {
        $("#home_last_price_label").text("Retail Price");
        $("#home_inst_price_label").text("Institutional Price");
        $("#shares-label").text("Shares (Current Shares: " + shares + ")");
        if (type == "buy") $("#modal_title").text("Buy shares from " + symbol);
        else $("#modal_title").text("Sell shares from " + symbol);
    }

    $('#local_calc_amount').val(currency_rate);

    $("#trade_symbol").text(symbol);
    $("#trade_company").text(company_name);
    $("#trade_price").text(formatPrice(price, currency));
    console.log(price);
    console.log(institutional_price);
    $("#trade_institutional_price").text(
        formatPrice(institutional_price, currency)
    );

    if (exchange.toLowerCase() == "crypto" || exchange.toLowerCase() == "xnys")
        $("#trade_is_xnys").css("display", "none");
    else $("#trade_is_xnys").css("display", "block");

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

// function getDatesFromRange(range) {
//     var current_date = new Date();
//     var start_date = "";
//     switch (range) {
//         case "7d":
//             start_date = new Date(current_date.getTime() - 7 * 24 * 60 * 60 * 1000);
//             break;
//         case "1m":
//             start_date = new Date();
//             start_date.setMonth(start_date.getMonth() - 1);
//             break;
//         case "6m":
//             start_date = new Date();
//             start_date.setMonth(start_date.getMonth() - 6);
//             break;
//         case "ytd":
//             start_date = new Date(new Date().getFullYear(), 0, 1);
//             break;
//         case "1y":
//             start_date = new Date();
//             start_date.setFullYear(start_date.getFullYear() - 1);
//             break;
//         case "5y":
//             start_date = new Date();
//             start_date.setFullYear(start_date.getFullYear() - 5);
//             break;
//         default:
//             start_date = new Date(current_date.getTime() - 7 * 24 * 60 * 60 * 1000);
//             break;
//     }

//     var interval =
//         range == "5y"
//             ? 20
//             : range == "1y" || range == "ytd"
//             ? 10
//             : range == "6m"
//             ? 5
//             : 1;

//     var retVal = [];
//     var prev_date = new Date(start_date);

//     while (prev_date <= current_date) {
//         retVal.push(new Date(prev_date));
//         prev_date = new Date(prev_date.setDate(prev_date.getDate()+interval));
//     }

//     if(retVal(retVal.length-1) != current_date)
//         retVal[retVal.length] = current_date;

//     return retVal;
// }
