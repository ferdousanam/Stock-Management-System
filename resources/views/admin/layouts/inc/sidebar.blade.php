<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/home') }}" class="brand-link">
        <img src="{{ asset('assets/admin/img/logo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=random" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                <li class="nav-item" id="dashboard-mm">
                    <a href="{{ url('/home') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item" id="products-mm">
                    <a href="{{ url('/products') }}" class="nav-link">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>Products</p>
                    </a>
                </li>
                <li class="nav-item" id="purchases-mm">
                    <a href="{{ url('/purchases') }}" class="nav-link">
                        <i class="nav-icon fas fa-star"></i>
                        <p>Purchases</p>
                    </a>
                </li>
                <li class="nav-item" id="sales-mm">
                    <a href="{{ url('/sales') }}" class="nav-link">
                        <i class="nav-icon fas fa-heart"></i>
                        <p>Sales</p>
                    </a>
                </li>
                <li class="nav-item" id="transfers-mm">
                    <a href="{{ url('/transfers') }}" class="nav-link">
                        <i class="nav-icon far fa-star"></i>
                        <p>Transfers</p>
                    </a>
                </li>
                <li class="nav-item" id="returns-mm">
                    <a href="{{ url('/returns') }}" class="nav-link">
                        <i class="nav-icon fas fa-random"></i>
                        <p>Returns</p>
                    </a>
                </li>
                <li class="nav-item" id="stock-management-mm">
                    <a href="{{ url('/stock-management') }}" class="nav-link">
                        <i class="nav-icon fas fa-cubes"></i>
                        <p>Stock Management</p>
                    </a>
                </li>
                <li class="nav-item" id="users-mm">
                    <a href="{{ url('/users') }}" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>People</p>
                    </a>
                </li>
                <li class="nav-item has-treeview" id="settings-mm">
                    <a href="#" class="nav-link tree-opener">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>
                            Settings
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item" id="system_settings-sm">
                            <a href="{{ url('/system_settings') }}" class="nav-link">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>System Settings</p>
                            </a>
                        </li>
                        <li class="nav-item" id="brands-sm">
                            <a href="{{ url('/brands') }}" class="nav-link">
                                <i class="nav-icon fas fa-th-list"></i>
                                <p>Brands</p>
                            </a>
                        </li>
                        <li class="nav-item" id="categories-sm">
                            <a href="{{ url('/categories') }}" class="nav-link">
                                <i class="nav-icon fas fa-th-list"></i>
                                <p>Categories</p>
                            </a>
                        </li>
                        <li class="nav-item" id="warehouses-sm">
                            <a href="{{ url('/warehouses') }}" class="nav-link">
                                <i class="nav-icon far fa-building"></i>
                                <p>Warehouses</p>
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
