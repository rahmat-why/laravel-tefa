<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class MsVehicle extends Model
{
    use HasFactory;

    protected $table = 'ms_vehicles';
    protected $primaryKey = 'id_vehicle';
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_vehicle',
        'type',
        'classify',
        'police_number',
        'color',
        'year',
        'vehicle_owner',
        'chassis_number',
        'machine_number',
        'id_customer',
    ];

    public function idCustomerNavigation()
    {
        return $this->belongsTo(MsCustomer::class, 'id_customer');
    }

    public function trsBookings()
    {
        return $this->hasMany(TrsBooking::class, 'id_vehicle')->orderBy('order_date', 'asc');
    }

}
