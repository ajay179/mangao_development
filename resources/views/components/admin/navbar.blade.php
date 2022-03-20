<header class="main-header">
  <!-- Logo -->
  <a href="admin/dashboard" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini">
      <img src="{{asset('commonarea/dist/img/logo.png')}}" alt="logo">
    </span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg" style="font-size: 18px;">
      <img src="{{asset('commonarea/dist/img/logo.png')}}" alt="logo">
    </span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <!-- <//?php $profile = (!empty($this->session->userdata('profile_path')) ? base_url($this->session->userdata('profile_path')) : base_url('assets/commonarea/dist/img/user2-160x160.jpg')); ?> -->
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="{{asset('commonarea/dist/img/avatar5.png')}}" class="user-image" alt="User Image">
            <span class="hidden-xs">Admin</span>
          </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
              <img src="{{asset('commonarea/dist/img/avatar5.png')}}" class="img-circle" alt="User Image">

              <p>
                Admin
                <small>Member since </small>
              </p>
            </li>
            <!-- Menu Body -->

            <!-- Menu Footer-->
            <li class="user-footer">
              <!-- <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div> -->
              <div class="pull-right">
                
                 @if ((!empty(Auth::guard('admin')->user())) &&  (Auth::guard('admin')->user()->can('isSuperAdmin')))
                   <a href="{{url('admin-logout')}}" onclick="return confirm('Are you sure you want to logout super admin?')" class="btn btn-default btn-flat"> logout</a>
                @endif

                @if ((!empty(Auth::guard('city_admin')->user())) && (Auth::guard('city_admin')->user()->can('isCityAdmin')))
                    <a href="{{url('city-admin-logout')}}" onclick="return confirm('Are you sure you want to logout city amidn?')" class="btn btn-default btn-flat"> logout</a>
                @endif
                
                @if ((!empty(Auth::guard('vendor')->user())) && (Auth::guard('vendor')->user()->can('isVendorAdmin')))
                    <a href="{{url('vendor-admin-logout')}}" onclick="return confirm('Are you sure you want to logout vendor?')" class="btn btn-default btn-flat"> logout</a>
                @endif
                

              </div>
            </li>
          </ul>
        </li>

      </ul>
    </div>
  </nav>
</header>