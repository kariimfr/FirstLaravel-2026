@extends('layouts.app')
@section('content')
    <div class="w-50 mx-auto mt-5">
        <form action="{{ route('register.store') }}" method="POST" class="form-fieldast bg-white">

            {{-- csrf adalah untuk megenerate token setiap form yang akan 
               di proses. sebagai antisipasi adanya serangan csfr --}}

            @csrf
            <h2 class="text-center my-3">Create Akun</h2>
            <div class="mb-3">
                <label class="form-label required" for="#">Full Name</label>

                <input type="text" name="name" placeholder="kariim Faidlurrahman"
                    class="form-control @error('name')
            is-invalid @enderror" autocomplete="off" />

                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label required" for="#">Email</label>
                <input type="text" name="email" placeholder="example@gmail.com"
                    class="form-control @error('email')
            is-invalid @enderror" autocomplete="off" />

                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

            </div>

            <div class="mb-3">
                <label class="form-label required" for="">Password</label>
                <input type="password" name="password" placeholder="- - - - - - - -"
                    class="form-control @error('password')
            is-invalid @enderror" autocomplete="off" />

                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary w-100">Daftar</button>
        </form>
    </div>
@endsection
