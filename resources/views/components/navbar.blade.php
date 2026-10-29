<header class="navbar navbar-expand-md d-print-none">
    <div class="container-xl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
            aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- BEGIN NAVBAR LOGO -->
        <a href="." aria-label="Tabler" class="navbar-brand navbar-brand-autodark me-3 text-blue">
            <img src="https://www.gambaranimasi.org/data/media/53/animasi-bergerak-buku-0021.gif" width="40"
                height="50" alt="Tabler" class="navbar-brand-logo">Ebooks
        </a>
        <!-- END NAVBAR LOGO -->

        <div class="navbar-nav mx-auto w-50 d-flex flex-row align-items-center gap-3">
            @if (Auth::check() && Auth::user()->role == 'admin')
                {{-- 1. Menu Khusus Admin --}}
                <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.book-categories.*') ? 'active' : '' }}"">
                    {{-- request()->routeIs() : mengecek apakah route saat ini adalah name route yg disimpan. ini digunakan untuk
                     memberikan class active agar ada style biru pada nav-link kategori
                     buku ketika sedang diakses --}}
                    <a href="{{ route('admin.book-categories.index') }}"
                        class="nav-link {{ request()->routeIs('admin.book-categories.index') ? 'active' : '' }}">Kategori
                        Buku</a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.subscriptions.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.subscriptions.index') }}" class="nav-link">Paket Langganan</a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.books.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.books.index') }}" class="nav-link">Buku</a>
                </li>
            @else
                {{-- Menu untuk User --}}
                <div class="dropdown">
                    <a href="#" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Kategori
                    </a>
                    <div class="dropdown-menu dropdown-menu-card" style="width: 600px;">
                        <div class="p-3">
                            <div class="row g-2">
                                @foreach ($navbarCategories as $category)
                                    <div class="col-3">
                                        <a href="{{ route('category.show', $category->id) }}"
                                            class="text-decoration-none">
                                            <div class="card py-2 h-100 shadow-sm">
                                                <div class="card-body p-2 text-center text-dark fw-bold">
                                                    {{ $category->name }}
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SEARCH BAR -->
                <form method="GET" action="{{ route('search') }}" class="dropdown mt-2">
                    <input type="text" name="q" value="{{ request('q') }}"
                        class="form-control form-control-rounded" placeholder="Cari judul, produk, buku, penulis..." />
                    <span class="input-icon-addon">
                        <button type="submit" class="border-0 p-0 bg-transparent">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" aria-hidden="true" focusable="false" class="icon">
                                <path d="M3 10a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                <path d="M21 21l-6 -6" />
                            </svg>
                        </button>
                    </span>
                </form>


                {{-- KERANJANG --}}
                <div>
                    <i class="fa-solid fa-cart-arrow-down fs-3 text-dark"></i>
                </div>
            @endif
        </div>

        <!-- ACTION BUTTONS -->
        <div class="flex-row order-md-last ms-auto">
            @if (Auth::check())
                <a href="{{ route('logout') }}" class="btn btn-danger">Logout</a>
            @else
                <a href="{{ route('login.store') }}" class="btn btn-primary">Login</a>
                <a href="{{ route('register.store') }}" class="btn btn-light">Daftar</a>
            @endif
        </div>
    </div>
</header>
