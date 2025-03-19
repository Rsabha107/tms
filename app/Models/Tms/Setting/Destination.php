<?php

namespace App\Models\Tms\Setting;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    protected $guarded = [];
    protected $table = "bookapp_destinations";

    public function active_status()
    {
        return $this->belongsTo(GlobalStatus::class, 'active_flag');
    }
}
