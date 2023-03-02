========== Left Sidebar Start ========== -->
<div class="leftside-menu">
    <!-- LOGO -->
    <a href="{{route('home')}}" class="logo text-center logo-light">
        <span class="logo-lg">
            <img src="{{asset('theme/images/logo-dark.png')}}" alt="" height="30">
        </span>
    </a>

    <!-- LOGO -->
    <a href="{{route('home')}}" class="logo text-center logo-dark">
        <span class="logo-lg">
            <img src="#" alt="" height="30">
        </span>
    </a>

    <div class="h-100" id="leftside-menu-container" data-simplebar>
        <!--- Sidemenu -->
        <ul class="side-nav">
            <li class="side-nav-title side-nav-item">Navigation</li>
           
            <li class="side-nav-item">
                <a href="{{route('home')}}" class="side-nav-link">
                    <i class="uil-home-alt"></i>
                    <span> Dashboard </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="{{route('location')}}" class="side-nav-link">
                    <i class="uil-location-point"></i>
                    <span>Location</span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="{{ route('logout') }}"onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="side-nav-link">
                    <i class="mdi mdi-logout me-1"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>

        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End