<header class="main-nav">
    <div class="sidebar-user">
        <div class="owl-carousel owl-theme" id="owl-carousel-14">
            <div class="text-center item">
                <a class="setting-primary" href="{{ route('settings') }}" style="top: 0px; right:5px;"><i data-feather="settings"></i></a>
                @if(File::exists('storage/'.auth()->user()->avatar))
                <img src="/{{ 'storage/'.auth()->user()->avatar }}" class="img-90 rounded-circle" style="display: initial;" />
                @else
                <img src="{{asset('assets/images/avtar/default.png')}}" class="img-90 rounded-circle" style="display: initial;" />
                @endif
                <a href="{{ route('settings') }}">
                    <h6 class="mt-3 f-16 f-w-800">{{ auth()->user()->first_name." ".auth()->user()->last_name }}</h6>
                </a>
                <h6 class="mt-3 f-14 f-w-600 text-primary">{{ auth()->user()->email }}</h6>
                <h6 class="mt-3 f-14 f-w-600 text-primary">{{ auth()->user()->phone }}</h6>
                <h6 class="mt-3 f-14 f-w-600 text-danger"><span class="font-w-800">Balance: </span>{{ auth()->user()->getBalance() }}</h6>
            </div>
            <div class="text-center item">
                @if(File::exists('storage/'.$account_manager->avatar))
                <img src="/{{ 'storage/'.$account_manager->avatar }}" class="img-90 rounded-circle" style="display: initial;" />
                @else
                <img src="{{asset('assets/images/avtar/default.png')}}" class="img-90 rounded-circle" style="display: initial;" />
                @endif
                <h6 class="mt-3 f-16 f-w-800">{{ $account_manager->first_name." ".$account_manager->last_name }}<span class="text-danger font-w-300">(Manager)</span></h6>
                <h6 class="mt-3 f-14 f-w-600 text-primary">{{ $account_manager->email }}</h6>
                <h6 class="mt-3 f-14 f-w-600 text-primary">{{ $account_manager->phone }}</h6>
                <h6 class="f-14 f-w-600 text-secondary mt-0 pt-3" style="text-overflow: ellipsis; overflow: hidden; white-space: nowrap;" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ array_get($account_manager->extra, 'availability', 'Unknown') }}">{{ array_get($account_manager->extra, 'availability', 'Unknown') }}</h6>
            </div>
        </div>
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
                        <a class="nav-link menu-title link-nav {{ request()->route()->named('xtbs') ? 'active' : '' }}" href="{{ route('xtbs') }}"><i data-feather="aperture"></i><span>XTB's</span></a>
                    </li>
                    <li class="dropdown">
                        <a class="nav-link menu-title link-nav {{ request()->route()->named('transactions') ? 'active' : '' }}" href="{{ route('transactions') }}"><i data-feather="zap"></i><span>Transactions</span></a>
                    </li>
                    <li class="dropdown">
                        <a class="nav-link menu-title link-nav {{ request()->route()->named('documents.index') ? 'active' : '' }}" href="{{ route('documents.index') }}"><i data-feather="file-text"></i><span>Documents</span></a>
                    </li>
                    <li class="dropdown">
                        <a class="nav-link menu-title link-nav {{ request()->route()->named('stocks.search') ? 'active' : '' }}" href="{{ route('stocks.search') }}"><i data-feather="bar-chart"></i><span>All Stocks</span></a>
                    </li>
                    <li class="dropdown">
                        <a class="nav-link menu-title link-nav {{ request()->route()->named('mfds.search') ? 'active' : '' }}" href="{{ route('mfds.search') }}"><i data-feather="bar-chart"></i><span>All Mutual Funds</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>