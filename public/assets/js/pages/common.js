var all_stocks = [];
var all_funds = [];
var search_fund = false;

$.ajax({
    method: "get",
    url: "/api/stocks/all",
    success: function(res) {
        all_stocks = res.data;
    }
});

$.ajax({
    method: "get",
    url: "/api/mfds/all",
    success: function(res) {
        all_funds = res.data;
    }
});

$("#search_stocks").on("input", function() {
    $(".search-results").empty();
    var search_query = this.value;
    var search_regex = new RegExp(search_query, "i");
    if (search_query != "") {
        $(".search-results").removeClass("d-none");
        $(".search-results").addClass("d-flex");
        if (search_fund) {
            var funds = $.grep(all_funds, function(fund) {
                return (
                    fund.symbol.match(search_regex) ||
                    fund.company_name.match(search_regex)
                );
            });
            if (funds.length == 0) {
                $(".search-results").append(
                    '<span class="text-secondary">No results.</span>'
                );
            } else {
                var results = funds;
                if (funds.length > 10) var results = funds.slice(0, 10);
                for (var i = 0; i < results.length; i++) {
                    $(".search-results").append(
                        '<a style="width:max-content; padding:10px 0px;" class="text-secondary single-stock-link" href="/mfds/' +
                            results[i].symbol +
                            '">' +
                            results[i].symbol +
                            " - <span>" +
                            results[i].company_name +
                            "</span></a>"
                    );
                }
            }
        } else {
            var stocks = $.grep(all_stocks, function(stock) {
                return (
                    stock.symbol.match(search_regex) ||
                    stock.company_name.match(search_regex)
                );
            });
            if (stocks.length == 0) {
                $(".search-results").append(
                    '<span class="text-secondary">No results.</span>'
                );
            } else {
                var results = stocks;
                if (stocks.length > 10) var results = stocks.slice(0, 10);
                for (var i = 0; i < results.length; i++) {
                    $(".search-results").append(
                        '<a style="width:max-content; padding:10px 0px;" class="text-secondary single-stock-link" href="/stocks/' +
                            results[i].symbol +
                            '">' +
                            results[i].symbol +
                            " - <span>" +
                            results[i].company_name +
                            "</span></a>"
                    );
                }
            }
        }
    } else {
        $(".search-results").removeClass("d-flex");
        $(".search-results").addClass("d-none");
        $(".search-results").append("<span>No Stocks</span>");
    }
});

$("#search_switch").on("click", function() {
    var flag = $(this)[0].checked;
    if (flag) {
        $("#search_stocks").attr("placeholder", "Search Stocks");
        search_fund = false;
    } else {
        $("#search_stocks").attr("placeholder", "Search Mutual Funds");
        search_fund = true;
    }
});
