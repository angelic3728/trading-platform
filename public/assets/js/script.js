(function($) {
    "use strict";
    $(".mobile-toggle").click(function() {
        $(".nav-menus").toggleClass("open");
    });
    $(".mobile-toggle-left").click(function() {
        $(".left-header").toggleClass("open");
    });
    $(".mobile-search").click(function() {
        $(".form-control-plaintext").toggleClass("open");
    });
    $(".bookmark-search").click(function() {
        $(".form-control-search").toggleClass("open");
    });
    $(".filter-toggle").click(function() {
        $(".product-sidebar").toggleClass("open");
    });
    $(".toggle-data").click(function() {
        $(".product-wrapper").toggleClass("sidebaron");
    });
    $(".form-control-search").keyup(function(e) {
        if (e.target.value) {
            $(".page-wrapper.horizontal-wrapper").addClass(
                "offcanvas-bookmark"
            );
        } else {
            $(".page-wrapper.horizontal-wrapper").removeClass(
                "offcanvas-bookmark"
            );
        }
    });
})(jQuery);

$(".loader-wrapper").fadeOut("slow", function() {
    $(this).remove();
});

$(window).on("scroll", function() {
    if ($(this).scrollTop() > 600) {
        $(".tap-top").fadeIn();
    } else {
        $(".tap-top").fadeOut();
    }
});

$(".media-size-email svg").on("click", function(e) {
    $(this).toggleClass("like");
});

$(".tap-top").click(function() {
    $("html, body").animate(
        {
            scrollTop: 0
        },
        600
    );
    return false;
});

function toggleFullScreen() {
    if (
        (document.fullScreenElement && document.fullScreenElement !== null) ||
        (!document.mozFullScreen && !document.webkitIsFullScreen)
    ) {
        if (document.documentElement.requestFullScreen) {
            document.documentElement.requestFullScreen();
        } else if (document.documentElement.mozRequestFullScreen) {
            document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullScreen) {
            document.documentElement.webkitRequestFullScreen(
                Element.ALLOW_KEYBOARD_INPUT
            );
        }
    } else {
        if (document.cancelFullScreen) {
            document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        }
    }
}
(function($, window, document, undefined) {
    "use strict";
    var $ripple = $(".js-ripple");
    $ripple.on("click.ui.ripple", function(e) {
        var $this = $(this);
        var $offset = $this.parent().offset();
        var $circle = $this.find(".c-ripple__circle");
        var x = e.pageX - $offset.left;
        var y = e.pageY - $offset.top;
        $circle.css({
            top: y + "px",
            left: x + "px"
        });
        $this.addClass("is-active");
    });
    $ripple.on(
        "animationend webkitAnimationEnd oanimationend MSAnimationEnd",
        function(e) {
            $(this).removeClass("is-active");
        }
    );
})(jQuery, window, document);

// active link
$(".chat-menu-icons .toogle-bar").click(function() {
    $(".chat-menu").toggleClass("show");
});

// Language
var tnum = "en";
$(document).ready(function() {
    if (localStorage.getItem("primary") != null) {
        var primary_val = localStorage.getItem("primary");
        $("#ColorPicker1").val(primary_val);
        var secondary_val = localStorage.getItem("secondary");
        $("#ColorPicker2").val(secondary_val);
    }
    $(document).click(function(e) {
        $(".translate_wrapper, .more_lang").removeClass("active");
    });
    $(".translate_wrapper .current_lang").click(function(e) {
        e.stopPropagation();
        $(this)
            .parent()
            .toggleClass("active");

        setTimeout(function() {
            $(".more_lang").toggleClass("active");
        }, 5);
    });

    /*TRANSLATE*/
    translate(tnum);

    $(".more_lang .lang").click(function() {
        $(this)
            .addClass("selected")
            .siblings()
            .removeClass("selected");
        $(".more_lang").removeClass("active");

        var i = $(this)
            .find("i")
            .attr("class");
        var lang = $(this).attr("data-value");
        var tnum = lang;
        translate(tnum);

        $(".current_lang .lang-txt").text(lang);
        $(".current_lang i").attr("class", i);
    });
});

