<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'ms_users'; // Sesuaikan dengan nama tabel di database

    protected $primaryKey = 'id_user'; // Sesuaikan dengan nama kolom primary key di database

    public $incrementing = false; // Jika primary key bukan tipe auto-increment

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

    // ... (lainnya sesuai kebutuhan)

    public function trsBookingHeadMechanicNavigations()
    {
        return $this->hasMany(TrsBooking::class, 'head_mechanic_id', 'id_user');
    }

    public function trsBookingServiceAdvisorNavigations()
    {
        return $this->hasMany(TrsBooking::class, 'service_advisor_id', 'id_user');
    }

    public function trsPendings()
    {
        return $this->hasMany(TrsPending::class, 'user_id', 'id_user');
    }
}
