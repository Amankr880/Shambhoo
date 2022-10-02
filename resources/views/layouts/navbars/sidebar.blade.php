<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand pt-0" href="{{ route('home') }}">
            <img src="../assets/img/brand/blue.png" class="navbar-brand-img" alt="...">
        </a>
        <!-- User -->
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('home') }}">
                            <img src="../assets/img/brand/blue.png" class="navbar-brand-img" alt="...">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Form -->
            <form class="mt-4 mb-3 d-md-none">
                <div class="input-group input-group-rounded input-group-merge">
                    <input type="search" class="form-control form-control-rounded form-control-prepended" placeholder="{{ __('Search') }}" aria-label="Search">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fa fa-search"></span>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Navigation -->
            <ul class="navbar-nav">
            <!-- <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}">
                    {{ __('Dashboard') }}
                </a>
            </li> -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('allcategories') }}">
                    <span class="nav-link-text">Categories</span>
                </a>

                <!-- <div class="collapse" id="navbar-examples">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('allcategories') }}">
                                Parent Categories
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.index') }}">
                                Child Categories
                            </a>
                        </li>
                    </ul>
                </div> -->
            </li>

            <!-- <li class="nav-item">
                <a class="nav-link" href="{{ route('icons') }}">
                    {{ __('Icons') }}
                </a>
            </li> -->
            <li class="nav-item ">
                <a class="nav-link" href="{{ route('allvendors') }}">
                    Vendors
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('table') }}">
                  <span class="nav-link-text">Shops</span>
                </a>
              </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('allusers') }}">
                  <span class="nav-link-text">Customers</span>
                </a>
              </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('orders') }}">
                  <span class="nav-link-text">Orders</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('featuredads') }}">
                  <span class="nav-link-text">Featured Ads</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('featuredstores') }}">
                  <span class="nav-link-text">Featured Stores</span>
                </a>
              </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="ni ni-ui-04"></i> Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
        </ul>
            <!-- Navigation --><!-- 
            <ul class="navbar-nav mb-md-3">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('profile.edit') }}">
                        <i class="ni ni-spaceship"></i>My Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://argon-dashboard-laravel.creative-tim.com/docs/foundation/colors.html">
                        <i class="ni ni-palette"></i>Settings
                    </a>
                </li>
            </ul> -->
        </div>
    </div>
</nav>
