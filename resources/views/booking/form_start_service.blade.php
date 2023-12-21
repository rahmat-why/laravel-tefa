@extends('layouts.app')

@section('title', 'MULAI SERVIS')

@section('content')

@if (session('ErrorMessage'))
    <div class="alert alert-danger" role="alert">
        {{ session('ErrorMessage') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<form action="{{ route('reparation.post-form-start-service') }}" method="post">
    @csrf
    <input type="hidden" name="idBooking" value="{{ $booking['id_booking'] }}" />
    <div class="mb-3">
        <label for="finish_estimation_time">Estimasi Selesai:</label>
        <input type="datetime-local" name="finish_estimation_time" class="form-control" value="{{ $booking->finish_estimation_time }}" />
        @error('finish_estimation_time')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="head_mechanic">Head Mechanic : </label>
        <select name="head_mechanic" class="form-control">
            @foreach($head_mechanic as $head_mechanic_name)
                <option value="{{ $head_mechanic_name->id_user }}" @if($booking->head_mechanic == $head_mechanic_name->id_us) selected @endif>{{ $head_mechanic_name->full_name }}</option>
            @endforeach
        </select>
        @error('head_mechanic')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    
    <div class="text-end">
    @if (!in_array($booking->repair_status, ['MENUNGGU','PERENCANAAN']))
        <a href="{{ route('reparation.index', ['idBooking' => $booking->id_booking]) }}" class="btn btn-outline-primary mb-4 ms-auto">
            Kembali
        </a>
    @else
        <button type="submit" class="btn btn-primary mb-4 ms-auto">
            Mulai Servis!
        </button>
    @endif
</div>
</form>
@endsection
