@extends('layouts.app')

@section('title', 'KONTROL')

@section('content')

@if(session('ErrorMessage'))
    <div class="alert alert-danger" role="alert">
        {{ session('ErrorMessage') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<form action="{{ route('reparation.post-form-control') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="idBooking" value="{{ $booking->id_booking }}" />

    <table class="table">
        <thead>
            <tr>
                <th>
                    Perbaikan
                </th>
                <th>
                    Ganti Part
                </th>
                <th>
                    Ceklis
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    @if($booking->repair_description == null)
                        <span>-</span>
                    @else
                        <span>{{ $booking->repair_description }}</span>
                    @endif
                </td>
                <td>
                    @if($booking->replacement_part == null)
                        <span>-</span>
                    @else
                        <span>{{ $booking->replacement_part }}</span>
                    @endif
                </td>
                <td>
                    <div class="form-check">
                        <input type="checkbox" name="control" value="1" class="form-check-input" {{ $booking->control == 1 ? 'checked' : '' }} required />
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="text-end">
        @if ($booking->repair_status != "KONTROL")
            <a href="{{ route('reparation.index', ['idBooking' => $booking->id_booking]) }}" class="btn btn-outline-primary mb-4 ms-auto">
                Kembali
            </a>
        @else
            <button type="submit" class="btn btn-primary mb-4 ms-auto">
                Lanjut Evaluasi!
            </button>
        @endif
    </div>
</form>
@endsection