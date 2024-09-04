<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('backend/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Session::get('admin_name') }}</a>
          
        </div>
        <div><li><a href="{{URL::to('/login')}}"><i class="fa fa-key"></i> Log Out</a></li></div>
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
                <a href="./index3.html" class="nav-link active">
                  <p>Thống kê</p>
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
          <li class="nav-item {{Request::segment(1)=='blogs' ? 'menu-is-opening menu-open' : ' '}}">
            <a href="{{route('blogs.index')}}" class="nav-link active">
            <i class="fa-solid fa-bookmark"></i>

              <p>
                Blogs
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
              <li class="nav-item ">
                <a href="{{route('blogs.create')}}" class="nav-link active">
                <i class="fa-sharp fa-solid fa-gears"></i>
                  <p>Thêm bài logs</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('blogs.index')}}" class="nav-link active">
                <i class="fa-solid fa-list"></i>
                  <p>Danh sách bài blogs</p>
                </a>
              </li>
            </ul>
            
          </li>
          <li class="nav-item {{ Request::segment(1) == 'gallery' ? 'menu-is-opening menu-open' : '' }}">
    <a href="{{ route('gallery.index') }}" class="nav-link active {{ Request::segment(1) == 'gallery' ? 'active' : '' }}">
        <i class="fa-solid fa-images"></i>
        <p>
            Thư viện ảnh
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('gallery.create') }}" class="nav-link active {{ Request::segment(2) == 'create' ? 'active' : '' }}">
                <i class="fa-solid fa-plus"></i>
                <p>Thêm ảnh</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('gallery.index') }}" class="nav-link active {{ Request::segment(2) == 'index' ? 'active' : '' }}">
                <i class="fa-solid fa-list"></i>
                <p>Danh sách thư viện ảnh</p>
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