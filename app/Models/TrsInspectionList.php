<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrsInspectionList extends Model
{
    protected $table = 'trs_inspection_list';
    protected $primaryKey = 'id_inspection';
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_inspection',
        'id_booking',
        'id_equipment',
        'checklist',
        'description',
    ];

    public function booking()
    {
        return $this->belongsTo(TrsBooking::class, 'id_booking');
    }

    public function equipment()
    {
        return $this->belongsTo(MsEquipment::class, 'id_equipment');
    }
}
