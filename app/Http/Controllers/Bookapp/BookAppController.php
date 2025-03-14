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
            ->get('booking_date')
            ->map(fn($item) => [
                'start' => $item->booking_date,
                'end' => date('Y-m-d', strtotime($item->period_date . '+1 days')),
                'display' => 'background',
                'color' => 'green',
                'className' => ['bg-success'],
            ]);

        return response()->json($events);
    }
}
