<?php

namespace App\Models\Mds;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MdsDriver extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table="mds_drivers";


    public function status()
    {
        return $this->belongsTo(DriverStatus::class, 'status_id');
    }
}
