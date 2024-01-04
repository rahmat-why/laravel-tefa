<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

@php
    $total = $bookings->price+$bookings->additional_price+$bookings->working_cost;
@endphp
        <!-- Top-right corner content -->
<div class="top-right">
    <table style="width: 250px;">
        <tr>
            <td>
                <img src="{{ public_path().'/assets/images/logos/logo.png' }}" style="width: 40px">
            </td>
            <td style="position: relative; left: -50px;">
                <b>TEACHING FACTORY</b><br>
                Politeknik Astra
            </td>
        </tr>
    </table>
</div>
<div class="container">
    <div class="card">
        <div class="card-body">
            <div style="text-align: center; margin-top: 20px;">
                <h4>
                    <b>INVOICE</b>
                </h4>
            </div>
            <table style="width: 100%;">
                <tr>
                    <td style="width: 50%;">
                        <dl>
                            <p style="margin-top: 15px !important;">Tanggal Booking: {{ \Carbon\Carbon::parse($bookings->order_date)->format('d F Y') }}</p>
                            <p style="margin-top: 15px !important;">Nama Customer: {{ $bookings->idVehicleNavigation->idCustomerNavigation->name }}</p>
                            <p style="margin-top: 15px !important;">Email: {{ $bookings->idVehicleNavigation->idCustomerNavigation->email }}</p>
                            <p style="margin-top: 15px !important;">Telp: {{ $bookings->idVehicleNavigation->idCustomerNavigation->phone }}</p>
                            <p style="margin-top: 15px !important;">Alamat: {{ $bookings->idVehicleNavigation->idCustomerNavigation->address }}</p>
                            
                        </dl>
                    </td>
                    <td style="width: 50%;">
                        <dl>
                            <dt style="margin-top: 15px !important;">Tipe Kendaraan: {{ $bookings->idVehicleNavigation->classify }}</dt>                            
                            <dt style="margin-top: 15px !important;">No. Polisi: {{ $bookings->idVehicleNavigation->police_number }}</dt>
                            <dt style="margin-top: 15px !important;">Odometer: {{ $bookings->odometer }}</dt>
                            <dt style="margin-top: 15px !important;">No. Rangka: {{ $bookings->idVehicleNavigation->chassis_number }}</dt>
                            <dt style="margin-top: 15px !important;">No. Mesin: {{ $bookings->idVehicleNavigation->machine_number }}</dt>
                        </dl>
                    </td>
                </tr>
                <div></div>
                <tr>
                    <td colspan="2" style="border-top: 1px solid #343a40;"></td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #343a40;">
                        <dl>
                            <p style="margin-top: 15px !important;">Nomor Invoice: {{ $bookings->id_booking }}</p>
                            <p style="margin-top: 15px !important;">Head Mechanic: {{ $bookings->headMechanicNavigation->full_name }}</p>
                        </dl>
                    </td>
                    <td style="width: 50%; border-bottom: 1px solid #343a40;">
                        <dl>'
                            <dt style="margin-top: 15px !important;">Status: {{ $bookings->repair_status }}</dt>
                            <dt style="margin-top: 15px !important;">Service Advisor: {{ $bookings->serviceAdvisorNavigation->full_name}}</dt>
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
            <th style="padding: 10px; border: 1px solid #dee2e6; vertical-align: middle;">Pajak</th>
            <th style="padding: 10px; border: 1px solid #dee2e6; vertical-align: middle;">Total Harga</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="padding: 10px; border: 1px solid #dee2e6; vertical-align: middle;">{{ $bookings->repair_description ?: '-' }}</td>
            <td style="padding: 10px; border: 1px solid #dee2e6; vertical-align: middle;">{{'-' }}</td>
            <td style="padding: 10px; border: 1px solid #dee2e6; vertical-align: middle;">Rp. {{ number_format($total ?: 0, 0, ',', '.') }}</td>
        </tr>
    </tbody>
    <!-- <tbody>
        <tr>
            @if($bookings->additional_replacement_part == null)
            <td><a></a></td>
            @else
            <td style="padding: 10px; border: 1px solid #dee2e6; vertical-align: middle;">Temuan</td>
            <td style="padding: 10px; border: 1px solid #dee2e6; vertical-align: middle;">{{ $bookings->additional_replacement_part ?: '-' }}</td>
            <td style="padding: 10px; border: 1px solid #dee2e6; vertical-align: middle;">Rp. {{ number_format($bookings->additional_price ?: 0, 0, ',', '.') }}</td>
            @endif
        </tr>
    </tbody> -->
</table>
<table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
    <thead style="background-color: #343a40; color: #fff;">
        <tr>
            <td style="margin-top: 15px !important;">Detail Price :</td>
            @if($bookings->replacement_part !=null)
            <tr>
                <td style="margin-top: 15px !important;">{{$bookings->replacement_part }} </td>
                <td style="margin-top: 15px !important;">Rp. {{ number_format($bookings->price ?: 0, 0, ',', '.') }}</td>
            </tr>
            @endif

            @if($bookings->additional_replacement_part !=null)
            <tr>
                <td style="margin-top: 15px !important;">{{$bookings->additional_replacement_part }} </td>
                <td style="margin-top: 15px !important;">Rp. {{ number_format($bookings->additional_price ?: 0, 0, ',', '.') }}</td>
            </tr>
            @endif

            @if($bookings->working_cost !=null)
            <tr>
                <td style="margin-top: 15px !important;">Biaya Kerja </td>
                <td style="margin-top: 15px !important;">Rp. {{ number_format($bookings->working_cost ?: 0, 0, ',', '.') }}</td> 
            </tr>
            @endif
        </tr>
    </thead>
</table>

<h4>Total: <b>Rp. {{ number_format($total ?: 0, 0, ',', '.') }}</b></h4>
<p>Terimakasih telah menggunakan layanan teaching factory  program studi mesin otomotif politeknik astra</p>

</body>
</html>
