@section('container')
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
                <div class="sidebar-brand-icon">
                    <img src="{{ asset('img/iminlogo.png') }}" alt="iminlogo" style="max-width:100%">
                </div>
                <div class="sidebar-brand-text mx-3">
                    <sup>Tech</sup>
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="/">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Stock Barang
            </div>

            <!-- Nav Item - Pinjam -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-target="#collapseOne"
                    aria-expanded="true" aria-controls="collapseOne">
                    <i class="fas fa-fw fa-box"></i>
                    <span>Stock</span>
                </a>
                <div id="collapseOne" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">List Stock:</h6>
                        <a class="collapse-item {{ Request::is('stock') ? 'active' : '' }}" href="/stock">Monitor</a>
                        <a class="collapse-item {{ Request::is('stock/gudang*') ? 'active' : '' }}"
                            href="/stock/gudang">Gudang</a>
                        <a class="collapse-item {{ Request::is('stock/service*') ? 'active' : '' }}"
                            href="/stock/service">Service</a>
                        <a class="collapse-item {{ Request::is('stock/dipinjam*') ? 'active' : '' }}"
                            href="/stock/dipinjam">Dipinjam</a>
                        <a class="collapse-item {{ Request::is('stock/terjual*') ? 'active' : '' }}"
                            href="/stock/terjual">Terjual</a>
                    </div>
                </div>

            </li>

            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Peminjaman Barang
            </div>

            <!-- Nav Item - Pinjam -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-tag"></i>
                    <span>Pinjam</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">List Pinjam:</h6>
                        <a class="collapse-item {{ Request::is('pinjam*') ? 'active' : '' }}" href="/pinjam">DiPinjam</a>
                        <a class="collapse-item {{ Request::is('kembali*') ? 'active' : '' }}"
                            href="/kembali">DiKembalikan</a>
                    </div>
                </div>
            </li>


            {{-- <div class="sidebar-heading">
                Service Barang
            </div>
            <!-- Nav Item - Services -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Services</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">List Services</h6>
                        <a class="collapse-item {{ Request::is('monitor*') ? 'active' : '' }}" href="/monitor">Monitor</a>
                        <a class="collapse-item {{ Request::is('servicedone*') ? 'active' : '' }}"
                            href="/servicedone">Service Done</a>
                        <a class="collapse-item {{ Request::is('servicepending*') ? 'active' : '' }}"
                            href="/servicepending">Service Pending</a>
                        <a class="collapse-item {{ Request::is('kanibal*') ? 'active' : '' }}" href="/kanibal">Kanibal</a>
                    </div>
                </div>
            </li> --}}

            <div class="sidebar-heading">
                Service
            </div>
            <!-- Nav Item - Services -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Services</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">List Services</h6>
                        <a class="collapse-item {{ Request::is('monitor*') ? 'active' : '' }}" href="/monitor">Tambah
                            Baru</a>
                        <a class="collapse-item {{ Request::is('servicedone*') ? 'active' : '' }}"
                            href="/servicedone">Service Done</a>
                        <a class="collapse-item {{ Request::is('servicepending*') ? 'active' : '' }}"
                            href="/servicepending">Service Pending</a>
                    </div>
                </div>
            </li>

            <div class="sidebar-heading">
                Service Spare Parts
            </div>
            <!-- Nav Item - SpareParts -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-target="#collapseone"
                    aria-expanded="true" aria-controls="collapseone">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>SpareParts</span>
                </a>
                <div id="collapseone" class="collapse" aria-labelledby="headingone" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">List SpareParts</h6>
                        <a class="collapse-item {{ Request::is('spareparts*') ? 'active' : '' }}"
                            href="/spareparts">Stock</a>
                        <a class="collapse-item {{ Request::is('history*') ? 'active' : '' }}" href="/history">History</a>
                    </div>
                </div>
            </li>

            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                Firmware
            </div>
            <!-- Nav Item - Firmware -->
            <li class="nav-item">
                <a class="nav-link {{ Request::is('firmware*') ? 'active' : '' }}" href="/firmware">
                    <i class="fas fa-fw fa-microchip"></i>
                    <span>Firmware</span></a>
            </li>

            <hr class="sidebar-divider">

            @auth
                @if (auth()->user()->hasRole('superadmin'))
                    <div class="sidebar-heading">
                        Users Settings
                    </div>
                    <!-- Nav Item - User -->
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('user*') ? 'active' : '' }}" href="/user">
                            <i class="fas fa-fw fa-user"></i>
                            <span>User Settings</span>
                        </a>
                    </li>
                @endif
            @endauth

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div>

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <div class="ml-2">
                        <a href="https://oss-sg.imin.sg/docs/en/index.html" class="btn btn-outline-secondary"
                            target="blank">SDK</a>
                    </div>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>
                    </ul>

                    <ul class="navbar-nav ms-auto">

                        <!-- Authentication Links -->
                        @guest

                            @if (Route::has('login'))
                                <li class="nav-item mr-4 overflow-hidden font-weight-bold">
                                    <a class="nav-link text-dark" href="{{ route('login') }}">Login</a>
                                </li>
                            @endif

                            {{-- @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif --}}
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                        <a class="dropdown-item" href="{{ route('logout') }}" data-bs-toggle="modal"
                                            data-target="#logoutModal">
                                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                            {{ __('Logout') }}
                                        </a>
                                </div>
                                </form>

                </div>
                </li>

            @endguest
            </ul>

            </nav>

            <div>
                @yield('content')
            </div>

        </div>
    @endsection
