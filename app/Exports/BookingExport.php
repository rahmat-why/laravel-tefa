<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BookingExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        // Membuat koleksi dengan struktur asli tetapi hanya dengan field 'order_date' dan 'nama_pelanggan'
        $formattedData = collect($this->data)->map(function ($booking) {
            return [
                $booking['id_booking'],
                optional($booking['idVehicleNavigation']['idCustomerNavigation'])['name'] ?? '-',
                optional($booking['order_date'])->format('Y-m-d') ?? '-',
                optional($booking['idVehicleNavigation'])['type'] ?? '-',
                optional($booking['idVehicleNavigation'])['police_number'] ?? '-',
                $booking['odometer'] ?? '-',
                $booking['complaint'] ?? '-',
                optional($booking['start_repair_time'])->format('Y-m-d H:i') ?? '-',
                optional($booking['end_repair_time'])->format('Y-m-d H:i') ?? '-',
                optional($booking['finish_estimation_time'])->format('Y-m-d H:i') ?? '-',
                $booking['repair_description'] ?? '-',
                $booking['replacement_part'] ?? '-',
                $booking['price'] ?? '-',
                $booking['evaluation'] ?? '-',
                $booking['repair_method'] ?? '-',
                $booking['additional_replacement_part'] ?? '-',
                $booking['decision'] == 1 ? 'Ya' : ($booking['decision'] == 2 ? 'Tidak' : '-'),
            ];
        });

        return $formattedData;
    }

    public function headings(): array
    {
        return [
            'ID Booking',
            'Nama Pelanggan',
            'Tanggal Booking',
            'Tipe Kendaraan',
            'No. Polisi',
            'Odometer (km)',
            'Keluhan',
            'Mulai Servis',
            'Selesai Servis',
            'Estimasi Selesai',
            'Deskripsi Perbaikan',
            'Deskripsi Ganti Part',
            'Tagihan',
            'Evaluasi',
            'Metode Servis',
            'Tambahan Tagihan',
            'Keputusan',
        ];
    }
}
