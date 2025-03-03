<?php

namespace App\Models\Mds;

use App\Models\GlobalStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MdsEvent extends Model
{
    use HasFactory;
    protected $table="mds_events";
    protected $guarded = [];


    public function active_status()
    {
        return $this->belongsTo(GlobalStatus::class, 'active_flag');
    }
}
