@extends('layouts.app')

@section('title', 'Daftar Booking')

@section('content')
    <table class="table">
        <thead>
            <tr>
                <th>Nama Customer</th>
                <th>Tanggal Booking</th>
                <th>Merk</th>
                <th>No.Polisi</th>
                <th>Odometer</th>
                <th>Keluhan</th>
                <th>Status</th>
                <th>Metode Servis</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($bookings as $booking)
            @php
            $background_color = '';
                if ($booking->repair_status == 'MENUNGGU') {
                    if ($booking->repair_method == 'TEFA'){
                        $background_color = 'background-color: yellow;';
                    }else{
                        $background_color = 'background-color: red;';
                    }
                }else{
                    $background_color = 'background-color: white;';
                }
            @endphp
            
            <tr style = "{{ $background_color }}">
                <td>
                    {{ optional(optional($booking->idVehicleNavigation)->idCustomerNavigation)->name ?? 'N/A' }}
                    <a class="btn btn-outline-success btn-sm"
                    data-phone="{{ optional(optional($booking->idVehicleNavigation)->idCustomerNavigation)->phone }}"
                    onclick="copyPhone(this)" data-toggle="tooltip" data-placement="top" title="Salin nomor whatsapp">
                        <i class="ti ti-brand-whatsapp"></i>
                    </a>
                </td>
                <td>
                    {{ optional($booking->order_date)->format('d F Y') }}
                </td>
                <td>
                    {{ optional(optional($booking->idVehicleNavigation))->type ?? 'N/A' }}
                    <a class="btn btn-outline-primary btn-sm" href="{{ route('vehicles.history', ['id' => $booking->id_vehicle]) }}" data-toggle="tooltip" data-placement="top" title="Lihat riwayat kendaraan">
                        <i class="ti ti-history"></i>
                    </a>
                </td>
                <td>{{ optional(optional($booking->idVehicleNavigation))->police_number ?? 'N/A' }}</td>
                <td>{{ $booking->odometer }}</td>
                <td>{{ $booking->complaint }}</td>
                <td>{{ $booking->repair_status }}</td>
                <td>
                @if($booking->repair_status == "MENUNGGU")
                    <form method="post" action="{{ route('reparation.post-form-start-service') }}" onsubmit="return confirm('Apakah anda yakin untuk memulai servis ini?');">
                        @csrf
                        <input type="hidden" name="idBooking" value="{{$booking->id_booking}}">
                        <input type="submit" value="{{ $booking->repair_method }}" style="background: none; border: none; color: blue; cursor: pointer; text-decoration: none;">
                    </form>
                @else
                    <a href="{{ route('reparation.index', ['idBooking' => $booking->id_booking]) }}">
                        {{ $booking->repair_method }}
                    </a>
                @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
<script>
    function copyPhone(button) {
        var phoneNumber = $(button).data('phone');

        // Create a temporary input element
        var tempInput = $('<input>');
        $('body').append(tempInput);

        // Set the value of the input to the phone number
        tempInput.val(phoneNumber);

        // Select and copy the text from the input
        tempInput.select();
        document.execCommand('copy');

        // Remove the temporary input element
        tempInput.remove();

        // You can provide feedback to the user, e.g., show a tooltip or alert
        alert('Nomor whatsapp berhasil disalin: ' + phoneNumber);
    }
</script>
