<?php

namespace App\Http\Controllers;

use App\Models\TrsBooking;
use Illuminate\Http\Request;

class RaparationController extends Controller
{
    public function formIndent($id_booking)
    {
        $booking = TrsBooking::where("id_booking",$id_booking)->first();
        $repair_status = TrsBooking::where("id_booking", $id_booking)->value('repair_status');
        if (!$booking) {
            return redirect()->route('authentication.notfound');
        }

    
        return view('raparation.index', ['booking'=>$booking,'repair_status'=>$repair_status]);
    }

    public function formIndentPost(Request $request,$id_booking)
    {
         // Validasi data agar tidak boleh kosong
         $request->validate([
            'additional_replacement_part' => 'required|regex:/^[A-Za-z0-9 ]+$/',
            'additional_price' => 'required|numeric',
        ], [
            'additional_replacement_part.required' => 'Alasan wajib diisi.',
            'additional_replacement_part.regex' => 'Alasan harus mengandung huruf, angka, dan spasi saja.',
            'additional_price.required' => 'Harga wajib diisi.',
            'additional_price.numeric' => 'Harga harus berupa angka.',
        ]); 
        // Ambil data yang diterima dari formulir
        $data = $request->all();

        $bookings = TrsBooking::findOrFail($id_booking);
            $bookings->update($data);
            return redirect(route('booking.history.form'))->with('successMessage', 'Kendaraan berhasil diperbaharui!');
    }
    
}


