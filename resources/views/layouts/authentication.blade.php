<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, minimum-scale=1, maximum-scale=1" />
        <meta name="description" content="This is really useful trading platform." />
        <meta name="keywords" content="trading stock, fund, crypto, cryptocurrency" />
        <meta name="author" content="pixelstrap" />
        <link rel="icon" href="{{asset('assets/images/favicon.png')}}" type="image/x-icon" />
        <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}" type="image/x-icon" />
        <title>@yield('title')</title>
        <!-- Google font-->
        @includeIf('auth.partials.css')
    </head>
    <body>
        <!-- Loader starts-->
        <div class="loader-wrapper">
            <div class="theme-loader">
                <div class="loader-p"></div>
            </div>
        </div>
        <!-- Loader ends-->
        <!-- error page start //-->
        @yield('content')
        <!-- error page end //-->
        <!-- latest jquery-->
        @includeIf('auth.partials.js')
    </body>
</html>



