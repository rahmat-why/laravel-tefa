<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

class MsUser extends Model implements Authenticatable
{
    use AuthenticatableTrait;

    protected $table = 'ms_users';
    protected $primaryKey = 'id_user';
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_user',
        'full_name',
        'nim',
        'nidn',
        'username',
        'password',
        'position',
    ];

    protected $hidden = [
        'password',
    ];

    public function bookingsAsHeadMechanic()
    {
        return $this->hasMany(TrsBooking::class, 'head_mechanic', 'id_user');
    }

    public function bookingsAsServiceAdvisor()
    {
        return $this->hasMany(TrsBooking::class, 'service_advisor', 'id_user');
    }
}
