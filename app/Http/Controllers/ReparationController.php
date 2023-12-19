<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrsBooking;
use App\Models\TrsInspectionList;
use App\Models\MsEquipment;
use App\Models\MsUser;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Validator;
use Symfony\Contracts\Service\Attribute\Required;

class ReparationController extends Controller
{
    public function index($idBooking)
    {
        $booking = TrsBooking::with('idVehicleNavigation')->where('id_booking', $idBooking)->first();

        if ($booking->repair_status === 'BATAL'){
            session()->flash('ErrorMessge', 'Servis ini telah dibatalkan dan tidak dapat dilanjutkan lagi!');
        } elseif ($booking->repair_status === 'PENDING'){
            session()->flash('ErrorMessage', 'Servis ini sedang dipending!');
        }

        return view('reparation.index', compact('booking'));
    }

    public function postFormStartService(Request $request)
    {
        $id_booking = $request->input('idBooking');
        $booking = TrsBooking::find($id_booking);

        if (!$booking) {
            abort(404, 'Booking not found');
        }

        $booking->repair_status = 'PERENCANAAN';
        $booking->save();

        session()->flash('successMessage', 'Servis berhasil dimulai!');

        return redirect()->route('reparation.index', ['idBooking' => $id_booking]);
    }

    public function formPlan($idBooking)
    {
        $booking = TrsBooking::find($idBooking);

        //dd($booking->repair_description);

        if (!$booking) {           
            abort(404, 'Not Found');
        }

        if (!in_array($booking->repair_status, ['PERENCANAAN', 'KEPUTUSAN'])) {
            session()->flash('ErrorMessage', 'Perencanaan harus dilakukan sebelum keputusan!');
        }

        return view('reparation.form_plan', compact('booking'));
    }

    public function processFormPlan(Request $request)
    {
        $validatedData = $request->validate([
            'repair_description' => 'required|string',
            'replacement_part' => 'nullable',
            'price' => 'required|numeric|min:0',
            'finish_estimation_time' => 'required|date|after:now',
        ], [
            'repair_description.required' => 'Kolom Deskripsi Perbaikan harus diisi.', 
            'replacement_part.required' => 'Kolom Ganti Part harus diisi.',
            'price.required' => 'Kolom Harga harus diisi.',
            'price.numeric' => 'Kolom Harga harus berupa angka.',
            'price.min' => 'Kolom Harga tidak boleh kurang dari 0.',
            'finish_estimation_time.required' => 'Kolom Estimasi Selesai harus diisi.',
            'finish_estimation_time.date' => 'Kolom Estimasi Selesai harus berupa tanggal.',
            'finish_estimation_time.after' => 'Estimasi selesai tidak boleh sebelum waktu saat ini.',           
        ]);

        $booking = TrsBooking::find($request->id_booking);

        if (!$booking) {            
            abort(404, 'Not Found');
        } 
        
        if (!in_array($booking->repair_status, ['PERENCANAAN', 'KEPUTUSAN'])) {
            session()->flash('ErrorMessage', 'Perencanaan harus dilakukan setelah info proyek atau sebelum keputusan!');
            return redirect()->route('reparation.form-plan', ['idBooking' => $validatedData['id_booking']]);
        }

        $booking->update([
            'repair_description' => $validatedData['repair_description'],
            'replacement_part' => $validatedData['replacement_part'],
            'price' => $validatedData['price'],
            'finish_estimation_time' => $validatedData['finish_estimation_time'],
            'repair_status' => 'KEPUTUSAN',
            'progress' => 10,
        ]);

        session()->flash('SuccessMessage', 'Perencanaan berhasil! Tahapan berlanjut ke keputusan!');

        return redirect()->route('reparation.index', ['idBooking' => $request->id_booking]);
    }

    public function formDecision($idBooking)
    {
        $booking = TrsBooking::find($idBooking);

        if (!$booking) {
            abort(404, 'Not Found');
        }

        if ($booking->repair_status == "BATAL") {
            session()->flash('ErrorMessage', 'Servis ini telah dibatalkan dan tidak dapat dilanjutkan lagi!');
        } elseif (!in_array($booking->repair_status, ["KEPUTUSAN", "INSPECTION LIST"])) {
            session()->flash('ErrorMessage', 'Keputusan harus dilakukan setelah perencanaan atau sebelum eksekusi!');
        }

        return view('reparation.form_decision', compact('booking'));
    }