function translate(tnum) {
    $(".lan-1").text(trans[0][tnum]);
    $(".lan-2").text(trans[1][tnum]);
    $(".lan-3").text(trans[2][tnum]);
    $(".lan-4").text(trans[3][tnum]);
    $(".lan-5").text(trans[4][tnum]);
    $(".lan-6").text(trans[5][tnum]);
    $(".lan-7").text(trans[6][tnum]);
    $(".lan-8").text(trans[7][tnum]);
    $(".lan-9").text(trans[8][tnum]);
}

var trans = [
    {
        en: "General",
        pt: "Geral",
        es: "Generalo",
        fr: "GÃ©nÃ©rale",
        de: "Generel",
        cn: "ä¸€èˆ¬",
        ae: "Ø­Ø¬Ù†Ø±Ø§Ù„ Ù„ÙˆØ§Ø¡"
    },
    {
        en: "Dashboards,widgets & layout.",
        pt: "PainÃ©is, widgets e layout.",
        es: "Paneloj, fenestraÄµoj kaj aranÄo.",
        fr: "Tableaux de bord, widgets et mise en page.",
        de: "Dashboards, widgets en lay-out.",
        cn: "ä»ªè¡¨æ¿ï¼Œå°å·¥å…·å’Œå¸ƒå±€ã€‚",
        ae: "Ù„ÙˆØ­Ø§Øª Ø§Ù„Ù…Ø¹Ù„ÙˆÙ…Ø§Øª ÙˆØ§Ù„Ø£Ø¯ÙˆØ§Øª ÙˆØ§Ù„ØªØ®Ø·ÙŠØ·."
    },
    {
        en: "Dashboards",
        pt: "PainÃ©is",
        es: "Paneloj",
        fr: "Tableaux",
        de: "Dashboards",
        cn: " ä»ªè¡¨æ¿ ",
        ae: "ÙˆØ­Ø§Øª Ø§Ù„Ù‚ÙŠØ§Ø¯Ø© "
    },
    {
        en: "Default",
        pt: "PadrÃ£o",
        es: "Vaikimisi",
        fr: "DÃ©faut",
        de: "Standaard",
        cn: "é›»å­å•†å‹™",
        ae: "ÙˆØ¥ÙØªØ±Ø§Ø¶ÙŠ"
    },
    {
        en: "Ecommerce",
        pt: "ComÃ©rcio eletrÃ´nico",
        es: "Komerco",
        fr: "Commerce Ã©lectronique",
        de: "E-commerce",
        cn: "é›»å­å•†å‹™",
        ae: "ÙˆØ§Ù„ØªØ¬Ø§Ø±Ø© Ø§Ù„Ø¥Ù„ÙƒØªØ±ÙˆÙ†ÙŠØ©"
    },
    {
        en: "Widgets",
        pt: "Ferramenta",
        es: "Vidin",
        fr: "Widgets",
        de: "Widgets",
        cn: "å°éƒ¨ä»¶",
        ae: "ÙˆØ§Ù„Ø­Ø§Ø¬ÙŠØ§Øª"
    },
    {
        en: "Page layout",
        pt: "Layout da pÃ¡gina",
        es: "PaÄa aranÄo",
        fr: "Tableaux",
        de: "Mise en page",
        cn: "é é¢ä½ˆå±€",
        ae: "ÙˆØªØ®Ø·ÙŠØ· Ø§Ù„ØµÙØ­Ø©"
    },
    {
        en: "Applications",
        pt: "FormulÃ¡rios",
        es: "Aplikoj",
        fr: "Applications",
        de: "Toepassingen",
        cn: "æ‡‰ç”¨é ˜åŸŸ",
        ae: "ÙˆØ§Ù„ØªØ·Ø¨ÙŠÙ‚Ø§Øª"
    },
    {
        en: "Ready to use Apps",
        pt: "Pronto para usar aplicativos",
        es: "Preta uzi Apps",
        fr: " Applications prÃªtes Ã  lemploi ",
        de: "Klaar om apps te gebruiken",
        cn: "ä»ªè¡¨æ¿",
        ae: "Ø¬Ø§Ù‡Ø² Ù„Ø§Ø³ØªØ®Ø¯Ø§Ù… Ø§Ù„ØªØ·Ø¨ÙŠÙ‚Ø§Øª"
    }
];

/*=====================
02. Background Image js
  ==========================*/
