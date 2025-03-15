<?php

namespace App\Http\Controllers\Bookapp;

use App\Http\Controllers\Controller;
use App\Models\Bookapp\BookingSlots;
use App\Models\Bookapp\Destination;
use App\Models\Bookapp\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookAppController extends Controller
{
    //
    public function index()
    {
        $teams = Team::all();
        $destinations = Destination::all();
        $booking_slots = BookingSlots::all();
        return view('bookapp.index', compact('teams', 'destinations', 'booking_slots'));
    }

    public function listEvent(Request $request)
    {
        Log::info('listEvent');
        log::info($request->all());
        $events = BookingSlots::where('event_id', $request->event_id)
            ->where('booking_date', '>=',NOW())
            ->get()
            ->map(fn($item) => [
                'start' => $item->booking_date,
                'end' => date('Y-m-d', strtotime($item->booking_date . '+1 days')),
                'title' => $item->booking_slot,
                'display' => 'background',
                // 'textColor' => 'yellow',
                'background' => "linear-gradient(90deg, green 80%, cyan 0%)",
                'className' => ['bg-success'],
            ]);

        Log::info($events);

        return response()->json($events);
    }

    public function get_times_cal(Request $request)
    {
        $date = $request->date;
        // $venue_id = $request->venue_id;
        // LOG::info('inside get_times');
        // $formated_date = Carbon::createFromFormat('dmY', $date)->toDateString();
        // LOG::info('formated_date: '.$formated_date);
        // LOG::info('venue_id: '.$venue_id);
        // $venue = DeliverySchedulePeriod::where('period_date', '=', $date)
        //     ->where('venue_id', '=', $venue_id)
        //     // ->where('available_slots', '>', '0')
        //     ->get();
        // $cut_off_time = 24 - config('mds.cut_off_time');

        Log::info('BookingController::get_times_cal date: ' . $date);
        // Log::info('BookingController::get_times_cal venue_id: ' . $venue_id);
        Log::info('BookingController::get_times_cal EVENT_ID: ' . session()->get('EVENT_ID'));

        $ops = BookingSlots::where('booking_date', '=', $date)
            ->where('booking_slot_available', '>', '0');


        $ops = $ops->get();

        Log::info('BookingController::get_times_cal ops: ' . $ops);
        // $venue = DeliverySchedulePeriod::all();

        return response()->json(['ops' => $ops]);
    }
}
