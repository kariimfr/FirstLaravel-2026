@extends('layouts.app')

@section('content')
    @push('styles')
        <style>
            .cart-page-header {
                background: linear-gradient(135deg, rgba(32, 107, 196, 0.08), rgba(47, 179, 68, 0.06));
                border: 1px solid rgba(32, 107, 196, 0.14);
                border-radius: 16px;
                padding: 1.15rem 1.4rem;
            }

            .cart-item-card {
                border-radius: 16px !important;
                border: 1px solid rgba(98, 105, 118, 0.16) !important;
                transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
                background: #ffffff;
            }

            .cart-item-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 24px -10px rgba(24, 36, 51, 0.16) !important;
                border-color: rgba(32, 107, 196, 0.35) !important;
            }

            .cart-cover-wrap {
                width: 74px;
                height: 106px;
                border-radius: 10px;
                overflow: hidden;
                box-shadow: 0 6px 14px rgba(0, 0, 0, 0.12);
                flex-shrink: 0;
            }

            .cart-cover-wrap img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.3s ease;
            }

            .cart-item-card:hover .cart-cover-wrap img {
                transform: scale(1.05);
            }

            .cart-summary-card {
                border-radius: 20px !important;
                border: 1px solid rgba(98, 105, 118, 0.16) !important;
                background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            }

            .btn-checkout-live {
                transition: transform 0.18s ease, box-shadow 0.18s ease;
                box-shadow: 0 8px 18px -6px rgba(32, 107, 196, 0.55);
            }

            .btn-checkout-live:hover {
                transform: translateY(-1px);
                box-shadow: 0 12px 22px -6px rgba(32, 107, 196, 0.65);
            }

            .btn-delete-soft {
                transition: all 0.18s ease;
            }

            .btn-delete-soft:hover {
                transform: translateY(-1px);
            }

            @keyframes fadeSlideUp {
                from {
                    opacity: 0;
                    transform: translateY(8px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .cart-animate-in {
                animation: fadeSlideUp 0.28s ease both;
            }
        </style>
    @endpush

    <div class="container my-4 cart-animate-in">
        <!-- Header Halaman -->
        <div class="cart-page-header d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
            <div>
                <h2 class="fw-bold mb-1">Keranjang Belanja</h2>
                <div class="text-muted small">Kelola buku pilihan atau paket langganan sebelum lanjut ke pembayaran.</div>
            </div>
            <span class="badge bg-primary-lt text-primary fs-6 px-3 py-2 rounded-pill">
                <i class="fa-solid fa-bag-shopping me-1"></i>
                <span id="header-cart-badge">{{ $carts->count() }}</span> Item
            </span>
        </div>

        {{-- alert success --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
            </div>
        @endif

        <div class="row g-4">
            <!-- Kolom Kiri: Daftar Keranjang -->
            <div class="col-lg-8">

                <!-- Box Pilih Semua -->
                <div class="card border rounded-4 p-3 mb-3 shadow-sm">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="form-check d-flex align-items-center m-0">
                            <input class="form-check-input me-2" type="checkbox" id="check-all" checked>
                            <label class="form-check-label fw-semibold" for="check-all">
                                Pilih Semua (<span id="cart-count">{{ $carts->count() }}</span> Buku Terpilih)
                            </label>
                        </div>
                        <span class="text-muted small d-none d-sm-inline">Centang item untuk dihitung</span>
                    </div>
                </div>

                <!-- List Item Keranjang -->
                @forelse($carts as $cart)
                    <div class="card cart-item-card p-3 mb-3 shadow-sm position-relative">
                        <div class="d-flex align-items-center">

                            <!-- Checkbox Item -->
                            <div class="form-check me-3">
                                <input class="form-check-input item-checkbox" type="checkbox" name="selected_carts[]"
                                    {{-- JS perlu tahu harga tiap item dan baris ringkasan mana 
                                yang cocok dengan checkbox mana --}} value="{{ $cart->id }}"
                                    data-price="{{ $cart->display_price }}" checked>
                            </div>

                            <!-- Gambar Cover -->
                            <div class="cart-cover-wrap me-3">
                                <img src="{{ $cart->book->cover ?? '' }}" alt="{{ $cart->book->title ?? 'Tanpa Buku' }}">
                            </div>

                            <!-- Detail Produk -->
                            <div class="flex-grow-1 pe-2">
                                <div class="text-muted small mb-1">
                                    <i class="fa-solid fa-feather-pointed me-1 opacity-75"></i>
                                    {{ $cart->book->writer ?? 'Penulis Tidak Diketahui' }}
                                </div>
                                <h4 class="fw-bold mb-1 text-dark">{{ $cart->book->title ?? 'Judul Buku' }}</h4>
                                @if ($cart->needs_package)
                                    <span class="badge bg-red-lt text-red mt-1">
                                        <i class="fa-solid fa-circle-exclamation me-1"></i>Perlu membeli paket terlebih
                                        dahulu
                                    </span>
                                @endif
                            </div>

                            <!-- Harga dan Tombol Hapus -->
                            @php
                                $price = $cart->subscriptionPackage
                                    ? $cart->subscriptionPackage->price
                                    : $cart->book->price;
                            @endphp
                            <div class="text-end d-flex flex-column align-items-end justify-content-between style-price-container"
                                style="min-height: 102px;">
                                <div>
                                    {{-- atribut price di ganti jadi display_price karena di controller
                                    pake atribut display_price --}}
                                    <h4 class="fw-bold mb-1 text-primary">
                                        Rp{{ number_format($cart->display_price, 0, ',', '.') }}
                                    </h4>
                                    <div>
                                        @if ($cart->subscriptionPackage)
                                            <span class="badge bg-green text-green-fg rounded-pill px-2.5">
                                                {{ $cart->subscriptionPackage->name_package }}
                                            </span>
                                        @else
                                            <span class="badge bg-azure text-azure-fg rounded-pill px-2.5">Medium</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Form / Button Hapus -->
                                <form action="{{ route('carts.destroy', $cart->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus item ini dari keranjang?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger btn-delete-soft rounded-3"
                                        title="Hapus">
                                        <i class="fa-solid fa-trash me-1"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="card p-5 text-center text-muted border rounded-4 shadow-sm">
                        <i class="fa-solid fa-cart-shopping fs-1 mb-3 opacity-50"></i>
                        <h5 class="fw-semibold text-dark mb-1">Keranjang Belanja Kosong</h5>
                        <p class="mb-0 small">Yuk, tambahkan buku favoritmu ke keranjang terlebih dahulu.</p>
                    </div>
                @endforelse

            </div>

            <!-- Kolom Kanan: Ringkasan Keranjang -->
            <div class="col-lg-4">
                <div class="card cart-summary-card p-4 shadow-sm position-sticky" style="top: 20px;">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h5 class="fw-bold mb-0">Ringkasan Keranjang</h5>
                        <span class="badge bg-blue-lt text-blue rounded-pill">Siap Checkout</span>
                    </div>

                    <div class="d-flex justify-content-between mb-3 text-muted small">
                        <span>Total Belanja (<span id="total-selected-count"
                                class="fw-semibold text-dark">{{ $carts->count() }}</span> buku)</span>
                    </div>

                    {{-- Daftar harga/item --}}
                    <div class="mb-2">
                        @foreach ($carts as $cart)
                            {{-- summary-row (untuk pengenal HTML ke JavaScript --}}
                            <div class="summary-row d-flex justify-content-between align-items-start small mb-2 {{ $cart->needs_package ? 'text-danger' : 'text-muted' }}"
                                {{-- data-cart-id (yang menghubungkan item checkbox di 
                                kiri dengan ringkasan keranjangnya di section kanan) --}} data-cart-id="{{ $cart->id }}">
                                <div class="pe-2 text-truncate">
                                    <span class="fw-medium">{{ $cart->book->title }}</span>
                                    @if ($cart->needs_package)
                                        <br><small class="text-danger">Perlu membeli paket dulu
                                            {{ $cart->subscriptionPackage->name_package }}
                                        </small>
                                    @endif
                                </div>
                                <span class="fw-semibold text-nowrap">
                                    Rp{{ number_format($cart->display_price, 0, ',', '.') }}
                                </span>
                            </div>
                        @endforeach
                    </div>

                    <hr class="my-3">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted fw-medium">Total Belanja</span>
                        <h3 class="text-dark fw-bold mb-0" id="total-price-text">
                            Rp {{ number_format($totalPrice, 0, ',', '.') }}
                        </h3>
                    </div>

                    <form method="GET" id="form-checkout">
                        <!-- Dynamic Hidden Inputs for Selected Items -->
                        <div id="checkout-inputs"></div>

                        <button type="submit"
                            class="btn btn-primary btn-checkout-live w-100 py-2.5 rounded-pill fw-semibold"
                            id="btn-checkout">
                            <i class="fa-solid fa-lock me-1 small"></i> Checkout Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const checkboxes = document.querySelectorAll('.item-checkbox');
            const totalPriceText = document.getElementById('total-price-text');
            const totalCountText = document.getElementById('total-selected-count');
            const cartCount = document.getElementById('cart-count');
            const btnCheckout = document.getElementById('btn-checkout');
            const checkoutInputs = document.getElementById('checkout-inputs');

            const rupiah = n => 'Rp' + n.toLocaleString('id-ID');

            function updateSummary() {
                const checked = [...checkboxes].filter(cb => cb.checked);
                const total = checked.reduce((sum, cb) => sum + Number(cb.dataset.price), 0);

                // [DIUBAH] Ditambah pengecekan 'if' agar aman jika elemen belum ditemukan di DOM
                if (totalPriceText) totalPriceText.textContent = rupiah(total);
                if (totalCountText) totalCountText.textContent = checked.length;
                if (cartCount) cartCount.textContent = `(${checked.length})`;

                checkboxes.forEach(cb => {
                    const row = document.querySelector(`.summary-row[data-cart-id="${cb.value}"]`);
                    if (row) {
                        if (cb.checked) {
                            row.classList.remove('d-none');
                        } else {
                            row.classList.add('d-none');
                        }
                    }
                });

                // [DIUBAH] Ditambah pengecekan 'if (btnCheckout)' sebelum mengubah .disabled
                if (btnCheckout) {
                    btnCheckout.disabled = checked.length === 0;
                }

                // [DIUBAH] Ditambah pengecekan 'if (checkoutInputs)' sebelum mengisi innerHTML
                if (checkoutInputs) {
                    checkoutInputs.innerHTML = '';
                    checked.forEach(cb => {
                        checkoutInputs.innerHTML +=
                            `<input type="hidden" name="selected_carts[]" value="${cb.value}">`;
                    });
                }
            }

            checkboxes.forEach(cb => cb.addEventListener('change', updateSummary));

            updateSummary();
        });
    </script>
@endpush
