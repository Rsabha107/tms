<?php

namespace App\Http\Controllers\Tms\Setting;

use App\Http\Controllers\Controller;
// use App\Models\Mds\DeliveryRsp;
// use App\Models\Mds\DeliverySchedule;
// use App\Models\Mds\DeliveryVenue;
use App\Models\Location;
use App\Models\Tms\Setting\BookingSlots;
use App\Models\Tms\Setting\Event;
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
        $schedules = BookingSlots::all();
        $events = Event::all();


        return view('tms.setting.schedule.list', compact('schedules', 'events'));
    }

    public function get($id)
    {
        $schedules = BookingSlots::findOrFail($id);
        return response()->json(['schedules' => $schedules]);
    }

    public function update(Request $request)
    {
        //
        // dd($request);
        $user_id = Auth::user()->id;
        $op = BookingSlots::find($request->id);

        $rules = [
            'event_id' => 'required',
            'booking_date' => 'required',
            'booking_slot' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $error = true;
            $message = implode($validator->errors()->all('<div>:message</div>'));  // use this for json/jquery
        } else {

            $error = false;
            $message = 'Schedule updated succesfully.' . $op->id;

            $op->event_id = $request->event_id;
            // $op->event_name = Event::find($request->event_id)->name;
            $op->booking_date = Carbon::createFromFormat('d/m/Y', $request->booking_date)->toDateString();
            $op->booking_slot = $request->booking_slot;
            $op->maximum_slots = $request->maximum_slots;
            $op->available_slots = $request->available_slots;
            $op->used_slots = $request->used_slots;
            $op->updated_by = $user_id;

            $op->save();
        }

        $notification = array(
            'message'       => 'Schedule updated successfully',
            'alert-type'    => 'success'
        );

        return response()->json(['error' => $error, 'message' => $message]);
    }

    public function list()
    {
        $search = request('search');
        $sort = (request('sort')) ? request('sort') : "id";
        $order = (request('order')) ? request('order') : "DESC";
        $mds_schedule_event_filter = (request()->mds_schedule_event_filter) ? request()->mds_schedule_event_filter : "";
        $mds_schedule_venue_filter = (request()->mds_schedule_venue_filter) ? request()->mds_schedule_venue_filter : "";
        $mds_schedule_rsp_filter = (request()->mds_schedule_rsp_filter) ? request()->mds_schedule_rsp_filter : "";


        $ops = BookingSlots::orderBy($sort, $order);

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
        $ops = $ops->paginate(request("limit"))->through(function ($op) {

                $div_action = '<div class="font-sans-serif btn-reveal-trigger position-static">';

                $update_action =
                    '<a href="javascript:void(0)" class="btn btn-sm" id="edit_booking_slot_offcanv" data-id=' . $op->id .
                    ' data-table="schedules_table" data-bs-toggle="tooltip" data-bs-placement="right" title="Update">' .
                    '<i class="fa-solid fa-pen-to-square text-primary"></i></a>';
                $duplicate_action =
                    '<a href="javascript:void(0)" class="btn btn-sm" id="duplicate_employee" data-action="update" data-type="duplicate" data-id=' .
                    $op->id .
                    ' data-table="schedules_table" data-bs-toggle="tooltip" data-bs-placement="right" title="Duplicate">' .
                    '<i class="fa-solid fa-copy text-success"></i></a>';
                $delete_action =
                    '<a href="javascript:void(0)" class="btn btn-sm" data-table="schedules_table" data-id="' .
                    $op->id .
                    '" id="delete_booking_slot" data-bs-toggle="tooltip" data-bs-placement="right" title="Delete">' .
                    '<i class="fa-solid fa-trash text-danger"></i></a></div></div>';

            $actions = $div_action . $update_action . $delete_action;

            return  [
                'id' => $op->id,
                // 'id' => '<div class="align-middle white-space-wrap fw-bold fs-8 ps-2">' .$venue->id. '</div>',
                'event' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->event?->name . '</div>',
                'booking_date' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . format_date($op->booking_date) . '</div>',
                'booking_slot' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->booking_slot . '</div>',
                'maximum_slots' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->maximum_slots . '</div>',
                'available_slots' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->available_slots . '</div>',
                'used_slots' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->used_slots . '</div>',
                'actions' => $actions,
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
        //
        // dd($request);
        $user_id = Auth::user()->id;
        $op = new BookingSlots();

        $rules = [
            'event_id' => 'required',
            'booking_date' => 'required',
            'booking_slot' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $error = true;
            $message = implode($validator->errors()->all('<div>:message</div>'));  // use this for json/jquery
        } else {

            $error = false;
            $message = 'Schedule created succesfully.' . $op->id;

            $op->event_id = $request->event_id;
            // $op->event_name = Event::find($request->event_id)->name;
            $op->booking_date = Carbon::createFromFormat('d/m/Y', $request->booking_date)->toDateString();
            $op->booking_slot = $request->booking_slot;
            $op->maximum_slots = $request->maximum_slots;
            $op->available_slots = $request->available_slots;
            $op->used_slots = $request->used_slots;
            $op->created_by = $user_id;
            $op->updated_by = $user_id;

            $op->save();
        }

        $notification = array(
            'message'       => 'Schedule created successfully',
            'alert-type'    => 'success'
        );

        return response()->json(['error' => $error, 'message' => $message]);
    }

    public function delete($id)
    {
        $ws = BookingSlots::findOrFail($id);
        $ws->delete();

        $error = false;
        $message = 'Schedule deleted succesfully.';

        $notification = array(
            'message'       => 'Schedule deleted successfully',
            'alert-type'    => 'success'
        );

        return response()->json(['error' => $error, 'message' => $message]);
        // return redirect()->route('tracki.setup.workspace')->with($notification);
    } // delete

    public function getScheduleView($id)
    {
        $schedule = BookingSlots::find($id);
        $events = Event::all();

        $view = view('/tms/setting/schedule/mv/edit', [
            'schedule' => $schedule,
            'events' => $events,
        ])->render();

        return response()->json(['view' => $view]);
    }  // End function getProjectView

}
