<?php
namespace App\Http\Controllers;
use App\Models\TrsBooking;
use App\Models\TrsPending;

use Illuminate\Http\Request;
use Carbon\Carbon;
class PendingController extends Controller
{
    function index($id_booking){
        $pending = TrsPending::where("id_booking", $id_booking)->get();
        $repair_status = TrsBooking::where("id_booking", $id_booking)->value('repair_status');
        return view('pending.index',['pending' => $pending,'id_booking' => $id_booking, 'repair_status'=>$repair_status]);
    }

    function startpending(Request $request){
        $timezone = 'Asia/Jakarta';
        $request->validate([
            'reason' => 'required|regex:/^[A-Za-z0-9 ]+$/',
        ], [
            'reason.required' => 'Alasan wajib diisi.',
            'reason.regex' => 'Alasan harus mengandung huruf, angka, dan spasi saja.',
        ]);
        
        // Buat id otomatis pending
        $count_pending = TrsPending::count();
        $autoid = $count_pending+1;
        $request->merge(['id_pending' => 'PND' . $autoid]);
        $request->merge(['id_user' => auth()->user()->id_user]);

        //waktu sekarang zona 
        $waktuSekarang = Carbon::now($timezone);
        $request->merge(['start_time' => $waktuSekarang]);
        // Simpan data ke dalam database setelah validasi
        TrsPending::create($request->all());

        TrsBooking::where('id_booking', $request->id_booking)
        ->update(['repair_status' => 'PENDING']);

        // Redirect ke halaman yang diinginkan setelah data disimpan
        return redirect()->route('booking.history.form')->with('successMessage', 'Kendaraan berhasil disimpan!');
    }

    public function stoppending(Request $request, $id_pending)
    {
        //time zone
        $timezone = 'Asia/Jakarta';
        $pending = TrsPending::find($id_pending);
    
        if (!$pending) {
            return redirect()->route('booking.history.form');
        }
        $booking = TrsBooking::find($pending->id_booking);
        $waktuSekarang = Carbon::now($timezone);
        $waktuSekarang = Carbon::now($timezone);
        $pending->update([
            
            'finish_time' => $waktuSekarang,
        ]);
        if ($booking->progress == 20) {
            $repair_status = "INSPECTION LIST";
        } elseif ($booking->progress == 45) {
            $repair_status = "EKSEKUSI";
        } else {
            $repair_status = "KONTROL";
        }

        $newFinishEstimationTime = Carbon::parse($booking->finish_estimation_time)
        ->addSeconds(Carbon::parse($pending->finish_time)->diffInSeconds(Carbon::parse($pending->start_time)))
        ->setTimezone($timezone);
        
        $booking->update([
            'repair_status'=>$repair_status,
            'finish_estimation_time'=>  $newFinishEstimationTime,
        ]);        
        return redirect()->route('booking.history.form')->with('successMessage', 'Kendaraan berhasil disimpan!');
    }
    
}
