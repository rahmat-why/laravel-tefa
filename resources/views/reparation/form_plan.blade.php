@extends('layouts.app')

@section('title', 'PERENCANAAN')

@section('content')

@if (session('ErrorMessage'))
    <div class="alert alert-danger" role="alert">
        {{ session('ErrorMessage') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<form action="{{ route('reparation.process-form-plan') }}" method="post">
    @csrf
    <input type="hidden" name="id_booking" value="{{ $booking['id_booking'] }}" />
    <div class="mb-3">
        <label for="repair_description">Perbaikan : </label>
        <textarea name="repair_description" class="form-control">{{ $booking['repair_description'] }}</textarea>
        @error('repair_description')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="replacement_part">Ganti Part : </label>
        <textarea name="replacement_part" class="form-control">{{ $booking['replacement_part'] }}</textarea>
        <small class="text-muted">Opsional: Anda dapat mengosongkan bagian ini jika tidak diperlukan.</small>
        @error('replacement_part')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="price">Harga:</label>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="price-addon">Rp.</span>
            </div>
            <input type="text" name="price" value="{{ old('price', str_replace(',', '', number_format($booking->price))) }}" class="form-control" aria-describedby="price-addon">
        </div>
        @error('price')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="working_cost">Biaya Jasa:</label>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="service-fee-addon">Rp.</span>
            </div>
            <input type="text" name="working_cost" value="{{ old('working_cost', str_replace(',', '', number_format($booking->working_cost))) }}" class="form-control" aria-describedby="working-cost-addon">
        </div>
        @error('working_cost')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="text-end">
        @if (!in_array($booking->repair_status, ['PERENCANAAN', 'KEPUTUSAN']))
            <a href="{{ route('reparation.index', ['idBooking' => $booking->id_booking]) }}" class="btn btn-outline-primary mb-4 ms-auto">
                Kembali
            </a>
        @else
            <button type="submit" class="btn btn-primary mb-4 ms-auto">
                Lanjut Keputusan!
            </button>
        @endif
    </div>
</form>
@endsection
