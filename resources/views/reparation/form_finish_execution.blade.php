@extends('layouts.app')

@section('title', 'SELESAI EKSEKUSI')

@php
    $currentDatetime = now()->format('d F Y - H:i');
@endphp

@section('content')
<form action="{{ route('reparation.post-form-finish-execution') }}" method="post">
    @csrf
    <input type="hidden" name="id_booking" value="{{ $booking['id_booking'] }}" />
    @if (session('ErrorMessage'))
        <div class="alert alert-danger" role="alert">
            {{ session('ErrorMessage') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <p>Servis ini akan diselesaikan pada <b>{{ $currentDatetime }}</b>. Apakah anda yakin?</p>
    
    <div class="text-end">
        <a href="{{ route('inspection_list.index', ['idBooking' => $booking->id_booking]) }}" class="btn btn-outline-dark mb-4 ms-auto">
            Inspection List
        </a>

        @if (!in_array($booking->repair_status, ['EKSEKUSI']))
            <a href="{{ route('reparation.index', ['idBooking' => $booking->id_booking]) }}" class="btn btn-outline-primary mb-4 ms-auto">
                Kembali
            </a>
        @else
            <button type="submit" class="btn btn-primary mb-4 ms-auto">
                Selesai!
            </button>
        @endif
    </div>
</form>
@endsection
