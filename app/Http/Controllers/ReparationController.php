<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrsBooking;
use App\Models\TrsInspectionList;
use App\Models\MsEquipment;
use App\Models\MsUser;

class ReparationController extends Controller
{
    public function index($idBooking)
    {
        $booking = TrsBooking::with('idVehicleNavigation')->where('id_booking', $idBooking)->first();

        return view('reparation.index', compact('booking'));
    }

    public function formMethod($idBooking)
    {
        $booking = TrsBooking::find($idBooking);

        if (!$booking) {          
            abort(404, 'Not Found');
        }

        if ($booking->progress > 0) {
            session()->flash('ErrorMessage', 'Perubahan metode tidak dapat dilakukan ketika progres sudah berjalan!');
        }

        return view('reparation.form_method', compact('booking'));
    }

    public function processFormMethod(Request $request)
    {
        $booking = TrsBooking::find($request->idBooking);

        if (!$booking) {           
            abort(404, 'Not Found');
        }

        if (empty($request->repair_method) || empty($request->finish_estimation_time)) {
            return redirect()->route('reparation.form-method', ['idBooking' => $request->idBooking])
                ->with('ErrorMessage', 'Metode dan estimasi selesai tidak boleh kosong!');
        }
        
        if (new \DateTime($request->finish_estimation_time) <= now()) {
            return redirect()->route('reparation.form-method', ['idBooking' => $request->idBooking])
                ->with('ErrorMessage', 'Estimasi selesai tidak boleh dibawah waktu saat ini!');
        }

        if ($booking->Progress > 0) {
            return redirect()->route('reparation.index', ['idBooking' => $request->idBooking])
                ->with('ErrorMessage', 'Perubahan metode tidak dapat dilakukan ketika progres sudah berjalan!');
        }

        $repairStatus = ($request->repair_method == "TEFA") ? "PERENCANAAN" : "MULAI";

        $booking->repair_method = $request->repair_method;
        $booking->finish_estimation_time = $request->finish_estimation_time;
        $booking->repair_status = $repairStatus;

        $booking->save();

        return redirect()->route('reparation.index', ['idBooking' => $request->idBooking]);
    }

