<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\TrsBooking;
use App\Models\MsUser;
use App\Models\MsVehicle;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BookingExport; // 

class BookingController extends Controller
{
    public function history()
    {
        $bookings = TrsBooking::with(['idVehicleNavigation.idCustomerNavigation'])
            ->where('repair_status', '!=', 'SELESAI')
            ->orderBy('order_date')
            ->get();

        return view('booking.history', ['bookings' => $bookings]);
    }

    public function Index()
    {
        $bookings = TrsBooking::with('IdVehicleNavigation')
        ->whereHas('IdVehicleNavigation', function ($query) {
            $query->where('id_customer', auth()->user()->id_customer);
        })
        ->orderBy('order_date', 'asc')
        ->get();
        return view('booking.Index', compact('bookings'));
    }

    public function create()
    {
        $vehicles = MsVehicle::where('id_customer', auth()->user()->id_customer)->
                                whereIn('classify',['MOBIL','MOTOR'])->
                                get();
        return view('booking.Create', compact('vehicles'));
    }      

    public function store(Request $request)
{
    $request->validate([
        'order_date' => 'required|date|after:tomorrow',
        'odometer' => 'required|numeric',
        'complaint' => 'required|regex:/^[A-Za-z0-9 ]+$/',
    ], [
        'order_date.required' => 'Tanggal wajib diisi.',
        'order_date.after' => 'Tanggal pemesanan hanya boleh H+1',
        'odometer.required' => 'Odometer wajib diisi.',
        'odometer.numeric' => 'Odometer harus mengandung angka saja.',
        'complaint.regex' => 'Keluhan harus mengandung huruf, angka, dan spasi saja.',
        'complaint.required' => 'Keluhan wajib diisi.',
    ]);
    
    $count_booking = TrsBooking::count();
    $autoid = $count_booking+1;
    $request->merge(['id_booking' => 'BKN' . $autoid]);
    $request->merge(['repair_method' => 'TEFA']);
    $request->merge(['repair_status' => 'MENUNGGU']);
    TrsBooking::create($request->all());

    return redirect()->route('booking.Index')->with('successMessage', 'Booking berhasil dilakukan!');
}

public function fast()
{
    $vehicles = MsVehicle::where('id_customer', auth()->user()->id_customer)->
                            whereIn('classify',['MOBIL','MOTOR'])->
                            get();
    return view('booking.fasttrack', compact('vehicles'));
}      

public function faststore(Request $request)
{
    $request->validate([
        'odometer' => 'required|numeric',
        'complaint' => 'required|regex:/^[A-Za-z0-9 ]+$/',
    ], [
        'odometer.required' => 'Odometer wajib diisi.',
        'odometer.numeric' => 'Odometer harus mengandung angka saja.',
        'complaint.regex' => 'Keluhan harus mengandung huruf, angka, dan spasi saja.',
        'complaint.required' => 'Keluhan wajib diisi.',
    ]);

    $count_booking = TrsBooking::count();
    $autoid = $count_booking+1;
    $request->merge(['id_booking' => 'BKN' . $autoid]);
    $request->merge(['order_date' => now()->format('Y-m-d')]);
    $request->merge(['repair_method' => 'FAST TRACK']);
    $request->merge(['repair_status' => 'MENUNGGU']);

    TrsBooking::create($request->all());

    return redirect()->route('booking.Index')->with('successMessage', 'fast berhasil dilakukan!');
}

public function progress()
{
    $bookings = TrsBooking::all()->filter(function ($booking) {
        return $booking->progress < 100;
    });  

    return view('booking.progress', ['bookings' => $bookings]);
}


public function report(Request $request)
{
    // Ambil bulan dari parameter request atau gunakan bulan saat ini jika tidak ada
    $month = $request->input('month', Carbon::now()->format('Y-m'));

    // Ambil data pemesanan yang telah selesai atau dibatalkan dengan menyertakan kendaraan dan pelanggan terkait
    $report = TrsBooking::with(['idVehicleNavigation.idCustomerNavigation'])
        ->where(function ($query) {
            $query->where('repair_status', 'SELESAI')
                  ->orWhere('repair_status', 'BATAL');
        })
        ->whereMonth('order_date', Carbon::parse($month)->month)
        ->orderBy('order_date')
        ->get();

    // Hitung jumlah pemesanan dengan metode perbaikan TEFA dan SERVICE yang telah selesai
    $countTefa = TrsBooking::where('repair_method', 'TEFA')
        ->where('repair_status', 'SELESAI')
        ->whereMonth('order_date', Carbon::parse($month)->month)
        ->count();

    $countService = TrsBooking::where('repair_method', 'FAST TRACK')
        ->where('repair_status', 'SELESAI')
        ->whereMonth('order_date', Carbon::parse($month)->month)
        ->count();

    // Hitung jumlah pemesanan yang dibatalkan
    $countBatal = TrsBooking::where('repair_status', 'BATAL')
        ->whereMonth('order_date', Carbon::parse($month)->month)
        ->count();

    return view('booking.report', compact('report', 'countTefa', 'countService', 'countBatal', 'month'));
}

    
   
    public function export(Request $request)
    {
        $month = $request->input('month', Carbon::now()->format('Y-m'));

        $report = TrsBooking::with(['idVehicleNavigation.idCustomerNavigation'])
            ->where('repair_status', 'SELESAI')
            ->orwhere('repair_status', 'BATAL')
            ->whereMonth('order_date', Carbon::parse($month)->month)
            ->orderBy('order_date')
            ->get();

        $export = new \App\Exports\BookingExport($report);
        // Mendownload file Excel dengan nama "Laporan.xlsx"
        return Excel::download($export, 'Laporan.xlsx');
    }


    function pdf($id_booking){
        $mpdf = new \Mpdf\Mpdf();
        $bookings = TrsBooking::find($id_booking);
        
        $mpdf->WriteHTML(view("booking.invoice",['bookings' => $bookings]));
        $mpdf->Output('Invoice.pdf','D' );
    }
}

