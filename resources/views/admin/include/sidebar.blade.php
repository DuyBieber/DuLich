<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('admin_dashboard')}}" class="brand-link">
      <img src="{{asset('backend/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Admin_DuyTRAVEL</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('backend/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="{{ route('profile_admin') }}" class="d-block">{{ Session::get('admin_name') }}</a>
          
        </div>
        <div><li><a href="{{URL::to('/login_admin')}}"><i class="fa fa-key"></i> Log Out</a></li></div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="{{route('home')}}" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
              <li class="nav-item">
                <a href="{{route('admin_dashboard')}}" class="nav-link active">
                  <p>Thống kê</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item {{ Request::segment(1) == 'customers' ? 'menu-open' : '' }}">
          <a href="#" class="nav-link active {{ Request::segment(1) == 'customers' ? 'active' : '' }}">
              <i class="fa-solid fa-users"></i>
              <p>
                  Quản lý khách hàng
                  <i class="right fas fa-angle-left"></i>
              </p>
          </a>
          <ul class="nav nav-treeview">
              <li class="nav-item">
                  <a href="{{ route('customers.index') }}" class="nav-link active {{ Request::is('customers') ? 'active' : '' }}">
                      <i class="fa-solid fa-list"></i>
                      <p>Danh sách khách hàng</p>
                  </a>
              </li>
          </ul>
          </li>
          <li class="nav-item {{Request::segment(1)=='categories' ? 'menu-is-opening menu-open' : ' '}}">
            <a href="{{route('categories.index')}}" class="nav-link active">
            <i class="fa-solid fa-layer-group"></i>
              <p>
                Danh mục tour
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
              <li class="nav-item ">
                <a href="{{route('categories.create')}}" class="nav-link active">
                <i class="fa-sharp fa-solid fa-gears"></i>
                  <p>Thêm danh mục tour</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('categories.index')}}" class="nav-link active">
                <i class="fa-solid fa-list"></i>
                  <p>Danh sách danh mục tour</p>
                </a>
              </li>
            </ul>
            
          </li>
          <li class="nav-item {{Request::segment(1)=='tour_types' ? 'menu-is-opening menu-open' : ' '}}">
            <a href="{{route('tour_types.index')}}" class="nav-link active">
            <i class="fa-solid fa-layer-group"></i>
              <p>
                Loại tour
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
              <li class="nav-item ">
                <a href="{{route('tour_types.create')}}" class="nav-link active">
                <i class="fa-sharp fa-solid fa-gears"></i>
                  <p>Thêm danh loại tour</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('tour_types.index')}}" class="nav-link active">
                <i class="fa-solid fa-list"></i>
                  <p>Danh sách loại tour</p>
                </a>
              </li>
            </ul>
            
          </li>
          <li class="nav-item ">
            <a href="{{route('categories.index')}}" class="nav-link active">
            <i class="fa-sharp fa-solid fa-train-subway"></i>
              <p>
                Tours
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
              <li class="nav-item {{Request::segment(1)=='tours' ? 'menu-is-opening menu-open' : ' '}}">
                <a href="{{route('tours.create')}}" class="nav-link active">
                <i class="fa-sharp fa-solid fa-gears"></i>
                  <p>Thêm tour</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('tours.index')}}" class="nav-link active">
                <i class="fa-solid fa-list"></i>
                  <p>Danh sách tour</p>
                </a>
              </li>
            </ul>
          </li>
