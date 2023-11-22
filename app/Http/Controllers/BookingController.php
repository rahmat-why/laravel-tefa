<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\TrsBooking;
use App\Models\MsUser;

class BookingController extends Controller
{
    public function history()
    {
        $bookings = TrsBooking::with(['idVehicleNavigation.idCustomerNavigation'])
            ->where('repair_status', '!=', 'SELESAI')
            ->whereNotNull('repair_method')
            ->orderBy('order_date')
            ->get();

        return view('booking.history', ['bookings' => $bookings]);
    }
}
