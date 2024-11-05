<!DOCTYPE html>
<html lang="en" class="layout">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Marketing</title>
    <meta name="description" content="Perusahaan distributor dan bahan kimia">
    <meta name="keywords" content="chemical, pome, mechanical">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/app.css') }}">
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/dselect.css') }}">
    <link rel="canonical" href="https://sismark.mitoenergiindonesia.com">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.datatables.net/v/bs5/dt-2.0.8/r-3.0.2/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @vite(['resources/js/app.js'])
    @stack('style')
</head>
<body>
    
    <div class="page_wrapper">
        <aside class="left_sidebar d-none d-xl-flex d-xxl-flex" id="left_sidebar">
            <div class="brand_logo">
                <a href="{{ route('home') }}" class="nav-link">
                    <img class="logo" src="{{ asset('img/logo.png') }}" alt="Logo Company">
                    <span>sismark</span>
                </a>
            </div>
            <!-- Navbar sidebar main -->
            <ul class="sidebar_nav">
                <li class="sidebar_item">
                    <a class="nav__link" href="{{ route('home') }}">
                        <i class='bx bxs-dashboard icon_nav'></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar_item">
                    <a class="nav__link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#dataMaster" aria-expanded="false" aria-controls="dataMaster">
                        <i class='bx bxs-data icon_nav'></i>
                        <span>Data Master</span>
                    </a>
                    <ul class="sidebar_dropdown collapse" id="dataMaster" data-bs-parent="#left_sidebar">
                        <li class="sidebar_item">
                            <a class="nav_link" href="{{ route('product.index') }}">Produk</a>
                        </li>
                        <li class="sidebar_item">
                            <a class="nav_link" href="{{ route('branches.index') }}">Branches</a>
                        </li>
                        <li class="sidebar_item">
                            <a class="nav_link" href="{{ route('customer.index') }}">Customer</a>
                        </li>
                    </ul>
                </li>

                {{-- <li class="sidebar_item">
                    <a class="nav__link actived" href="#" data-bs-toggle="collapse" data-bs-target="#analyticsBar" aria-expanded="true" aria-controls="analyticsBar">
                        <i class='bx bxs-color icon_nav'></i>
                        <span>Analytics</span>
                    </a>
                    <ul class="sidebar_dropdown collapse show" id="analyticsBar" data-bs-parent="#left_sidebar">
                        <li class="sidebar_item">
                            <a class="nav_link" href="#">Profitable</a>
                        </li>
                        <li class="sidebar_item">
                            <a class="nav_link actived" href="#">Loss</a>
                        </li>
                    </ul>
                </li> --}}

                <li class="sidebar_item">
                    <a class="nav__link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#worksheet" aria-expanded="false" aria-controls="worksheet">
                        <i class='bx bxs-folder icon_nav'></i>
                        <span>Marketing</span>
                    </a>
                    <ul class="sidebar_dropdown collapse" id="worksheet" data-bs-parent="#left_sidebar">
                        <li class="sidebar_item">
                            <a class="nav_link" href="{{ route('workplan.index') }}">Realisasi Kerja</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar_item">
                    <a class="nav__link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#sales" aria-expanded="false" aria-controls="sales">
                        <i class='bx bxs-dollar-circle icon_nav'></i>
                        <span>Sales</span>
                    </a>
                    <ul class="sidebar_dropdown collapse" id="sales" data-bs-parent="#left_sidebar">
                        <li class="sidebar_item">
                            <a class="nav_link" href="{{ route('sales-order.index') }}">Purchase Order</a>
                        </li>
                    </ul>
                </li>

                {{-- <li class="sidebar_item">
                    <a class="nav__link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#finance" aria-expanded="false" aria-controls="finance">
                        <i class='bx bxs-wallet icon_nav'></i>
                        <span>Finance</span>
                    </a>
                    <ul class="sidebar_dropdown collapse" id="finance" data-bs-parent="#left_sidebar">
                        <li class="sidebar_item">
                            <a class="nav_link" href="{{ route('sales.order.outstanding') }}">Outstanding</a>
                        </li>
                    </ul>
                </li> --}}

                <li class="sidebar_item">
                    <a class="nav__link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#reports" aria-expanded="false" aria-controls="reports">
                        <i class='bx bx-folder icon_nav'></i>
                        <span>Reports</span>
                    </a>
                    <ul class="sidebar_dropdown collapse" id="reports" data-bs-parent="#left_sidebar">
                        <li class="sidebar_item">
                            <a class="nav_link" href="{{ route('report.sales') }}">Sales</a>
                        </li>
                        <li class="sidebar_item">
                            <a class="nav_link" href="{{ route('report.progress') }}">Rekap Progress</a>
                        </li>
                        <li class="sidebar_item">
                            <a class="nav_link" href="{{ route('report.purchase.order') }}">Purchase Order</a>
                        </li>
                        <li class="sidebar_item">
                            <a class="nav_link" href="#">Realisasi Kerja</a>
                        </li>
                        
                    </ul>
                </li>

                <li class="sidebar_item">
                    <a class="nav__link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#downloads" aria-expanded="false" aria-controls="downloads">
                        <i class='bx bxs-cloud-download icon_nav'></i>
                        <span>Downloads</span>
                    </a>
                    <ul class="sidebar_dropdown collapse" id="downloads" data-bs-parent="#left_sidebar">
                        <li class="sidebar_item">
                            <a class="nav_link" href="{{ route('print.recap.progress') }}">Recap Progress</a>
                        </li>
                        <li class="sidebar_item">
                            <a class="nav_link" href="{{ route('download.purchase.order') }}">Purchase Orders</a>
                        </li>
                        {{-- <li class="sidebar_item">
                            <a class="nav_link" href="#">Customers</a>
                        </li> --}}
                    </ul>
                </li>

                <li class="sidebar_item">
                    <a class="nav__link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                        <i class='bx bx-shield-quarter icon_nav'></i>
                        <span>Auth</span>
                    </a>
                    <ul class="sidebar_dropdown collapse" id="auth" data-bs-parent="#left_sidebar">
                        <li class="sidebar_item">
                            <a class="nav_link" href="{{ route('user.index') }}">User</a>
                        </li>
                        <li class="sidebar_item">
                            <a class="nav_link" href="#">Register</a>
                        </li>
                        <li class="sidebar_item">
                            <a class="nav_link" href="#">Role & Permission</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar_item">
                    <a class="nav__link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#configuration" aria-expanded="false" aria-controls="configuration">
                        <i class='bx bxs-wrench icon_nav'></i>
                        <span>Configuration</span>
                    </a>
                    <ul class="sidebar_dropdown collapse" id="configuration" data-bs-parent="#left_sidebar">
                        <li class="sidebar_item">
                            <a class="nav_link" href="{{ route('approval.index') }}">Approval</a>
                        </li>
                        <li class="sidebar_item">
                            <a class="nav_link" href="{{ route('tax.index') }}">Tax</a>
                        </li>
                        <li class="sidebar_item">
                            <a class="nav_link" href="{{ route('category-customer.index') }}">Segmen</a>
                        </li>
                        <li class="sidebar_item">
                            <a class="nav_link" href="{{ route('market-progress.index') }}">Market Progress</a>
                        </li>
                        <li class="sidebar_item">
                            <a class="nav_link" href="{{ route('type-customer.index') }}">Type Customer</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar_item">
                    <a class="nav__link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#trash" aria-expanded="false" aria-controls="trash">
                        <i class='bx bxs-trash  icon_nav'></i>
                        <span>Trash</span>
                    </a>
                    <ul class="sidebar_dropdown collapse" id="trash" data-bs-parent="#left_sidebar">
                        <li class="sidebar_item">
                            <a class="nav_link" href="{{ route('trash.branch') }}">Branches</a>
                        </li>
                    </ul>
                </li>

            </ul>
            <!-- Navbar sidebar footer -->
            <ul class="sidebar_footer px-3">
                <li class="sidebar_item">
                    <a class="nav__link" href="#">
                        <i class='bx bxs-cog icon_nav'></i>
                        <span>Pengaturan</span>
                    </a>
                </li>
                <li class="sidebar_item">
                    <form action="{{ route('logout') }}" method="POST" id="logout-sidebar">
                        @csrf
                        @method('POST')
                        <button class="btn nav__link w-100" type="button" onclick="logOut('logout-sidebar')">
                            <i class='bx bx-log-out-circle icon_nav'></i>
                            <span>Log out</span>
                        </button>
                    </form>
                </li>
            </ul>   
        </aside>


        <div class="wrapper__main_content">
            <header class="wrapper__header px-3 px-xl-4 px-xxl-4">
                <!-- Button toggle sidebar for small screen -->
                <button class="btn btn__toggle_sidebar d-xl-none">
                    <i class='bx bx-menu'></i>
                </button>
                <!-- Header navbar -->
                <div class="wrap__navbar_header">
                    <div class="title__navbar_header">
                        Sistem Marketing
                    </div>
                    <!-- Navbar dropdown -->
                    <div class="wrap__navbar_right ms-auto">
                        <div class="wrap__dropdown">
                            <!-- Toggle dropdown -->
                            <button class="btn btn__dropdown" id="btn__dropdown_toggle">
                                <img class="rounded-circle" src="{{ asset('img/avatar.jpg') }}" alt="Avatar Image">
                            </button>
                            <!-- Content dropdown -->
                            <div class="wrap__dropdown_menu" id="content_dropdown_menu">
                                <div class="wrap__user_profile">
                                    <img class="rounded-circle" src="{{ asset('img/avatar.jpg') }}" alt="User Profile">
                                    <div class="user">
                                        <div class="name">{{ Auth::user()->name }}</div>
                                        <div class="title">Welcome back</div>
                                    </div>
                                </div>

                                <hr class="dropdown__divider">

                                <ul class="wrap__dropdown_items">
                                    <li>
                                        <a class="dropdown__item" href="#">
                                            <i class='bx bxs-cog icon_dropdown'></i>
                                            <span>Pengaturan</span>
                                        </a>
                                    </li>
                                    {{-- <li>
                                        <a class="dropdown__item" href="#">
                                            <i class='bx bxs-help-circle icon_dropdown'></i>
                                            <span>Bantuan</span>
                                        </a>
                                    </li> --}}
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST" id="logout-navbar">
                                            @csrf
                                            @method('POST')
                                            <button class="btn dropdown__item" type="button" onclick="logOut('logout-navbar')">
                                                <i class='bx bxs-log-in-circle bx-rotate-180 icon_dropdown'></i>
                                                <span>Log Out</span>
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                              </div>
                        </div>
                    </div>

                </div>
            </header>

            <div class="layout__content pb-5">
                @yield('content')
            </div>
        </div>

        <div class="layout__overlay"></div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-2.0.8/r-3.0.2/datatables.min.js"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="{{ Vite::asset('resources/js/confirm.js') }}"></script>
    <script src="{{ Vite::asset('resources/js/dselect.js') }}"></script>
    @stack('scripts')
</body>
</html>