<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrsBooking extends Model
{
    use HasFactory;
    
    protected $table = 'trs_booking';
    protected $primaryKey = 'id_booking';
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'id_booking',
        'order_date',
        'id_vehicle',
        'odometer',
        'complaint',
        'service_advisor',
        'head_mechanic',
        'start_repair_time',
        'end_repair_time',
        'finish_estimation_time',
        'repair_description',
        'replacement_part',
        'evaluation',
        'price',
        'created_time',
        'repair_status',
        'repair_method',
        'control',
        'progress',
        'additional_replacement_part',
        'additional_price',
        'decision',
    ];

    protected $dates = [
        'order_date',
        'start_repair_time',
        'end_repair_time',
        'finish_estimation_time',
        'created_time',
    ];
    
    public function idVehicleNavigation()
    {
        return $this->belongsTo(MsVehicle::class, 'id_vehicle');
    }

    public function headMechanicNavigation()
    {
        return $this->belongsTo(MsUser::class, 'head_mechanic');
    }

    public function serviceAdvisorNavigation()
    {
        return $this->belongsTo(MsUser::class, 'service_advisor');
    }

    public function trsInspectionLists()
    {
        return $this->hasMany(TrsInspectionList::class, 'id_booking');
    }

    public function trsPendings()
    {
        return $this->hasMany(TrsPending::class, 'IdBooking', 'IdBooking');
    }
}
