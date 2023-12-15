@extends('layouts.customer')

@section('title', 'Booking Servis')

@section('content')
<!--  Body Wrapper -->
<div class="position-relative overflow-hidden min-vh-100 d-flex align-items-center justify-content-center">
    <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
            <div class="card-body">
                <span class="text-nowrap logo-img text-center d-block py-4 w-100">
                </span>
                <div class="text-center">
                    <b><h4>Form Booking Servis</h4></b>
                    <p class="mb-0">Servis yang cenderung kompleks silahkan booking disini</p>
                </div>
                @if (session('ErrorMessage'))
                <div class="alert alert-danger" role="alert">
                    {{ session('ErrorMessage') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <form method="post" action="{{ route('booking.Store') }}">
                    @csrf
                    <div class="text-danger"></div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Booking</label>
                        <input name="order_date" class="form-control" type="date">
                        <div id="orderDateHelp" class="form-text">Tanggal yang valid minimum H+1</div>
                        @error('order_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="id_vehicle">Kendaraan</label>
                        <select name="id_vehicle" class="form-control" required>
                            @foreach ($vehicles as $vehicle)
                                <option value="{{ $vehicle->id_vehicle }}">{{ $vehicle->type }} - {{ $vehicle->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Odometer</label>
                        <input name="odometer" class="form-control" required>
                        <span class="text-danger"></span>
                        @error('odometer')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keluhan</label>
                        <textarea class="form-control" name="complaint" aria-describedby="addressHelp" required></textarea>
                        <span class="text-danger"></span>
                        @error('complaint')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-check">
                        <input type="checkbox" name="checklist" class="form-check-input" id="AgreeToTerms" required>
                        <label class="form-check-label" for="AgreeToTerms">Spare part disiapkan atau dibeli oleh customer</label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm w-100 py-2 fs-4 rounded-2 mt-3">Booking</button>
                </form>
            </div>
            <a href="{{ route('home.form') }}" class="btn btn-outline-dark btn-sm w-100 py-2 fs-4 rounded-2 mt-3 mb-3">Home</a>
            <p class="text-center mt-5">
            </p>
        </div>
    </div>
</div>
@endsection
