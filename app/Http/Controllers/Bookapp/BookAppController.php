<?php

namespace App\Http\Controllers\Bookapp;

use App\Http\Controllers\Controller;
use App\Models\Bookapp\Bookings;
use App\Models\Bookapp\BookingSlots;
use App\Models\Bookapp\Destination;
use App\Models\Bookapp\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BookAppController extends Controller
{
    //
    public function index()
    {
        $bookings = Bookings::all();
        $teams = Team::all();
        $destinations = Destination::all();
        $booking_slots = BookingSlots::all();
        return view('bookapp.admin.booking.list', compact('bookings'));
    }

    public function create()
    {
        $teams = Team::all();
        $destinations = Destination::all();
        $booking_slots = BookingSlots::all();
        return view('bookapp.admin.booking.create', compact('teams', 'destinations', 'booking_slots'));
    }

    public function list(Request $request)
    {
        $search = request('search');
        $sort = (request('sort')) ? request('sort') : "id";
        $order = (request('order')) ? request('order') : "DESC";
        $mds_schedule_event_filter = (request()->mds_schedule_event_filter) ? request()->mds_schedule_event_filter : "";
        $mds_schedule_venue_filter = (request()->mds_schedule_venue_filter) ? request()->mds_schedule_venue_filter : "";
        $mds_schedule_rsp_filter = (request()->mds_schedule_rsp_filter) ? request()->mds_schedule_rsp_filter : "";

        $ops = Bookings::orderBy($sort, $order);
        // if ($search) {
        //     $venue = $venue->where(function ($query) use ($search) {
        //         $query->where('status', 'like', '%' . $search . '%')
        //         ->orWhere('period', 'like', '%' . $search . '%')
        //         ->orWhere('period', 'like', '%' . $search . '%')
        //             ->orWhere('id', 'like', '%' . $search . '%');
        //     });
        // }
        // if (session()->has('EVENT_ID')) {
        //     $current_event_id = session()->get('EVENT_ID');
        //     $ops = $ops->where('event_id', '=', $current_event_id);
        // }

        if ($search) {

            $ops = $ops->whereHas('client', function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%');
            })
                ->orWhereHas(
                    'schedule_period',
                    function ($query) use ($search) {
                        $query->where('period', 'like', '%' . $search . '%');
                    }
                )
                ->orWhereHas(
                    'cargo',
                    function ($query) use ($search) {
                        $query->where('title', 'like', '%' . $search . '%');
                    }
                )
                ->orWhereHas(
                    'zone',
                    function ($query) use ($search) {
                        $query->where('title', 'like', '%' . $search . '%');
                    }
                )
                ->orWhereHas(
                    'status',
                    function ($query) use ($search) {
                        $query->where('title', 'like', '%' . $search . '%');
                    }
                )
                ->orWhereHas(
                    'driver',
                    function ($query) use ($search) {
                        $query->where('first_name', 'like', '%' . $search . '%');
                    }
                )
                ->orWhereHas(
                    'driver',
                    function ($query) use ($search) {
                        $query->where('last_name', 'like', '%' . $search . '%');
                    }
                );
        }


        if ($mds_schedule_event_filter) {
            $ops = $ops->where('event_id', $mds_schedule_event_filter);
        }

        if ($mds_schedule_venue_filter) {
            $ops = $ops->where('venue_id', $mds_schedule_venue_filter);
        }

        if ($mds_schedule_rsp_filter) {
            $ops = $ops->where('rsp_id', $mds_schedule_rsp_filter);
        }

        $total = $ops->count();
        $ops = $ops->paginate(request("limit"))->through(function ($op) {

            // $location = Location::find($booking->location_id);

            $actions =

                '<div class="font-sans-serif btn-reveal-trigger position-static">' .
                '<a href="javascript:void(0)" class="btn btn-sm" id="bookingDetails" data-id="' .
                $op->id .
                '" data-table="bookapp_bookings_table" data-bs-toggle="tooltip" data-bs-placement="right" title="View Booking Details">' .
                '<i class="fas fa-lightbulb text-warning"></i></a>' .
                '<a href="' . route('mds.admin.booking.pass.pdf', $op->id) . '"  target="_blank" class="btn btn-sm" id="generateBookingPass" data-id="' .
                $op->id .
                '" data-table="bookapp_bookings_table" data-bs-toggle="tooltip" data-bs-placement="right" title="Generate Pass">' .
                '<i class="fas fa-passport text-success"></i></a>' .
                '<a href="' . route('mds.admin.booking.edit', $op->id) . '" class="btn btn-sm" id="editBooking" data-id="' .
                $op->id .
                '" data-table="bookapp_bookings_table" data-bs-toggle="tooltip" data-bs-placement="right" title="Update">' .
                '<i class="fa-solid fa-pen-to-square text-primary"></i></a>' .
                '<a href="javascript:void(0)" class="btn btn-sm" data-table="bookapp_bookings_table" data-id="' .
                $op->id .
                '" id="deleteBooking" data-bs-toggle="tooltip" data-bs-placement="right" title="Delete">' .
                '<i class="bx bx-trash text-danger"></i></a></div></div>';

            $details_url = route('mds.admin.booking.edit', $op->id);

            // $div_action = '<div class="font-sans-serif btn-reveal-trigger position-static">';
            // $update_action =
            //     '<a href="javascript:void(0)" class="btn btn-sm" id="editEvents" data-id=' . $op->id .
            //     ' data-table="event_table" data-bs-toggle="tooltip" data-bs-placement="right" title="Update">' .
            //     '<i class="fa-solid fa-pen-to-square text-primary"></i></a>';
            // $delete_action =
            //     '<a href="javascript:void(0)" class="btn btn-sm" data-table="event_table" data-id="' .
            //     $op->id .
            //     '" id="deleteEvent" data-bs-toggle="tooltip" data-bs-placement="right" title="Delete">' .
            //     '<i class="fa-solid fa-trash text-danger"></i></a></div></div>';


            return  [
                'id' => $op->id,
                // 'id' => '<div class="align-middle white-space-wrap fw-bold fs-8 ps-2">' .$op->id. '</div>',
                'delivery_status_id' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->status?->title . '</div>',
                'booking_ref_number' => '<div class="align-middle white-space-wrap fs-9 ms-2">
                        <a href="javascript:void(0)" id="bookingDetails" data-table="bookings_table" data-id="' . $op->id . '">' . $op->booking_ref_number . '</a></div>',
                'event_id' => '<div class="align-middle white-space-wrap fs-9 ps-2">' .  $op->event?->name . '</div>',
                'team_id' => '<div class="align-middle white-space-wrap fs-9 ps-2">' .  $op->team?->title . '</div>',
                'destination_id' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->destination->title . '</div>',
                'booking_date' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . format_date($op->booking_date) . '</div>',
                // 'booking_time' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . time_range_segment($op->schedule_period->period, 'from') . '</div>',
                'booking_time' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->schedule->booking_slot . '</div>',
                // 'booking_time' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . ($op->schedule_period->period) . '</div>',
                'action' => $actions,
                'created_at' => format_date($op->created_at,  'H:i:s'),
                'updated_at' => format_date($op->updated_at, 'H:i:s'),
            ];
        });

        return response()->json([
            "rows" => $ops->items(),
            "total" => $total,
        ]);
    }

    public function store(Request $request)
    {

        $rules = [
            'time_slot_id' => 'required',
            'team_id' => 'required',
            'destination_id' => 'required',
            // 'booking_date' => 'required',
            'time_slot_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            Log::info($validator->errors());
            $error = true;
            $type = 'success';
            $message = 'Booking could not be created';
            $notification = array(
                'message'       => 'Booking could not be created',
                'alert-type'    => 'error'
            );
        } else {

            // check number of slots available.  if available slots = 0 then exit with a warning message.
            // this is incase a user grabed the last slot with this user is waiting ..

            $booking = new Bookings();
            $user_id = auth()->user()->id;
            $timeslots = BookingSlots::find($request->time_slot_id);

            if ($timeslots->available_slots > 0) {
                $error = false;
                $type = 'success';
                $message = 'Booking created succesfully.' . $booking->id;

                $booking->user_id = $user_id;
                $booking->event_id = 4;
                $booking->team_id = $request->team_id;
                $booking->destination_id = $request->destination_id;
                $booking->booking_date = $request->booking_date;
                $booking->schedule_period_id = $request->time_slot_id;
                $booking->delivery_status_id = $request->delivery_status_id;
                $booking->arrival_date_time = $request->arrival_date_time;
                $booking->created_by = $user_id;
                $booking->updated_by = $user_id;

                $timeslots->available_slots = $timeslots->available_slots - 1;
                $timeslots->used_slots = $timeslots->used_slots + 1;

                $timeslots->save();
                $booking->save();

                $notification = array(
                    'message'       => 'Booking created successfully',
                    'alert-type'    => 'success'
                );
            } else {
                $error = true;
                $type = 'success';
                $message = 'Booking could not be created. No slots available';
                $notification = array(
                    'message'       => 'Booking could not be created. No slots available',
                    'alert-type'    => 'error'
                );
            }
        }
        return redirect()->route('bookapp')->with($notification);
    }

    public function delete($id)
    {
        // LOG::info('inside delete');
        $op = Bookings::find($id);

        // get the timeslot id
        $timeslot_id = $op->schedule_period_id;
        // get the timeslot
        $timeslot = BookingSlots::find($timeslot_id);

        $timeslot->available_slots = $timeslot->available_slots + 1;
        $timeslot->used_slots = $timeslot->used_slots - 1;

        $timeslot->save();

        $op->delete();

        $error = false;
        $message = 'Booking deleted succesfully.';

        $notification = array(
            'message'       => 'Booking deleted successfully',
            'alert-type'    => 'success'
        );

        return response()->json(['error' => $error, 'message' => $message]);
        // return redirect()->route('tracki.setup.workspace')->with($notification);
    } // delete

    public function listEvent(Request $request)
    {
        Log::info('listEvent');
        log::info($request->all());
        $events = BookingSlots::where('event_id', $request->event_id)
            ->where('booking_date', '>=', NOW())
            ->where('available_slots', '>', '0')
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
            ->where('available_slots', '>', '0');


        $ops = $ops->get();

        Log::info('BookingController::get_times_cal ops: ' . $ops);
        // $venue = DeliverySchedulePeriod::all();

        return response()->json(['ops' => $ops]);
    }
}
