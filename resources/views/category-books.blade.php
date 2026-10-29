@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        <!-- 1. Judul Kategori & Tombol Kembali -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Kategori: {{ $category->name }}</h2>
            <a href="{{ url('/') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>

        <!-- 2. Form Pencarian & Sorting -->
        <form method="GET" action="{{ route('category.show', $category->id) }}" class="row g-2 mb-4">
            <!-- Input Search -->
            <div class="col-md-8">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                    placeholder="Cari judul buku atau penulis...">
            </div>

            <!-- Dropdown Sorting -->
            <div class="col-md-4">
                <select name="sort" class="form-select" onchange="this.form.submit()">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Buku Terbaru</option>
                    <option value="cheapest" {{ request('sort') == 'cheapest' ? 'selected' : '' }}>Harga Termurah</option>
                    <option value="expensive" {{ request('sort') == 'expensive' ? 'selected' : '' }}>Harga Termahal</option>
                </select>
            </div>
        </form>

        <!-- 3. Daftar Buku -->
        <div class="row g-3">
            @forelse ($books as $book)
                <div class="col-md-3">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <div class="w-100 mb-2">
                                <img src="{{ asset($book->cover) }}" class="img-fluid rounded"
                                    style="height: 160px; object-fit: cover;" alt="Cover">
                            </div>

                            <!-- Penulis & Judul -->
                            <small class="text-muted">{{ $book->writer }}</small>
                            <h5 class="fw-bold mt-1" style="font-size: 1rem;">{{ $book->title }}</h5>

                            <!-- Harga Buku -->
                            <p class="text-primary fw-bold mt-2">
                                Rp. {{ number_format($book->price, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">Tidak ada buku dalam kategori ini.</p>
                </div>
            @endforelse
        </div>

        <!-- 4. Paginasi Halaman -->
        <div class="mt-4 d-flex justify-content-center">
            {{ $books->withQueryString()->links() }}
        </div>

    </div>
@endsection
