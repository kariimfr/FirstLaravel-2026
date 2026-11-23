@extends('layouts.app')

@section('content')
    <div class="container my-5">

        <!-- Informasi Detail Paket & Tombol Langganan -->
        <div class="card shadow-sm border-0 p-4 mb-4 rounded-4 bg-light">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h2 class="fw-bold mb-1">{{ $subscriptionPackage->name_package }}</h2>
                    <p class="text-muted mb-0">Daftar buku pilihan eksklusif dalam paket langganan ini.</p>
                </div>
                <div class="text-end">
                    <h4 class="text-primary fw-bold mb-2">Rp {{ number_format($subscriptionPackage->price, 0, ',', '.') }}
                    </h4>
                    <a href="{{ route('subscription.checkout.page', $subscriptionPackage->id) }}"
                        class="btn btn-primary btn-subscribe text-white ms-md-2">Langganan Sekarang</a>
                </div>
            </div>
        </div>

        <!-- Search Bar untuk Mencari Buku Berdasarkan Judul -->
        <div class="mb-4">
            <input type="text" id="search-book" class="form-control form-control-lg rounded-pill px-4 shadow-sm"
                placeholder="Cari judul buku di paket ini...">
        </div>

        <!-- Daftar Buku yang Tertaut -->
        <div class="row g-4" id="book-list-container">
            @forelse($subscriptionPackage->subscriptionPackageBooks as $item)
                <div class="col-6 col-md-2 book-item">
                    <div class="card h-100 shadow-sm border-0 rounded-4 p-2">
                        @if ($item->book && $item->book->cover)
                            <img src="{{ asset($item->book->cover) }}" class="card-img-top rounded-3" alt="..."
                                style="height: 240px; object-fit: cover;">
                        @else
                            <div class="bg-secondary text-white rounded-3 d-flex align-items-center justify-content-center"
                                style="height: 200px;">No Cover</div>
                        @endif
                        <div class="card-body px-2 pb-2">
                            <h6 class="card-title fw-bold book-title text-truncate" title="{{ $item->book->title ?? '-' }}">
                                {{ $item->book->title ?? '-' }}</h6>
                            <p class="card-text text-muted small mb-1">Penulis: {{ $item->book->writer ?? '-' }}</p>
                            <p class="card-text fw-semibold text-dark small">Rp
                                {{ number_format($item->book->price ?? 0, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center rounded-4 py-4">Belum ada buku yang ditambahkan ke dalam paket
                        langganan ini.</div>
                </div>
            @endforelse
        </div>

    </div>

    <!-- Script JavaScript untuk Search Bar Buku -->
    @push('scripts')
        <script>
            document.getElementById('search-book').addEventListener('keyup', function() {
                let keyword = this.value.toLowerCase();
                let books = document.querySelectorAll('.book-item');

                books.forEach(function(book) {
                    let title = book.querySelector('.book-title').innerText.toLowerCase();
                    if (title.includes(keyword)) {
                        book.style.display = 'block';
                    } else {
                        book.style.display = 'none';
                    }
                });
            });
        </script>
    @endpush
@endsection
