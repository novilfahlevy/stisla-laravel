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
      <li class="menu-header">Dashboard</li>
      <li class="nav-item {{ route('dashboard') == $currentRoute ? 'active' : null }}">
        <a href="{{ route('dashboard') }}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
      </li>
      <li class="menu-header">Users</li>
      <li class="nav-item {{ route('user.index') == $currentRoute ? 'active' : null }}">
        <a href="{{ route('user.index') }}" class="nav-link"><i class="fas fa-users"></i><span>Users</span></a>
      </li>
      <li class="menu-header">Authentication</li>
      <li class="nav-item {{ route('role.index') == $currentRoute ? 'active' : null }}">
        <a href="{{ route('role.index') }}" class="nav-link"><i class="fas fa-user-tie"></i><span>Roles</span></a>
      </li>
      <li class="nav-item">
        <a href="#" class="nav-link"><i class="fas fa-user-tag"></i><span>Permissions</span></a>
      </li>
    </ul>
  </aside>
</div>