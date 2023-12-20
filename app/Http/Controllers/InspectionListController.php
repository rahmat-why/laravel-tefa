<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrsBooking;
use App\Models\TrsInspectionList;

class InspectionListController extends Controller
{
    public function index($idBooking)
    {
        $trsBooking = TrsBooking::with('idVehicleNavigation')->find($idBooking);

        if (!$trsBooking) {
            return abort(404);
        }

        if (!in_array($trsBooking->repair_status, ["INSPECTION LIST", "EKSEKUSI"])) {
            session()->flash('ErrorMessage', 'Inspection list harus dilakukan setelah kontrol atau sebelum eksekusi!');
        }

        $trsInspectionLists = TrsInspectionList::where('id_booking', $idBooking)
            ->with(['booking', 'equipment'])
            ->join("ms_equipments", "ms_equipments.id_equipment", "trs_inspection_list.id_equipment")
            ->orderBy("ordering", "ASC")
            ->get();

        return view('inspection_list.index', compact('trsInspectionLists', 'idBooking', 'trsBooking'));
    }

    public function create(Request $request)
    {
        if(!in_array(auth()->user()->position, ["HEAD MECHANIC"])) {
            abort(403, 'Unauthorized.');
        }
        
        $idBooking = $request->input('idBooking');
        $booking = TrsBooking::find($idBooking);

        if (!$booking) {
            return abort(404);
        }

        if (!in_array($booking->repair_status, ["INSPECTION LIST", "EKSEKUSI"])) {
            session()->flash('ErrorMessage', 'Inspection list harus dilakukan setelah kontrol atau sebelum eksekusi!');
            return redirect()->route('reparation.index', ['idBooking' => $booking->id_booking]);
        }

        TrsInspectionList::where('id_booking', $idBooking)->delete();

        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'checklist') === 0) {
                $id_equipment = substr($key, strlen('checklist'));
                $descriptionKey = 'description' . $id_equipment;

                $checklist = (int)$value;
                $description = $request->input($descriptionKey);

                $id_inspection = mt_rand(100000, 999999);

                TrsInspectionList::create([
                    'id_inspection' => $id_inspection,
                    'id_booking' => $idBooking,
                    'id_equipment' => $id_equipment,
                    'checklist' => $checklist,
                    'description' => $description,
                ]);
            }
        }

        $booking->repair_status = "EKSEKUSI";
        $booking->start_repair_time = now() -> setTimezone('Asia/Jakarta'); // timezone jakarta
        $booking->progress = 45;

        $booking->update();

        session()->flash('SuccessMessage', 'Inspection list berhasil! Tahapan berlanjut ke inspection list!');

        return redirect()->route('reparation.index', ['idBooking' => $booking->id_booking]);
    }
}