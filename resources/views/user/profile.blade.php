@extends('layouts.app') {{-- Sesuaikan dengan layout utama web kamu --}}

@section('content')
    <div class="container py-4">
        <div class="row">
            <!-- Kolom Kiri: Profil Summary -->
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm p-4">
                    <div class="d-flex align-items-center mb-4">
                        <!-- Form & Input tersembunyi untuk upload foto profil -->
                        <form action="{{ route('user.profile.photo') }}" method="POST" enctype="multipart/form-data"
                            id="form-photo" class="mb-0">
                            @csrf
                            <input type="file" name="photo" id="input-photo" accept="image/*" class="d-none"
                                onchange="document.getElementById('form-photo').submit();">
                        </form>

                        <!-- Label yang membungkus foto/inisial agar bisa diklik untuk ganti foto -->
                        <label for="input-photo" class="position-relative d-inline-block me-3 mb-0" style="cursor: pointer;"
                            title="Klik untuk ganti foto profil">
                            @if (Auth::user()->photo)
                                <!-- Jika user sudah upload foto -->
                                <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Foto Profil"
                                    class="rounded-circle object-fit-cover border" style="width: 80px; height:80px;">
                                <!-- Titik Bulat Hijau (Status Online/Login) -->
                                <span class="position-absolute bottom-0 end-0 bg-success border border-white rounded-circle"
                                    style="width: 18px; height: 18px;" title="Online">
                                </span>
                            @else
                                <!-- Jika belum ada foto, tampilkan inisial huruf -->
                                <div class="avatar bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                    style="width: 80px; height: 80px; font-size: 20px;">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                </div>
                            @endif
                        </label>

                        <div>
                            <h5 class="mb-0 fw-bold">{{ Auth::user()->name }}</h5>
                            <small class="text-muted" style="font-size: 11px;">Klik foto untuk mengganti</small>
                        </div>
                    </div>

                    <hr class="text-muted">

                    <h6 class="fw-bold text-primary mb-3">Profil Summary</h6>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Koleksi Buku</span>
                        {{-- ini ngambil dimana --}}
                        <span class="fw-bold">{{ $bookCount }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Langganan</span>
                        <span class="fw-bold">{{ $subscriptionCount }}</span>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Daftar Transaksi & Filter -->
            <div class="col-md-8">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="fw-bold mb-0">Transaksi</h4>

                    <!-- Dropdown Filter Jenis Transaksi -->
                    <div class="dropdown">
                        <label class="form-label small text-muted mb-1">Jenis Transaksi</label>
                        <select class="form-select form-select-sm" id="filterTransaksi">
                            <option value="langganan" selected>Paket Langganan</option>
                            <option value="buku">Buku</option>
                        </select>
                    </div>
                </div>

                <!-- List Card Transaksi -->
                @forelse($transactions as $trx)
                    <div class="card border-0 shadow-sm mb-3 p-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <!-- Tanggal data dibuat -->
                            <small class="text-muted">
                                {{ $trx->created_at->format('d M Y, H:i') }}
                            </small>
                            <span class="badge bg-success-subtle text-success px-3 py-2">Transaksi Sukses</span>
                        </div>

                        <hr class="my-2">

                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <div>
                                <!-- Nama paket langganan -->
                                <h5 class="fw-bold mb-1">
                                    {{ $trx->subscriptionPackage->name_package ?? 'Paket Langganan' }}
                                </h5>
                                <!-- Tanggal paket langganan akan habis masa berlakunya -->
                                <span class="badge bg-danger text-white">
                                    Berlaku sd : {{ \Carbon\Carbon::parse($trx->expired_date)->format('d M Y') }}
                                </span>
                            </div>
                            <div class="text-end">
                                <small class="text-muted d-block">Total Pembayaran</small>
                                <!-- Harga paket langganan -->
                                <h5 class="fw-bold text-dark mb-0">
                                    Rp {{ number_format($trx->subscriptionPackage->price ?? 0, 0, ',', '.') }}
                                </h5>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="card border-0 shadow-sm p-4 text-center text-muted">
                        <p class="mb-0">Belum ada riwayat transaksi paket langganan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
