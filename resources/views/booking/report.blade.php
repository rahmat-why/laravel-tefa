@extends('layouts.app')

@section('title', 'Laporan Booking')

@section('content')
    <div class="row">
        <div class="col-3">
            <div class="card overflow-hidden">
                <div class="card-body p-4">
                    <p class="mb-9 text-primary" style="font-size: 16px;">TEFA</p>
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="ti ti-motorbike text-primary" style="font-size: 24px;"></i>
                        </div>
                        <div class="col-8">
                            <p class="text-primary" style="font-size: 24px;"><b>{{ $countTefa }}</b></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card overflow-hidden">
                <div class="card-body p-4">
                    <p class="mb-9 text-primary" style="font-size: 16px;">FAST TRACK</p>
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="ti ti-scooter-electric text-primary" style="font-size: 24px;"></i>
                        </div>
                        <div class="col-8">
                            <p class="text-primary" style="font-size: 24px;"><b>{{ $countService }}</b></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-3">
            <div class="card overflow-hidden">
                <div class="card-body p-4">
                    <p class="mb-9 text-primary" style="font-size: 16px;">TOTAL BATAL</p>
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="ti ti-xbox-x text-primary" style="font-size: 24px;"></i>
                        </div>
                        <div class="col-8">
                            <p class="text-primary" style="font-size: 24px;"><b>{{ $countBatal }}</b></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-3">
            <div class="mb-1">
                <label class="form-label">Pilih Bulan</label>
                <input class="form-control" type="month" id="month" name="month" value="{{ $month }}" required>
            </div>

            <a href="javascript:void(0)" class="btn btn-primary btn-sm w-100 py-2 fs-4 rounded-2 mb-1" onclick="filterData()">FILTER</a>
            <a href="javascript:void(0)" class="btn btn-warning btn-sm w-100 py-2 fs-4 rounded-2 mb-1" onclick="exportData()">EXPORT</a>
        </div>
    </div>

    @if (session('ErrorMessage'))
        <div class="alert alert-danger" role="alert">
            {{ session('ErrorMessage') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>
                    Nama Customer
                </th>
                <th>
                    Tanggal Booking
                </th> 
                <th>
                    Merk
                </th>
                <th>
                    No.Polisi
                </th>
                <th>
                    Odometer (km)
                </th>
                <th>
                    Keluhan
                </th>
                <th>
                    Status
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($report as $item)
                <tr>
                    <td>
                        <span>{{ $item->idVehicleNavigation->idCustomerNavigation->name ?? "-" }}</span>
                    </td>
                    <td>
                        <span>{{ $item->order_date ? $item->order_date->format('d F Y') : "-" }}</span>
                    </td>
                    <td>
                        {{ $item->idVehicleNavigation->type }}
                    </td>
                    <td>
                        {{ $item->idVehicleNavigation->police_number }}
                    </td>
                    <td>
                        {{ $item->odometer }}
                    </td>
                    <td>
                        {{ $item->complaint }}
                    </td>
                    <td>
                        {{ $item->repair_status }}
                        <a href="{{ route('reparation.index', ['idBooking' => $item->id_booking]) }}" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Lihat servis">
                            <i class="ti ti-tool"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <script>
        function filterData() {
            var month = document.getElementById("month").value;
            window.location.href = '/booking/report?month=' + month;
        }

        function exportData() {
            var month = document.getElementById("month").value;
            window.location.href = '/booking/export?month=' + month;
        }
    </script>
@endsection

