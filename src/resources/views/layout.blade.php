<!DOCTYPE html>
<html lang="en" class="layout">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $metadata['title'] }}</title>
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
                    <a class="nav__link {{ $metadata['description'] == 'Dashboard' ? 'actived' : '' }}" href="{{ route('home') }}">
                        <i class='bx bxs-dashboard icon_nav'></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                @canany(['read-type-product','read-category-product','read-segment-customer','read-tax', 'read-market-progress'])
                <li class="sidebar_item">
                    <a class="nav__link {{ $metadata['description'] == 'Data Management' ? 'actived' : 'collapsed' }}" href="#" data-bs-toggle="collapse" data-bs-target="#dateManagement" aria-expanded="false" aria-controls="dateManagement">
                        <i class='bx bxs-data icon_nav'></i>
                        <span>Data Management</span>
                    </a>
                    <ul class="sidebar_dropdown collapse {{ $metadata['description'] == 'Data Management' ? 'show' : '' }}" id="dateManagement" data-bs-parent="#left_sidebar">
                        @can('read-type-product')
                        <li class="sidebar_item">
                            <a class="nav_link {{ $metadata['submenu'] == 'type-product' ? 'actived' : '' }}" href="{{ route('type-product.index') }}">Jenis Produk</a>
                        </li>
                        @endcan

                        @can('read-category-product')
                        <li class="sidebar_item">
                            <a class="nav_link {{ $metadata['submenu'] == 'category-product' ? 'actived' : '' }}" href="{{ route('category-product.index') }}">Kategori Produk</a>
                        </li>
                        @endcan
                        @can('read-segment-customer')
                        <li class="sidebar_item">
                            <a class="nav_link {{ $metadata['submenu'] == 'segment-customer' ? 'actived' : '' }}" href="{{ route('category-customer.index') }}">Segmen Customer</a>
                        </li>
                        @endcan
                        @can('read-tax')
                        <li class="sidebar_item">
                            <a class="nav_link {{ $metadata['submenu'] == 'taxes' ? 'actived' : '' }}" href="{{ route('tax.index') }}">Pajak</a>
                        </li>
                        @endcan
                        @can('read-market-progress')
                        <li class="sidebar_item">
                            <a class="nav_link {{ $metadata['submenu'] == 'market-progress' ? 'actived' : '' }}" href="{{ route('market-progress.index') }}">Market Progress</a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcanany

                @canany(['read-product','read-branch','read-customer'])
                <li class="sidebar_item">
                    <a class="nav__link {{ $metadata['description'] == 'Data Master' ? 'actived' : 'collapsed' }}" href="#" data-bs-toggle="collapse" data-bs-target="#dataMaster" aria-expanded="false" aria-controls="dataMaster">
                        <i class='bx bxs-data icon_nav'></i>
                        <span>Data Master</span>
                    </a>
                    <ul class="sidebar_dropdown collapse {{ $metadata['description'] == 'Data Master' ? 'show' : '' }}" id="dataMaster" data-bs-parent="#left_sidebar">
                        @can('read-product')
                        <li class="sidebar_item">
                            <a class="nav_link {{ $metadata['submenu'] == 'product' ? 'actived' : '' }}" href="{{ route('product.index') }}">Products</a>
                        </li>
                        @endcan
                        @can('read-branch')
                        <li class="sidebar_item">
                            <a class="nav_link {{ $metadata['submenu'] == 'branches' ? 'actived' : '' }}" href="{{ route('branches.index') }}">Branches</a>
                        </li>
                        @endcan
                        @can('read-customer')
                        <li class="sidebar_item">
                            <a class="nav_link {{ $metadata['submenu'] == 'customers' ? 'actived' : '' }}" href="{{ route('customer.index') }}">Customers</a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcanany

                @canany(['read-realisasi-kerja'])
                <li class="sidebar_item">
                    <a class="nav__link {{ $metadata['description'] == 'Marketing' ? 'actived' : 'collapsed' }}" href="#" data-bs-toggle="collapse" data-bs-target="#worksheet" aria-expanded="false" aria-controls="worksheet">
                        <i class='bx bxs-folder icon_nav'></i>
                        <span>Marketing</span>
                    </a>
                    <ul class="sidebar_dropdown collapse {{ $metadata['description'] == 'Marketing' ? 'show' : '' }}" id="worksheet" data-bs-parent="#left_sidebar">
                        @can('read-realisasi-kerja')
                        <li class="sidebar_item">
                            <a class="nav_link {{ $metadata['submenu'] == 'realisasi-kerja' ? 'actived' : '' }}" href="{{ route('workplan.index') }}">Realisasi Kerja</a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcanany

                @canany(['read-purchase-order','read-recap-invoice'])
                <li class="sidebar_item">
                    <a class="nav__link {{ $metadata['description'] == 'Sales' ? 'actived' : 'collapsed' }}" href="#" data-bs-toggle="collapse" data-bs-target="#sales" aria-expanded="false" aria-controls="sales">
                        <i class='bx bxs-dollar-circle icon_nav'></i>
                        <span>Sales</span>
                    </a>
                    <ul class="sidebar_dropdown collapse {{ $metadata['description'] == 'Sales' ? 'show' : '' }}" id="sales" data-bs-parent="#left_sidebar">
                        @can('read-purchase-order')
                        <li class="sidebar_item">
                            <a class="nav_link {{ $metadata['submenu'] == 'purchase-order' ? 'actived' : '' }}" href="{{ route('sales-order.index') }}">Purchase Order</a>
                        </li>
                        @endcan
                        @can('read-recap-invoice')
                        <li class="sidebar_item">
                            <a class="nav_link {{ $metadata['submenu'] == 'recap-invoice' ? 'actived' : '' }}" href="{{ route('recap-invoice.index') }}">Rekap Invoice</a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcanany

                <li class="sidebar_item">
                    <a class="nav__link {{ $metadata['description'] == 'Reports' ? 'actived' : 'collapsed' }}" href="#" data-bs-toggle="collapse" data-bs-target="#reports" aria-expanded="false" aria-controls="reports">
                        <i class='bx bxs-cabinet icon_nav'></i>
                        <span>Reports</span>
                    </a>
                    <ul class="sidebar_dropdown collapse {{ $metadata['description'] == 'Reports' ? 'show' : '' }}" id="reports" data-bs-parent="#left_sidebar">
                        <li class="sidebar_item">
                            <a class="nav_link {{ $metadata['submenu'] == 'recap-progress' ? 'actived' : '' }}" href="{{ route('report.progress') }}">Rekap Progress</a>
                        </li>
                        <li class="sidebar_item">
                            <a class="nav_link {{ $metadata['submenu'] == 'report-purchase-order' ? 'actived' : '' }}" href="{{ route('report.purchase.order') }}">Rekap PO</a>
                        </li>
                        <li class="sidebar_item">
                            <a class="nav_link {{ $metadata['submenu'] == 'list-purchase-order' ? 'actived' : '' }}" href="{{ route('report.list.purchase.order') }}">List Orders</a>
                        </li>
                    </ul>
                </li>

                @canany(['pull-report-progress','pull-report-po','pull-report-payment'])
                <li class="sidebar_item">
                    <a class="nav__link {{ $metadata['description'] == 'Download' ? 'actived' : 'collapsed' }}" href="#" data-bs-toggle="collapse" data-bs-target="#downloads" aria-expanded="false" aria-controls="downloads">
                        <i class='bx bxs-cloud-download icon_nav'></i>
                        <span>Downloads</span>
                    </a>
                    <ul class="sidebar_dropdown collapse {{ $metadata['description'] == 'Download' ? 'show' : '' }}" id="downloads" data-bs-parent="#left_sidebar">
                        @can('pull-report-progress')
                        <li class="sidebar_item">
                            <a class="nav_link {{ $metadata['submenu'] == 'download-progress' ? 'actived' : '' }}" href="{{ route('print.recap.progress') }}">Recap Progress</a>
                        </li>
                        @endcan
                        @can('pull-report-po')
                        <li class="sidebar_item">
                            <a class="nav_link {{ $metadata['submenu'] == 'download-purchase-order' ? 'actived' : '' }}" href="{{ route('download.purchase.order') }}">Purchase Orders</a>
                        </li>
                        @endcan
                        @can('pull-report-payment')
                        <li class="sidebar_item">
                            <a class="nav_link {{ $metadata['submenu'] == 'download-payment' ? 'actived' : '' }}" href="{{ route('download.payment') }}">Payments</a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcanany

                @if(auth()->user()->can('read-user') || auth()->user()->hasRole('Super Admin'))
                <li class="sidebar_item">
                    <a class="nav__link {{ $metadata['description'] == 'Auth' ? 'actived' : 'collapsed' }}" href="#" data-bs-toggle="collapse" data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                        <i class='bx bx-shield-quarter icon_nav'></i>
                        <span>Auth</span>
                    </a>
                    <ul class="sidebar_dropdown collapse {{ $metadata['description'] == 'Auth' ? 'show' : '' }}" id="auth" data-bs-parent="#left_sidebar">
                        @can('read-user')
                        <li class="sidebar_item">
                            <a class="nav_link {{ $metadata['submenu'] == 'users' ? 'actived' : '' }}" href="{{ route('user.index') }}">User</a>
                        </li>
                        @endcan
                        @role('Super Admin')
                        <li class="sidebar_item">
                            <a class="nav_link {{ $metadata['submenu'] == 'roles' ? 'actived' : '' }}" href="{{ route('roles.index') }}">Role & Permission</a>
                        </li>
                        @endrole
                    </ul>
                </li>
                @endif

                @role('Super Admin')
                <li class="sidebar_item">
                    <a class="nav__link {{ $metadata['description'] == 'Trash' ? 'actived' : 'collapsed' }}" href="#" data-bs-toggle="collapse" data-bs-target="#trash" aria-expanded="false" aria-controls="trash">
                        <i class='bx bxs-trash icon_nav'></i>
                        <span>Trash</span>
                    </a>
                    <ul class="sidebar_dropdown collapse {{ $metadata['description'] == 'Trash' ? 'show' : '' }}" id="trash" data-bs-parent="#left_sidebar">
                        <li class="sidebar_item">
                            <a class="nav_link {{ $metadata['submenu'] == 'trash' ? 'actived' : '' }}" href="{{ route('trash.branch') }}">Branches</a>
                        </li>
                    </ul>
                </li>
                @endrole

            </ul>
            <!-- Navbar sidebar footer -->
            <ul class="sidebar_footer px-3">
                <li class="sidebar_item">
                    <a class="nav__link {{ $metadata['submenu'] == 'pengaturan' ? 'actived' : '' }}" href="{{ route('pengaturan.index') }}">
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
                            <span>Keluar</span>
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
                                        <a class="dropdown__item" href="{{ route('pengaturan.index') }}">
                                            <i class='bx bxs-cog icon_dropdown'></i>
                                            <span>Pengaturan</span>
                                        </a>
                                    </li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST" id="logout-navbar" class="w-100">
                                            @csrf
                                            @method('POST')
                                            <button class="btn dropdown__item w-100" type="button" onclick="logOut('logout-navbar')">
                                                <i class='bx bxs-log-in-circle bx-rotate-180 icon_dropdown'></i>
                                                <span>Keluar</span>
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