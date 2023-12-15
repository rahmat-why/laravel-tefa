@extends('layouts.customer')

@section('title', 'Tambah Kendaraan')

@section('content')
<!--  Body Wrapper -->
<div class="position-relative overflow-hidden min-vh-100 d-flex align-items-center justify-content-center">
    <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
            <div class="card-body">
                <span class="text-nowrap logo-img text-center d-block py-4 w-100">
                </span>
                <p class="text-center">
                    <b>Tambah Kendaraan</b>
                </p>
                @if (session('ErrorMessage'))
                <div class="alert alert-danger" role="alert">
                    {{ session('ErrorMessage') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <form method="post" action="{{ route('Vehicle.Store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="type" class="control-label">Tipe Kendaraan</label>
                        <input type="text" name="type" class="form-control" />
                        <div id="typeHelp" class="form-text">Contoh: Honda Beat 125</div>
                        @error('type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="classify" class="control-label">Jenis</label>
                        <select name="classify" class="form-control">
                            <option value="MOTOR">Motor</option>
                            <option value="MOBIL">Mobil</option>
                        </select>
                        @error('classify')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="police_number" class="control-label">Plat Nomor</label>
                        <input type="text" name="police_number" class="form-control" />
                        <div id="police_numberHelp" class="form-text">Contoh: B 1234 ABC</div>
                        @error('police_number')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror                     
                    </div>
                    <div class="mb-3">
                        <label for="color" class="control-label">Warna</label>
                        <input type="text" name="color" class="form-control" />
                        @error('color')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror                     
                    </div>
                    <div class="mb-3">
                        <label for="year" class="control-label">Tahun Pembuatan</label>
                        <input type="text" name="year" class="form-control" />
                        @error('year')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror                   
                    </div>
                    <div class="mb-3">
                        <label for="vehicle_owner" class="control-label">Nama Pemilik</label>
                        <input type="text" name="vehicle_owner" class="form-control" />
                        @error('vehicle_owner')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror         
                    </div>
                    <div class="mb-3">
                        <label for="chassis_number" class="control-label">No. Rangka</label>
                        <input type="text" name="chassis_number" class="form-control" />
                        <div id="chassisNumberHelp" class="form-text">Silahkan lihat di STNK anda</div>
                        @error('chassis_number')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror                     
                    </div>
                    <div class="mb-3">
                        <label for="machine_number" class="control-label">No. Mesin</label>
                        <input type="text" name="machine_number" class="form-control" />
                        <div id="machineNumberHelp" class="form-text">Silahkan lihat di STNK anda</div>
                        @error('machine_number')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror                     
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm w-100 py-2 fs-4 rounded-2 mt-3">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

