@extends('layouts.app') {{-- Sesuaikan nama master layout Anda --}}

@section('content')
    <div class="page-header d-print-none my-3">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title fw-bold">
                        Pembayaran
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">

                {{-- Bagian Kiri: QR Code Pembayaran --}}
                <div class="col-lg-8">
                    <div class="card card-lg">
                        <div class="card-body text-center py-4">
                            <h3 class="card-title fw-bold fs-2 mb-1">
                                Scan QR Code
                            </h3>
                            <p class="text-secondary mb-4">
                                Gunakan aplikasi e-wallet atau m-banking Anda untuk memindai kode di bawah ini
                            </p>
                        </div>
                    </div>

                    {{-- Container QR Code --}}
                    <div
                        class="d-flex justify-content-center align-items-center my-3 p-3 bg-light rounded-3 border d-inline-block">
                        {!! QrCode::size(250)->generate($code) !!}
                    </div>

                    <p class="text-secondary small mt-3 mb-0">
                        <i class="ti ti-info-circle me-1"></i>
                        QR Code ini berlaku untuk semua pembayaran QRIS (Gopay, OVO, Dana, ShopeePay, BCA, Mandiri, dll).
                    </p>
                </div>

                {{-- Bagian Kanan: Ringkasan Total Pembayaran --}}
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">

                            {{-- Collapse Detail (Show detail) --}}
                            <div class="mb-3">
                                <a class="text-decoration-none text-body fw-medium d-flex align-items-center justify-content-between"
                                    data-bs-toggle="collapse" href="#collapseDetails" role="button" aria-expanded="true"
                                    aria-controls="collapseDetails">

                                    <span>Detail Pesanan</span>
                                    <i class="ti ti-chevron-down"></i>
                                </a>
                            </div>

                            <div class="collapse show" id="collapseDetails">
                                <div class="d-flex justify-content-between text-secondary mb-2">
                                    <span>Total Item</span>
                                    <span>1</span>
                                </div>

                                <div class="d-flex justify-content-between fw-bold mb-1">
                                    <span>Sub Total</span>
                                    <span></span>
                                </div>

                                <div class="d-flex justify-content-between text-secondary mb-1 ps-2">
                                    <span>Total Belanja</span>
                                    <span>
                                        Rp {{ number_format($subscriptionPackage->price, 0, '', '.') }}
                                    </span>
                                </div>

                                <div class="d-flex justify-content-between text-danger mb-3 ps-2">
                                    <span>Diskon</span>
                                    <span>
                                        -Rp {{ number_format($subscriptionPackage->price * 0.2, 0, ',', '.') }}
                                    </span>
                                </div>

                                <hr class="my-2">
                            </div>

                            <div class="d-flex justify-content-between align-items-center my-3">
                                <span class="fs-3 fw-bold">Total Bayar</span>

                                <span class="fs-2 fw-bold text-primary">
                                    Rp {{ number_format($subscriptionPackage->price, 0, ',', '.') }}
                                </span>
                            </div>

                            <form action="{{ route('subscription.checkout', $subscriptionPackage->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary w-100 py-2 fs-3 fw-bold rounded-pill">
                                    Bayar Sekarang
                                </button>
                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
