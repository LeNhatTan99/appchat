<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">  
      <span class="font-weight-bold">Users</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <i class="fas fa-user text-white"></i>
        </div>
          <li class="nav-item dropdown">
          @if (Auth::check())
          <a class="font-weight-bold pr-3">
            {{ Auth::user()->user_name }}
        </a>
            <a href="{{ route('user.logout') }}"
               onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                {{__('auth.logout')}}
            </a>
            <form id="logout-form" action="{{ route('user.logout') }}" method="POST" class="d-none">
                @csrf
            </form>
          @endif
            
        </li>
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

          <li class="nav-item">
            <a href="{{route('categories.index')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                {{__('product.categories')}}
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('products.index')}}" class="nav-link">
              <i class="nav-icon fa-brands fa-product-hunt"></i>
              <p>
                {{__('product.products')}}
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('orders.index')}}" class="nav-link">
              <i class="nav-icon fa-regular fa-clipboard"></i>
              <p>
                {{__('order.orders')}}
              </p>
            </a>
          </li>
               
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>