$(document).ready(function () {
    //search bar function
    var all_stocks = [];
    var all_funds = [];
    var all_bonds = [];
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
        url: "/api/bonds/all",
        success: function(res) {
            all_bonds = res.data;
            total_items = total_items.concat(all_bonds);
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

    $(".search_stocks").on("input", function() {
        $(".search-results").empty();
        var search_query = this.value;
        var search_regex = new RegExp(search_query, "i");
        if (search_query != "") {
            $(".search-results").removeClass("d-none");
            $(".search-results").addClass("d-flex");
            var filtered = $.grep(total_items, function(item) {
                if (item.wherefrom == "bonds" || item.wherefrom == "cryptos")
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
                    if (results[i].wherefrom == "stocks" || results[i].wherefrom == "funds")
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
});
