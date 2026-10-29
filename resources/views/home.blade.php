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
        @if (@session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (@session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
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
            <!-- Judul Paket Langganan -->
            <div class="d-flex align-items-center gap-2 mb-4">
                <span class="badge bg-yellow text-yellow-fg p-2">
                    <i class="fa-solid fa-crown fs-3"></i>
                </span>
                <h2 class="m-0 text-dark">Paket Langganan</h2>
            </div>

            <!-- Kontainer Baris -->
            <div class="row g-4">
                @foreach ($subscriptionPackages as $sp)
                    <!-- KARTU -->
                    <div class="col-md-4">
                        <div class="card h-100"
                            style="background: linear-gradient(135deg, #ffffff 0%, #f0fdf4 0%, #aef5c7 100%);">
                            <div class="card-body text-center text-dark d-flex flex-column justify-content-center py-4">
                                <h2 style="font-weight: bold;">{{ $sp->name_package }}</h2>
                                <p class="text-secondary mb-3" style="font-weight: bold;">PACKAGE</p>
                                <div>
                                    Rp <span style="font-size: 2rem; font-weight: bold;" class="text-warning">
                                        {{ number_format($sp->price, 0, ',', '.') }}
                                    </span>
                                    <br>
                                    <span class="text-secondary" style="font-weight: bold; margin: 0 !important;">/30
                                        days</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        {{-- buku dirilis --}}
        <div class="mt-3">
            <div class="d-flex align-items-center gap-2 mb-2">
                <h2 class="text-dark mt-3" style="font-weight: bold;">Buku Baru Dirilis</h2>
            </div>
            <div id="wrapper-slider">
                @foreach ($latestBooks as $book)
                    <div class="px-2">
                        <div class="card">
                            <div class="card-body">
                                <img src="{{ asset($book->cover) }}" class="d-block mx-auto w-75 h-56" alt="">
                                <div class="d-flex gap-2 mt-2">
                                    <p class="badge"><i class="fa-solid fa-mobile"></i>PDF</p>
                                    <p class="badge"></p>
                                </div>
                                <div>
                                    <h5>
                                        <span style="font-size: 0,8rem">{{ $book['writer'] }}</span>
                                        <br><span style="font-size: 1rem;">{{ $book['title'] }}</span>
                                    </h5>
                                    <h4 style="font-size: 1.2rem; font-weight: bold;">Rp.
                                        {{ number_format($book['price'], 0, ',', '.') }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- free book --}}
            <div class="mt-4"></div>
            <div class="d-flex align-items-center gap-2 mb-4">
                <h2 class="mt-3 text-dark" style="font-weight: bold">Free Books</h2>
            </div>

            <div class="row g-4">

                {{-- book1 --}}
                @foreach ($freeBooks as $free)
                    <div class="col-4">
                        <div class="card d-flex flex-column h-100">
                            <div class="row row-0 flex-fill">
                                <div class="col-md-4">
                                    <a href="#">
                                        <img src="{{ asset($free->cover) }}" alt="gambar buku">
                                    </a>
                                </div>
                                <div class="col">
                                    <div class="card-body h-full d-flex flex-column">
                                        <h3 class="card-title">
                                            <div class="badge">
                                                <i class="fa-solid fa-mobile"></i>PDF
                                            </div>
                                        </h3>
                                        <div class="text-secondary">{{ $free['writer'] }}
                                            <br><span class="text-dark">{{ $free['title'] }}</span>
                                        </div>
                                        <div class="d-flex align-items-center pt-4 mt-auto">
                                            <h3>
                                                <span class="text-decoration-line-through text-secondary">Rp. 00.000</span>
                                                <span class="text-success">Free</span>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
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
