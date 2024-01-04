@extends('layouts.app')

@section('title', 'Daftar Booking')

@section('content')
<table class="table">
    <thead>
        <tr>
            <th>Nama Customer</th>
            <th>Tanggal Booking</th>
            <th>Tipe Kendaraan</th>
            <th>No.Polisi</th>
            <th>Odometer (km)</th>
            <th>Keluhan</th>
            <th>Status</th>
            <th>Metode Servis</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($bookings as $booking)
        @php
        $background_color = '';
            if ($booking->repair_status == 'MENUNGGU') {
                if ($booking->repair_method == 'TEFA'){
                    $background_color = 'background-color: yellow;';
                }else{
                    $background_color = 'background-color: red;';
                }
            }else{
                $background_color = 'background-color: white;';
            }
        @endphp
        
        <tr style="{{ $background_color }}">
            <td>
                {{ optional(optional($booking->idVehicleNavigation)->idCustomerNavigation)->name ?? 'N/A' }}
                <a class="btn btn-outline-success btn-sm"
                data-phone="{{ optional(optional($booking->idVehicleNavigation)->idCustomerNavigation)->phone }}"
                onclick="copyPhone(this)" data-toggle="tooltip" data-placement="top" title="Salin nomor whatsapp">
                    <i class="ti ti-brand-whatsapp"></i>
                </a>
            </td>
            <td>
                {{ optional($booking->order_date)->format('d F Y') }}
            </td>
            <td>
                {{ optional(optional($booking->idVehicleNavigation))->type ?? 'N/A' }}
                <a class="btn btn-outline-primary btn-sm" href="{{ route('vehicles.history', ['id' => $booking->id_vehicle]) }}" data-toggle="tooltip" data-placement="top" title="Lihat riwayat kendaraan">
                    <i class="ti ti-history"></i>
                </a>
            </td>
            <td>{{ optional(optional($booking->idVehicleNavigation))->police_number ?? 'N/A' }}</td>
            <td>{{ $booking->odometer }}</td>
            <td>{{ $booking->complaint }}</td>
            <td>{{ $booking->repair_status }}</td>
            <td>
                @if($booking->repair_status == "MENUNGGU")
                    <a href="{{ route('reparation.form-start-service', ['idBooking' => $booking->id_booking]) }}" style="color: blue; text-decoration: none;">
                        {{ $booking->repair_method }}
                    </a>
                @else
                    <a href="{{ route('reparation.index', ['idBooking' => $booking->id_booking]) }}">
                        {{ $booking->repair_method }}
                    </a>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
