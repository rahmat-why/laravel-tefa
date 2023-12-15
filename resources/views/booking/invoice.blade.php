<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
        <!-- Top-right corner content -->
        <div class="top-right">
    <div>
        <b>TEACHING FACTORY</b><br>
        Politeknik Astra
    </div>
</div>
</div>
    <div class="container">
        <div class="card">
            <div class="card-body">
                    <div style="text-align: center; margin-top: 20px;">
                    <p></p>
                        <b>INVOICE #{{ $bookings->id_booking }}</b>
                        <p></p>
                    </div>
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 50%;">
                        <dl>
                                <dt>Tanggal Booking: {{ $bookings->order_date }}</dt>
                                <dt>Tipe Kendaraan: {{ $bookings->idVehicleNavigation->classify }}</dt>
                                <dt>Nama Customer: {{ $bookings->idVehicleNavigation->idCustomerNavigation->name }}</dt>
                                <dt>No. Polisi: {{ $bookings->idVehicleNavigation->police_number }}</dt>
                                <dt>Email: {{ $bookings->idVehicleNavigation->idCustomerNavigation->email }}</dt>
                            </dl>
                        </td>
                        <td style="width: 50%;">
                            <dl>
                                <dt>Odometer: {{ $bookings->odometer }}</dt>
                                <dt>No.Telpon: {{ $bookings->idVehicleNavigation->idCustomerNavigation->phone }}</dt>
                                <dt>No. Rangka: {{ $bookings->idVehicleNavigation->chassis_number }}</dt>
                                <dt>Alamat: {{ $bookings->idVehicleNavigation->idCustomerNavigation->address }}</dt>
                                <dt>No. Mesin: {{ $bookings->idVehicleNavigation->machine_number }}</dt>
                            </dl>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
    <thead style="background-color: #343a40; color: #fff;">
        <tr>
            <th style="padding: 1px; border: 1px solid #dee2e6; vertical-align: middle;">Perbaikan</th>
            <th style="padding: 10px; border: 1px solid #dee2e6; vertical-align: middle;">Ganti Part</th>
            <th style="padding: 10px; border: 1px solid #dee2e6; vertical-align: middle;">Harga</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="padding: 10px; border: 1px solid #dee2e6; vertical-align: middle;">{{ $bookings->repair_description ?: '-' }}</td>
            <td style="padding: 10px; border: 1px solid #dee2e6; vertical-align: middle;">{{ $bookings->replacement_part ?: '-' }}</td>
            <td style="padding: 10px; border: 1px solid #dee2e6; vertical-align: middle;">Rp.{{ number_format($bookings->price ?: 0, 0, ',', '.') }}</td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            @if($bookings->additional_replacement_part == null)
            <td><a></a></td>
            @else
            <td style="padding: 10px; border: 1px solid #dee2e6; vertical-align: middle;">Temuan</td>
            <td style="padding: 10px; border: 1px solid #dee2e6; vertical-align: middle;">{{ $bookings->additional_replacement_part ?: '-' }}</td>
            <td style="padding: 10px; border: 1px solid #dee2e6; vertical-align: middle;">Rp.{{ number_format($bookings->additional_price ?: 0, 0, ',', '.') }}</td>
            @endif
        </tr>
    </tbody>
</table>
<p>Terimakasih telah menggunakan layanan teaching factory  program studi mesin otomotif politeknik astra</p>

</body>
</html>
