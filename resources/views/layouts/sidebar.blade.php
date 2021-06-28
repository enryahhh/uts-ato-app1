<div class="main-sidebar">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="{{route('dashboard-admin')}}">TB LINGJUL</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{route('dashboard-admin')}}">LJ</a>
          </div>
          <ul class="sidebar-menu">
              <li class="menu-header">Menu</li>
              <li class="nav-item  @if(Route::currentRouteName() == 'dashboard-admin') active @endif">
                <a href="{{route('dashboard-admin')}}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
              </li>
              <li class="nav-item">
                <a href="{{route('barang.index')}}" class="nav-link"><i class="fas fa-boxes"></i><span>Data Barang</span></a>
              </li>
              <li class="nav-item  @if(Route::currentRouteName() == 'transaksi-admin') active @endif">
                <a href="{{route('admin.transaksi')}}" class="nav-link"><i class="fas fa-shopping-bag"></i><span>Transaksi</span></a>
              </li>
            </ul>           
        </aside>
      </div>