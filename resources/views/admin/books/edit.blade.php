@extends('layouts.app')

@section('content')
    <form action="{{ route('admin.books.update', $book->id) }}" method="POST" enctype="multipart/form-data"
        class="card w-75 d-block mx-auto mt-5">
        @csrf
        @method('PUT')
        {{-- memunculkan error sekaligus (pengganti @error) --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card-header">
            <h3>Edit Data Buku</h3>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-6">
                    <label for="book_category_id" class="form-label">Kategori Buku</label>
                    <select name="book_category_id" id="book_category_id" class="form-select">
                        <option value="" disabled>Pilih Kategori Buku</option>
                        {{-- memunculkan data kategori yang dari controller ::all --}}
                        @foreach ($bookCategories as $item)
                            <option value="{{ $item->id }}" @selected(old('book_category_id', $book->book_category_id) == $item->id)>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('book_category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-6">
                    <label for="title" class="form-label">Judul Buku</label>
                    <input type="text" name="title" id="title" class="form-control"
                        value="{{ old('title', $book->title) }}">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <label for="writer" class="form-label">Penulis</label>
                    <input type="text" name="writer" id="writer" class="form-control"
                        value="{{ old('writer', $book->writer) }}">
                    @error('writer')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                </div>
                <div class="col-6">
                    <label for="publisher" class="form-label">Penerbit</label>
                    <input type="text" name="publisher" id="publisher" class="form-control"
                        value="{{ old('publisher', $book->publisher) }}">
                    @error('publisher')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <label for="release_date" class="form-label">Tanggal Rilis</label>
                    <input type="date" name="release_date" id="release_date" class="form-control"
                        value="{{ old('release_date', $book->release_date) }}">
                    @error('release_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-6">
                    <label for="page_of_book" class="form-label">Jumlah Halaman</label>
                    <input type="number" name="page_of_book" id="page_of_book" class="form-control"
                        value="{{ old('page_of_book', $book->page_of_book) }}">
                    @error('page_of_book')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <label for="price" class="form-label">Harga</label>
                    <input type="number" name="price" id="price" class="form-control"
                        value="{{ old('price', $book->price) }}">
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-6">
                    <label for="language" class="form-label">Bahasa yang Digunakan</label>
                    <input type="text" name="language" id="language" class="form-control"
                        value="{{ old('language', $book->language) }}">
                    @error('language')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
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
                    <label for="description" class="form-label">Deskripsi</label>
                    <div id="editor"></div>
                    {{-- input yang disembunyikan untuk menyimpan nilai dari deskripsi yang
                di quilljs --}}
                    <input type="hidden" name="description" id="description"
                        value="{{ old('description', $book->description) }}">
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="d-flex justify-content-between mt-3">
                <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        const quill = new Quill('#editor', {
            theme: 'snow'
        });
        const description = document.getElementById('description');
        quill.clipboard.dangerouslyPasteHTML(description.value);
        // ketika isi di quill berubah, maka ubah juga isi input descriptionnya
        quill.on('text-change', function() {
            description.value = quill.root.innerHTML;
        });
    </script>
@endpush