$(".bg-center")
    .parent()
    .addClass("b-center");
$(".bg-img-cover")
    .parent()
    .addClass("bg-size");
$(".bg-img-cover").each(function() {
    var el = $(this),
        src = el.attr("src"),
        parent = el.parent();
    parent.css({
        "background-image": "url(" + src + ")",
        "background-size": "cover",
        "background-position": "center",
        display: "block"
    });
    el.hide();
});

/*----------------------------------------
passward show hide
----------------------------------------*/
$(".show-hide").show();
$(".show-hide span").addClass("show");

$(".show-hide span").click(function() {
    if ($(this).hasClass("show")) {
        $('input[name="login[password]"]').attr("type", "text");
        $(this).removeClass("show");
    } else {
        $('input[name="login[password]"]').attr("type", "password");
        $(this).addClass("show");
    }
});
$('form button[type="submit"]').on("click", function() {
    $(".show-hide span").addClass("show");
    $(".show-hide")
        .parent()
        .find('input[name="login[password]"]')
        .attr("type", "password");
});

//landing header //
$(".toggle-menu").click(function() {
    $(".landing-menu").toggleClass("open");
});
$(".menu-back").click(function() {
    $(".landing-menu").toggleClass("open");
});

$(".product-size ul li ").on("click", function(e) {
    $(".product-size ul li ").removeClass("active");
    $(this).addClass("active");
});

$(".email-sidebar .email-aside-toggle ").on("click", function(e) {
    $(".email-sidebar .email-left-aside ").toggleClass("open");
});

$(".job-sidebar .job-toggle ").on("click", function(e) {
    $(".job-sidebar .job-left-aside ").toggleClass("open");
});

$(".mode").on("click", function() {
    $(".mode i")
        .toggleClass("fa-moon-o")
        .toggleClass("fa-lightbulb-o");
    // $('.mode-sun').toggleClass("show")
    $("body").toggleClass("dark-only");
    var color = $(this).attr("data-attr");
    localStorage.setItem("body", "dark-only");
});

