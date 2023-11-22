<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

class MsCustomer extends Model implements Authenticatable
{
    use AuthenticatableTrait;

    protected $table = 'ms_customers';
    protected $primaryKey = 'id_customer';
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_customer',
        'name',
        'email',
        'phone',
        'address',
        'password',
    ];

    protected $hidden = [
        'password', // hide the password field when converting to array or JSON
    ];

    public function vehicles()
    {
        return $this->hasMany(MsVehicle::class, 'id_customer', 'id_customer');
    }
}
