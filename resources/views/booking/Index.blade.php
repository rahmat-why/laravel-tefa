    @extends('layouts.customer')

@section('title', 'Riwayat Servis')

@section('content')
    <!--  Body Wrapper -->
    <div class="position-relative overflow-hidden min-vh-100 d-flex align-items-center justify-content-center">
        <div class="d-flex align-items-center justify-content-center w-100">
            <div class="row justify-content-center w-100">
                <div class="card-body">
                    <span class="text-nowrap logo-img text-center d-block py-4 w-100">
                    </span>
                    <p class="text-center">
                        <b>RIWAYAT SERVICE</b>
                    </p>
                    @if(session('successMessage'))
                        <div class="alert alert-success">
                            {{ session('successMessage') }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Tipe</th>
                                <th>Tanggal booking</th>
                                <th>Odometer</th>
                                <th>Keluhan</th>
                                <th>Perbaikan</th>
                                <th>Ganti part</th>
                                <th>Harga</th>
                                <th>Unduh Invoice</th>      
                            </tr>
                        </thead>
                            <tbody>
                                @forelse ($bookings as $item)
                                    <tr>
                                        <td>{{ $item->idVehicleNavigation->type }}</td>
                                        <td>{{ date('d/m/Y', strtotime($item->order_date)) }}</td>
                                        <td>{{ $item->odometer }}</td>
                                        <td>{{ $item->complaint }}</td>

                                        <td>{{ $item->repair_description ?:'-'}}</td>
                                        <td>{{ $item->replacement_part ?:'-'}}</td>
                                        <td>Rp.{{ number_format($item->price ?: 0, 0, ',', '.') }}</td>
                                    @if($item->repair_status=='SELESAI')
                                        <td> <a class="btn btn-outline-primary btn-sm" href="{{ route('booking.invoice', ['id' => $item->id_booking]) }}" data-toggle="tooltip" data-placement="top" title="pdf">
                                            <i class="ti ti-download"></i></a>
                                        </td>
                                    @else
                                        <td>
                                            <i class="fas fa-spinner fa-spin"title="Sedang Proses Perbaikan"></i></a>
                                        </td>
                                    @endif
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
