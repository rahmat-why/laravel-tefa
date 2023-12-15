@extends('layouts.app')

@section('title', 'Indent')

@section('content')

@if (session('ErrorMessage'))
    <div class="alert alert-danger" role="alert">
        {{ session('ErrorMessage') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<form action="{{ route('reparation.form-indent') }}" method="post">
    @csrf
    <input type="hidden" name="idBooking" value="{{ $booking->id_booking }}" />

    <div class="mb-3">
        <label for="additional_replacement_part">Tambahan Ganti Part: </label>
        <textarea name="additional_replacement_part" class="form-control"></textarea>
        @error('additional_replacement_part')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="additional_price">Harga: </label>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="price-addon">Rp.</span>
            </div>
            <input type="text" name="additional_price" class="form-control" aria-describedby="price-addon">
        </div>
        @error('additional_price')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="text-end">
        @if (!in_array($booking->repair_status, ['KONTROL', 'INSPECTION LIST', 'EKSEKUSI']))
            <a href="{{ route('reparation.index', ['idBooking' => $booking->id_booking]) }}" class="btn btn-outline-primary mb-4 ms-auto">
                Kembali
            </a>
        @else
            <button type="submit" class="btn btn-primary mb-4 ms-auto">
                Indent!
            </button>
        @endif
    </div>
</form>
@endsection
