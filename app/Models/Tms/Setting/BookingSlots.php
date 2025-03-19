<?php

namespace App\Models\Tms\Setting;

use Illuminate\Database\Eloquent\Model;

class BookingSlots extends Model
{
    protected $guarded = [];
    protected $table = "bookapp_booking_slots";



    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

}
