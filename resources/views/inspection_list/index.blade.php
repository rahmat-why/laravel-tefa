@extends('layouts.app')

@section('title', 'Inspection List')

@php
    $currentDatetime = now()->format('d F Y - H:i');
@endphp

@section('content')
@if (session('ErrorMessage'))
    <div class="alert alert-danger" role="alert">
        {{ session('ErrorMessage') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<form action="{{ route('inspection_list.create') }}" method="post">
    @csrf
    <input type="hidden" name="idBooking" value="{{ $idBooking }}">
    @if($trsBooking->idVehicleNavigation->classify == "MOBIL")
        <table class="table">
            <thead>
                <tr>
                    <th>Kelengkapan</th>
                    <th>Masuk</th>
                    <th>Keluar</th>
                    <th>Std</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($trsInspectionLists as $inspection)
                    <tr>
                        <td>
                            <input type="hidden" name="id_equipment{{ $inspection->id_equipment }}" value="{{ $inspection->id_equipment }}">
                            {{ $inspection->equipment->name }}
                        </td>
                        <td>
                            <input type="radio" name="checklist{{ $inspection->equipment->id_equipment }}" value="1" {{ $inspection->checklist == 1 ? 'checked' : '' }}>
                        </td>
                        <td>
                            <input type="radio" name="checklist{{ $inspection->equipment->id_equipment }}" value="0" {{ $inspection->checklist == 0 ? 'checked' : '' }}>
                        </td>
                        <td>
                            {{ $inspection->equipment->std }}
                        </td>
                        <td>
                            <input type="text" name="description{{ $inspection->equipment->id_equipment }}" value="{{ $inspection->description }}" class="form-control">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    
    @if ($trsBooking->start_repair_time != NULL)
        <p>
            Servis ini sudah dimulai pada <b>{{ $trsBooking->finish_estimation_time->format('d F Y - H:i') }}</b>.
        </p>
    @else
        <p>Servis ini akan dimulai pada <b>{{ $currentDatetime }}</b>. Apakah anda yakin?</p>
    @endif
    
    <div class="text-end">
        @if (!(($trsBooking->repair_status == "INSPECTION LIST" || $trsBooking->repair_status == "EKSEKUSI") || ($trsBooking->start_repair_time != null && $trsBooking->idVehicleNavigation->classify == "MOTOR")))
            <a href="{{ route('reparation.index', ['idBooking' => $idBooking]) }}" class="btn btn-outline-primary mb-4 ms-auto">
                Kembali
            </a>
        @else
            <button type="submit" class="btn btn-primary mb-4 ms-auto">
                Mulai Eksekusi!
            </button>
        @endif
    </div>
</form>
@endsection
