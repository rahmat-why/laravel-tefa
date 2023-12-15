@extends('layouts.app')

@section('title', 'EVALUASI')

@section('content') 

@if (session('ErrorMessage'))
    <div class="alert alert-danger" role="alert">
        {{ session('ErrorMessage') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<form action="{{ route('reparation.post-form-evaluation') }}" method="post">
    @csrf
    <input type="hidden" name="idBooking" value="{{ $booking['id_booking'] }}" />
    <div class="mb-3">
  
        <label for="evaluation">Evaluasi: </label>
        <textarea name="evaluation" class="form-control">{{ $booking['evaluation'] }}</textarea>
        @error('evaluation')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="text-end">
        @if ($booking->repair_status != "EVALUASI")
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
