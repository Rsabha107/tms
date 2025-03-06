<?php

namespace App\Http\Controllers\Mds\Setting;

use App\Http\Controllers\Controller;
use App\Models\Mds\DeliveryRsp;
use App\Models\Mds\DeliverySchedule;
use App\Models\Mds\DeliveryVenue;
use App\Models\Location;
use App\Models\Mds\BookingSlot;
use App\Models\Mds\MdsEvent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

// use Illuminate\Support\Facades\Redirect;

class ScheduleController extends Controller
{
    //
    public function index()
    {
        $schedules = DeliverySchedule::all();
        $events = MdsEvent::all();
        $venues = DeliveryVenue::all();
        $rsps = DeliveryRsp::all();

        return view('mds.setting.schedule.list', compact('schedules', 'venues', 'rsps','events'));
    }

    public function get($id)
    {
        $venue = DeliverySchedule::findOrFail($id);
        return response()->json(['venue' => $venue]);
    }

    public function update(Request $request)
    {

        $venue = DeliverySchedule::findOrFail($request->id);

        $rules = [
            'id' => 'required',
            'regime_start_date' => 'required',
            'regime_end_date' => 'required',
            'schedule_venue_id' => 'required',
            'schedule_rsp_id' => 'required',
            'time_slots' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            Log::info($validator->errors());
            $error = true;
            $message = 'Schedule could not be updated';
        } else {

            $venue->regime_start_date = Carbon::createFromFormat('d/m/Y', $request->regime_start_date);
            $venue->regime_end_date = Carbon::createFromFormat('d/m/Y', $request->regime_end_date);
            $venue->venue_id = $request->schedule_venue_id;
            $venue->rsp_id = $request->schedule_rsp_id;
            $venue->time_slots = $request->time_slots;

            if ($venue->save()) {
                return response()->json(['error' => false, 'message' => 'Schedule updated successfully.', 'id' => $venue->id]);
            } else {
                return response()->json(['error' => true, 'message' => 'Schedule couldn\'t updated.']);
            }
        }
    }

    public function list()
    {
        $search = request('search');
        $sort = (request('sort')) ? request('sort') : "id";
        $order = (request('order')) ? request('order') : "DESC";
        $mds_schedule_event_filter = (request()->mds_schedule_event_filter) ? request()->mds_schedule_event_filter : "";
        $mds_schedule_venue_filter = (request()->mds_schedule_venue_filter) ? request()->mds_schedule_venue_filter : "";
        $mds_schedule_rsp_filter = (request()->mds_schedule_rsp_filter) ? request()->mds_schedule_rsp_filter : "";


        $ops = BookingSlot::orderBy($sort, $order);

        if ($search) {
            $ops = $ops->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('short_name', 'like', '%' . $search . '%')
                    ->orWhere('id', 'like', '%' . $search . '%');
            });
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
        $venue = $ops->paginate(request("limit"))->through(function ($ops) {

        // $location = Location::find($ops->location_id);

            return  [
                'id' => $ops->id,
                // 'id' => '<div class="align-middle white-space-wrap fw-bold fs-8 ps-2">' .$venue->id. '</div>',
                'event' => '<div class="align-middle white-space-wrap fw-bold fs-10 ps-2">' . $ops->event?->name . '</div>',
                'venue' => '<div class="align-middle white-space-wrap fw-bold fs-10 ps-2">' . $ops->venue?->title . '</div>',
                'booking_date' => '<div class="align-middle white-space-wrap fw-bold fs-10 ps-2">' . format_date($ops->booking_date) . '</div>',
                'rsp_booking_slot' => '<div class="align-middle white-space-wrap fw-bold fs-10 ps-2">' . $ops->rsp_booking_slot . '</div>',
                'venue_arrival_time' => '<div class="align-middle white-space-wrap fw-bold fs-10 ps-2">' . $ops->venue_arrival_time . '</div>',
                'bookings_slots_all' => '<div class="align-middle white-space-wrap fw-bold fs-10 ps-2">' . $ops->bookings_slots_all . '</div>',
                'available_slots' => '<div class="align-middle white-space-wrap fw-bold fs-10 ps-2">' . $ops->available_slots . '</div>',
                'used_slots' => '<div class="align-middle white-space-wrap fw-bold fs-10 ps-2">' . $ops->used_slots . '</div>',
                'bookings_slots_cat' => '<div class="align-middle white-space-wrap fw-bold fs-10 ps-2">' . $ops->bookings_slots_cat . '</div>',
                'slot_visibility' => '<div class="align-middle white-space-wrap fw-bold fs-10 ps-2">' . format_date($ops->slot_visibility) . '</div>',
                'remote_search_park' => '<div class="align-middle white-space-wrap fw-bold fs-10 ps-2">' . $ops->remote_search_park . '</div>',
                'match_day' => '<div class="align-middle white-space-wrap fw-bold fs-10 ps-2">' . $ops->match_day . '</div>',
                'comments' => '<div class="align-middle white-space-wrap fw-bold fs-10 ps-2">' . $ops->comments . '</div>',
                'created_at' => format_date($ops->created_at,  'H:i:s'),
                'updated_at' => format_date($ops->updated_at, 'H:i:s'),
            ];
        });

        return response()->json([
            "rows" => $venue->items(),
            "total" => $total,
        ]);
    }

    public function store(Request $request)
    {
        //
        // dd($request);
        $user_id = Auth::user()->id;
        $venue = new DeliverySchedule();

        $rules = [
            'regime_start_date' => 'required',
            'regime_end_date' => 'required',
            'schedule_venue_id' => 'required',
            'schedule_rsp_id' => 'required',
            'time_slots' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            Log::info($validator->errors());
            $error = true;
            $message = 'Schedule could not be created';
        } else {

            $error = false;
            $message = 'Schedule created succesfully.' . $venue->id;

            $venue->regime_start_date = Carbon::createFromFormat('d/m/Y', $request->regime_start_date)->toDateString();
            $venue->regime_end_date = Carbon::createFromFormat('d/m/Y', $request->regime_end_date)->toDateString();
            $venue->venue_id = $request->schedule_venue_id;
            $venue->rsp_id = $request->schedule_rsp_id;
            $venue->time_slots = $request->time_slots;
            $venue->created_by = $user_id;
            $venue->updated_by = $user_id;
            $venue->active_flag = 1;

            $venue->save();

        }

        $notification = array(
            'message'       => 'Schedule created successfully',
            'alert-type'    => 'success'
        );

        return response()->json(['error' => $error, 'message' => $message]);

    }

    public function delete($id)
    {
        $ws = DeliverySchedule::findOrFail($id);
        $ws->delete();

        $error = false;
        $message = 'Venue deleted succesfully.';

        $notification = array(
            'message'       => 'Venue deleted successfully',
            'alert-type'    => 'success'
        );

        return response()->json(['error' => $error, 'message' => $message]);
        // return redirect()->route('tracki.setup.workspace')->with($notification);
    } // delete

}
