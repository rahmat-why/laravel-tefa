<?php
namespace App\Http\Controllers;
use App\Models\TrsBooking;
use App\Models\TrsPending;

use Illuminate\Http\Request;
use Carbon\Carbon;
class PendingController extends Controller
{
    function index($id_booking){

        $allowedStatus = ['INSPECTION LIST', 'EKSEKUSI', 'KONTROL'];
        $booking = TrsBooking::find($id_booking);
        
        if (!in_array($booking->repair_status, $allowedStatus)) {
            session()->flash('errorMessage', 'Pending hanya dapat dilakukan saat Inspection List, Eksekusi, dan Kontrol.');
        }
        $pending = TrsPending::where("id_booking", $id_booking)->get();
        return view('pending.index',['pending' => $pending,'id_booking' => $id_booking, 'repair_status'=>$booking->repair_status]);
    }

    public function startpending(Request $request)
    {
        $timezone = 'Asia/Jakarta';
        $request->validate([
            'reason' => 'required|regex:/^[A-Za-z0-9 ]+$/',
        ], [
            'reason.required' => 'Alasan wajib diisi.',
            'reason.regex' => 'Alasan harus mengandung huruf, angka, dan spasi saja.',
        ]);

        // Periksa jenis item sebelum melakukan operasi "pending"
        $booking = TrsBooking::find($request->id_booking);

        if (!$booking) {
            session()->flash('errorMessage', 'Booking tidak ditemukan.');
            return redirect()->route('booking.history.form');
        }

        // Validasi untuk memastikan hanya item dengan jenis tertentu yang dapat dipending
        $allowedStatus = ['INSPECTION LIST', 'EKSEKUSI', 'KONTROL'];

        if (!in_array($booking->repair_status, $allowedStatus)) {
            session()->flash('errorMessage', 'Pending hanya dapat dilakukan saat Inspection List, Eksekusi, dan Kontrol.');
            return redirect()->route('booking.history.form');
        }
        
        // Buat id otomatis pending
        $count_pending = TrsPending::count();
        $autoid = $count_pending + 1;
        $request->merge(['id_pending' => 'PND' . $autoid]);
        $request->merge(['id_user' => auth()->user()->id_user]);

        // Waktu sekarang zona 
        $waktuSekarang = Carbon::now($timezone);
        $request->merge(['start_time' => $waktuSekarang]);

        // Simpan data ke dalam database setelah validasi
        TrsPending::create($request->all());
        
        // Update status booking menjadi 'PENDING'
        TrsBooking::where('id_booking', $request->id_booking)
            ->update(['repair_status' => 'PENDING']);

        // Redirect ke halaman yang diinginkan setelah data disimpan
        return redirect()->route('booking.history.form')->with('successMessage', 'Kendaraan berhasil disimpan!');
    }

    public function stoppending(Request $request, $id_pending)
    {
        //time zone
        $timezone = 'Asia/Jakarta';

        // Mencari data pending berdasarkan ID
        $pending = TrsPending::find($id_pending);
    
        // Jika data pending tidak ditemukan, kembalikan ke halaman booking history
        if (!$pending) {
            return redirect()->route('booking.history.form');
        }

        // Mencari data booking berdasarkan ID booking dari data pending
        $booking = TrsBooking::find($pending->id_booking);

         // Waktu sekarang
        $waktuSekarang = Carbon::now($timezone);

        // Update waktu selesai pada data pending
        $pending->update([   
            'finish_time' => $waktuSekarang,
        ]);

        // Menentukan status perbaikan berdasarkan progress
        if ($booking->progress == 20) {
            $repair_status = "INSPECTION LIST";
        } elseif ($booking->progress == 45) {
            $repair_status = "EKSEKUSI";
        } else {
            $repair_status = "KONTROL";
        }

        // Menghitung waktu estimasi selesai baru dengan mempertimbangkan waktu mulai dan selesai pada data pending
        $newFinishEstimationTime = Carbon::parse($booking->finish_estimation_time)
            ->addSeconds(Carbon::parse($pending->finish_time)->diffInSeconds(Carbon::parse($pending->start_time)))
            ->setTimezone($timezone);
        
        // Update status perbaikan dan estimasi selesai pada data booking
        $booking->update([
            'repair_status'=>$repair_status,
            'finish_estimation_time'=>  $newFinishEstimationTime,
        ]);        

        return redirect()->route('booking.history.form')->with('successMessage', 'Kendaraan berhasil disimpan!');
    }
    
}
