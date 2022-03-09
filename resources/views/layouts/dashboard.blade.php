<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="viho admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities. laravel/framework: ^8.40">
  <meta name="keywords" content="admin template, viho admin template, dashboard template, flat admin template, responsive admin template, web app">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <meta name="author" content="pixelstrap">
  <link rel="icon" href="{{asset('assets/images/favicon.png')}}" type="image/x-icon">
  <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}" type="image/x-icon">
  <title>@yield('title')</title>
  <!-- Google font-->
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
  <!-- Font Awesome-->
  @includeIf('layouts.partials.css')
</head>

<body>
  <!-- Loader starts-->
  <div class="loader-wrapper">
    <div class="theme-loader"></div>
  </div>
  <!-- Loader ends-->
  <!-- page-wrapper Start-->
  <div class="page-wrapper compact-wrapper" id="pageWrapper">
    <!-- Page Header Start-->
    @includeIf('layouts.partials.header')
    <!-- Page Header Ends -->
    <!-- Page Body Start-->
    <div class="page-body-wrapper sidebar-icon">
      <!-- Page Sidebar Start-->
      @includeIf('layouts..partials.sidebar')
      <!-- Page Sidebar Ends-->
      <div class="page-body">
        <!-- Container-fluid starts-->
        @yield('content')
        <!-- Container-fluid Ends-->
      </div>
      <!-- footer start-->
      <footer class="footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-6 footer-copyright">
              <p class="mb-0">Copyright {{date('Y')}}-{{date('y', strtotime('+1 year'))}} © viho All rights reserved.</p>
            </div>
            <div class="col-md-6">
              <p class="pull-right mb-0">Hand crafted & made with <i class="fa fa-heart font-secondary"></i></p>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <!-- latest jquery-->
  <script type="text/javascript">
    // localStorage.clear();
    var div = document.querySelector("div.page-wrapper");
    if (div.classList.contains('compact-sidebar')) {
      div.classList.remove("compact-sidebar");
    }
    if (div.classList.contains('modern-sidebar')) {
      div.classList.remove("modern-sidebar");
    }
    localStorage.setItem('page-wrapper', 'page-wrapper compact-wrapper');
    localStorage.setItem('page-body-wrapper', 'sidebar-icon');
  </script>

  @includeIf('layouts.partials.js')
  <script>
    var all_stocks = [];
    $.ajax({
      method: 'get',
      url: '/api/stocks/all',
      success: function(res) {
        all_stocks = res.data;
      }
    });

    $("#search_stocks").on('input', function() {
      $('.search-results').empty();
      var search_query = this.value;
      var search_regex = new RegExp(search_query, "i");
      if (search_query != '') {
        $('.search-results').removeClass('d-none');
        $('.search-results').addClass('d-flex');
        var stocks = $.grep(all_stocks, function(stock) {
          return stock.symbol.match(search_regex) || stock.company_name.match(search_regex);
        });
        if (stocks.length == 0) {

        } else {
          var results = stocks;
          if (stocks.length > 10)
            var results = stocks.slice(0, 10);
          for (var i = 0; i < results.length; i++) {
            $('.search-results').append('<a style="width:max-content; padding:10px 0px;" class="text-secondary single-stock-link" href="/stocks/' + results[i].symbol + '">' + results[i].symbol + ' - <span>' + results[i].company_name + '</span></a>');
          }
        }
      } else {
        $('.search-results').removeClass('d-flex');
        $('.search-results').addClass('d-none');
        $('.search-results').append('<span>No Stocks</span>');
      }
    });

    $('#search_switch').on('click', function() {
      var flag = $(this)[0].checked;
      if (flag) {
        $("#search_stocks").attr('placeholder', 'Search Stocks');
      } else {
        $("#search_stocks").attr('placeholder', 'Search Mutual Funds');
      }
    });
  </script>
</body>

</html>