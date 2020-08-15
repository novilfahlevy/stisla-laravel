@php $currentRoute = url(join('/', request()->segments())); @endphp
<div class="main-sidebar">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="{{ route('dashboard') }}">Stisla</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="{{ route('dashboard') }}">St</a>
    </div>
    <ul class="sidebar-menu">
      <li class="nav-item {{ route('dashboard') == $currentRoute ? 'active' : null }}">
        <a href="{{ route('dashboard') }}" class="nav-link"><i class="fas fa-fire"></i><span>Dasbor</span></a>
      </li>
      @can('Melihat daftar pengguna')
      <li class="nav-item {{ route('user.index') == $currentRoute ? 'active' : null }}">
        <a href="{{ route('user.index') }}" class="nav-link"><i class="fas fa-users"></i><span>Pengguna</span></a>
      </li>
      @endcan
      @can('Melihat daftar role')
      <li class="nav-item {{ route('role.index') == $currentRoute ? 'active' : null }}">
        <a href="{{ route('role.index') }}" class="nav-link"><i class="fas fa-user-tie"></i><span>Role</span></a>
      </li>
      @endcan
      @can('Melihat daftar Hak Akses')
      <li class="nav-item {{ route('permissions') == $currentRoute ? 'active' : null }}">
        <a href="{{ route('permissions') }}" class="nav-link"><i class="fas fa-user-tag"></i><span>Hak Akses</span></a>
      </li>
      @endcan
    </ul>
  </aside>
</div>