@extends('layouts.app')

@section('title', 'SERVIS '.$booking->repair_method)

@section('content')
    @if (session('ErrorMessage'))
        <div class="alert alert-danger" role="alert">
            {{ session('ErrorMessage') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('SuccessMessage'))
        <div class="alert alert-success" role="alert">
            {{ session('SuccessMessage') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <table class="table">
    <thead>
        <tr>
            <th>Tipe Kendaraan</th>
            <th>No. Polisi</th>
            <th>Odometer</th>
            <th>Keluhan</th>
            <th>Estimasi Selesai</th>
            <th>Status</th>
            <th>Menu</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                {{ $booking->idVehicleNavigation->type }}
                <a class="btn btn-outline-primary btn-sm" href="{{ route('vehicles.history', ['id' => $booking->id_vehicle]) }}" data-toggle="tooltip" data-placement="top" title="Lihat riwayat kendaraan">
                    <i class="ti ti-history"></i>
                </a>
            </td>
            <td>{{ $booking->idVehicleNavigation->police_number }}</td>
            <td>{{ $booking->odometer }}</td>
            <td>{{ $booking->complaint }}</td>
            <td>
                @if ($booking->finish_estimation_time)
                    {{ \Carbon\Carbon::parse($booking->finish_estimation_time)->format('d F Y - H:i') }}
                @else
                    <span>-</span>
                @endif
            </td>
            <td>{{ $booking->repair_status }}</td>
            <td>
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="ti ti-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('booking.invoice', ['id' => $booking->id_booking]) }}">Invoice</a></li>
                        <li><a class="dropdown-item" href="{{ route('Pending.index', ['id_booking' => $booking->id_booking]) }}">Pending</a></li>
                        <li><a class="dropdown-item" href="{{ route('reparation.form-special-handling', ['idBooking' => $booking->id_booking]) }}">Temuan</a></li>
                    </ul>
                </div>
            </td>
        </tr>
    </tbody>
</table>

<div class="row">
    <div class="col-sm-6 col-xl-2">
        <div class="d-flex flex-column align-items-center justify-content-center rounded-circle text-center" style="width: 125px; height: 125px; background-color: #5296D6; position: relative;">
            <h6 class="text-white">INFO PROYEK</h6>
            <i class="ti ti-circle-check text-primary position-absolute" style="top: 5px; right: 5px;"></i>
        </div>
    </div>
    <div class="col-sm-6 col-xl-2">
        <a href="{{ route('reparation.form-plan', ['idBooking' => $booking->id_booking]) }}" class="position-relative">
            <div class="d-flex flex-column align-items-center justify-content-center rounded-circle text-center" style="width: 125px; height: 125px; background-color: #304F6C; position: relative;">
                <h6 class="text-white">PERENCANAAN</h6>
                @if ($booking->repair_description == null)
                    <i class="ti ti-loader text-warning position-absolute" style="top: 5px; right: 5px;"></i>
                @else
                    <i class="ti ti-circle-check text-primary position-absolute" style="top: 5px; right: 5px;"></i>
                @endif
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-xl-2">
        <a href="{{ route('reparation.form-decision', ['idBooking' => $booking->id_booking]) }}" class="position-relative">
            <div class="d-flex flex-column align-items-center justify-content-center rounded-circle text-center" style="width: 125px; height: 125px; background-color: #5296D6; position: relative;">
                <h6 class="text-white">KEPUTUSAN</h6>
                @if ($booking->decision != null)
                    <i class="ti ti-circle-check text-primary position-absolute" style="top: 5px; right: 5px;"></i>
                @else
                    <i class="ti ti-loader text-warning position-absolute" style="top: 5px; right: 5px;"></i>
                @endif
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-xl-2">
        @if ($booking->end_repair_time != null)
            <a href="{{ route('reparation.form-finish-execution', ['idBooking' => $booking->id_booking]) }}" class="position-relative">
                <div class="d-flex flex-column align-items-center justify-content-center rounded-circle text-center" style="width: 125px; height: 125px; background-color: #304F6C; position: relative;">
                    <h6 class="text-white">EKSEKUSI</h6>
                    <p class="text-white" style="font-size: 12px">Selesai</p>
                    <i class="ti ti-circle-check text-primary position-absolute" style="top: 5px; right: 5px;"></i>
                </div>
            </a>
        @elseif ($booking->start_repair_time != null)
            <a href="{{ route('reparation.form-finish-execution', ['idBooking' => $booking->id_booking]) }}" class="position-relative">
                <div class="d-flex flex-column align-items-center justify-content-center rounded-circle text-center" style="width: 125px; height: 125px; background-color: #304F6C; position: relative;">
                    <h6 class="text-white">EKSEKUSI</h6>
                    <p class="text-white" style="font-size: 12px">Sedang Berlangsung</p>
                    <i class="ti ti-loader text-warning position-absolute" style="top: 5px; right: 5px;"></i>
                </div>
            </a>
        @else
            <a href="{{ route('inspection_list.index', ['idBooking' => $booking->id_booking]) }}" class="position-relative">
                <div class="d-flex flex-column align-items-center justify-content-center rounded-circle text-center" style="width: 125px; height: 125px; background-color: #304F6C; position: relative;">
                    <h6 class="text-white">EKSEKUSI</h6>
                    <p class="text-white" style="font-size: 12px">Belum Dimulai</p>
                    <i class="ti ti-loader text-warning position-absolute" style="top: 5px; right: 5px;"></i>
                </div>
            </a>
        @endif
    </div>
    <div class="col-sm-6 col-xl-2">
        <a href="{{ route('reparation.form-control', ['idBooking' => $booking->id_booking]) }}" class="position-relative">
            <div class="d-flex flex-column align-items-center justify-content-center rounded-circle text-center" style="width: 125px; height: 125px; background-color: #5296D6; position: relative;">
                <h6 class="text-white">KONTROL</h6>
                @if ($booking->control == null || $booking->control == 0)
                    <i class="ti ti-loader text-warning position-absolute" style="top: 5px; right: 5px;"></i>
                @else
                    <i class="ti ti-circle-check text-primary position-absolute" style="top: 5px; right: 5px;"></i>
                @endif
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-xl-2">
        <a href="{{ route('reparation.form-evaluation', ['idBooking' => $booking->id_booking]) }}" class="position-relative">
            <div class="d-flex flex-column align-items-center justify-content-center rounded-circle text-center" style="width: 125px; height: 125px; background-color: #304F6C; position: relative;">
                <h6 class="text-white">EVALUASI</h6>
                @if ($booking->evaluation == null)
                    <i class="ti ti-loader text-warning position-absolute" style="top: 5px; right: 5px;"></i>
                @else
                    <i class="ti ti-circle-check text-primary position-absolute" style="top: 5px; right: 5px;"></i>
                @endif
            </div>
        </a>
    </div>
</div>
@endsection