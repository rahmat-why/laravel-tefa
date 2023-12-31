@extends('layouts.customer')

@section('title', 'Home')

@section('content')
<div class="position-relative overflow-hidden d-flex align-items-center justify-content-center mt-3">
    <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
            <h5>
                Selamat Datang <b>{{ auth()->user()->name }}</b>
            </h5>
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <a href="{{ route('Vehicle.Index') }}">
                            <div class="card" style="border: 1px solid #3A4287;">
                                <div class="text-center py-3">
                                    <i class="ti ti-motorbike" style="color: #3A4287; font-size: 72px; display: block; margin: 0 auto;"></i>
                                </div>
                                <p class="text-center" style="color: #3A4287">Data Kendaraan</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <a href="{{ route('booking.Create') }}">
                            <div class="card" style="border: 1px solid #3A4287;">
                                <div class="text-center py-3">
                                    <i class="ti ti-tool" style="color: #3A4287; font-size: 72px; display: block; margin: 0 auto;"></i>
                                </div>
                                <p class="text-center" style="color: #3A4287">Booking Servis</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <a href="{{ route('booking.fast') }}">
                            <div class="card" style="border: 1px solid #3A4287;">
                                <div class="text-center py-3">
                                    <i class="ti ti-mail-fast" style="color: #3A4287; font-size: 72px; display: block; margin: 0 auto;"></i>
                                </div>
                                <p class="text-center" style="color: #3A4287">Fast Track Servis</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <a href="{{ route('booking.Index') }}">
                            <div class="card" style="border: 1px solid #3A4287;">
                                <div class="text-center py-3">
                                    <i class="ti ti-history" style="color: #3A4287; font-size: 72px; display: block; margin: 0 auto;"></i>
                                </div>
                                <p class="text-center" style="color: #3A4287">Riwayat Servis</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-12">
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
        </div>
    </div>
</div>
@endsection
