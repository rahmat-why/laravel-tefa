<!-- resources/views/your_view_name.blade.php -->

@extends('layouts.app')

@section('title', 'Form part tambahan')

@section('content')

<div class="container">
    <!-- Display success or error messages -->
    @if (session('successMessage'))
        <div class="alert alert-danger" role="alert">
            {{ session('successMessage') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('errorMessage'))
        <div class="alert alert-danger" role="alert">
            {{ session('errorMessage') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Display form and booking information -->
   
    <form action="{{ route('reparation.post-form-indent') }}" method="post">
        @csrf
        @method('POST') <!-- Gunakan metode POST untuk pembaruan -->
        <input type="hidden" name="idBooking" value="{{$booking->id_booking}}">
            <div class="mb-3">
                <label class="form-label">Tambahan Ganti Part</label>
                <textarea class="form-control" name="additional_replacement_part">{{ $booking->additional_replacement_part }}</textarea>
                @error('additional_replacement_part')
                            <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Tambahan Harga</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="price-addon">Rp.</span>
                    </div>
                    <input type="text" name="additional_price" onkeypress="return isNumberKey(event)" value="{{ old('additional_price', $booking->additional_price !== null ? number_format($booking->additional_price, 2, ',', '.') : '') }}" class="form-control" aria-describedby="price-addon">
                </div>    
                @error('additional_price')
                        <span class="text-danger">{{ $message }}</span>
                @enderror
        @if($booking->repair_status=='PENDING')
            <div  class="text-end">
                <button type="submit" class="btn btn-primary mb-4 ms-auto">Simpan</button>
            </div>
        @else
            <div class="text-end">
                <a href="{{ route('reparation.index', ['idBooking' => $booking->id_booking]) }}" class="btn btn-primary mb-4 ms-auto">Kembali</a>
            </div>
        @endif
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