    public function formPlan($idBooking)
    {
        $booking = TrsBooking::find($idBooking);
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
            'id_booking' => 'required',
            'repair_description' => 'required',
            'replacement_part' => 'required',
        ]);

        $booking = TrsBooking::find($validatedData['id_booking']);

        if (!$booking) {            
            abort(404, 'Not Found');
        }

        if (!in_array($booking->repair_status, ['PERENCANAAN', 'KEPUTUSAN'])) {
            session()->flash('ErrorMessage', 'Perencanaan harus dilakukan setelah info proyek atau sebelum keputusan!');
            return redirect()->route('reparation.index', ['idBooking' => $validatedData['id_booking']]);
        }

        $booking->update([
            'repair_description' => $validatedData['repair_description'],
            'replacement_part' => $validatedData['replacement_part'],
            'repair_status' => 'KEPUTUSAN',
            'progress' => 10,
        ]);

        session()->flash('SuccessMessage', 'Perencanaan berhasil! Tahapan berlanjut ke keputusan!');

        return redirect()->route('reparation.index', ['idBooking' => $validatedData['Id_booking']]);
    }

    public function formDecision($idBooking)
    {
        $booking = TrsBooking::find($idBooking);

        if (!$booking) {
            abort(404, 'Not Found');
        }

        if (!in_array($booking->repair_status, ["KEPUTUSAN", "INSPECTION LIST"])) {
            session()->flash('ErrorMessage', 'Keputusan harus dilakukan setelah perencanaan atau sebelum eksekusi!');
        }

        return view('reparation.form_decision', compact('booking'));
    }

    public function postFormDecision(Request $request)
    {
        $trsBooking = TrsBooking::find($request->idBooking);

        if (!$trsBooking) {
            abort(404);
        }

        $validRepairStatus = ["KEPUTUSAN", "INSPECTION LIST"];
        if (!in_array($trsBooking->repair_status, $validRepairStatus)) {
            session()->flash('ErrorMessage', 'Keputusan harus dilakukan setelah perencanaan atau sebelum eksekusi!');
            return redirect()->route('reparation.index', ['idBooking' => $request->idBooking]);
        }

        TrsInspectionList::where('id_booking', $trsBooking->id_booking)->delete();

        $equipment = MsEquipment::where('is_active', 1)->get();

        foreach ($equipment as $equip) {
            $idInspection = mt_rand(100000, 999999);
            $data = new TrsInspectionList([
                'id_inspection' => $idInspection,
                'id_booking' => $trsBooking->id_booking,
                'id_equipment' => $equip->id_equipment,
                'checklist' => 1,
                'description' => null,
            ]);

            $data->save();
        }

        $trsBooking->price = $request->price;
        $trsBooking->repair_status = "INSPECTION LIST";
        $trsBooking->progress = 20;

        $trsBooking->update();
        
        session()->flash('SuccessMessage', 'Keputusan berhasil! Tahapan berlanjut ke inspection list!');

        return redirect()->route('reparation.index', ['idBooking' => $request->idBooking]);
    }

    public function formStartExecution($idBooking)
    {
        $booking = TrsBooking::find($idBooking);

        if (!$booking) {          
            abort(404, 'Not Found');
        }

        if ($booking->start_repair_time != null) {
            session()->flash('ErrorMessage', 'Eksekusi sudah dimulai pada: ' . date('d F Y - H:i', strtotime($booking->start_repair_time)));
        }

        return view('reparation.form_start_execution', compact('booking'));
    }

    public function postFormStartExecution(Request $request)
    {
        $trsBooking = TrsBooking::find($request->idBooking);

        if (!$trsBooking) {          
            abort(404, 'Not Found');
        }

        if ($trsBooking->start_repair_time != null) {
            session()->flash('ErrorMessage', 'Eksekusi sudah dimulai pada: ' . date('d F Y - H:i', strtotime($trsBooking->start_repair_time)));
            return redirect()->route('reparation.index', ['idBooking' => $trsBooking->id_booking]);
        }

        $trsBooking->start_repair_time = now();
        $trsBooking->repair_status = "EKSEKUSI";
        $trsBooking->progress = 50;

        $trsBooking->update();

        session()->flash('SuccessMessage', 'Mulai berhasil! Tahapan berlanjut ke eksekusi!');

        return redirect()->route('reparation.index', ['idBooking' => $request->idBooking]);
    }

    public function formFinishExecution($idBooking)
    {
        $booking = TrsBooking::find($idBooking);

        if (!$booking) {           
            abort(404, 'Not Found');
        }

        if ($booking->end_repair_time != null) {
            session()->flash('ErrorMessage', 'Eksekusi sudah diselesaikan pada: ' . date('d F Y - H:i', strtotime($booking->end_repair_time)));
        }

        return view('reparation.form_finish_execution', compact('booking'));
    }

    public function postFormFinishExecution(Request $request)
    {
        $trsBooking = TrsBooking::find($request->idBooking);

        if (!$trsBooking) {            
            abort(404, 'Not Found');
        }

        if ($trsBooking->end_repair_time != null) {
            session()->flash('ErrorMessage', 'Eksekusi sudah diselesaikan pada: ' . date('d F Y - H:i', strtotime($trsBooking->end_repair_time)));
            return redirect()->route('reparation.index', ['idBooking' => $trsBooking->id_booking]);
        }

        $repairStatus = $trsBooking->repair_method == 'TEFA' ? 'KONTROL' : 'SELESAI';
        $progress = $trsBooking->repair_method == 'TEFA' ? 70 : 100;

        $trsBooking->end_repair_time = now();
        $trsBooking->repair_status = $repairStatus;
        $trsBooking->progress = $progress;

        $trsBooking->update();

        session()->flash('SuccessMessage', 'Keputusan berhasil! Tahapan berlanjut ke inspection list!');

        return redirect()->route('reparation.index', ['idBooking' => $request->idBooking]);
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
        $idBooking = $request->input('idBooking');
        $control = $request->input('control');

        $booking = TrsBooking::find($idBooking);

        if (!$booking) {
            abort(404, 'Not Found');
        }

        if (!in_array($booking->repair_status, ["KONTROL", "EVALUASI"])) {
            session()->flash('ErrorMessage', 'Kontrol harus dilakukan setelah keputusan atau sebelum evaluasi!');
            return redirect()->route('reparation.index', ['idBooking' => $booking->id_booking]);
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
        $trsBooking = TrsBooking::find($request->idBooking);

        if (!$trsBooking) {           
            abort(404, 'Not Found');
        }
        
        if ($trsBooking->repair_status != "EVALUASI") {
            session()->flash('ErrorMessage', 'Evaluasi harus dilakukan setelah kontrol atau sebelum selesai!');
            return redirect()->route('reparation.index', ['idBooking' => $trsBooking->id_booking]);
        }

        $trsBooking->evaluation = $request->input('evaluation');
        $trsBooking->repair_status = "SELESAI";
        $trsBooking->progress = 100;

        $trsBooking->update();

        session()->flash('SuccessMessage', 'Evaluasi berhasil! Seluruh tahapan sudah selesai!');

        return redirect()->route('reparation.index', ['idBooking' => $request->idBooking]);
    }
}