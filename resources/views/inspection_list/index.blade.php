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
    <table class="table">
        <thead>
            <tr>
                <th>Kelengkapan</th>
                <th>Masuk</th>
                <th>Keluar</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($trsInspectionLists as $booking)
                <tr>
                    <td>
                        <input type="hidden" name="id_equipment{{ $booking->id_equipment }}" value="{{ $booking->id_equipment }}">
                        @if ($booking->equipment)
                            {{ $booking->equipment->name }}
                        @else
                            Nama Equipment tidak tersedia
                        @endif
                    </td>
                    <td>
                        @if ($booking->equipment)
                            <input type="radio" name="checklist{{ $booking->equipment->id_equipment }}" value="1" {{ $booking->checklist == 1 ? 'checked' : '' }}>
                        @else
                            <span class="text-danger">Equipment tidak tersedia</span>
                        @endif
                    </td>
                    <td>
                        @if ($booking->equipment)
                            <input type="radio" name="checklist{{ $booking->equipment->id_equipment }}" value="0" {{ $booking->checklist == 0 ? 'checked' : '' }}>
                        @else
                            <span class="text-danger">Equipment tidak tersedia</span>
                        @endif
                    </td>
                    <td>
                        @if ($booking->equipment)
                            <input type="text" name="description{{ $booking->equipment->id_equipment }}" value="{{ $booking->description }}" class="form-control">
                        @else
                            <span class="text-danger">Equipment tidak tersedia</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    @if ($trsInspectionLists->isNotEmpty() && $trsInspectionLists->first()->idBookingNavigation && $trsInspectionLists->first()->idBookingNavigation->finish_estimation_time)
        <p>
            Servis ini akan dimulai pada <b>{{ $trsInspectionLists->first()->idBookingNavigation->finish_estimation_time->format('d F Y - H:i') }}</b>.
        </p>
    @else
        <p>Servis ini akan dimulai pada <b>{{ $currentDatetime }}</b>. Apakah anda yakin?</p>
    @endif
    
    <div class="text-end">
        @if (session('ErrorMessage'))
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
