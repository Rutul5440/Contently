<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Contently</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">>
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - User -->
    <li class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('users.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>User</span></a>
    </li>

    <hr class="sidebar-divider">
    <!-- Categories -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('categories.index') }}">
            <i class="fas fa-folder-open"></i>
            <span>Categories</span>
        </a>
    </li>
    
    <hr class="sidebar-divider">
    
    <li class="nav-item dropdown {{ request()->is('settings/*') ? 'active' : '' }}">
        <a class="nav-link dropdown-toggle" href="#" id="settingsDropdown" role="button"
            data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-fw fa-cogs"></i>
            <span>Settings</span>
        </a>
        <ul class="dropdown-menu" aria-labelledby="settingsDropdown">
            <li><a class="dropdown-item" href="{{ route('settings.roles.index') }}">Roles & Permissions</a></li>
        </ul>
    </li>



</ul>