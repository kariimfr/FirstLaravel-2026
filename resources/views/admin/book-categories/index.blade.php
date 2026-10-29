@extends('layouts.app')

@section('content')
    <div class="container-fluid">
    </div>
    <div class="container mt-5">

        {{-- succses --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Kategori Buku</h1>
            <a href="{{ route('admin.book-categories.create') }}" class="btn btn-primary">Tambah Data</a>
        </div>

        <div class="card">
            <div class="card-body">
                {{-- TAMBAHKAN id="book-categories-table" DI SINI --}}
                <table class="table table-bordered table-responsive bg-white" id="book-categories-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach dihapus karena data dimuat otomatis via AJAX DataTables --}}
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#book-categories-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.book-categories.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endpush
