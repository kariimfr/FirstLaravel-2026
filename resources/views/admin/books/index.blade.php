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
            <h3>Data Buku</h3>
            <a href="{{ route('admin.books.create') }}" class="btn btn-primary">Tambah Buku</a>
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
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>


    {{-- Model Detail --}}


    <div class="modal modal-blur-fade" id="modalDetailBook" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Informasi Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        {{-- column cover --}}
                        <div class="col-md-4 text-center mb-3 mb-md-0">
                            <img id="detail-cover" src="" alt="Cover buku"
                                class="rounded shadow-sm border img-fluid"
                                style="max-height: 250px; width: 100px; object-fit: cover;">
                        </div>


                        {{-- column info --}}
                        <div class="col-md-8">
                            <h3 id="detail-title" class="mb-1 text-primary fu-bold"></h3>
                            <div class="mb-3">
                                <span id="detail-category" class="badge bg-blue-lt"></span>
                            </div>


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="pt-2">Harga</div>
                                    <div class="text-success fu-bold" id="detail-price"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="pt-2">Penulis</div>
                                    <div class="" id="detail-writer"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="pt-2">Penerbit</div>
                                    <div class="" id="detail-publisher"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="pt-2">Bahasa</div>
                                    <div class="" id="detail-language"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="pt-2">Tanggal Rilis</div>
                                    <div class="" id="detail-release"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="pt-2">Jumlah Halaman</div>
                                    <div class="" id="detail-pages"></div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-3">
                        <div class="my-3">
                            <h4 class="subheader mb-2">Deskripsi Buku</h4>
                            <div id="detail-description" class="p-3 bg-body-tertiary rounded-border"
                                style="max-height: 200px; overflow-y: auto">
                                <span class="text-secondary">tidak ada deskripsi</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary me-auto"
                        data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
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
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },

                ]
            });
            $('#books-table').on('click', '.btn-detail', function() {
                const btn = $(this);


                const cover = btn.attr('data-cover') || '-';
                const title = btn.attr('data-title') || '-';
                const category = btn.attr('data-category') || '-';
                const price = btn.attr('data-price') || '-';
                const writer = btn.attr('data-writer') || '-';
                const publisher = btn.attr('data-publisher') || '-';
                const language = btn.attr('data-language') || '-';
                const release = btn.attr('data-release') || '-';
                const pages = btn.attr('data-pages') || '-';
                const description = btn.attr('data-description') || '';


                $('#detail-cover').attr('src', cover);
                $('#detail-title').text(title);
                $('#detail-category').text(category);
                $('#detail-price').text(price);
                $('#detail-writer').text(writer);
                $('#detail-publisher').text(publisher);
                $('#detail-language').text(language);
                $('#detail-release').text(release);
                $('#detail-pages').text(pages === '-' ? '-' : pages + ' Halaman');
                $('#detail-description').html(description || 'Tidak ada deskripsi');

                const modalElement = document.getElementById('modalDetailBook');
                $(modalElement).modal('show');
            })
        });
    </script>
@endpush
