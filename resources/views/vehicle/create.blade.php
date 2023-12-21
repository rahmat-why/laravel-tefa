@extends('layouts.customer')

@section('title', 'Tambah Kendaraan')

@section('content')
<!--  Body Wrapper -->
<div class="position-relative overflow-hidden d-flex align-items-center justify-content-center">
    <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
            <div class="card-body">
                <nav aria-label="breadcrumb" class="bg-light p-3 mt-2">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home.form') }}">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('Vehicle.Index') }}">Data Kendaraan</a></li>
                        <li class="breadcrumb-item">Tambah</li>
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
                <form method="post" action="{{ route('Vehicle.Store') }}" class="mt-2">
                    @csrf
                    @method('POST') <!-- Use POST method for update -->
                    <div class="row g-3">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label for="type" class="control-label">Tipe Kendaraan</label>
                            <input type="text" name="type" class="form-control" />
                            <div id="typeHelp" class="form-text">Contoh: Honda Beat 125</div>
                            @error('type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label for="classify" class="control-label">Jenis</label>
                            <select name="classify" class="form-control">
                                <option value="MOTOR">Motor</option>
                                <option value="MOBIL">Mobil</option>
                            </select>
                            @error('classify')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label for="police_number" class="control-label">Plat Nomor</label>
                            <input type="text" name="police_number" class="form-control" />
                            <div id="police_numberHelp" class="form-text">Contoh: B 1234 ABC</div>
                            
                            @error('police_number')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label for="color" class="control-label">Warna</label>
                            <input type="text" name="color" class="form-control" />
                            @error('color')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror                     
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label for="year" class="control-label">Tahun Pembuatan</label>
                            <input type="text" name="year" class="form-control" />
                            @error('year')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror                   
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label for="vehicle_owner" class="control-label">Nama Pemilik</label>
                            <input type="text" name="vehicle_owner" class="form-control" />
                            @error('vehicle_owner')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror         
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label for="chassis_number" class="control-label">No. Rangka</label>
                            <input type="text" name="chassis_number" class="form-control" />
                            <div id="chassisNumberHelp" class="form-text">Silahkan lihat di STNK anda</div>
                            @error('chassis_number')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror                     
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label for="machine_number" class="control-label">No. Mesin</label>
                            <input type="text" name="machine_number" class="form-control" />
                            <div id="machineNumberHelp" class="form-text">Silahkan lihat di STNK anda</div>
                            @error('machine_number')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror                     
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

