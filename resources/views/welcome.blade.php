@extends('layout.app')

@section('content')
    <header class="navbar navbar-expand-md d-print-none">
        <div class="container-xl">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
                aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- BEGIN NAVBAR LOGO -->
            <a href="#" aria-label="Tabler" class="navbar-brand navbar-brand-autodark me-3">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTOCvNa3r_hszq7pPtvOQKKYOepdqMsD5tJapqoyZoiAA&s=10"
                    width="110" height="32" class="navbar-brand-image">Ebooks
            </a>

            <!-- END NAVBAR LOGO -->
            <div class="navbar-nav mx-auto w-50">
                {{-- Dropdown --}}
                <div class="dropdown mt-2">
                    <a href="#" class="btn btn-light dropdown-toggle pt-2 me-2" data-bs-toggle="dropdown">Kategori</a>
                    <div class="dropdown-menu dropdown-menu-card" style="min-width: 600px">
                        <div class="p-3">
                            <div class="row g-2">
                                <div class="col-3">
                                    <div class="card py-2">
                                        <div class="card-body py-2 text-center">Kategori 1</div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="card py-2">
                                        <div class="card-body py-2 text-center">Kategori 2</div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="card py-2">
                                        <div class="card-body py-2 text-center">Kategori 3</div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="card py-2">
                                        <div class="card-body py-2 text-center">Kategori 4</div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="card py-2">
                                        <div class="card-body py-2 text-center">Kategori 5</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Search bar --}}
                <div class="input-icon w-100 py-2">
                    <input type="text" value class="form-control form-control-rounded"
                        placeholder="Cari Judul, produk, buku, penulis..." />
                    <span class="input-icon-addon">
                        <!-- Download SVG icon from http://tabler.io/icons/icon/search -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" aria-hidden="true" focusable="false" class="icon">
                            <path d="M3 10a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                            <path d="M21 21l-6 -6" />
                        </svg>
                    </span>
                </div>
                {{-- icon keranjang --}}
                <div class="mt-3 ms-2">
                    <i class="fa-solid fa-cart-arrow-down fs-3 text-dark"></i>
                </div>
            </div>
            <div class="flex-row order-md-last ms-auto">
                <a href="" class="btn btn-primary">Login</a>
                <a href="" class="btn btn-light">Daftar</a>
            </div>
        </div>
        </div>
    </header>

    <div class="container py-4">

        <div id="carousel-sample" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carousel-sample" data-bs-slide-to="0" aria-label="Slide 1"
                    aria-current="true" class="active"></button>
                <button type="button" data-bs-target="#carousel-sample" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carousel-sample" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" alt
                        src="https://i.pinimg.com/736x/b0/f1/68/b0f1682b7061f85687cf8ccd277b5f5a.jpg" />
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" alt
                        src="https://i.pinimg.com/736x/81/a6/87/81a687e3ae091cf42b1c438a44e28a87.jpg" />
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" alt
                        src="https://i.pinimg.com/1200x/b4/76/9e/b4769eeae40793ca14f681c931ab683d.jpg" />
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carousel-sample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carousel-sample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
@endsection
