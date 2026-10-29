@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <h2>Hasil Pencarian: "{{ $query }}</h2>
        @if ($books->isEmpty())
            <div class="alert alert-info mt-3">
                Tidak ada buku yang di temukan untuk kata kunci ini <b>"{{ $query }}"</b>
            </div>
        @else
            <div class="row mt-3">
                @foreach ($books as $book)
                    <div class="px-2 col-3">
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
        @endif
    </div>
@endsection
