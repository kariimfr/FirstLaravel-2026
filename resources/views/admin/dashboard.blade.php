@extends('layouts.app')

@push('styles')
    <style>
        .admin-hero-glass {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.94) 0%, rgba(239, 246, 255, 0.9) 100%);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(32, 107, 196, 0.12);
            border-radius: 18px;
            box-shadow: 0 12px 30px -16px rgba(15, 23, 42, 0.16);
        }

        .kpi-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(15, 23, 42, 0.07);
            border-radius: 16px;
            box-shadow: 0 10px 24px -16px rgba(15, 23, 42, 0.18);
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }

        .kpi-card:hover {
            transform: translateY(-3px);
            border-color: rgba(32, 107, 196, 0.3);
            box-shadow: 0 16px 32px -16px rgba(32, 107, 196, 0.25);
        }

        .kpi-icon-box {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .admin-panel-card {
            background: rgba(255, 255, 255, 0.94);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(15, 23, 42, 0.07);
            border-radius: 16px;
            box-shadow: 0 10px 24px -16px rgba(15, 23, 42, 0.15);
        }

        .book-thumb-mini {
            width: 38px;
            height: 50px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid rgba(15, 23, 42, 0.08);
        }
    </style>
@endpush

@section('content')
    <div class="page-body">
        <div class="container-xl py-4">

            {{-- Header & Quick Actions --}}
            <div class="admin-hero-glass p-4 mb-4">
                <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                    <div>
                        <span class="badge rounded-pill bg-success-lt text-succes fw-semibold mb-2">
                            Admin Control Center
                        </span>
                        <h1 class="h2 fw-bold text-dark mb-1">Dashboard Admin</h1>
                        <p class="text-muted mb-0">
                            Selamat datang kembali, <strong>{{ Auth::user()->name ?? 'Admin' }}</strong> — pantau katalog
                            buku, kategori, dan paket langganan.
                        </p>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('admin.books.create') }}" class="btn btn-primary rounded-3 fw-semibold">
                            <i class="fa-solid fa-plus me-1"></i> Tambah Buku
                        </a>
                        <a href="{{ route('admin.book-categories.index') }}"
                            class="btn btn-outline-primary rounded-3 fw-semibold">
                            Kelola Kategori
                        </a>
                        <a href="{{ route('admin.subscriptions.index') }}"
                            class="btn btn-outline-secondary rounded-3 fw-semibold">
                            Paket Langganan
                        </a>
                    </div>
                </div>
            </div>

            {{-- KPI Cards --}}
            <div class="row row-cards g-3 mb-4">
                <div class="col-sm-6 col-xl-3">
                    <div class="card kpi-card h-100">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <div class="text-muted small fw-semibold text-uppercase">Total Buku</div>
                                <div class="h1 fw-bold text-dark mt-1 mb-0">{{ number_format($totalBooks ?? 0) }}</div>
                                <span class="text-muted small">Katalog aktif di toko</span>
                            </div>
                            <div class="kpi-icon-box bg-primary-lt text-primary">
                                <i class="fa-solid fa-book"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card kpi-card h-100">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <div class="text-muted small fw-semibold text-uppercase">Kategori Buku</div>
                                <div class="h1 fw-bold text-dark mt-1 mb-0">{{ number_format($totalCategories ?? 0) }}</div>
                                <span class="text-muted small">Kelompok genre & topik</span>
                            </div>
                            <div class="kpi-icon-box bg-success-lt text-success">
                                <i class="fa-solid fa-layer-group"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card kpi-card h-100">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <div class="text-muted small fw-semibold text-uppercase">Paket Langganan</div>
                                <div class="h1 fw-bold text-dark mt-1 mb-0">{{ number_format($totalSubscriptions ?? 0) }}
                                </div>
                                <span class="text-muted small">Opsi akses berlangganan</span>
                            </div>
                            <div class="kpi-icon-box bg-warning-lt text-warning">
                                <i class="fa-solid fa-crown"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card kpi-card h-100">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <div class="text-muted small fw-semibold text-uppercase">Buku Gratis</div>
                                <div class="h1 fw-bold text-dark mt-1 mb-0">{{ number_format($freeBooksCount ?? 0) }}</div>
                                <span class="text-muted small">Harga Rp 0 / promo</span>
                            </div>
                            <div class="kpi-icon-box bg-info-lt text-info">
                                <i class="fa-solid fa-gift"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Chart & Tabel Buku Terbaru --}}
            <div class="row g-4">
                <div class="col-lg-5">
                    <div class="card admin-panel-card h-100">
                        <div class="card-header border-0 pb-0">
                            <h3 class="card-title fw-bold mb-0">Buku per Kategori</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="booksByCategoryChart" height="240"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="card admin-panel-card h-100">
                        <div class="card-header border-0 pb-0 d-flex align-items-center justify-content-between">
                            <h3 class="card-title fw-bold mb-0">Buku Terbaru</h3>
                            <a href="{{ route('admin.books.index') }}" class="btn btn-sm btn-outline-primary rounded-3">
                                Lihat Semua
                            </a>
                        </div>
                        <div class="card-body p-0 mt-3">
                            <div class="table-responsive">
                                <table class="table table-vcenter table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Buku</th>
                                            <th>Kategori</th>
                                            <th>Harga</th>
                                            <th class="text-end">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($recentBooks ?? [] as $item)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        @if ($item->cover)
                                                            <img src="{{ asset($item->cover) }}" alt="{{ $item->title }}"
                                                                class="book-thumb-mini">
                                                        @else
                                                            <div
                                                                class="book-thumb-mini bg-light d-flex align-items-center justify-content-center text-muted small">
                                                                N/A
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <div class="fw-semibold text-dark">{{ $item->title }}</div>
                                                            <div class="text-muted small">{{ $item->writer }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-secondary-lt text-secondary">
                                                        {{ $item->bookCategory->name ?? '-' }}
                                                    </span>
                                                </td>
                                                <td class="fw-semibold">
                                                    @if ((int) $item->price === 0)
                                                        <span class="text-success">Gratis</span>
                                                    @else
                                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                                    @endif
                                                </td>
                                                <td class="text-end">
                                                    <a href="{{ route('admin.books.edit', $item->id) }}"
                                                        class="btn btn-sm btn-outline-warning rounded-3">
                                                        Edit
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-4">
                                                    Belum ada data buku.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('booksByCategoryChart');
            if (!canvas) return;

            const labels = @json($categoryChartLabels ?? ['Umum']);
            const data = @json($categoryChartData ?? [0]);

            new Chart(canvas, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        borderWidth: 1,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        });
    </script>
@endpush
