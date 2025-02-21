<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'event_venue';

    public function locations()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
}