<li class="nav-item {{ Request::segment(1) == 'itineraries' ? 'menu-open' : '' }}">
                <a href="#" class="nav-link active {{ Request::segment(1) == 'itineraries' ? 'active' : '' }}">
                    <i class="fa-solid fa-route"></i>
                    <p>
                        Quản lý lịch trình
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('itineraries.create') }}" class="nav-link active  {{ Request::is('itineraries/create') ? 'active' : '' }}">
                            <i class="fa-solid fa-plus"></i>
                            <p>Thêm lịch trình</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('itineraries.index') }}" class="nav-link active {{ Request::is('itineraries') ? 'active' : '' }}">
                            <i class="fa-solid fa-list"></i>
                            <p>Danh sách lịch trình</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item {{ Request::segment(1) == 'sliders' ? 'menu-is-opening menu-open' : '' }}">
            <a href="{{ route('sliders.index') }}" class="nav-link active {{ Request::segment(1) == 'sliders' ? 'active' : '' }}">
              <i class="fa-solid fa-images"></i>
              <p>
                Banner
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('sliders.create') }}" class="nav-link active {{ Request::segment(2) == 'create' ? 'active' : '' }}">
                  <i class="fa-solid fa-plus"></i>
                  <p>Thêm banner</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('sliders.index') }}" class="nav-link active {{ Request::segment(2) == 'create' ? 'active' : '' }}">
                  <i class="fa-solid fa-list"></i>
                  <p>Danh sách banner</p>
                </a>
              </li>
            </ul>
            <li class="nav-item {{ Request::segment(1) == 'locations' ? 'menu-is-opening menu-open' : '' }}">
            <a href="{{ route('locations.index') }}" class="nav-link active {{ Request::segment(1) == 'sliders' ? 'active' : '' }}">
            <i class="fa-solid fa-location-dot"></i>
              <p>
                Địa điểm
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('locations.create') }}" class="nav-link active {{ Request::segment(2) == 'create' ? 'active' : '' }}">
                  <i class="fa-location fa-plus"></i>
                  <p>Thêm địa điểm</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('locations.index') }}" class="nav-link active {{ Request::segment(2) == 'create' ? 'active' : '' }}">
                  <i class="fa-solid fa-list"></i>
                  <p>Danh sách Địa điểm</p>
                </a>
              </li>
            </ul>
            <li class="nav-item {{ Request::segment(1) == 'tour_price_details' ? 'menu-open' : '' }}">
    <a href="#" class="nav-link active {{ Request::segment(1) == 'tour_price_details' ? 'active' : '' }}">
        <i class="fa-solid fa-tags"></i>
        <p>
            Quản lý giá chi tiết
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('tour_price_details.create') }}" class="nav-link active {{ Request::is('tour_price_details/create') ? 'active' : '' }}">
                <i class="fa-solid fa-plus"></i>
                <p>Thêm giá chi tiết</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('tour_price_details.index') }}" class="nav-link active {{ Request::is('tour_price_details') ? 'active' : '' }}">
                <i class="fa-solid fa-list"></i>
                <p>Danh sách giá chi tiết</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item {{ Request::segment(1) == 'departure_dates' ? 'menu-open' : '' }}">
    <a href="#" class="nav-link active {{ Request::segment(1) == 'departure_dates' ? 'active' : '' }}">
        <i class="fa-solid fa-calendar-alt"></i>
        <p>
            Quản lý ngày khởi hành
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('departure-dates.create') }}" class="nav-link active {{ Request::is('departure_dates/create') ? 'active' : '' }}">
                <i class="fa-solid fa-plus"></i>
                <p>Thêm ngày khởi hành</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('departure-dates.index') }}" class="nav-link active {{ Request::is('departure_dates') ? 'active' : '' }}">
                <i class="fa-solid fa-list"></i>
                <p>Danh sách ngày khởi hành</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item {{Request::segment(1)=='coupons' ? 'menu-is-opening menu-open' : ' '}}">
    <a href="{{ route('coupons.index') }}" class="nav-link active">
        <i class="fa-solid fa-tag"></i> <!-- Thay đổi icon nếu cần -->
        <p>
            Coupons
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('coupons.create') }}" class="nav-link active">
                <i class="fa-sharp fa-solid fa-plus"></i> <!-- Thay đổi icon nếu cần -->
                <p>Thêm mã giảm giá</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('coupons.index') }}" class="nav-link active">
                <i class="fa-solid fa-list"></i>
                <p>Danh sách mã giảm giá</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item {{Request::segment(1)=='bookings' ? 'menu-is-opening menu-open' : ' '}}">
    <a href="{{ route('bookings.index') }}" class="nav-link active">
        <i class="fa-solid fa-calendar-check"></i> <!-- Thay đổi icon nếu cần -->
        <p>
            Booking
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('bookings.index') }}" class="nav-link active">
                <i class="fa-solid fa-list"></i>
                <p>Danh sách Booking</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item {{Request::segment(1)=='reviews' ? 'menu-is-opening menu-open' : ' '}}">
    <a href="{{ route('reviews.index') }}" class="nav-link active">
        <i class="fa-solid fa-comments"></i> <!-- Thay đổi icon nếu cần -->
        <p>
            Bình luận
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('reviews.index') }}" class="nav-link active">
                <i class="fa-solid fa-list"></i>
                <p>Danh sách Bình luận</p>
            </a>
        </li>
    </ul>
</li>


        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>