<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="{{ asset("admin/dist/img/AdminLTELogo.png") }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">বন্ধু ব্যাটারি
    </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset("admin/dist/img/user2-160x160.jpg") }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ auth()->user()->name }}</a>
        </div>
      </div>



      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                ড্যাশবোর্ড
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.categories.index') }}" class="nav-link">
              <i class="nav-icon fas fa-sitemap"></i>

              <p>
                ক্যাটাগরি
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.brands.index') }}" class="nav-link">
              <i class="nav-icon fab fa-bandcamp"></i>
              <p>
                ব্র্যান্ড
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('admin.units.index') }}" class="nav-link">
              <i class="nav-icon fas fa-ring"></i>
              <p>
                পরিমাপ
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.customers.index') }}" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                গ্রাহক
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.vendors.index') }}" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                বিক্রেতা
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.products.index') }}" class="nav-link">
              <i class="nav-icon fas fa-car-battery"></i>
              <p>
                পণ্য
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.orders.index') }}" class="nav-link">
              <i class="nav-icon fab fa-first-order"></i>
              <p>
                অর্ডার
              </p>
            </a>
          </li>

          @if (in_array("simple-link",$permissions))
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                সাধারণ লিংক
                <span class="right badge badge-danger">নতুন</span>
              </p>
            </a>
          </li>
          @endif

          <li class="nav-item">
            <a href="{{ url('log-viewer') }}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                লগ ভিউ
                <span class="right badge badge-danger">নতুন</span>
              </p>
            </a>
          </li>
          @if (0)
          <li class="nav-item menu--open">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-solid fa-user-lock"></i>
              <p>
                সিকিউরিটি
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.roles.index') }}" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>ভূমিকা</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.permissions.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>অনুমতি</p>
                </a>
              </li>
            </ul>
          </li>
          @endif
          @if (0)
          <li class="nav-item menu--open">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-users"></i>
              <p>
                অ্যাডমিন
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.admins.index') }}" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>অ্যাডমিন</p>
                </a>
              </li>
            </ul>
          </li>
          @endif
          <li class="nav-item">
            <form action="{{ route("admin.logout") }}" method="POST">
                @csrf
                <button class="nav-link btn btn-sm btn-success text-light">লগআউট</button>
            </form>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
