<style>
    .ebook-nav-list .nav-link {
        position: relative;
        color: #475569;
        font-weight: 500;
        padding: 0.45rem 0.75rem;
        border-radius: 8px;
        transition: color 0.2s ease;
    }

    .ebook-nav-list .nav-link::after {
        content: "";
        position: absolute;
        left: 0.75rem;
        right: 0.75rem;
        bottom: 2px;
        height: 2px;
        border-radius: 999px;
        background: #206bc4;
        transform: scaleX(0);
        transform-origin: left center;
        transition: transform 0.25s ease;
    }

    .ebook-nav-list .nav-link:hover,
    .ebook-nav-list .nav-link.active {
        color: #206bc4;
        background: transparent;
    }

    .ebook-nav-list .nav-link:hover::after,
    .ebook-nav-list .nav-link.active::after {
        transform: scaleX(1);
    }

    .ebook-brand-text {
        font-weight: 800;
        color: #206bc4;
    }

    .ebook-search-input {
        border-radius: 999px !important;
        background: #f8fafc;
    }

    .ebook-nav-list .nav-link.active {
        background: rgba(32, 107, 196, 0.12);
        color: #206bc4;
        border-radius: 8px;
        font-weight: 600;
    }

    .kr-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        border-radius: 999px;
        background: rgba(32, 107, 196, 0.1);
        border: 1px solid rgba(32, 107, 196, 0.25);
        color: #206bc4;
        font-weight: 700;
        font-size: 0.85rem;
        text-decoration: none;
    }

    .kr-pill:hover {
        background: rgba(32, 107, 196, 0.18);
        color: #1a569e;
    }

    .logout-pill {
        display: inline-flex;
        align-items: center;
        padding: 5px 12px;
        border-radius: 999px;
        background: rgba(220, 38, 38, 0.08);
        border: 1px solid rgba(220, 38, 38, 0.2);
        color: #dc2626;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
    }

    .logout-pill:hover {
        background: #dc2626;
        color: #fff;
    }

    .cat-toggle-btn {
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.85);
        border: 1px solid rgba(15, 23, 42, 0.14);
        color: #1e293b;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .cat-toggle-btn:hover,
    .cat-toggle-btn[aria-expanded="true"] {
        background: rgba(32, 107, 196, 0.12);
        border-color: rgba(32, 107, 196, 0.4);
        color: #206bc4;
    }

    .cat-menu-glass {
        border-radius: 14px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(15, 23, 42, 0.08);
        box-shadow: 0 12px 28px -12px rgba(15, 23, 42, 0.2);
    }

    .cat-item-pill {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px 8px;
        border-radius: 10px;
        background: rgba(248, 250, 252, 0.9);
        border: 1px solid rgba(15, 23, 42, 0.08);
        color: #1e293b;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .cat-item-pill:hover {
        transform: translateY(-2px);
        background: rgba(32, 107, 196, 0.12);
        border-color: rgba(32, 107, 196, 0.35);
        color: #206bc4;
    }

    .search-glass-input {
        border-radius: 999px !important;
        background: rgba(248, 250, 252, 0.9);
        border: 1px solid rgba(15, 23, 42, 0.12);
        transition: all 0.2s ease;
    }

    .search-glass-input:focus {
        background: #ffffff;
        border-color: #206bc4;
        box-shadow: 0 0 0 3px rgba(32, 107, 196, 0.14);
    }

    .cart-glass-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: rgba(248, 250, 252, 0.9);
        border: 1px solid rgba(15, 23, 42, 0.12);
        color: #334155;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .cart-glass-btn:hover {
        transform: translateY(-1px);
        background: rgba(32, 107, 196, 0.12);
        border-color: rgba(32, 107, 196, 0.35);
        color: #206bc4;
    }
</style>

<header class="navbar navbar-expand-md ebook-navbar d-print-none">
    <div class="container-xl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
            aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- LOGO -->
        <a href="{{ route('home') }}" class="navbar-brand me-3 d-flex align-items-center gap-2">
            <img src="https://www.gambaranimasi.org/data/media/53/animasi-bergerak-buku-0012.gif" width="36"
                height="44" alt="Logo Ebooks" class="rounded-2">
            <span class="ebook-brand-text fs-3">Ebooks</span>
        </a>

        <div class="collapse navbar-collapse" id="navbar-menu">
            <div class="d-flex flex-column flex-md-row align-items-md-center gap-3 w-100 my-2 my-md-0">
                @if (Auth::check() && Auth::user()->role == 'admin')
                    {{-- Menu Admin --}}
                    <ul class="navbar-nav ebook-nav-list gap-1 mx-md-auto mb-0">
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}"
                                class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.book-categories.index') }}"
                                class="nav-link {{ request()->routeIs('admin.book-categories.*') ? 'active' : '' }}">Kategori
                                Buku</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.subscriptions.index') }}"
                                class="nav-link {{ request()->routeIs('admin.subscriptions.*') ? 'active' : '' }}">Paket
                                Langganan</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.books.index') }}"
                                class="nav-link {{ request()->routeIs('admin.books.*') ? 'active' : '' }}">Buku</a>
                        </li>
                    </ul>
                @else
                    {{-- Menu User --}}
                    <div
                        class="d-flex align-items-center justify-content-md-center flex-wrap gap-2 mx-md-auto flex-grow-1">
                        <div class="dropdown">
                            <a href="#" class="btn cat-toggle-btn dropdown-toggle" data-bs-toggle="dropdown"
                                aria-expanded="false">Kategori</a>
                            <div class="dropdown-menu cat-menu-glass p-2 mt-2" style="width: min(560px, 92vw);">
                                <div class="row g-2">
                                    @foreach ($navbarCategories as $category)
                                        <div class="col-6 col-sm-3">
                                            <a href="{{ route('category.show', $category->id) }}" class="cat-item-pill">
                                                {{ $category->name }}
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <form method="GET" action="{{ route('search') }}" class="flex-grow-1"
                            style="max-width: 400px;">
                            <input type="text" name="q" value="{{ request('q') }}"
                                class="form-control search-glass-input"
                                placeholder="Cari judul, buku, atau penulis..." />
                        </form>

                        {{-- Keranjang --}}
                        <a href="{{ route('carts') }}" class="cart-glass-btn" aria-label="Keranjang">
                            <i class="fa-solid fa-cart-arrow-down"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- ACTION BUTTONS -->
        <div class="d-flex align-items-center gap-2 order-md-last ms-auto">
            {{-- ambil huruf pertama dari/kata --}}
            @php
                $kata = explode(' ', trim(Auth::user()->name ?? ''));
                $inisial = strtoupper(substr($kata[0] ?? '', 0, 1) . substr($kata[1] ?? '', 0, 1));
            @endphp

            <a href="{{ route('user.profile') }}" class="kr-pill">
                <i class="fa-regular fa-user"></i>
                <span>{{ $inisial ?: '' }}</span>
            </a>

            @if (Auth::check())
                <a href="{{ route('logout') }}" class="logout-pill">Logout</a>
            @else
                <a href="{{ route('login.store') }}" class="btn btn-primary btn-sm rounded-pill px-3">Login</a>
                <a href="{{ route('register.store') }}"
                    class="btn btn-light border btn-sm rounded-pill px-3">Daftar</a>
            @endif
        </div>
    </div>
</header>