    public function postFormDecision(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'decision' => 'required',
        ], [
            'decision.required' => 'Persetujuan harus dipilih',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }        

        $id_booking = $request->input('id_booking');
        $booking = TrsBooking::with('idVehicleNavigation')->find($id_booking);
    
        if (!$booking) {
            abort(404);
        }

        if (!in_array($booking->repair_status, ["KEPUTUSAN", "INSPECTION LIST"])) {
            session()->flash('ErrorMessage', 'Keputusan harus dilakukan setelah perencanaan atau sebelum eksekusi!');
            return redirect()->route('reparation.form-decision', ['idBooking' => $id_booking]);
        }    

        $decision = $request->input('decision');
        $repairStatus = ($decision == 1) ? 'INSPECTION LIST' : 'BATAL';

        $booking->decision = $decision;
        $booking->repair_status = $repairStatus;
        $booking->progress = 20;

        if ($repairStatus == 'BATAL') {
            session()->flash('SuccessMessage', 'Servis berhasil dibatalkan!');
            return redirect()->route('reparation.index', ['idBooking' => $id_booking]);
        }
        
        // Menyimpan data mentah inspection list dari tabel equipment jika kendaraan mobil
        if ($booking->idVehicleNavigation->classify == 'MOBIL') {
            // Lakukan penghapusan data lama
            TrsInspectionList::where('idBooking', $id_booking)->delete();

            $equipment = MsEquipment::where('IsActive', 1)->get();
            foreach ($equipment as $equip) {
                $id_inspection = mt_rand(100000, 999999);
                TrsInspectionList::create([
                    'id_inspection' => $id_inspection,
                    'id_booking' => $id_booking,
                    'id_equipment' => $equip->id_equipment,
                    'checklist' => 1,
                    'description' => null,
                ]);
            }
        }

        $booking->save();

        session()->flash('SuccessMessage', 'Keputusan berhasil! Tahapan berlanjut ke inspection list!');

