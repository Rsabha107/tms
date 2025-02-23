<?php

namespace App\Models\Mds;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverStatus extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'mds_driver_status';
}
