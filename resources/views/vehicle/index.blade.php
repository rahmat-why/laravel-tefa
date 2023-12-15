    @extends('layouts.customer')

    @section('title', 'Data Kendaraan')

    @section('content')
        <!--  Body Wrapper -->
        <div class="position-relative overflow-hidden min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="card-body">
                        <span class="text-nowrap logo-img text-center d-block py-4 w-100">
                        </span>
                        <p class="text-center">
                            DAFTAR KENDARAAN
                        </p>
                        @if(isset($successMessage))
                            <div class="alert alert-success">
                                {{ $successMessage }}
                            </div>
                        @endif
                            <P></P>
                            <p>
                                <a href="{{ route('Vehicle.Create') }}">Tambah Kendaraan</a>
                            </p>
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
                                        @forelse ($model as $ttttt)
                                            <tr>
                                                <td>{{ $ttttt->type }}</td>
                                                <td>{{ $ttttt->classify }}</td>
                                                <td>{{ $ttttt->police_number }}</td>
                                                <td>{{ $ttttt->color }}</td>
                                                <td>{{ $ttttt->year }}</td>
                                                <td>{{ $ttttt->vehicle_owner }}</td>
                                                <td>{{ $ttttt->chassis_number }}</td>
                                                <td>{{ $ttttt->machine_number }}</td>
                                                <td>
                                                    <a href="{{ route('Vehicle.Edit', ['id' => $ttttt->id_vehicle]) }}">edit</a>|
                                                    <a href="#"onclick="
                                                        event.preventDefault();
                                                        if (confirm('Do you want to remove this?')) {
                                                            document.getElementById('delete-row-{{ $ttttt->id_vehicle }}').submit();
                                                        }">
                                                        delete
                                                    </a>
                                                    <form id="delete-row-{{$ttttt->id_vehicle}}"
                                                        action="{{route( 'Vehicle.Destroy',['id'=>$ttttt->id_vehicle])}}"
                                                        method="POST">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        @csrf
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan=>
                                                    No record found!
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <a href="{{ route('home.form') }}" class="btn btn-outline-dark btn-sm w-100 py-2 fs-4 rounded-2 mt-3 mb-3">Home</a>
                    </div>
                    <p class="text-center mt-5">
                    </p>
                </div>
            </div>
        </div>
    @endsection
