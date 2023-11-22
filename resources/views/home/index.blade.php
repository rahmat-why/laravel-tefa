@extends('layouts.customer')

@section('title', 'Verification')

@section('content')
<div class="position-relative overflow-hidden min-vh-100 d-flex align-items-center justify-content-center mt-3">
    <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
            <h5>
                Selamat Datang <b>Rahmat</b>
            </h5>
            <a href="{{ route('booking.history.form') }}">
                <div class="card" style="border: 1px solid #3A4287;">
                    <div class="text-center py-3">
                        <i class="ti ti-motorbike" style="color: #3A4287; font-size: 72px; display: block; margin: 0 auto;"></i>
                    </div>
                    <p class="text-center" style="color: #3A4287">Data Kendaraan</p>
                </div>
            </a>
            <a href="{{ route('booking.history.form') }}">
                <div class="card" style="border: 1px solid #3A4287;">
                    <div class="text-center py-3">
                        <i class="ti ti-tool" style="color: #3A4287; font-size: 72px; display: block; margin: 0 auto;"></i>
                    </div>
                    <p class="text-center" style="color: #3A4287">Booking Servis</p>
                </div>
            </a>
            <a href="{{ route('booking.history.form') }}">
                <div class="card" style="border: 1px solid #3A4287;">
                    <div class="text-center py-3">
                        <i class="ti ti-history" style="color: #3A4287; font-size: 72px; display: block; margin: 0 auto;"></i>
                    </div>
                    <p class="text-center" style="color: #3A4287">Riwayat Servis</p>
                </div>
            </a>
            <a href="{{ route('authentication.logout.process') }}">
                <div class="card" style="border: 1px solid #3A4287;">
                    <div class="text-center py-3">
                        <i class="ti ti-logout" style="color: #3A4287; font-size: 72px; display: block; margin: 0 auto;"></i>
                    </div>
                    <p class="text-center" style="color: #3A4287">Keluar</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
