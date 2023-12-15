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
        <input type="text" name="repair_description" class="form-control" value="{{ $booking['repair_description'] }}" />
        @error('repair_description')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="replacement_part">Ganti Part : </label>
        <input type="text" name="replacement_part" class="form-control" value="{{ $booking['replacement_part'] }}" />
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
            <input type="text" name="price" onkeypress="return isNumberKey(event)" value="{{ old('price', $booking->price !== null ? number_format($booking->price, 2, ',', '.') : '') }}" class="form-control" aria-describedby="price-addon">
        </div>
        @error('price')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="finish_estimation_time">Estimasi Selesai:</label>
        <input type="datetime-local" name="finish_estimation_time" class="form-control" value="{{ $booking->finish_estimation_time }}" />
        @error('finish_estimation_time')
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

<script>
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode;

        // Mengecek apakah karakter tersebut adalah angka (0-9) atau tanda titik (.)
        if ((charCode < 48 || charCode > 57) && charCode !== 46) {
            return false;
        }

        // Mengecek apakah karakter titik (.) muncul lebih dari satu kali
        var inputValue = evt.target.value;
        if (charCode === 46 && inputValue.indexOf('.') !== -1) {
            return false;
        }
        
        return true;
    }
</script>
@endsection
