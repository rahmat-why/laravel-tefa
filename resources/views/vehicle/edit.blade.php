@extends('layouts.customer')

@section('title', 'Edit Kendaraan')

@section('content')
<!--  Body Wrapper -->
<div class="position-relative overflow-hidden min-vh-100 d-flex align-items-center justify-content-center">
    <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
            <div class="card-body">
                <span class="text-nowrap logo-img text-center d-block py-4 w-100">
                </span>
                <p class="text-center">
                    <b>Edit Kendaraan</b>
                </p>
                @if (session('ErrorMessage'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('ErrorMessage') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <form method="post" action="{{ route('Vehicle.Update', $vehicle->id_vehicle) }}">
                    @csrf
                    @method('POST') <!-- Gunakan metode POST untuk pembaruan -->
                    <div class="mb-3">
                                <label class="form-label">Type</label>
                                <input type="text" class="form-control" name="type" value="{{ $vehicle->type }}" placeholder="#type">
                                <div id="typeHelp" class="form-text">Contoh: Honda Beat 125</div>
                            @error('type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            </div>
                            <div class="mb-3">
                                <label for="classify" class="control-label">Jenis</label>
                                <select name="classify" class="form-control">
                                    <option value="MOTOR" {{ $vehicle->classify === 'MOTOR' ? 'selected' : '' }}>Motor</option>
                                    <option value="MOBIL" {{ $vehicle->classify === 'MOBIL' ? 'selected' : '' }}>Mobil</option>
                                </select>
                                @error('classify')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Plat Nomor</label>
                                <input type="text" class="form-control" name="police_number" value="{{ $vehicle->police_number }}" placeholder="police_number">
                                @error('police_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Warna</label>
                                <input type="text" class="form-control" name="color" value="{{ $vehicle->color }}" placeholder="color">
                                @error('color')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror 
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tahun</label>
                                <input type="text" class="form-control" name="year" value="{{ $vehicle->year }}" placeholder="year">
                                @error('year')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Pemilik</label>
                                <input type="text" class="form-control" name="vehicle_owner" value="{{ $vehicle->vehicle_owner }}" placeholder="vehicle_owner">
                                @error('vehicle_owner')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No Rangka</label>
                                <input type="text" class="form-control" name="chassis_number" value="{{ $vehicle->chassis_number }}" placeholder="chassis_number">
                                @error('chassis_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror  
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No Mesin</label>
                                <input type="text" class="form-control" name="machine_number" value="{{ $vehicle->machine_number }}" placeholder="machine_number">
                                @error('machine_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                    <div>
                        <button type="submit" class="btn btn-primary btn-sm w-100 py-2 fs-4 rounded-2 mt-3">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
