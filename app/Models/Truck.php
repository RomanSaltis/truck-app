<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    use HasFactory;

    protected $table = 'trucks';
    public function subunits(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TruckSubunit::class, 'main_truck', 'id');
    }


}
