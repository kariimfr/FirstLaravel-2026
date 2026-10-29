@extends('layouts.app')

@section('content')
    <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data"
        class="w-75 d-block mx-auto mt-5">
        @csrf
        {{-- error ()pengganti error  --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $errors)
                        <li>{{ $errors }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card">
            <div class="card-header">
                <h3>Tambah Data Buku</h3>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-6">
                        <label for="book_category_id" class="form-label">Kategori Buku</label>
                        <select name="book_category_id" id="book_category_id" class="form-select">
                            <option selected hidden disabled>Pilih</option>
                            {{-- memunculkan data kategori dari controller ::all --}}
                            @foreach ($bookCategories as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="title" class="form-label">Judul</label>
                        <input type="text" name="title" id="title" class="form-control">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <label for="writer" class="form-label">Penulis</label>
                        <input type="text" name="writer" id="writer" class="form-control">
                    </div>
                    <div class="col-6">
                        <label for="publisher" class="form-label">Penerbit</label>
                        <input type="text" name="publisher" id="publisher" class="form-control">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <label for="release_date" class="form-label">Tanggal Rilis</label>
                        <input type="date" name="release_date" id="release_date" class="form-control">
                    </div>
                    <div class="col-6">
                        <label for="page_of_book" class="form-label">Jumlah Halaman</label>
                        <input type="number" name="page_of_book" id="page_of_book" class="form-control">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <label for="price" class="form-label">Harga</label>
                        <input type="number" name="price" id="price" class="form-control">
                    </div>
                    <div class="col-6">
                        <label for="language" class="form-label">Bahasa yang digunakan</label>
                        <input type="text" name="language" id="language" class="form-control">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <label for="cover" class="form-label">Sampul Buku</label>
                        <input type="file" name="cover" id="cover" class="form-control">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <label for="cover" class="form-label">Deskripsi</label>
                        <div id="editor"></div>
                        {{-- input yang di sembunyikan untuk menyimpan niali dari deskripsi ayng di quill js --}}
                        <input type="hidden" name="description" id="description">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" style="margin-top: 10%">Kirim</button>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        const quill = new Quill('#editor', {
            theme: 'snow'
        });

        // menyimpan nilai dari quiil ke input deskripsi 
        document.getElementById('description').value = quill.root.innerHTML;
        quill.on('text-change', function() {
            document.getElementById('description').value = quill.root.innerHTML;
        });
    </script>
@endpush
