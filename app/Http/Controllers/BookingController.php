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
            ->whereNotIn('repair_status', ['BATAL', 'SELESAI']);

        if(auth()->user()->position == "HEAD MECHANIC") {
            $bookings->where("head_mechanic", auth()->user()->id_user);
        }

        $bookings = $bookings->orderBy('order_date', 'DESC')
            ->get();

        return view('booking.history', ['bookings' => $bookings]);
    }

    public function Index()
    {
        $bookings = TrsBooking::with('IdVehicleNavigation')
        ->whereHas('IdVehicleNavigation', function ($query) {
            $query->where('id_customer', auth()->user()->id_customer);
        })
        ->orderBy('order_date', 'DESC')
        ->get();
        return view('booking.Index', compact('bookings'));
    }

    public function create()
    {
        $vehicles = MsVehicle::where('id_customer', auth()->user()->id_customer)->
        whereIn('classify',['MOBIL','MOTOR'])->get();
        return view('booking.Create', compact('vehicles'));
    }      

    public function store(Request $request)
    {
        $request->validate([
            'order_date' => 'required|date|after_or_equal:tomorrow',
            'odometer' => 'required|numeric',
            'complaint' => 'required|regex:/^[A-Za-z0-9 ]+$/',
        ], [
            'order_date.required' => ' wajib diisi.',
            'order_date.after_or_equal' => ' pemesanan hanya boleh H+1',
            'odometer.required' => ' wajib diisi.',
            '.numeric' => ' harus mengandung angka saja.',
            'complaint.regex' => ' harus mengandung huruf, angka, dan spasi saja.',
            'complaint.required' => ' wajib diisi.',
        ]);

        // Check maximum bookings per day
        $countBookingToday = TrsBooking::where('order_date', '=', $request->input('order_date'))
        ->count();

        if ($countBookingToday >= 10) {
            return redirect()
                ->route('booking.Create')
                ->with('ErrorMessage', 'Maaf kapasitas booking hari ini sudah penuh (10 per hari)');
        }

        // Check if the vehicle is currently being serviced
        $countBookingRunning = TrsBooking::where('id_vehicle', '=', $request->input('id_vehicle'))
        ->where(function ($query) {
            $query->where('repair_status', '!=', 'SELESAI')
                ->orWhere('repair_status', '!=', 'BATAL');
        })
        ->count();

        if ($countBookingRunning > 0) {
            return redirect()
                ->route('booking.Create', ['RepairMethod' => $request->input('repair_method')])
                ->with('ErrorMessage', 'Kendaraan ini sedang diservis');
        }
        
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
        whereIn('classify',['MOBIL','MOTOR'])-> get();
        return view('booking.fasttrack', compact('vehicles'));
    }      

    public function faststore(Request $request)
    {
        $request->validate([
            'odometer' => 'required|numeric',
            'complaint' => 'required|regex:/^[A-Za-z0-9 ]+$/',
        ], [
            'odometer.required' => ' wajib diisi.',
            'odometer.numeric' => ' harus mengandung angka saja.',
            'complaint.regex' => ' harus mengandung huruf, angka, dan spasi saja.',
            'complaint.required' => ' wajib diisi.',
        ]);

        // Check maximum bookings per day
        $countBookingToday = TrsBooking::where('order_date', '=', $request->input('order_date'))
        ->count();

        if ($countBookingToday >= 10) {
            return redirect()
                ->route('booking.fast')
                ->with('ErrorMessage', 'Maaf kapasitas booking hari ini sudah penuh (10 per hari)');
        }

        // Check if the vehicle is currently being serviced
        $countBookingRunning = TrsBooking::where('id_vehicle', '=', $request->input('id_vehicle'))
        ->where(function ($query) {
            $query->where('repair_status', '!=', 'SELESAI')
                ->orWhere('repair_status', '!=', 'BATAL');
        })
        ->count();

        if ($countBookingRunning > 0) {
            return redirect()
                ->route('booking.fast', ['RepairMethod' => $request->input('repair_method')])
                ->with('ErrorMessage', 'Kendaraan ini sedang diservis');
        }

        $count_booking = TrsBooking::count();
        $autoid = $count_booking+1;
        $request->merge(['id_booking' => 'BKN' . $autoid]);
        $request->merge(['order_date' => now()->format('Y-m-d')]);
        $request->merge(['repair_method' => 'FAST TRACK']);
        $request->merge(['repair_status' => 'MENUNGGU']);

        TrsBooking::create($request->all());

        return redirect()->route('booking.Index')->with('successMessage', 'Fast Track berhasil dilakukan!');
    }

    public function progress()
    {
        $bookings = TrsBooking::whereNotIn("repair_status", ["SELESAI", "MENUNGGU", "BATAL"])
        ->orderBy("progress", "DESC")
        ->get();

        return view('booking.progress', ['bookings' => $bookings]);
    }

    public function report(Request $request)
    {
        // Ambil bulan dari parameter request atau gunakan bulan saat ini jika tidak ada
        $month = $request->input('month', Carbon::now()->format('Y-m'));

        // Ambil data pemesanan yang telah selesai atau dibatalkan dengan menyertakan kendaraan dan pelanggan terkait
        $report = TrsBooking::with(['idVehicleNavigation.idCustomerNavigation'])
            ->whereIn('repair_status', ['SELESAI', 'BATAL'])
            ->whereMonth('order_date', Carbon::parse($month)->month)
            ->orderBy('order_date', 'desc')
            ->get();

        // Hitung jumlah pemesanan dengan metode perbaikan TEFA dan SERVICE yang telah selesai
        $countTefa = TrsBooking::where('repair_method', 'TEFA')
            ->whereIn('repair_status', ['SELESAI', 'BATAL'])
            ->whereMonth('order_date', Carbon::parse($month)->month)
            ->count();

        $countService = TrsBooking::where('repair_method', 'FAST TRACK')
            ->whereIn('repair_status', ['SELESAI', 'BATAL'])
            ->whereMonth('order_date', Carbon::parse($month)->month)
            ->count();

        // Hitung jumlah pemesanan yang dibatalkan
        $countBatal = TrsBooking::where('repair_status', 'BATAL')
            ->whereMonth('order_date', Carbon::parse($month)->month)
            ->count();
            
        $daily_report = TrsBooking::selectRaw("
                SUM(CASE WHEN repair_method = 'TEFA' THEN 1 ELSE 0 END) as count_tefa,
                SUM(CASE WHEN repair_method = 'FAST TRACK' THEN 1 ELSE 0 END) as count_fasttrack,
                order_date
            ")
            ->whereIn('repair_status', ['SELESAI', 'BATAL'])
            ->whereMonth('order_date', Carbon::parse($month)->month)
            ->groupBy('order_date')
            ->get();
        
        // Initialize empty arrays
        $data_tefa = [];
        $data_fasttrack = [];
        $data_orderdate = [];
        
        // Populate arrays based on $daily_report results
        foreach ($daily_report as $daily) {
            // Assuming $report->total_booking represents the data you want to use
            $data_tefa[] = $daily->count_tefa;
        
            // Assuming $report->repair_method represents the data for fasttrack
            $data_fasttrack[] = $daily->count_fasttrack;
        
            // Assuming $report->order_date is in the format "d/m"
            $data_orderdate[] = $daily->order_date->format('d F Y');
        }

        return view('booking.report', compact('report', 'countTefa', 'countService', 'countBatal', 'month', 'data_tefa', 'data_fasttrack', 'data_orderdate'));
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

        if (!in_array($bookings->repair_status, ['BATAL', 'SELESAI'])) {
            session()->flash('ErrorMessage', 'Invoice belum bisa diunduh karena servis belum selesai!');
            return redirect()->route('reparation.index', ['idBooking' => $id_booking]);
        }
        
        $mpdf->WriteHTML(view("booking.invoice",['bookings' => $bookings]));
        $mpdf->Output('INVOICE '.$id_booking.'.pdf','D' );
    }
}

