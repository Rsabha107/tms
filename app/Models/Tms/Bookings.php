<?php

namespace App\Models\Tms;

use App\Models\Mds\DeliveryNumGen;
use App\Models\Tms\Setting\BookingSlots;
use App\Models\Tms\Setting\Destination;
use App\Models\Tms\Setting\Event;
use App\Models\Tms\Setting\Team;
use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    protected $guarded = [];
    protected $table = "bookapp_bookings";

    public static function boot(){

        parent::boot();

        try {
            static::creating(function($model){
                $numGen = DeliveryNumGen::first();
                if ($numGen == null) {
                    $numGen = new DeliveryNumGen();
                    $numGen->last_number = 0;
                    $numGen->save();
                }
                $last_number = $numGen->max('last_number') + 1;
                $numGen->update(['last_number' => $last_number]);

                $model->booking_ref_number = 'TDS'.'-'.str_pad($last_number, 5, '0', STR_PAD_LEFT);
            });
        } catch (\Illuminate\Database\QueryException $e) {
            $errorInfo = $e->errorInfo;
            return redirect()->back()->with('error', $errorInfo[2]);
            // dd($e->getMessage());
        }

        // static::creating(function($model){
        //     $numGen = DeliveryNumGen::firstOrFail();
        //     $last_number = $numGen->max('last_number') + 1;
        //     $numGen->update(['last_number' => $last_number]);

        //     $model->booking_ref_number = 'TDS'.'-'.str_pad($last_number, 5, '0', STR_PAD_LEFT);
        // });
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function schedule()
    {
        return $this->belongsTo(BookingSlots::class, 'schedule_period_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }   

    public function destination()
    {
        return $this->belongsTo(Destination::class, 'destination_id');
    }   

}
