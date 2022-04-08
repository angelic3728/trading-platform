<header class="main-nav">
    <nav>
        <div class="main-navbar">
            <div id="mainnav">
                <ul class="nav-menu custom-scrollbar">
                    <li class="back-btn">
                        <div class="mobile-back text-end link-nav"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                    </li>
                    <li class="dropdown m-t-50">
                        <a class="nav-link menu-title link-nav {{ request()->route()->named('overview') ? 'active' : '' }}" href="{{ route('overview') }}"><i data-feather="home"></i><span>Home</span></a>
                    </li>
                    <li class="dropdown">
                        <a class="nav-link menu-title link-nav {{ request()->route()->named('forms.main') ? 'active' : '' }}" href="{{ route('forms.main') }}"><i data-feather="aperture"></i><span>Forms</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

