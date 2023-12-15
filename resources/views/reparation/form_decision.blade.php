@extends('layouts.app')

@section('title', 'KEPUTUSAN')

@section('content')

@if (session('ErrorMessage'))
    <div class="alert alert-danger" role="alert">
        {{ session('ErrorMessage') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<form action="{{ route('reparation.post-form-decision') }}" method="post">
    @csrf
    <input type="hidden" name="id_booking" value="{{ $booking['id_booking'] }}" />

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
                    Persetujuan Customer
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    @if (!$booking['repair_description'])
                        <span>-</span>
                    @else
                        {{ $booking['repair_description'] }}
                    @endif
                </td>
                <td>
                    @if (!$booking['replacement_part'])
                        <span>-</span>
                    @else
                        {{ $booking['replacement_part'] }}
                    @endif
                </td>
                <td>
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="radio" name="decision" class="form-check-input" value="1" id="yes" {{ $booking->decision != null && $booking->decision == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="yes">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="decision" class="form-check-input" value="0" id="no" {{ $booking->decision != null && $booking->decision == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="no">Tidak</label>
                        </div>
                        @if ($errors->has('decision'))
                            <span class="text-danger">{{ $errors->first('decision') }}</span>
                        @endif
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="text-end">
        @if (!in_array($booking->repair_status, ['KEPUTUSAN', 'INSPECTION LIST']))
            <a class="btn btn-outline-success mb-4 ms-auto" data-phone="{{ optional($booking->idVehicleNavigation)->idCustomerNavigation->phone }}" onclick="copyPhone(this)" data-toggle="tooltip" data-placement="top" title="Salin nomor whatsapp"><i class="ti ti-brand-whatsapp"></i></a>
            <a href="{{ route('reparation.index', ['idBooking' => $booking->id_booking]) }}" class="btn btn-outline-primary mb-4 ms-auto">
                Kembali
            </a>
        @else
            <button type="submit" class="btn btn-primary mb-4 ms-auto">
                Lanjut Eksekusi!
        @endif
    </div>
</form>
@endsection

