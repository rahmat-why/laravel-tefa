@extends('layouts.app')

@section('title', 'Daftar Booking')

@section('content')
    <table class="table">
        <thead>
            <tr>
                <th>Nama Customer</th>
                <th>Tanggal Booking</th>
                <th>Merk</th>
                <th>No.Polisi</th>
                <th>Odometer</th>
                <th>Keluhan</th>
                <th>Status</th>
                <th>Metode Servis</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($bookings as $booking)
            <tr>
                <td>
                    {{ optional(optional($booking->id_vehicle_navigation)->id_customer_navigation)->name ?? 'N/A' }}
                </td>
                <td>
                    {{ optional($booking->order_date)->format('d F Y') }}
                </td>
                <td>{{ optional(optional($booking->id_vehicle_navigation)->type)->__toString() ?? 'N/A' }}</td>
                <td>{{ optional(optional($booking->id_vehicle_navigation)->police_number)->__toString() ?? 'N/A' }}</td>
                <td>{{ $booking->odometer }}</td>
                <td>{{ $booking->complaint }}</td>
                <td>{{ $booking->repair_status }}</td>
                <td>
                    -
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection