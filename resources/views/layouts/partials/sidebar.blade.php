<header class="main-nav">
    <div class="sidebar-user text-center">
        <a class="setting-primary" href="{{ route('settings') }}"><i data-feather="settings"></i></a><img class="img-90 rounded-circle" src="{{ auth()->user()->avatar_url }}" alt="" />
        <a href="user-profile" href="{{ route('settings') }}">
            <h6 class="mt-3 f-14 f-w-600">{{ auth()->user()->first_name." ".auth()->user()->last_name }}</h6>
        </a>
        <h6 class="mt-3 f-14 f-w-600">{{ auth()->user()->email }}</h6>        
    </div>
    <nav>
        <div class="main-navbar">
            <div id="mainnav">
                <ul class="nav-menu custom-scrollbar">
                    <li class="back-btn">
                        <div class="mobile-back text-end link-nav"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                    </li>
                    <li class="dropdown">
                        <a class="nav-link menu-title link-nav {{ request()->route()->named('overview') ? 'active' : '' }}" href="{{ route('overview') }}"><i data-feather="home"></i><span>Dashboard</span></a>
                    </li>
                    <li class="dropdown">
                        <a class="nav-link menu-title link-nav {{ request()->route()->named('xtbs') ? 'active' : '' }}" href="{{ route('overview') }}"><i data-feather="aperture"></i><span>XTB's</span></a>
                    </li>
                    <li class="dropdown">
                        <a class="nav-link menu-title link-nav {{ request()->route()->named('transactions') ? 'active' : '' }}" href="{{ route('transactions') }}"><i data-feather="zap"></i><span>Transactions</span></a>
                    </li>
                    <li class="dropdown">
                        <a class="nav-link menu-title link-nav {{ request()->route()->named('documents.index') ? 'active' : '' }}" href="{{ route('documents.index') }}"><i data-feather="file-text"></i><span>Documents</span></a>
                    </li>
                    <li class="dropdown">
                        <a class="nav-link menu-title link-nav {{ request()->route()->named('stocks.search') ? 'active' : '' }}" href="{{ route('stocks.search') }}"><i data-feather="bar-chart"></i><span>Trade Now</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>