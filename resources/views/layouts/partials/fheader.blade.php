<div class="page-main-header">
  <div class="main-header-right row m-0">
    <div class="main-header-left">
      <div class="logo-wrapper"><a href="{{ route('overview') }}"><img class="img-fluid" src="{{asset('assets/images/logo/logo.png')}}" alt=""></a></div>
      <div class="dark-logo-wrapper"><a href="{{ route('overview') }}"><img class="img-fluid" src="{{asset('assets/images/logo/dark-logo.png')}}" alt="" style="max-height: 30px; margin-left:10px;"></a></div>
      <div class="toggle-sidebar"><i class="status_toggle middle" data-feather="align-center" id="sidebar-toggle"> </i></div>
    </div>
    <div class="d-flex col header-wrapper">
      <div class="nav-ticker col p-0  d-sm-block">
        <div class="ticker-wrap">
          <div class="ticker">
            <ul class="ticker__item" id="forward_ticker_wrapper">
            </ul>
          </div>
          <div class="ticker2">
            <ul class="ticker__item" id="back_ticker_wrapper">
            </ul>
          </div>
        </div>
      </div>
      <div class="nav-right pull-right right-menu p-0">
        <ul class="nav-menus w-100 sm:w-auto " style="width: 230px;">
          <li><a class="text-dark" href="#!" onclick="javascript:toggleFullScreen()"><i data-feather="maximize"></i></a></li>
          <li>
            <div class="mode"><i class="fa fa-moon-o"></i></div>
          </li>
        </ul>
      </div>
    </div>
    <div class="d-lg-none mobile-toggle pull-right w-auto"><i data-feather="more-horizontal"></i></div>
  </div>
</div>

