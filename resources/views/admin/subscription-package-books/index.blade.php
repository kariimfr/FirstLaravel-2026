@extends('layouts.app')

@section('content')
    <div class="container my-5">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="d-flex justify-content-between">
            <h3>Data Buku Untuk Paket {{ $subscriptionPackage->name_package }} </h3>
            <form method="POST" action="{{ route('admin.subscription-packages.books.store', $subscriptionPackage->id) }}">
                @csrf
                {{-- input hidden, ada tapi ga di tampilin. unutkk menampung id buk yang dipilih --}}
                {{-- name="book_id[]" di gunakan ketika data yang di kirim lebih dari 1, book_id yang di kirim (di ceklis) nanti boleh lebih dari 1 --}}
                {{--  --}}
                {{-- class="d-none" agar awalanya btn di hilangkan, kalau ada yang di pilih bukunya sama js baru di munculin btn nya --}}
                <div id= "input-wrap">
                    {{-- # --}}
                </div>
                <button type="submit" class="btn btn-outline-primary px-4 py-2 fw-bold rounded-2 d-none" id="btn_book">
                    <i class="bi bi-send-fill me-1"></i>Kirim &nbsp;<span id="jumlah-buku">0</span>&nbsp; Buku
                </button>
        </div>
        <table class="class table table-bordered mt-5" id="books-table">
            <thead>
                <tr>
                    <th>Pilih Buku</th>
                    <th>No</th>
                    <th>Sampul Buku</th>
                    <th>Judul</th>
                    <th>Kategori Buku</th>
                    <th>Penulis</th>
                    <th>Harga</th>
                </tr>
            </thead>
        </table>
    </div>

    {{-- Modal Detail --}}
@endsection
@push('scripts')
    <script>
        $(document.body).ready(function() {
            const table = $('#books-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.subscription-packages.books', $subscriptionPackage->id) }}",
                columns: [{
                        data: 'checkbox',
                        name: 'checkbox',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }, // agar checkbox ada di tengah
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'cover',
                        name: 'cover',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'category_name',
                        name: 'bookCategory'
                    },
                    {
                        data: 'writer',
                        name: 'writer'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                ]
            });

            function updateCheckboxBook() {
                // ambil semua class book-checkbox yang di ceklis (checked)
                const checkedBook = $('.book-checkbox:checked').length;
                // jumlah (length) yang di ceklis di tampilikan ke btn kirim
                $('#jumlah-buku').text(checkedBook);

                // hilang kan d-none jika ada yang pilih
                if (checkedBook > 0) {
                    $("#btn_book").removeClass('d-none');
                } else {
                    $("#btn_book").addClass('d-none');
                }

                const checkboxData = $('.book-checkbox:checked');
                // looping checkbox yang diceklis, untuk membuat input hidden
                checkboxData.each(function() {
                    let value = $(this).val(); // ambil value dari $row->id dari controller
                    //buat inputan dengan value dari controller
                    $("#input-wrap").append(`<input type="hidden" name="book_id[]" value="${value}">`);
                })
            }
            // setiap checkbox ada yang berubah ceklisannya, panggil fn di atas
            $("#books-table tbody").on("change", ".book-checkbox", function() {
                updateCheckboxBook();
            })
        });
    </script>
@endpush
