<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <img src="{{ url(\Settings::get('application_logo')) }}" alt="image" class="rounded-circle" height="60px" width="60px" style="border-radius:20%!important">

                    <ul class="dropdown-menu animated fadeInLeft m-t-xs">
                        <li><a class="dropdown-item" href="{{ route('admin.profile') }}">Profile</a></li>
                        <li class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('admin.logout') }}">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    <img alt="image" class="rounded-circle" height="60px" width="60px" style="border-radius:20%!important" src="{{ url(\Settings::get('application_logo')) }}">

                </div>
            </li>
            <li class="@if(Request::segment('2') == 'dashboard') active @endif">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fa fa-home"></i>
                    <span class="nav-label">
                        Dashboard
                    </span>
                </a>
            </li>
           
            <li class="@if(Request::segment('2') == 'screenlock') active @endif" data-toggle="tooltip" title="Settings">
                <a href="{{ route('admin.screenlock') }}">
                    <i class="fa fa-cog"></i>
                    <span class="nav-label">ScreenLock </span>
                </a>
            </li>

           <li class="@if(Request::segment('2') == 'settings') active @endif" data-toggle="tooltip" title="Settings">
                <a href="{{ url('admin/settings') }}">
                    <i class="fa fa-cog"></i>
                    <span class="nav-label">Setting </span>
                </a>
            </li>
            
        </ul>
    </div>
</nav>