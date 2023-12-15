<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MsEquipment extends Model
{
    protected $table = 'ms_equipments'; 

    protected $primaryKey = 'id_equipment';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id_equipment',
        'name',
        'isActive',
    ];

    public function trsInspectionLists(): HasMany
    {
        return $this->hasMany(TrsInspectionList::class, 'id_equipment', 'id_equipment');
    }
}
