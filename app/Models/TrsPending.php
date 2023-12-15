<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrsPending extends Model
{
    protected $table = 'trs_pending'; // Assuming your table name is 'trs_pending'

    protected $primaryKey = 'id_pending'; // Assuming 'IdPending' is the primary key

    public $incrementing = false; // Set to false if your table doesn't have auto increment

    public $timestamps = false; // Set to false if your table doesn't have created_at and updated_at columns

    protected $fillable = [
        'id_pending',
        'start_time',
        'finish_time',
        'reason',
        'id_booking',
        'id_user',
    ];

    public function IdBookingNavigation()
    {
        return $this->belongsTo(TrsBooking ::clas, 'id_booking', 'id_booking');
    }
}

