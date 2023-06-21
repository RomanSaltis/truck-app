<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TruckSubunit extends Model
{
    use HasFactory;

    protected $table = 'truck_subunits';

    protected $fillable = ['main_truck', 'subunit', 'start_date', 'end_date'];

    public function mainTruck(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Truck::class, 'main_truck');
    }

    public function subunitTruck(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Truck::class, 'subunit');
    }
}
