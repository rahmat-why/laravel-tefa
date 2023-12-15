<!-- resources/views/riwayat_kendaraan.blade.php -->

@extends('layouts.app')

@section('title', 'Riwayat Kendaraan')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <dl>
                    <dt>
                        Tipe Kendaraan: 
                        <b>{{ $vehicle->type }}</b>
                    </dt>
                    <dt>
                        Klasifikasi: 
                        <b>{{ $vehicle->classify }}</b>
                    </dt>
                    <dt>
                        No. Polisi: 
                        <b>{{ $vehicle->police_number }}</b>
                    </dt>
                    <dt>
                        Warna: 
                        <b>{{ $vehicle->color }}</b>
                    </dt>
                    <dt>
                        Tahun: 
                        <b>{{ $vehicle->year }}</b>
                    </dt>
                </dl>
            </div>
            <div class="col-sm-6">
                <dl>
                    <dt>
                        Nama Pemilik: 
                        <b>{{ $vehicle->vehicle_owner }}</b>
                    </dt>
                    <dt>
                        Nomor Rangka: 
                        <b>{{ $vehicle->chassis_number }}</b>
                    </dt>
                    <dt>
                        Nomor Mesin: 
                        <b>{{ $vehicle->machine_number }}</b>
                    </dt>
                    <dt>
                        Nama Customer: 
                        <b>{{ $vehicle->idCustomerNavigation->name }}</b>
                    </dt>
                    <dt>
                        Alamat Lengkap: 
                        <b>{{ $vehicle->idCustomerNavigation->address }}</b>
                    </dt>
                </dl>
            </div>
        </div>
    </div>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th>Tanggal Booking</th>
                <th>Odometer (km)</th>
                <th>Keluhan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($vehicle->trsBookings as $booking)
                <tr>
                    <td>
                        @if ($booking->order_date)
                            {{ $booking->order_date->format('d F Y') }}
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $booking->odometer }}</td>
                    <td>{{ $booking->complaint }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No booking records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
