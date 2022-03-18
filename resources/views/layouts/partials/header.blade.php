<div class="page-main-header">
  <div class="main-header-right row m-0">
    <div class="main-header-left">
      <div class="logo-wrapper"><a href="#"><img class="img-fluid" src="{{asset('assets/images/logo/logo.png')}}" alt=""></a></div>
      <div class="dark-logo-wrapper"><a href="#"><img class="img-fluid" src="{{asset('assets/images/logo/dark-logo.png')}}" alt=""></a></div>
      <div class="toggle-sidebar"><i class="status_toggle middle" data-feather="align-center" id="sidebar-toggle"> </i></div>
    </div>
    <div class="d-flex col">
      <div class="left-menu-header" style="padding: 24px 10px;">
        <ul style="width: 210px;">
          <li>
            <div class="search-form">
              <div class="search-bg"><i class="fa fa-search"></i>
                <input type="text" id="search_stocks" placeholder="Stocks, Funds, Cryptos" class="form-control" autocomplete="off">
                <div class="search-results d-none shadow shadow-showcase bg-white flex-column" style="position: absolute; top:25px; z-index:99; padding:10px 15px; min-width:100%;">
                </div>
              </div>
            </div>
            <span class="d-sm-none mobile-search search-bg"><i class="fa fa-search"></i></span>
          </li>
        </ul>
      </div>
      <div class="nav-ticker col p-0"></div>
      <div class="nav-right pull-right right-menu p-0">
        <ul class="nav-menus" style="width: 230px;">
          <li><a class="text-dark" href="#!" onclick="javascript:toggleFullScreen()"><i data-feather="maximize"></i></a></li>
          <li>
            <div class="mode"><i class="fa fa-moon-o"></i></div>
          </li>
          <li class="onhover-dropdown p-0">
            <a class="btn btn-primary-light" href="{{ route('logout') }}" type="button" style="padding: 6px 10px;"><i style="margin: 0px;" data-feather="log-out"></i></a>
          </li>
        </ul>
      </div>
    </div>
    <div class="d-lg-none mobile-toggle pull-right w-auto"><i data-feather="more-horizontal"></i></div>
  </div>
</div>