<div class="main-sidebar">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="index.html">Stisla</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
          </div>
          <ul class="sidebar-menu">
              <li class="menu-header">Menu</li>
              {{--<li class="nav-item">
                <a href="{{route('admin.dashboard')}}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
              </li>
              <li class="nav-item">
                <a href="{{route('barang.index')}}" class="nav-link"><i class="fas fa-box"></i><span>Data Barang</span></a>
              </li> --}}
              <li class="nav-item  @if(Route::currentRouteName() == 'dashboard-admin') active @endif">
                <a href="{{route('dashboard-admin')}}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
              </li>
              <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-boxes"></i><span>Barang</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="{{route('jenis-barang.index')}}">Jenis Barang</a></li>
                  <li class=""><a class="nav-link" href="{{route('barang.index')}}">Daftar Barang</a></li>
                </ul>
              </li>
            </ul>           
        </aside>
      </div>