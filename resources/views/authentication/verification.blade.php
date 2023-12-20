@extends('layouts.customer')

@section('title', 'Verification')

@section('content')
<div class="position-relative overflow-hidden min-vh-100 d-flex align-items-center justify-content-center">
    <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
            <div class="col-lg-4 col-md-6 col-sm-12 border border-1 border p-3 rounded-3 mt-1">
                <div class="card-body">
                    <span class="text-nowrap logo-img text-center d-block py-4 w-100">
                        <img src="{{ asset('assets/images/logos/logo.png') }}" width="60" alt="TEFA Politeknik Astra">
                    </span>
                    <h5 class="text-center"><b>TEACHING FACTORY<br />MESIN OTOMOTIF</b></h5>
                    <p class="text-center">
                        Proses praktik perbaikan kendaraan Mahasiswa Mesin Otomotif
                    </p>
                    @if (session('SuccessMessage'))
                    <div class="alert alert-success" role="alert">
                        {{ session('SuccessMessage') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    @if (session('ErrorMessage'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('ErrorMessage') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <!-- Loading Spinner -->
                    <div id="loadingSpinner" class="text-primary">
                        Loading...
                    </div>
                    <form action="{{ route('authentication.verification.process') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="password" class="form-label">OTP</label>
                            <input type="number" class="form-control" name="password" id="password" aria-describedby="otpHelp" required>
                            <span class="text-danger">{{ $errors->first('Password') }}</span>
                            <div id="otpHelp" class="form-text">OTP sudah dikirim ke email: <b>{{ session('email') }}</b></div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm w-100 py-2 fs-4 mb-4 rounded-2">
                            Verifikasi
                        </button>
                        <div class="d-flex align-items-center justify-content-center">
                            <p class="fs-4 mb-0 fw-bold">Tidak menerima OTP?</p>
                            <a class="text-primary fw-bold ms-2" href="{{ route('authentication.login.form') }}">Kirim ulang OTP.</a>
                        </div>
                    </form>
                </div>
                <p class="text-center mt-5">
                    <b>{{ now()->format('d F Y - H:i') }}</b>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection