@extends('layouts.customer')

@section('title', 'Login')

@section('content')
<!--  Body Wrapper -->
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
                <form action="{{ route('authentication.login.process') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" required>
                        <div id="emailHelp" class="form-text">Contoh: email@gmail.com</div>
                        <span class="text-danger">@error('Email') {{ $message }} @enderror</span>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm w-100 py-2 fs-4 mb-4 rounded-2">
                        Login
                    </button>
                    <div class="d-flex align-items-center justify-content-center">
                        <p class="fs-4 mb-0 fw-bold">Belum punya akun?</p>
                        <a class="text-primary fw-bold ms-2" href="{{ route('authentication.register.form') }}">Daftar disini.</a>
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