@extends('layouts.app')

@section('title', 'index')

@section('content')
<table class="table">
    <thead>
        <tr>
            <th>Tipe Kendaraan</th>
            <th>No. Polisi</th>
            <th>Odometer</th>
            <th>Keluhan</th>
            <th>Estimasi Selesai</th>
            <th>Status</th>
            @if(auth()->user()->position == 'SERVICE ADVISOR')
                <th>#</th>
            @endif
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $booking->IdVehicleNavigation->type }}</td>
            <td>{{ $booking->IdVehicleNavigation->police_number }}</td>
            <td>{{ $booking->odometer }}</td>
            <td>{{ $booking->complaint }}</td>
            <td>
                @if ($booking->finish_estimation_time)
                    {{ $booking->finish_estimation_time->format('dd MMMM yyyy - HH:mm') }}
                @else
                    <span>-</span>
                @endif
            </td>
            <td>{{ $booking->repair_status }}</td>
            @if (auth()->user()->position == 'SERVICE ADVISOR')
                <td>
                    <a href="{{ route('reparation.form-method', ['idBooking' => $booking->id_booking]) }}">Ganti Metode</a>
                </td>
            @endif
        </tr>
    </tbody>
</table>

@if ($booking->repair_method == 'SERVICE')
    <div class="row">
        <div class="col-sm-6 col-xl-2">
            <a href="{{ route('reparation.post-form-start-execution', ['idBooking' => $booking->id_booking]) }}" class="position-relative">
                <div class="d-flex flex-column align-items-center justify-content-center rounded-circle text-center" style="width: 125px; height: 125px; background-color: #5296D6; position: relative;">
                    <h6 class="text-white">MULAI</h6>
                    @if ($booking->start_repair_time == null)
                        <i class="ti ti-loader text-warning position-absolute" style="top: 5px; right: 5px;"></i>
                    @else
                        <i class="ti ti-circle-check text-primary position-absolute" style="top: 5px; right: 5px;"></i>
                    @endif
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-xl-2">
            <a href="{{ route('reparation.post-form-finish-execution', ['idBooking' => $booking->Id_booking]) }}" class="position-relative">
                <div class="d-flex flex-column align-items-center justify-content-center rounded-circle text-center" style="width: 125px; height: 125px; background-color: #5296D6; position: relative;">
                    <h6 class="text-white">SELESAI</h6>
                    @if ($booking->end_repair_time == null)
                        <i class="ti ti-loader text-warning position-absolute" style="top: 5px; right: 5px;"></i>
                    @else
                        <i class="ti ti-circle-check text-primary position-absolute" style="top: 5px; right: 5px;"></i>
                    @endif
                </div>
            </a>
        </div>
    </div>
@endif

@if ($booking->repair_method == 'TEFA')
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
                    @if ($booking->price == null)
                        <i class="ti ti-loader text-warning position-absolute" style="top: 5px; right: 5px;"></i>
                    @else
                        <i class="ti ti-circle-check text-primary position-absolute" style="top: 5px; right: 5px;"></i>
                    @endif
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-xl-2">
            @if ($booking->finish_estimation_time != null)
                <a href="{{ route('reparation.form-finish-execution', ['idBooking' => $booking->id_booking]) }}" class="position-relative">
                    <div class="d-flex flex-column align-items-center justify-content-center rounded-circle text-center" style="width: 125px; height: 125px; background-color: #304F6C; position: relative;">
                        <h6 class="text-white">EKSEKUSI</h6>
                        <p class="text-white" style="font-size: 12px">Selesai</p>
                        <i class="ti ti-circle-check text-primary position-absolute" style="top: 5px; right: 5px;"></i>
                    </div>
                </a>
            @elseif ($booking->start_repair_time != null)
                <a href="{{ route('reparation.form-finish-execution', ['idBooking' => $booking->Id_booking]) }}" class="position-relative">
                    <div class="d-flex flex-column align-items-center justify-content-center rounded-circle text-center" style="width: 125px; height: 125px; background-color: #304F6C; position: relative;">
                        <h6 class="text-white">EKSEKUSI</h6>
                        <p class="text-white" style="font-size: 12px">Sedang Berlangsung</p>
                        <i class="ti ti-loader text-warning position-absolute" style="top: 5px; right: 5px;"></i>
                    </div>
                </a>
            @else
                <a href="{{ route('inspectionList.index', ['idBooking' => $booking->Id_booking]) }}" class="position-relative">
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
                    <h6 class="text-white">Kontrol</h6>
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
@endif
@endsection