<?php

namespace App\Models\Mds;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingSlot extends Model
{
    use HasFactory;
    protected $table = 'mds_booking_slots';
    protected $guarded = [];

    public function venue()
    {
        return $this->belongsTo(DeliveryVenue::class, 'venue_id');
    }

    public function event()
    {
        return $this->belongsTo(MdsEvent::class, 'event_id');
    }

    public function rsp()
    {
        return $this->belongsTo(DeliveryRsp::class, 'rsp_id');
    }
}