        return redirect()->route('reparation.index', ['idBooking' => $request->id_booking]);
    }

    public function formFinishExecution($idBooking)
    {
        $booking = TrsBooking::find($idBooking);

        if (!$booking) {           
            abort(404, 'Not Found');
        }

         // Validasi jika eksekusi sudah diselesaikan
         if ($booking->end_repair_time !== null) {
            session()->flash('ErrorMessage', 'Eksekusi sudah diselesaikan pada: ' . $booking->end_repair_time->format('d F Y - H:i'));
            return redirect()->route('reparation.index', ['idBooking' => $idBooking]);
        }

        // Validasi untuk mengingatkan agar inspection list harus terlebih dahulu dilakukan sebelum selesai eksekusi
        if ($booking->repair_status !== "EKSEKUSI") {
            session()->flash('ErrorMessage', 'Selesai eksekusi harus dilakukan setelah inspection list!');
            return redirect()->route('reparation.index', ['idBooking' => $idBooking]);
        }

        return view('reparation.form_finish_execution', compact('booking'));
    }

    public function postFormFinishExecution(Request $request)
    {
        //dd($request->all);
        $trsBooking = TrsBooking::find($request->id_booking);

        if (!$trsBooking) {            
            abort(404, 'Not Found');
        }

         // Validasi jika eksekusi sudah diselesaikan
         if ($trsBooking->end_repair_time !== null) {
            session()->flash('ErrorMessage', 'Eksekusi sudah diselesaikan pada: ' . $trsBooking->end_repair_time->format('d F Y - H:i'));
            return redirect()->route('reparation.index', ['idBooking' => $request->id_booking]);
        }

        // Validasi untuk mengingatkan agar inspection list harus terlebih dahulu dilakukan sebelum selesai eksekusi
        if ($trsBooking->repair_status !== "EKSEKUSI") {
            session()->flash('ErrorMessage', 'Selesai eksekusi harus dilakukan setelah inspection list!');
            return redirect()->route('reparation.index', ['idBooking' => $request->id_booking]);
        }

        $trsBooking->end_repair_time = now()->setTimezone('Asia/Jakarta');;
        $trsBooking->repair_status = "KONTROL";
        $trsBooking->progress = 70;

        $trsBooking->update();

        session()->flash('SuccessMessage', 'Keputusan berhasil! Tahapan berlanjut ke inspection list!');

        return redirect()->route('reparation.index', ['idBooking' => $request->id_booking]);
    }
    
    public function formControl($idBooking)
    {
        $booking = TrsBooking::find($idBooking);

        if (!$booking) {          
            abort(404, 'Not Found');
        }

        if (!in_array($booking->repair_status, ["KONTROL", "EVALUASI"])) {
            session()->flash('ErrorMessage', 'Kontrol harus dilakukan setelah keputusan atau sebelum evaluasi!');
        }

        return view('reparation.form_control', compact('booking'));
    }

    public function postFormControl(Request $request)
    {
        $id_booking = $request->input('idBooking');
        $booking = TrsBooking::find($id_booking);

        if (!$booking) {
            abort(404, 'Not Found');
        }

        if (!in_array($booking->repair_status, ['KONTROL', 'EVALUASI'])) {
            session()->flash('error', 'Kontrol harus dilakukan setelah keputusan atau sebelum evaluasi!');
            return redirect()->route('reparation.index', ['idBooking' => $booking->id_booking]);
        }

        $control = $request->input('control');

        if (!$control) {
            session()->flash('error', 'Hasil kontrol harus disetujui!');
            return redirect()->route('reparation.form_control', ['idBooking' => $booking->id_booking]);
        }

        $booking->control = $control;
        $booking->repair_status = "EVALUASI";
        $booking->progress = 90;

        $booking->update();
        
        session()->flash('SuccessMessage', 'Kontrol berhasil! Tahapan berlanjut ke evaluasi!');

        return redirect()->route('reparation.index', ['idBooking' => $booking->id_booking]);
    }

    public function formEvaluation($idBooking)
    {
        $booking = TrsBooking::find($idBooking);

        if (!$booking) {           
            abort(404, 'Not Found');
        }

        if ($booking->repair_status != "EVALUASI") {
            session()->flash('ErrorMessage', 'Evaluasi harus dilakukan setelah kontrol atau sebelum selesai!');
        }

        return view('reparation.form_evaluation', compact('booking'));
    }

    public function postFormEvaluation(Request $request)
    {
        $request->validate([
            'evaluation' => 'required',
        ], [
            'evaluation.required' => 'Kolom evaluasi harus diisi.',
        ]);
        
        $id_booking = $request->input('idBooking');
        $trsBooking = TrsBooking::find($id_booking);

        if (!$trsBooking) {           
            abort(404, 'Not Found');
        }
        
        if ($trsBooking->repair_status != "EVALUASI") {
            session()->flash('ErrorMessage', 'Evaluasi harus dilakukan setelah kontrol atau sebelum selesai!');
            return redirect()->route('reparation.index', ['idBooking' => $trsBooking->id_booking]);
        }

        $evaluation = $request->input('evaluation');

        $trsBooking->evaluation = $evaluation;
        $trsBooking->repair_status = "SELESAI";
        $trsBooking->progress = 100;

        $trsBooking->update();

        session()->flash('SuccessMessage', 'Evaluasi berhasil! Seluruh tahapan sudah selesai!');

        return redirect()->route('reparation.index', ['idBooking' => $id_booking]);
    }

    public function formIndent($id_booking)
    {
        $allowedStatus = ['PENDING'];
        $booking = TrsBooking::find($id_booking);

        if (!$booking) {
            abort(404, 'Not Found');
        }

        if (!in_array($booking->repair_status, $allowedStatus)) {
            session()->flash('errorMessage', 'Temuan hanya bisa dilakukan pada saat pending.');
        }

        return view('reparation.form_ident', ['booking'=>$booking]);
    }

    public function PostFormIndent(Request $request)
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

        $bookings = TrsBooking::findOrFail($request->idBooking);
            $bookings->update($data);

            session()->flash('successMessage', 'Kendaraan berhasil diperbaharui!');
            return redirect(route('booking.history.form'));
    }
}