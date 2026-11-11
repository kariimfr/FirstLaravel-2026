@extends('layouts.app')


@section('content')
    <div class="container my-5">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="d-flex justify-content-between">
            <h3>Data Buku untuk paket {{ $subscriptionPackage->name_package }}</h3>
        </div>


        <table class="table table-bordered mt-5" id="books-table">
            <thead>
                <tr>
                    <th></th>
                    <th>Sampul Buku</th>
                    <th>Judul</th>
                    <th>Kategori Buku</th>
                    <th>Penulis</th>
                    <th>harga</th>
                </tr>
            </thead>
        </table>
    </div>


    {{-- Model Detail --}}

@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            const table = $('#books-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.books.index') }}",
                columns: [{
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
                        name: 'category_name'
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
        });
    </script>
@endpush