$(document).ready(function() {
    //search bar function
    var all_stocks = [];
    var all_funds = [];
    var all_cryptos = [];
    var total_items = [];

    $.ajax({
        method: "get",
        url: "/api/stocks/all",
        success: function(res) {
            all_stocks = res.data;
            total_items = total_items.concat(all_stocks);
        }
    });

    $.ajax({
        method: "get",
        url: "/api/funds/all",
        success: function(res) {
            all_funds = res.data;
            total_items = total_items.concat(all_funds);
        }
    });

    $.ajax({
        method: "get",
        url: "/api/cryptos/all",
        success: function(res) {
            all_cryptos = res.data;
            total_items = total_items.concat(all_cryptos);
        }
    });

    $("#search_stocks").on("input", function() {
        $(".search-results").empty();
        var search_query = this.value;
        var search_regex = new RegExp(search_query, "i");
        if (search_query != "") {
            $(".search-results").removeClass("d-none");
            $(".search-results").addClass("d-flex");
            var filtered = $.grep(total_items, function(item) {
                if (item.wherefrom == "cryptos")
                    return (
                        item.symbol.match(search_regex) ||
                        item.name.match(search_regex)
                    );
                else
                    return (
                        item.symbol.match(search_regex) ||
                        item.company_name.match(search_regex)
                    );
            });
            if (filtered.length == 0) {
                $(".search-results").append(
                    '<span class="text-secondary">No results.</span>'
                );
            } else {
                var results = filtered;
                if (filtered.length > 10) var results = filtered.slice(0, 10);
                for (var i = 0; i < results.length; i++) {
                    if (results[i].wherefrom != "cryptos")
                        $(".search-results").append(
                            '<a style="width:max-content; padding:10px 0px;" class="text-secondary single-stock-link" href="/' +
                                results[i].wherefrom +
                                "/" +
                                results[i].symbol +
                                '">' +
                                results[i].symbol +
                                " - <span>" +
                                results[i].company_name +
                                "</span></a>"
                        );
                    else
                        $(".search-results").append(
                            '<a style="width:max-content; padding:10px 0px;" class="text-secondary single-stock-link" href="/' +
                                results[i].wherefrom +
                                "/" +
                                results[i].symbol +
                                '">' +
                                results[i].symbol +
                                " - <span>" +
                                results[i].name +
                                "</span></a>"
                        );
                }
            }
        } else {
            $(".search-results").removeClass("d-flex");
            $(".search-results").addClass("d-none");
            $(".search-results").append("<span>No Stocks</span>");
        }
    });

    // add forward ticker feeds
    for (var i = 0; i < ticker_data.length; i++) {
        var ticker_item = $("<li>");
        if (ticker_data[i]["wherefrom"] == "stock") {
            var item_content = $("<a>")
                .appendTo(ticker_item)
                .attr("href", "/stocks/" + ticker_data[i]["symbol"]);
            $("<h6>")
                .appendTo(item_content)
                .css({
                    "margin-bottom": "5px",
                    "font-size": "14px",
                    "text-overflow": "ellipsis",
                    overflow: "hidden",
                    "white-space": "nowrap",
                    "max-width": "200px"
                })
                .text(ticker_data[i]["company_name"]);
            var info_wrapper = $("<div>")
                .appendTo(item_content)
                .attr("class", "d-flex");
            var ticker_wrapper = $("<div>")
                .appendTo(info_wrapper)
                .attr("class", "d-flex flex-column");
            $("<span>")
                .appendTo(ticker_wrapper)
                .text(
                    formatPrice(
                        Number(ticker_data[i]["price"]),
                        ticker_data[i]["gcurrency"]
                    )
                )
                .css({ "font-size": "12px" });
            $("<span>")
                .appendTo(ticker_wrapper)
                .attr(
                    "class",
                    ticker_data[i]["change_percentage"] > 0
                        ? "text-success"
                        : "text-danger"
                )
                .text(formatPercentage(ticker_data[i]["change_percentage"]));
            var chart_con = $("<div>")
                .appendTo(info_wrapper)
                .attr("class", "d-flex")
                .css("top", "-30px");
            $("<div>")
                .appendTo(chart_con)
                .attr("id", "chart_wrapper_" + i);
            var chartData = ticker_data[i]["chart"];
            if (chartData && chartData.length != 0) {
                var adjustedData = [];
                for (var j = 0; j < chartData.length; j++) {
                    var date = new Date(chartData[j]["date"]);
                    adjustedData[j] = [
                        date.getTime(),
                        Number((chartData[j]["fClose"] * 1).toFixed(2))
                    ];
                }
                ticker_item.appendTo("#forward_ticker_wrapper");
                renderChart(adjustedData, "#chart_wrapper_" + i, "stock");
            } else {
                ticker_item.appendTo("#forward_ticker_wrapper");
                $("#chart_wrapper_" + i).append(
                    '<span class="p-3">No Chart Data!</span>'
                );
            }
        } else if (ticker_data[i]["wherefrom"] == "fund") {
            var item_content = $("<a>")
                .appendTo(ticker_item)
                .attr("href", "/funds/" + ticker_data[i]["symbol"]);
            $("<h6>")
                .appendTo(item_content)
                .css({
                    "margin-bottom": "5px",
                    "font-size": "14px",
                    "text-overflow": "ellipsis",
                    overflow: "hidden",
                    "white-space": "nowrap",
                    "max-width": "200px"
                })
                .text(ticker_data[i]["company_name"]);
            var info_wrapper = $("<div>")
                .appendTo(item_content)
                .attr("class", "d-flex");
            var ticker_wrapper = $("<div>")
                .appendTo(info_wrapper)
                .attr("class", "d-flex flex-column");
            $("<span>")
                .appendTo(ticker_wrapper)
                .text(
                    formatPrice(
                        Number(ticker_data[i]["price"]),
                        ticker_data[i]["gcurrency"]
                    )
                )
                .css({ "font-size": "12px" });
            $("<span>")
                .appendTo(ticker_wrapper)
                .attr(
                    "class",
                    ticker_data[i]["change_percentage"] > 0
                        ? "text-success"
                        : "text-danger"
                )
                .text(formatPercentage(ticker_data[i]["change_percentage"]));
            var chart_con = $("<div>")
                .appendTo(info_wrapper)
                .attr("class", "d-flex")
                .css("top", "-30px");
            $("<div>")
                .appendTo(chart_con)
                .attr("id", "chart_wrapper_" + i);
            var chartData = ticker_data[i]["chart"];
            if (chartData && chartData.length != 0) {
                var adjustedData = [];
                for (var j = 0; j < chartData.length; j++) {
                    var date = new Date(chartData[j]["date"]);
                    adjustedData[j] = [
                        date.getTime(),
                        Number((chartData[j]["fClose"] * 1).toFixed(2))
                    ];
                }
                ticker_item.appendTo("#forward_ticker_wrapper");
                renderChart(adjustedData, "#chart_wrapper_" + i, "fund");
            } else {
                ticker_item.appendTo("#forward_ticker_wrapper");
                $("#chart_wrapper_" + i).append(
                    '<span class="p-3">No Chart Data!</span>'
                );
            }
        } else if (ticker_data[i]["wherefrom"] == "crypto") {
            var item_content = $("<a>")
                .appendTo(ticker_item)
                .attr("href", "/cryptos/" + ticker_data[i]["symbol"]);
            $("<h6>")
                .appendTo(item_content)
                .css({
                    "margin-bottom": "5px",
                    "font-size": "14px",
                    "text-overflow": "ellipsis",
                    overflow: "hidden",
                    "white-space": "nowrap",
                    "max-width": "200px"
                })
                .text(ticker_data[i]["name"]);
            var info_wrapper = $("<div>")
                .appendTo(item_content)
                .attr("class", "d-flex");
            var ticker_wrapper = $("<div>")
                .appendTo(info_wrapper)
                .attr("class", "d-flex flex-column");
            $("<span>")
                .appendTo(ticker_wrapper)
                .text(formatPrice(Number(ticker_data[i]["price"]), "USD"))
                .css({ "font-size": "12px" });
            $("<span>")
                .appendTo(ticker_wrapper)
                .attr(
                    "class",
                    ticker_data[i]["change_percentage"] > 0
                        ? "text-success"
                        : "text-danger"
                )
                .text(
                    formatPercentage(ticker_data[i]["change_percentage"] / 100)
                );
            var chart_con = $("<div>")
                .appendTo(info_wrapper)
                .attr("class", "d-flex")
                .css("top", "-25px");
            $("<div>")
                .appendTo(chart_con)
                .attr("id", "chart_wrapper_" + i);
            var chartData = ticker_data[i]["chart"];
            if (chartData && chartData.length != 0) {
                var adjustedData = [];
                for (var j = 0; j < chartData.length; j++) {
                    var date = new Date(chartData[j][0]);
                    var unit_price = 0;
                    if (Number(chartData[j][1] * 1) > 10) {
                        unit_price = Number((chartData[j][1] * 1).toFixed(2));
                    } else if (Number(chartData[j][1] * 1) > 1) {
                        unit_price = Number((chartData[j][1] * 1).toFixed(3));
                    } else if (Number(chartData[j][1] * 1) > 0.1) {
                        unit_price = Number((chartData[j][1] * 1).toFixed(4));
                    } else if (Number(chartData[j][1] * 1) > 0.01) {
                        unit_price = Number((chartData[j][1] * 1).toFixed(5));
                    } else if (Number(chartData[j][1] * 1) > 0.001) {
                        unit_price = Number((chartData[j][1] * 1).toFixed(6));
                    } else if (Number(chartData[j][1] * 1) > 0.0001) {
                        unit_price = Number((chartData[j][1] * 1).toFixed(7));
                    } else {
                        unit_price = Number((chartData[j][1] * 1).toFixed(8));
                    }
                    adjustedData[j] = [date.getTime(), unit_price];
                }
                ticker_item.appendTo("#forward_ticker_wrapper");
                renderChart(adjustedData, "#chart_wrapper_" + i, "crypto");
            } else {
                ticker_item.appendTo("#forward_ticker_wrapper");
                $("#chart_wrapper_" + i).append(
                    '<span class="p-3">No Chart Data!</span>'
                );
            }
        }
    }

    // add back ticker feeds
    for (var i = 0; i < ticker_data.length; i++) {
        var ticker_item = $("<li>");
        if (ticker_data[i]["wherefrom"] == "stock") {
            var item_content = $("<a>")
                .appendTo(ticker_item)
                .attr("href", "/stocks/" + ticker_data[i]["symbol"]);
            $("<h6>")
                .appendTo(item_content)
                .css({
                    "margin-bottom": "5px",
                    "font-size": "14px",
                    "text-overflow": "ellipsis",
                    overflow: "hidden",
                    "white-space": "nowrap",
                    "max-width": "200px"
                })
                .text(ticker_data[i]["company_name"]);
            var info_wrapper = $("<div>")
                .appendTo(item_content)
                .attr("class", "d-flex");
            var ticker_wrapper = $("<div>")
                .appendTo(info_wrapper)
                .attr("class", "d-flex flex-column");
            $("<span>")
                .appendTo(ticker_wrapper)
                .text(ticker_data[i]["price"])
                .css({ "font-size": "12px" });
            $("<span>")
                .appendTo(ticker_wrapper)
                .attr(
                    "class",
                    ticker_data[i]["change_percentage"] > 0
                        ? "text-success"
                        : "text-danger"
                )
                .text(formatPercentage(ticker_data[i]["change_percentage"]));
            var chart_con = $("<div>")
                .appendTo(info_wrapper)
                .attr("class", "d-flex")
                .css("top", "-30px");
            $("<div>")
                .appendTo(chart_con)
                .attr("id", "chart_wrapper2_" + i);
            var chartData = ticker_data[i]["chart"];
            if (chartData && chartData.length != 0) {
                var adjustedData = [];
                for (var j = 0; j < chartData.length; j++) {
                    var date = new Date(chartData[j]["date"]);
                    adjustedData[j] = [
                        date.getTime(),
                        Number((chartData[j]["fClose"] * 1).toFixed(2))
                    ];
                }
                ticker_item.appendTo("#back_ticker_wrapper");
                renderChart(adjustedData, "#chart_wrapper2_" + i, "stock");
            } else {
                ticker_item.appendTo("#back_ticker_wrapper");
                $("#chart_wrapper2_" + i).append(
                    '<span class="p-3">No Chart Data!</span>'
                );
            }
        } else if (ticker_data[i]["wherefrom"] == "fund") {
            var item_content = $("<a>")
                .appendTo(ticker_item)
                .attr("href", "/funds/" + ticker_data[i]["symbol"]);
            $("<h6>")
                .appendTo(item_content)
                .css({
                    "margin-bottom": "5px",
                    "font-size": "14px",
                    "text-overflow": "ellipsis",
                    overflow: "hidden",
                    "white-space": "nowrap",
                    "max-width": "200px"
                })
                .text(ticker_data[i]["company_name"]);
            var info_wrapper = $("<div>")
                .appendTo(item_content)
                .attr("class", "d-flex");
            var ticker_wrapper = $("<div>")
                .appendTo(info_wrapper)
                .attr("class", "d-flex flex-column");
            $("<span>")
                .appendTo(ticker_wrapper)
                .text(ticker_data[i]["price"])
                .css({ "font-size": "12px" });
            $("<span>")
                .appendTo(ticker_wrapper)
                .attr(
                    "class",
                    ticker_data[i]["change_percentage"] > 0
                        ? "text-success"
                        : "text-danger"
                )
                .text(formatPercentage(ticker_data[i]["change_percentage"]));
            var chart_con = $("<div>")
                .appendTo(info_wrapper)
                .attr("class", "d-flex")
                .css("top", "-30px");
            $("<div>")
                .appendTo(chart_con)
                .attr("id", "chart_wrapper2_" + i);
            var chartData = ticker_data[i]["chart"];
            if (chartData && chartData.length != 0) {
                var adjustedData = [];
                for (var j = 0; j < chartData.length; j++) {
                    var date = new Date(chartData[j]["date"]);
                    adjustedData[j] = [
                        date.getTime(),
                        Number((chartData[j]["fClose"] * 1).toFixed(2))
                    ];
                }
                ticker_item.appendTo("#back_ticker_wrapper");
                renderChart(adjustedData, "#chart_wrapper2_" + i, "fund");
            } else {
                ticker_item.appendTo("#back_ticker_wrapper");
                $("#chart_wrapper2_" + i).append(
                    '<span class="p-3">No Chart Data!</span>'
                );
            }
        } else if (ticker_data[i]["wherefrom"] == "crypto") {
            var item_content = $("<a>")
                .appendTo(ticker_item)
                .attr("href", "/cryptos/" + ticker_data[i]["symbol"]);
            $("<h6>")
                .appendTo(item_content)
                .css({
                    "margin-bottom": "5px",
                    "font-size": "14px",
                    "text-overflow": "ellipsis",
                    overflow: "hidden",
                    "white-space": "nowrap",
                    "max-width": "200px"
                })
                .text(ticker_data[i]["name"]);
            var info_wrapper = $("<div>")
                .appendTo(item_content)
                .attr("class", "d-flex");
            var ticker_wrapper = $("<div>")
                .appendTo(info_wrapper)
                .attr("class", "d-flex flex-column");
            $("<span>")
                .appendTo(ticker_wrapper)
                .text(formatPrice(Number(ticker_data[i]["price"]), "USD"))
                .css({ "font-size": "12px" });
            $("<span>")
                .appendTo(ticker_wrapper)
                .attr(
                    "class",
                    ticker_data[i]["change_percentage"] > 0
                        ? "text-success"
                        : "text-danger"
                )
                .text(
                    formatPercentage(ticker_data[i]["change_percentage"] / 100)
                );
            var chart_con = $("<div>")
                .appendTo(info_wrapper)
                .attr("class", "d-flex")
                .css("top", "-25px");
            $("<div>")
                .appendTo(chart_con)
                .attr("id", "chart_wrapper2_" + i);
            var chartData = ticker_data[i]["chart"];
            if (chartData && chartData.length != 0) {
                var adjustedData = [];
                for (var j = 0; j < chartData.length; j++) {
                    var date = new Date(chartData[j][0]);
                    var unit_price = 0;
                    if (Number(chartData[j][1] * 1) > 10) {
                        unit_price = Number((chartData[j][1] * 1).toFixed(2));
                    } else if (Number(chartData[j][1] * 1) > 1) {
                        unit_price = Number((chartData[j][1] * 1).toFixed(3));
                    } else if (Number(chartData[j][1] * 1) > 0.1) {
                        unit_price = Number((chartData[j][1] * 1).toFixed(4));
                    } else if (Number(chartData[j][1] * 1) > 0.01) {
                        unit_price = Number((chartData[j][1] * 1).toFixed(5));
                    } else if (Number(chartData[j][1] * 1) > 0.001) {
                        unit_price = Number((chartData[j][1] * 1).toFixed(6));
                    } else if (Number(chartData[j][1] * 1) > 0.0001) {
                        unit_price = Number((chartData[j][1] * 1).toFixed(7));
                    } else {
                        unit_price = Number((chartData[j][1] * 1).toFixed(8));
                    }
                    adjustedData[j] = [date.getTime(), unit_price];
                }
                ticker_item.appendTo("#back_ticker_wrapper");
                renderChart(adjustedData, "#chart_wrapper2_" + i, "crypto");
            } else {
                ticker_item.appendTo("#back_ticker_wrapper");
                $("#chart_wrapper2_" + i).append(
                    '<span class="p-3">No Chart Data!</span>'
                );
            }
        }
    }

    function renderChart(adjustedData, widget, wherefrom) {
        var options = {
            series: [
                {
                    name: "Closing Price",
                    data: adjustedData
                }
            ],
            stroke: {
                show: true,
                width: 1
            },
            grid: {
                show: false
            },
            chart: {
                id: "area-datetime",
                type: "area",
                height: 110,
                width: 150,
                zoom: {
                    enabled: false
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
                labels: {
                    show: false
                },
                tickerAmount: 3
            },
            tooltip: {
                enabled: false
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
            colors: ["#24695c"]
        };

        if (wherefrom == "stock") options["colors"] = [appConfig.primary];
        else if (wherefrom == "fund") options["colors"] = [appConfig.fund];
        else if (wherefrom == "crypto") options["colors"] = [appConfig.crypto];

        var charttimeline = new ApexCharts(
            document.querySelector(widget),
            options
        );
        charttimeline.render();
    }

    // news part creation
    if (news_symbols.length != 0) {
        var joinedSymbols = news_symbols.join(",");
        $.ajax({
            method: "get",
            url: "/api/news?symbols=" + joinedSymbols + "&&limit=4",
            success: function(res) {
                var artiles = res.data;
                if (artiles.length > 0) {
                    for (var i = 0; i < artiles.length; i++) {
                        $(".news-" + i).css("display", "block");
                        $(".news-img-" + i).attr("src", artiles[i]["image"]);
                        $(".news-link-" + i).attr("href", artiles[i]["url"]);
                        $(".news-date-" + i).html(
                            dateStr(new Date(artiles[i].datetime))
                        );
                        $(".news-headline-" + i).html(artiles[i]["headline"]);
                        if (artiles[i]["summary"].length > 150)
                            $(".news-summary-" + i)
                                .attr("class", "text-secondary")
                                .html(
                                    artiles[i]["summary"].substr(0, 150 - 3) +
                                        "..."
                                );
                        else
                            $(".news-summary-" + i)
                                .attr("class", "text-secondary")
                                .html(artiles[i]["summary"]);

                        if (i == 2) {
                            $(".see-more").removeClass("d-none");
                            $(".see-more").addClass("d-block");
                        }
                    }
                } else {
                    $(".news-content").css("display", "none");
                    $(".no-news").css("display", "block");
                }
                $(".news-content").css("opacity", "1");
                $(".news-loader").css("display", "none");
            }
        });
    }
});

// format Price and Percentage functions
function formatPrice(price, currency) {
    var decimal = 2;
    if (Number(price) > 10) {
        decimal = 2;
    } else if (Number(price) > 1) {
        decimal = 3;
    } else if (Number(price) > 0.1) {
        decimal = 4;
    } else if (Number(price) > 0.01) {
        decimal = 5;
    } else {
        decimal = 6;
    }

    var amount =
        Number(price) > 999
            ? Number(price.toFixed(decimal))
                  .toString()
                  .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            : Number(price.toFixed(decimal)).toString();

    switch (currency) {
        case "USD":
            return "$" + amount;

        case "GBP":
            return (
                (Number(price)*100 > 999
                    ? (price.toFixed(decimal) * 100)
                          .toString()
                          .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    : (price.toFixed(decimal)*100).toString()) + "p"
            );

        case "EUR":
            return "€" + amount;

        case "AUD":
            return "A$" + amount;

        case "CAD":
            return "C$" + amount;

        case "SEK":
            return amount + " kr";

        case "CHF":
            return "fr." + amount;

        case "CZK":
            return amount + " Kč";

        case "DKK":
            return "kr." + amount;

        case "HKD":
            return "HK$" + amount;

        case "HUF":
            return amount + " Ft";

        case "ILS":
            return "₪" + amount;

        case "JPY":
            return "¥" + amount;

        case "NOK":
            return "kr" + amount;

        case "PLN":
            return amount + " zł";

        case "PLN":
            return amount + " lei";

        default:
            return amount;
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
    $(".dashboard-content-wrapper").css("padding-right", "0px");
    $(".dashboard-content-wrapper").css("padding-top", "0px");
}

function dateStr(obj) {
    var mm = obj.getMonth() + 1; // getMonth() is zero-based
    var dd = obj.getDate();

    return [
        obj.getFullYear(),
        (mm > 9 ? "" : "0") + mm,
        (dd > 9 ? "" : "0") + dd
    ].join(" : ");
}

$(".ticker").hover(function() {
    $(this).css("animation-play-state", "paused");
    $(this).css("-webkit-animation-play-state", "paused");
    $(".ticker2").css("animation-play-state", "paused");
    $(".ticker2").css("-webkit-animation-play-state", "paused");
});

$(".ticker").on("mouseleave", function() {
    $(this).css("animation-play-state", "running");
    $(this).css("-webkit-animation-play-state", "running");
    $(".ticker2").css("animation-play-state", "running");
    $(".ticker2").css("-webkit-animation-play-state", "running");
});

$(".ticker2").hover(function() {
    $(this).css("animation-play-state", "paused");
    $(this).css("-webkit-animation-play-state", "paused");
    $(".ticker").css("animation-play-state", "paused");
    $(".ticker").css("-webkit-animation-play-state", "paused");
});

$(".ticker2").on("mouseleave", function() {
    $(this).css("animation-play-state", "running");
    $(this).css("-webkit-animation-play-state", "running");
    $(".ticker").css("animation-play-state", "running");
    $(".ticker").css("-webkit-animation-play-state", "running");
});
