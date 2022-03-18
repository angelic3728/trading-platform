<header class="main-nav">
    <div class="sidebar-user px-2 pt-0 pb-2">
        <ul class="nav nav-tabs nav-primary nav-justified justify-content-evenly" id="myTab" role="tablist">
            <li class="nav-item"><a class="nav-link active" id="manager-tab" data-bs-toggle="tab" href="#manager" role="tab" aria-controls="manager" aria-selected="true" style="border-color: #e9ecef #e9ecef #dee2e6; margin-right:10px;">Manager</a></li>
            <li class="nav-item"><a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false" style="border-color: #e9ecef #e9ecef #dee2e6; margin-left:10px;">Profile</a></li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="manager" role="tabpanel" aria-labelledby="home-tab">
                <div class="text-center item py-4">
                    @if(File::exists('storage/'.$account_manager->avatar))
                    <img src="/{{ 'storage/'.$account_manager->avatar }}" class="img-90 rounded-circle" style="display: initial;" />
                    @else
                    <img src="{{asset('assets/images/avtar/default.png')}}" class="img-90 rounded-circle" style="display: initial;" />
                    @endif
                    <h6 class="mt-3 f-16 f-w-800" style="color:#24695c">Account Manager</h6>
                    <h6 class="mt-1 f-16 f-w-800">{{ $account_manager->first_name." ".$account_manager->last_name }}</h6>
                    <h6 class="mt-3 f-14 f-w-600" style="color:#24695c">{{ $account_manager->email }}</h6>
                    <h6 class="mt-1 f-14 f-w-600" style="color:#24695c">{{ $account_manager->phone }}</h6>
                    <h6 class="mt-1 f-14 f-w-600 text-secondary">{{ array_get($account_manager->extra, 'availability', 'Unknown') }}</h6>
                </div>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="text-center item py-4">
                    <a class="setting-primary" href="{{ route('settings') }}" style="top: 50px;"><i data-feather="settings"></i></a>
                    @if(File::exists('storage/'.auth()->user()->avatar))
                    <img src="/{{ 'storage/'.auth()->user()->avatar }}" class="img-90 rounded-circle" style="display: initial;" />
                    @else
                    <img src="{{asset('assets/images/avtar/default.png')}}" class="img-90 rounded-circle" style="display: initial;" />
                    @endif
                    <h6 class="mt-3 f-16 f-w-800">{{ auth()->user()->first_name." ".auth()->user()->last_name }}</h6>
                    <h6 class="mt-3 f-14 f-w-600" style="color:#24695c">{{ auth()->user()->email }}</h6>
                    <h6 class="mt-1 f-14 f-w-600" style="color:#24695c">{{ auth()->user()->phone }}</h6>
                </div>
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
                        <a class="nav-link menu-title link-nav {{ request()->route()->named('mfds.search') ? 'active' : '' }}" href="{{ route('mfds.search') }}"><i data-feather="bar-chart"></i><span>All Funds</span></a>
                    </li>
                    <li class="dropdown">
                        <a class="nav-link menu-title link-nav {{ request()->route()->named('cryptos.search') ? 'active' : '' }}" href="{{ route('cryptos.search') }}"><i data-feather="bar-chart"></i><span>All Cryptocurrencies</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>