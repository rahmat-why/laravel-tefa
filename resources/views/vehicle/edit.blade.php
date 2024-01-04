@extends('layouts.customer')

@section('title', 'Edit Kendaraan')

@section('content')
<!--  Body Wrapper -->
<div class="position-relative overflow-hidden d-flex align-items-center justify-content-center">
    <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
            <div class="card-body">
                <nav ariAa-label="breadcrumb" class="bg-light p-3 mt-2">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home.form') }}">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('Vehicle.Index') }}">Data Kendaraan</a></li>
                        <li class="breadcrumb-item">Edit</li>
                    </ol>
                </nav>
                <!-- Loading Spinner -->
                <div id="loadingSpinner" class="text-primary">
                    Loading...
                </div>
                @if (session('ErrorMessage'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('ErrorMessage') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <!-- Update Vehicle Form -->
                <form method="post" action="{{ route('Vehicle.Update', $vehicle->id_vehicle) }}" class="mt-2">
                    @csrf
                    @method('post') <!-- Use post method for update -->
                    <div class="row g-3">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label">Type</label>  @error('type')<span class="text-danger">{{ $message }}</span>@enderror
                            <input type="text" class="form-control" name="type" value="{{ $vehicle->type }}">
                            <div id="typeHelp" class="form-text">Contoh: Honda Beat 125</div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label for="classify" class="control-label">Jenis</label>@error('classify')<span class="text-danger">{{ $message }}</span>@enderror
                            <select name="classify" class="form-control">
                                <option value="MOTOR" {{ $vehicle->classify === 'MOTOR' ? 'selected' : '' }}>Motor</option>
                                <option value="MOBIL" {{ $vehicle->classify === 'MOBIL' ? 'selected' : '' }}>Mobil</option>
                            </select>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label">Plat Nomor</label>@error('police_number')<span class="text-danger">{{ $message }}</span>@enderror
                            <input type="text" class="form-control" name="police_number" value="{{ $vehicle->police_number }}">
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label">Warna</label>@error('color')<span class="text-danger">{{ $message }}</span>@enderror
                            <input type="text" class="form-control" name="color" value="{{ $vehicle->color }}">
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label">Tahun</label>@error('year')<span class="text-danger">{{ $message }}</span>@enderror
                            <input type="text" class="form-control" name="year" value="{{ $vehicle->year }}">
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label">Nama Pemilik</label>@error('vehicle_owner')<span class="text-danger">{{ $message }}</span>@enderror
                            <input type="text" class="form-control" name="vehicle_owner" value="{{ $vehicle->vehicle_owner }}">
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label">No. Rangka</label>@error('chassis_number')<span class="text-danger">{{ $message }}</span>@enderror
                            <input type="text" class="form-control" name="chassis_number" value="{{ $vehicle->chassis_number }}">
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label">No. Mesin</label> @error('machine_number')<span class="text-danger">{{ $message }}</span>@enderror
                            <input type="text" class="form-control" name="machine_number" value="{{ $vehicle->machine_number }}">
                        </div>
                    </div>
                    <hr />
                    <div>
                        <button type="submit" class="btn btn-primary mb-2">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
