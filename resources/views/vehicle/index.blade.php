@extends('layouts.customer')

@section('title', 'Data Kendaraan')

@section('content')
<!--  Body Wrapper -->
<div class="position-relative overflow-hidden d-flex align-items-center justify-content-center">
    <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
            <div class="card-body">
                <nav aria-label="breadcrumb" class="bg-light p-3 mt-2">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home.form') }}">Beranda</a></li>
                        <li class="breadcrumb-item">Data Kendaraan</li>
                    </ol>
                </nav>
                <p>
                    <a href="{{ route('Vehicle.Create') }}" class="btn btn-primary m-1">Tambah Kendaraan</a>
                </p>
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Tipe</th>
                                    <th>Jenis</th>
                                    <th>No polisi</th>
                                    <th>Warna</th>
                                    <th>Tahun</th>
                                    <th>Nama pemilik</th>
                                    <th>No rangka</th>
                                    <th>No mesin</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($vehicles as $vehicle)
                                    <tr>
                                        <td>{{ $vehicle->type }}</td>
                                        <td>{{ $vehicle->classify }}</td>
                                        <td>{{ $vehicle->police_number }}</td>
                                        <td>{{ $vehicle->color }}</td>
                                        <td>{{ $vehicle->year }}</td>
                                        <td>{{ $vehicle->vehicle_owner }}</td>
                                        <td>{{ $vehicle->chassis_number }}</td>
                                        <td>{{ $vehicle->machine_number }}</td>
                                        <td>
                                            <a href="{{ route('Vehicle.Edit', ['id' => $vehicle->id_vehicle]) }}">Edit</a> |
                                            <a href="#" onclick="
                                                event.preventDefault();
                                                if (confirm('Do you want to remove this?')) {
                                                    document.getElementById('delete-row-{{ $vehicle->id_vehicle }}').submit();
                                                }">
                                                Delete
                                            </a>
                                            <form id="delete-row-{{$vehicle->id_vehicle}}"
                                                action="{{route( 'Vehicle.Destroy',['id'=>$vehicle->id_vehicle])}}"
                                                method="POST">
                                                <input type="hidden" name="_method" value="DELETE">
                                                @csrf
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9">
                                            No record found!
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
