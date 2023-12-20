@extends('layouts.app')

@section('title', 'FORM TEMUAN')

@section('content')

@if (session('errorMessage'))
    <div class="alert alert-danger" role="alert">
        {{ session('errorMessage') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<form action="{{ route('reparation.post-form-special-handling') }}" method="post">
    @csrf
    <input type="hidden" name="id_booking" value="{{ $booking->id_booking }}" />

    <div class="mb-3">
        <label for="additional_replacement_part">Tambahan Ganti Part:</label>
        <textarea name="additional_replacement_part" class="form-control">{{ $booking->additional_replacement_part }}</textarea>
        @error('additional_replacement_part')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="additional_price">Harga:</label>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="price-addon">Rp.</span>
            </div>
            <input name="additional_price" class="form-control" aria-describedby="price-addon" value="{{ old('additional_price', str_replace(',', '', number_format($booking->additional_price))) }}">
        </div>
        @error('additional_price')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="text-end">
        @if ($booking->repair_status !== 'PENDING')
            <a href="{{ route('reparation.index', ['idBooking' => $booking->id_booking]) }}" class="btn btn-outline-primary mb-4 ms-auto">
                Kembali
            </a>
        @else
            <button type="submit" class="btn btn-primary mb-4 ms-auto">
                Simpan Temuan!
            </button>
        @endif
    </div>
</form>
@endsection
