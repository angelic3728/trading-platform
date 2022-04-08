<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="This is really useful trading platform.">
  <meta name="keywords" content="trading stock, fund, crypto, cryptocurrency">
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
    @includeIf('layouts.partials.fheader')
    <!-- Page Header Ends -->
    <!-- Page Body Start-->
    <div class="page-body-wrapper sidebar-icon">
      <!-- Page Sidebar Start-->
      @includeIf('layouts.partials.fsidebar')
      <!-- Page Sidebar Ends-->
      <div class="page-body">
        <!-- Container-fluid starts-->
        @yield('content')
        <!-- Container-fluid Ends-->
      </div>
      <!-- footer start-->
      <footer class="m-l-0">
        <div class="container">
          <div class="row justify-content-between">
            <div class="col-sm-auto">
              © {{ date('Y') }} {{ config('app.name') }}
            </div>
            <div class="col-sm-auto pt-2 pt-sm-0">
              <nav>
                <a href="mailto://{{ config('app.email') }}" class="m-r-10">Contact Us</a>
                <a href="{{ route('legal.terms-and-conditions') }}" class="m-r-10">Terms & Conditions</a>
                <a href="{{ route('legal.privacy-policy') }}" class="m-r-10">Privacy Policy</a>
              </nav>
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

    // ticker data
    var ticker_data = {!! $widget_items !!};
    var news_symbols = {!! json_encode($news_symbols) !!};
  </script>

  @includeIf('layouts.partials.js')
</body>
</html>