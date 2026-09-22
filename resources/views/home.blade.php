@extends('layouts.app')

@push('styles')
    <style>
        .slick-prev:before,
        .slick-next:before {
            color: black;
        }

        #wrapper-slider .card-body>img {
            width: 75%;
            height: 280px;
            object-fit: cover;
        }
    </style>
@endpush

@section('content')
    {{-- Banner --}}
    <div class="container" py-4>
        <div id="carousel-sample" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carousel-sample" data-bs-slide-to="0" aria-label="Slide 1"
                    aria-current="true" class="active"></button>
                <button type="button" data-bs-target="#carousel-sample" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carousel-sample" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100 mx-auto" alt="World Book Day 1"
                        src="https://img.magnific.com/free-vector/hand-drawn-world-book-day-horizontal-banner-template_23-2149330358.jpg?semt=ais_hybrid&w=740&q=80" />
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100 mx-auto" alt="World Book Day 2"
                        src="https://img.magnific.com/free-vector/realistic-world-book-day-horizontal-banner-template_23-2149334931.jpg?semt=ais_hybrid&w=740&q=80" />
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100 mx-auto" alt="World Book Day 3"
                        src="https://img.magnific.com/free-vector/flat-world-book-day-sale-horizontal-banner-template_23-2149330816.jpg?semt=ais_hybrid&w=740&q=80" />
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

        {{-- paket langganan --}}
        <div class="container mt-4">
            <!-- Judul Paket Langganan (Cukup satu kali di atas) -->
            <div class="d-flex align-items-center gap-2 mb-4">
                <span class="badge bg-yellow text-yellow-fg p-2"><i class="fa-solid fa-crown fs-3"></i></span>
                <h2 class="m-0 text-dark">Paket Langganan</h2>
            </div>

            <!-- Kontainer Baris (Semua kartu ditaruh di dalam satu ROW ini agar sejajar) -->
            <div class="row g-4">

                <!-- KARTU 1 -->
                <div class="col-md-4">
                    <div class="card h-100"
                        style="background: linear-gradient(135deg, #ffffff 0%, #f0fdf4 0%, #aef5c7 100%);">
                        <div class="card-body text-center text-dark d-flex flex-column justify-content-center py-4">
                            <h2 style="font-weight: bold;">NON-FICTION</h2>
                            <p class="text-secondary mb-3" style="font-weight: bold;">PACKAGE</p>
                            <div>
                                Rp <span style="font-size: 2rem; font-weight: bold;" class="text-warning">49.000</span>
                                <br>
                                <span class="text-secondary" style="font-weight: bold;">/30 days</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KARTU 2 -->
                <div class="col-md-4">
                    <div class="card h-100"
                        style="background: linear-gradient(135deg, #ffffff 0%, #f0f9ff 0%, #a4d1ef 100%);">
                        <div class="card-body text-center text-dark d-flex flex-column justify-content-center py-4">
                            <h2 style="font-weight: bold;">FICTION</h2>
                            <p class="text-secondary mb-3" style="font-weight: bold;">PACKAGE</p>
                            <div>
                                Rp <span style="font-size: 2rem; font-weight: bold;" class="text-warning">79.000</span>
                                <br>
                                <span class="text-secondary" style="font-weight: bold;">/30 days</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KARTU 3 -->
                <div class="col-md-4">
                    <div class="card h-100"
                        style="background: linear-gradient(135deg, #ffffff 0%, #fefcf0 0%, #ebd372 100%);">
                        <div class="card-body text-center text-dark d-flex flex-column justify-content-center py-4">
                            <h2 style="font-weight: bold;">PREMIUM</h2>
                            <p class="text-secondary mb-3" style="font-weight: bold;">PACKAGE</p>
                            <div>
                                Rp <span style="font-size: 2rem; font-weight: bold;" class="text-warning">87.000</span>
                                <br>
                                <span class="text-secondary" style="font-weight: bold;">/30 days</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>




        {{-- buku dirilis --}}
        <div class="mt-3">
            <div class="d-flex align-items-center gap-2 mb-2">
                <h2 class="text-dark mt-3" style="font-weight: bold;">Buku Baru Dirilis</h2>
            </div>
            <div id="wrapper-slider">
                <div class="px-2">
                    <div class="card">
                        <div class="card-body">
                            <img src="https://image.gramedia.net/rs:fit:256:0/f:webp/plain/https://cdn.gramedia.com/uploads/product-metas/t0-eee-l7x.jpg"
                                class="d-block mx-auto w-75 h-56" alt="">
                            <div class="d-flex gap-2 mt-2">
                                <p class="badge"><i class="fa-solid fa-mobile"></i>PDF</p>
                                <p class="badge"></p>
                            </div>
                            <div>
                                <h2><span style="font-size: 0,8rem"></span></h2>
                                <br><span style="font-size: 3rem;"></span>
                                </h2>
                                <h4 style="font-size: 1.2rem; font-weight: bold;">Rp. 74.500</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-2">
                    <div class="card">
                        <div class="card-body">
                            <img src="https://image.gramedia.net/rs:fit:256:0/f:webp/plain/https://cdn.gramedia.com/uploads/product-metas/11zb4i2-ea.png"
                                class="d-block mx-auto w-75 h-56" alt="">
                            <div class="d-flex gap-2 mt-2">
                                <p class="badge"><i class="fa-solid fa-mobile"></i>PDF</p>
                                <p class="badge"></p>
                            </div>
                            <div>
                                <h2><span style="font-size: 0,8rem"></span></h2>
                                <br><span style="font-size: 3rem;"></span>
                                </h2>
                                <h4 style="font-size: 1.2rem; font-weight: bold;">Rp. 100.000</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-2">
                    <div class="card">
                        <div class="card-body">
                            <img src="https://image.gramedia.net/rs:fit:256:0/f:webp/plain/https://cdn.gramedia.com/uploads/items/9786020633176_.Atomic_Habit.jpg"
                                class="d-block mx-auto w-75 h-56" alt="">
                            <div class="d-flex gap-2 mt-2">
                                <p class="badge"><i class="fa-solid fa-mobile"></i>PDF</p>
                                <p class="badge"></p>
                            </div>
                            <div>
                                <h2><span style="font-size: 0,8rem"></span></h2>
                                <br><span style="font-size: 3rem;"></span>
                                </h2>
                                <h4 style="font-size: 1.2rem; font-weight: bold;">Rp. 90.000</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-2">
                    <div class="card">
                        <div class="card-body">
                            <img src="https://image.gramedia.net/rs:fit:256:0/f:webp/plain/https://cdn.gramedia.com/uploads/items/9786020366517_Cantik-Itu-Luka-Hard-Cover---Limited-Edition.jpg"
                                class="d-block mx-auto w-75 h-56" alt="">
                            <div class="d-flex gap-2 mt-2">
                                <p class="badge"><i class="fa-solid fa-mobile"></i>PDF</p>
                                <p class="badge"></p>
                            </div>
                            <div>
                                <h2><span style="font-size: 0,8rem"></span></h2>
                                <br><span style="font-size: 3rem;"></span>
                                </h2>
                                <h4 style="font-size: 1.2rem; font-weight: bold;">Rp. 90.000</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-2">
                    <div class="card">
                        <div class="card-body">
                            <img src="https://image.gramedia.net/rs:fit:256:0/f:webp/plain/https://cdn.gramedia.com/uploads/picture_meta/2023/7/21/kvfvqfp3u7eja6g2xzzrui.jpg"
                                class="d-block mx-auto w-75 h-56" alt="">
                            <div class="d-flex gap-2 mt-2">
                                <p class="badge"><i class="fa-solid fa-mobile"></i>PDF</p>
                                <p class="badge"></p>
                            </div>
                            <div>
                                <h2><span style="font-size: 0,8rem"></span></h2>kariime
                                <br><span style="font-size: 3rem;"></span>
                                </h2>
                                <h4 style="font-size: 1.2rem; font-weight: bold;">Rp. 60.500</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-2">
                    <div class="card">
                        <div class="card-body">
                            <img src="https://image.gramedia.net/rs:fit:256:0/f:webp/plain/https://cdn.gramedia.com/uploads/items/milea_aUf00jx.jpg"
                                class="d-block mx-auto w-75 h-56" alt="">
                            <div class="d-flex gap-2 mt-2">
                                <p class="badge"><i class="fa-solid fa-mobile"></i>PDF</p>
                                <p class="badge"></p>
                            </div>
                            <div>
                                <h2><span style="font-size: 0,8rem"></span></h2>
                                <br><span style="font-size: 3rem;"></span>
                                </h2>
                                <h4 style="font-size: 1.2rem; font-weight: bold;">Rp. 90.000</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-2">
                    <div class="card">
                        <div class="card-body">
                            <img src="https://image.gramedia.net/rs:fit:256:0/f:webp/plain/https://cdn.gramedia.com/uploads/items/9786020318929_Critical-Eleven.jpg"
                                class="d-block mx-auto w-75 h-56" alt="">
                            <div class="d-flex gap-2 mt-2">
                                <p class="badge"><i class="fa-solid fa-mobile"></i>PDF</p>
                                <p class="badge"></p>
                            </div>
                            <div>
                                <h2><span style="font-size: 0,8rem"></span></h2>
                                <br><span style="font-size: 3rem;"></span>
                                </h2>
                                <h4 style="font-size: 1.2rem; font-weight: bold;">Rp. 75.400</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- free book --}}
            <div class="mt-4"></div>
            <div class="d-flex align-items-center gap-2 mb-4">
                <h2 class="mt-3 text-dark" style="font-weight: bold">Free Books</h2>
            </div>

            <!-- PERBAIKAN: Ditambahkan 'g-4' di class row agar ada jarak antar kartu -->
            <div class="row g-4">

                {{-- book1 --}}
                <div class="col-4">
                    <div class="card d-flex flex-column h-100">
                        <div class="row row-0 flex-fill">
                            <div class="col-md-4">
                                <a href="#">
                                    <img src="https://image.gramedia.net/rs:fit:256:0/f:webp/plain/https://cdn.gramedia.com/uploads/items/HARGA_SEBUAH_PERCAYA.jpg"
                                        alt="gambar buku">
                                </a>
                            </div>
                            <div class="col">
                                <div class="card-body h-full d-flex flex-column">
                                    <h3 class="card-title">
                                        <div class="badge">
                                            <i class="fa-solid fa-mobile"></i>PDF
                                        </div>
                                    </h3>
                                    <div class="text-secondary">Riikma .R
                                        <br><span class="text-dark">Diantara Ada dan Tiada</span>
                                    </div>
                                    <div class="d-flex align-items-center pt-4 mt-auto">
                                        <h3>
                                            <span class="text-decoration-line-through text-secondary">Rp. 23.200</span>
                                            <span class="text-success">Free</span>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- book2 --}}
                <div class="col-4">
                    <div class="card d-flex flex-column h-100">
                        <div class="row row-0 flex-fill">
                            <div class="col-md-4">
                                <a href="#">
                                    <img src="https://image.gramedia.net/rs:fit:256:0/f:webp/plain/https://cdn.gramedia.com/uploads/items/Mengapa_Luka_Tidak_Memaafkan_Pisau.jpeg"
                                        alt="gambar buku">
                                </a>
                            </div>
                            <div class="col">
                                <div class="card-body h-full d-flex flex-column">
                                    <h3 class="card-title">
                                        <div class="badge">
                                            <i class="fa-solid fa-mobile"></i>PDF
                                        </div>
                                    </h3>
                                    <div class="text-secondary">Kariim .F .R
                                        <br><span class="text-dark">Lanjut Usia</span>
                                    </div>
                                    <div class="d-flex align-items-center pt-4 mt-auto">
                                        <h3>
                                            <span class="text-decoration-line-through text-secondary">Rp. 19.400</span>
                                            <span class="text-success">Free</span>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- book3 --}}
                <div class="col-4">
                    <div class="card d-flex flex-column h-100">
                        <div class="row row-0 flex-fill">
                            <div class="col-md-4">
                                <a href="#">
                                    <img src="https://image.gramedia.net/rs:fit:256:0/f:webp/plain/https://cdn.gramedia.com/uploads/items/REMBULAN_TENGGELAM_DIWAJAHMU.jpg"
                                        alt="gambar buku">
                                </a>
                            </div>
                            <div class="col">
                                <div class="card-body h-full d-flex flex-column">
                                    <h3 class="card-title">
                                        <div class="badge">
                                            <i class="fa-solid fa-mobile"></i>PDF
                                        </div>
                                    </h3>
                                    <div class="text-secondary">Miirka .R .F
                                        <br><span class="text-dark">Tak Selamanya Ada</span>
                                    </div>
                                    <div class="d-flex align-items-center pt-4 mt-auto">
                                        <h3>
                                            <span class="text-decoration-line-through text-secondary">Rp. 20.000</span>
                                            <span class="text-success">Free</span>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- book4 --}}
                <div class="col-4">
                    <div class="card d-flex flex-column h-100">
                        <div class="row row-0 flex-fill">
                            <div class="col-md-4">
                                <a href="#">
                                    <img src="https://image.gramedia.net/rs:fit:256:0/f:webp/plain/https://cdn.gramedia.com/uploads/items/9786020656069_Sang_Alkemis_cov.jpg"
                                        alt="gambar buku">
                                </a>
                            </div>
                            <div class="col">
                                <div class="card-body h-full d-flex flex-column">
                                    <h3 class="card-title">
                                        <div class="badge">
                                            <i class="fa-solid fa-mobile"></i>PDF
                                        </div>
                                    </h3>
                                    <div class="text-secondary">Kiirma .F .R
                                        <br><span class="text-dark">Pergi dan Sepi</span>
                                    </div>
                                    <div class="d-flex align-items-center pt-4 mt-auto">
                                        <h3>
                                            <span class="text-decoration-line-through text-secondary">Rp. 20.500</span>
                                            <span class="text-success">Free</span>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- book5 --}}
                <div class="col-4">
                    <div class="card d-flex flex-column h-100">
                        <div class="row row-0 flex-fill">
                            <div class="col-md-4">
                                <a href="#">
                                    <img src="https://image.gramedia.net/rs:fit:256:0/f:webp/plain/https://cdn.gramedia.com/uploads/items/9786020656069_Sang_Alkemis_cov.jpg"
                                        alt="gambar buku">
                                </a>
                            </div>
                            <div class="col">
                                <div class="card-body h-full d-flex flex-column">
                                    <h3 class="card-title">
                                        <div class="badge">
                                            <i class="fa-solid fa-mobile"></i>PDF
                                        </div>
                                    </h3>
                                    <div class="text-secondary">Irkaam .R .R
                                        <br><span class="text-dark">Tak Lagi Rindu</span>
                                    </div>
                                    <div class="d-flex align-items-center pt-4 mt-auto">
                                        <h3>
                                            <span class="text-decoration-line-through text-secondary">Rp. 30.500</span>
                                            <span class="text-success">Free</span>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- book6 --}}
                <div class="col-4">
                    <div class="card d-flex flex-column h-100">
                        <div class="row row-0 flex-fill">
                            <div class="col-md-4">
                                <a href="#">
                                    <img src="https://image.gramedia.net/rs:fit:256:0/f:webp/plain/https://cdn.gramedia.com/uploads/items/9786020656069_Sang_Alkemis_cov.jpg"
                                        alt="gambar buku">
                                </a>
                            </div>
                            <div class="col">
                                <div class="card-body h-full d-flex flex-column">
                                    <h3 class="card-title">
                                        <div class="badge">
                                            <i class="fa-solid fa-mobile"></i>PDF
                                        </div>
                                    </h3>
                                    <div class="text-secondary">Riikam .F .R
                                        <br><span class="text-dark">Hanya Kamu Yang Ku Cinta</span>
                                    </div>
                                    <div class="d-flex align-items-center pt-4 mt-auto">
                                        <h3>
                                            <span class="text-decoration-line-through text-secondary">Rp. 33.400</span>
                                            <span class="text-success">Free</span>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    @endsection

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#wrapper-slider').slick({
                    dots: true,
                    infinite: false,
                    speed: 300,
                    slidesToShow: 4,
                    slidesToScroll: 4,
                    responsive: [{
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 3,
                                infinite: true,
                                dots: true
                            }
                        },
                        {
                            breakpoint: 600,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                });
            });
        </script>
    @endpush
