@extends('layouts.customer')

@section('title', 'Registrasi')

@section('content')
<!-- Body Wrapper -->
<div class="position-relative overflow-hidden min-vh-100 d-flex align-items-center justify-content-center">
    <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
            <div class="card-body">
                <span class="text-nowrap logo-img text-center d-block py-4 w-100">
                    <img src="{{ asset('assets/images/logos/logo.png') }}" width="60" alt="TEFA Politeknik Astra">
                </span>
                <h5 class="text-center"><b>TEACHING FACTORY<br />MESIN OTOMOTIF</b></h5>
                <p class="text-center">
                    Proses praktik perbaikan kendaraan Mahasiswa Mesin Otomotif
                </p>
                @if (session('ErrorMessage'))
                <div class="alert alert-danger" role="alert">
                    {{ session('ErrorMessage') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <form action="{{ route('authentication.register.process') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" required>
                        <div id="emailHelp" class="form-text">Contoh: email@gmail.com</div>
                        @error('Email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap Anda</label>
                        <input type="text" class="form-control" id="name" name="name" aria-describedby="fullNameHelp" required>
                        @error('Name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">No Telepon/Whatsapp</label>
                        <input type="number" class="form-control" id="phone" name="phone" aria-describedby="phoneNumberHelp" required>
                        <div id="phoneNumberHelp" class="form-text">Contoh: 08123456789</div>
                        @error('Phone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="address" class="form-label">Alamat Lengkap</label>
                        <textarea class="form-control" id="address" name="address" aria-describedby="addressHelp" required></textarea>
                        @error('Address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm w-100 py-2 fs-4 mb-4 rounded-2">
                        Daftar
                    </button>
                    <div class="d-flex align-items-center justify-content-center">
                        <p class="fs-4 mb-0 fw-bold">Sudah memiliki akun?</p>
                        <a class="text-primary fw-bold ms-2" href="{{ route('authentication.login.form') }}">Login disini.</a>
                    </div>
                </form>
            </div>
            <p class="text-center mt-5">
                <b>{{ now()->format('d F Y - H:i') }}</b>
            </p>
        </div>
    </div>
</div>
@endsection