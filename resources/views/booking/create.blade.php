@extends('layouts.customer')

@section('title', 'Booking Servis')

@section('content')
<!--  Body Wrapper -->
<div class="position-relative overflow-hidden d-flex align-items-center justify-content-center">
    <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
            <div class="card-body">
                <nav aria-label="breadcrumb" class="bg-light p-3 mt-2">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home.form') }}">Beranda</a></li>
                        <li class="breadcrumb-item">Servis</li>
                    </ol>
                </nav>
                <h6 class="mt-2 text-center"><b>TEFA</b></h6>
                <p class="text-center">Servis dengan tanggal booking fleksibel</p>
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
                <form method="post" action="{{ route('booking.Store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label">Tanggal Booking</label>@error('order_date')<span class="text-danger">{{ $message }}</span>@enderror
                            <input name="order_date" class="form-control" type="date">
                           <div id="orderDateHelp" class="form-text">Tanggal yang valid minimum H+1</div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label for="id_vehicle">Kendaraan</label>
                            <select name="id_vehicle" class="form-control">
                                @foreach ($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id_vehicle }}">{{ $vehicle->type }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label">Odometer (km)</label>@error('odometer')<span class="text-danger">{{ $message }}</span>@enderror
                            <input name="odometer" class="form-control">
                            <span class="text-danger"></span>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label">Keluhan</label>@error('complaint')<span class="text-danger">{{ $message }}</span>@enderror
                            <textarea class="form-control" name="complaint" aria-describedby="addressHelp"></textarea>
                            <span class="text-danger"></span>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-check">
                                <input type="checkbox" name="checklist" class="form-check-input" id="AgreeToTerms">
                                <label class="form-check-label" for="AgreeToTerms">Spare part disiapkan atau dibeli oleh customer</label>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <button type="submit" class="btn btn-primary mb-2">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
