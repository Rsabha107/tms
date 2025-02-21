<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryVehicleType extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'mds_vehicle_types';
}
