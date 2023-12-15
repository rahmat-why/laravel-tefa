<!-- resources/views/your_view_name.blade.php -->

@extends('layouts.app')

@section('title', 'Form part tambahan')

@section('content')

<div class="container">
    <!-- Display success or error messages -->
    @if (session('successMessage'))
        <div class="alert alert-success">
            {{ session('successMessage') }}
        </div>
    @endif

    @if (session('errorMessage'))
        <div class="alert alert-danger">
            {{ session('errorMessage') }}
        </div>
    @endif

    <!-- Display form and booking information -->
   
    <form method="post" action="{{ route('reparation.formindent.post', $booking->id_booking) }}">
        @csrf
        @method('PUT') <!-- Gunakan metode PUT untuk pembaruan -->
            <div class="mb-3">
                <label class="form-label">Tambahan Ganti Part</label>
                <textarea class="form-control" name="additional_replacement_part">{{ $booking->additional_replacement_part }}</textarea>
                @error('additional_replacement_part')
                            <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Tambahan Harga</label>
                <input type="text" class="form-control" name="additional_price" value="{{ $booking->additional_price }}">
                @error('additional_price')
                        <span class="text-danger">{{ $message }}</span>
                @enderror
        @if($repair_status=='PENDING')
            <div  class="text-end">
                <button type="submit" class="btn btn-primary mb-4 ms-auto">Simpan</button>
            </div>
        @else
            <div class="text-end">
                <a href="{{ route('booking.history.form') }}" class="btn btn-primary mb-4 ms-auto">Kembali</a>
            </div>
        @endif
    </form>

@endsection

