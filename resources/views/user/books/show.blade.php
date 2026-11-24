@extends('layouts.app')

@push('styles')
    <style>
        .description-clamped {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .style-width-label {
            min-width: 110px;
            display: inline-block;
        }

        .book-detail-surface {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(15, 23, 42, 0.06);
            border-radius: 18px;
            box-shadow: 0 14px 34px -18px rgba(15, 23, 42, 0.18);
        }

        .book-cover-stage {
            background: linear-gradient(160deg, #f8fafc 0%, #eef2ff 100%);
            border: 1px solid rgba(15, 23, 42, 0.06);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .book-cover-stage:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 30px -16px rgba(15, 23, 42, 0.22);
        }

        .purchase-option-card {
            min-width: 180px;
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }

        .purchase-option-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 18px -10px rgba(37, 99, 235, 0.28);
        }

        .form-selectgroup-input:checked+.purchase-option-card {
            border-color: var(--tblr-primary, #206bc4) !important;
            background: linear-gradient(135deg, rgba(32, 107, 196, 0.08) 0%, rgba(255, 255, 255, 0.95) 100%) !important;
            box-shadow: 0 10px 22px -12px rgba(32, 107, 196, 0.45);
        }

        .app-access-card {
            background: linear-gradient(135deg, rgba(248, 250, 252, 0.95) 0%, rgba(239, 246, 255, 0.9) 100%);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(37, 99, 235, 0.12);
            box-shadow: 0 10px 24px -12px rgba(15, 23, 42, 0.14);
        }

        .store-badge-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 8px 16px;
            border-radius: 12px;
            background: #0f172a;
            color: #ffffff !important;
            text-decoration: none;
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: 0 6px 14px -4px rgba(15, 23, 42, 0.28);
            transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
        }

        .store-badge-btn:hover {
            transform: translateY(-2px);
            background: #1e293b;
            box-shadow: 0 10px 22px -6px rgba(15, 23, 42, 0.36);
        }

        .store-badge-sub {
            display: block;
            font-size: 0.62rem;
            line-height: 1.1;
            opacity: 0.75;
            letter-spacing: 0.03em;
        }

        .store-badge-title {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            line-height: 1.2;
        }

        .sticky-action-glass {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }
    </style>
@endpush

@section('content')
    <form action="{{ route('carts.store') }}" method="POST">
        @csrf
        <div class="page-body">
            @if ($errors->any())
                <div class="alert alert-danger">Terjadi Kesalahan, Silakan Coba Lagi.</div>
            @endif
            <div class="container-xl pb-5 book-detail-surface p-3 p-md-4 mb-5">
                <div class="row g-4">

                    <!-- Kolom Gambar Produk (Kiri) -->
                    <div class="col-lg-5 col-md-6">
                        <div class="card border-0 bg-transparent shadow-none">
                            <!-- Preview Gambar Utama -->
                            <div class="text-center rounded-4 book-cover-stage p-4 mb-3"
                                style="min-height: 380px; display: flex; align-items: center; justify-content: center;">
                                <img src="{{ asset($book->cover) }}" alt="{{ $book->title }}"
                                    class="img-fluid rounded-3 shadow-sm" style="max-height: 350px; object-fit: contain;">
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Informasi Produk (Kanan) -->
                    <div class="col-lg-7 col-md-6">
                        <h1 class="h2 fw-bold text-dark mb-3">
                            {{ $book->title }}
                        </h1>

                        <!-- Opsi Pembelian -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted small text-uppercase mb-2">Opsi Pembelian</label>
                            <div class="row g-2">
                                @foreach ($book->subscriptionPackageBooks ?? [] as $subscriptionPackageBook)
                                    @if ($subscriptionPackageBook->subscriptionPackage)
                                        <div class="col-auto">
                                            <label class="form-selectgroup-item">
                                                <input type="radio" name="purchase_option"
                                                    value="{{ $subscriptionPackageBook->subscription_package_id }}"
                                                    class="form-selectgroup-input" {{ $loop->first ? 'checked' : '' }}>
                                                <div
                                                    class="form-selectgroup-label purchase-option-card d-flex flex-column align-items-start p-3 border rounded-3 bg-light text-start">
                                                    <span class="text-muted small">
                                                        {{ $subscriptionPackageBook->subscriptionPackage->name_package }}
                                                    </span>
                                                    <span class="h3 fw-bold text-dark mb-0 mt-2">
                                                        Rp{{ number_format($subscriptionPackageBook->subscriptionPackage->price, 0, ',', '.') }}
                                                    </span>
                                                </div>
                                            </label>
                                        </div>
                                    @endif
                                @endforeach

                                <div class="col-auto">
                                    <label class="form-selectgroup-item">
                                        <input type="radio" name="purchase_option" value="none"
                                            class="form-selectgroup-input"
                                            {{ empty($book->subscriptionPackageBooks) || $book->subscriptionPackageBooks->isEmpty() ? 'checked' : '' }}>
                                        <div
                                            class="form-selectgroup-label purchase-option-card d-flex flex-column align-items-start p-3 border rounded-3 bg-light text-start">
                                            <span class="text-muted small">Satuan</span>
                                            <span class="h3 fw-bold text-dark mb-0 mt-2">
                                                Rp{{ number_format($book->price, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Info Box: Akses Aplikasi -->
                        <div class="card app-access-card border-0 rounded-4 mb-4">
                            <div class="card-body p-3 p-md-4">
                                <h5 class="mb-1 fw-bold text-dark">Konten ini dapat dibaca melalui aplikasi Gramedia Digital
                                </h5>
                                <p class="text-muted small mb-3">
                                    Download aplikasi Gramedia Digital yang tersedia di seluruh perangkat iOS dan Android
                                </p>
                                <div class="d-flex flex-wrap gap-2">
                                    <a href="#" class="store-badge-btn" aria-label="Google Play">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M3.609 1.814L13.792 12 3.61 22.186a1.98 1.98 0 0 1-.49-1.31V3.124c0-.5.185-.975.49-1.31Z"
                                                fill="#4285F4" />
                                            <path
                                                d="M17.205 8.587L13.792 12l3.413 3.413 3.854-2.186c.704-.4.704-1.454 0-1.854l-3.854-2.786Z"
                                                fill="#FBBC05" />
                                            <path d="M3.609 1.814L17.205 8.587 13.792 12 3.609 1.814Z" fill="#34A853" />
                                            <path d="M13.792 12l3.413 3.413L3.609 22.186 13.792 12Z" fill="#EA4335" />
                                        </svg>
                                        <span>
                                            <span class="store-badge-sub">GET IT ON</span>
                                            <span class="store-badge-title">Google Play</span>
                                        </span>
                                    </a>

                                    <a href="#" class="store-badge-btn" aria-label="App Store">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M17.05 20.28c-.98.95-2.05.8-3.08.35-1.09-.46-2.09-.48-3.24 0-1.44.62-2.2.44-3.06-.35C2.79 15.25 3.51 7.59 9.05 7.31c1.35.07 2.29.74 3.08.8 1.18-.24 2.31-.93 3.57-.84 1.51.12 2.65.72 3.4 1.8-3.12 1.87-2.38 5.98.48 7.13-.57 1.5-1.32 2.99-2.53 4.08ZM12.03 7.25c-.15-2.23 1.66-4.07 3.74-4.25.29 2.58-2.34 4.5-3.74 4.25Z" />
                                        </svg>
                                        <span>
                                            <span class="store-badge-sub">Download on the</span>
                                            <span class="store-badge-title">App Store</span>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Deskripsi Buku -->
                        <div class="mb-4">
                            <h3 class="h4 fw-bold mb-2">Deskripsi</h3>
                            {{-- Container deskripsi dengan batas baris --}}
                            <div class="text-muted leading-relaxed mb-1 description-clamped" id="bookDescription">
                                {!! $book->description !!}
                            </div>

                            {{-- Tombol Toggle Baca Selengkapnya --}}
                            <a href="javascript:void(0)"
                                class="text-primary small fw-bold d-inline-flex align-items-center gap-1 mt-2"
                                id="btnReadMore" onclick="toggleDescription()">
                                <span id="readMoreText">Baca Selengkapnya</span>
                                <i class="ti ti-chevron-down" id="readMoreIcon"></i>
                            </a>
                        </div>

                        <!-- Informasi Detail Buku -->
                        <div class="mb-4">
                            <h3 class="h4 fw-bold mb-3">Informasi Buku</h3>
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="d-flex mb-2">
                                        <span class="text-muted style-width-label">Bahasa</span>
                                        <span class="fw-semibold">: {{ $book->language }}</span>
                                    </div>
                                    <div class="d-flex mb-2">
                                        <span class="text-muted style-width-label">Penerbit</span>
                                        <span class="fw-semibold">: {{ $book->publisher }}</span>
                                    </div>
                                    <div class="d-flex mb-2">
                                        <span class="text-muted style-width-label">Penulis</span>
                                        <span class="fw-semibold">: {{ $book->writer }}</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-flex mb-2">
                                        <span class="text-muted style-width-label">Tanggal Rilis</span>
                                        <span class="fw-semibold">:
                                            {{ \Carbon\Carbon::parse($book->release_date)->format('d F Y') }}</span>
                                    </div>
                                    <div class="d-flex mb-2">
                                        <span class="text-muted style-width-label">Halaman</span>
                                        <span class="fw-semibold">: {{ $book->page_of_book }} Halaman</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <!-- Sticky Bottom Action Bar (Fixed melayang di bagian bawah) -->
        <div class="fixed-bottom sticky-action-glass border-top shadow-lg py-2" style="z-index: 1020;">
            <div class="container-xl">
                <div class="d-flex align-items-center justify-content-between gap-3">
                    <!-- Informasi Singkat Produk -->
                    <div class="d-flex align-items-center gap-3">
                        <img src="{{ asset($book->cover) }}" alt="{{ $book->title }}" class="rounded border"
                            style="width: 40px; height: 50px; object-fit: cover;">
                        <div>
                            <h4 class="mb-0 text-truncate fw-bold" style="max-width: 400px;">
                                {{ $book->title }}
                            </h4>
                            <span class="fw-bold text-dark h4 mb-0">
                                Rp{{ number_format($book->price, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <!-- Tombol Transaksi -->
                    <div class="d-flex gap-2">
                        <input type="hidden" name="book_id" value="{{ $book->id }}">

                        {{-- agar controller bisa membedakan tombol yang diklik itu  --}}
                        {{-- yang nantinya digunakan untuk pengkondisian di controller 
                        terkait aksi lanjutan yang diperlukan --}}
                        <button type="submit" name="action" value="add_to_cart"
                            class="btn btn-outline-primary px-4 py-2 fw-medium">
                            Tambah ke Keranjang
                        </button>
                        <button type="submit" name="action" value="buy_now"
                            class="btn btn-primary px-4 py-2 fw-medium">
                            Beli Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        function toggleDescription() {
            const desc = document.getElementById('bookDescription');
            const text = document.getElementById('readMoreText');
            const icon = document.getElementById('readMoreIcon');

            if (desc.classList.contains('description-clamped')) {
                desc.classList.remove('description-clamped');
                text.innerText = 'Tutup';
                icon.classList.replace('ti-chevron-down', 'ti-chevron-up');
            } else {
                desc.classList.add('description-clamped');
                text.innerText = 'Baca Selengkapnya';
                icon.classList.replace('ti-chevron-up', 'ti-chevron-down');
            }
        }
    </script>
@endpush
