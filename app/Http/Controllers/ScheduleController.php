<?php

namespace App\Http\Controllers;

use App\Models\DeliveryRsp;
use App\Models\DeliverySchedule;
use App\Models\DeliveryVenue;
use App\Models\Location;
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
        $venues = DeliveryVenue::all();
        $rsps = DeliveryRsp::all();

        return view('mds.setting.schedule.list', compact('schedules', 'venues', 'rsps'));
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
        $venue = DeliverySchedule::orderBy($sort, $order);

        if ($search) {
            $venue = $venue->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('short_name', 'like', '%' . $search . '%')
                    ->orWhere('id', 'like', '%' . $search . '%');
            });
        }
        $total = $venue->count();
        $venue = $venue->paginate(request("limit"))->through(function ($venue) {

        // $location = Location::find($venue->location_id);

            return  [
                'id' => $venue->id,
                // 'id' => '<div class="align-middle white-space-wrap fw-bold fs-8 ps-2">' .$venue->id. '</div>',
                'regime_start_date' => '<div class="align-middle white-space-wrap fw-bold fs-8 ps-2">' . format_date($venue->regime_start_date) . '</div>',
                'regime_end_date' => '<div class="align-middle white-space-wrap fw-bold fs-8 ps-2">' .  format_date($venue->regime_end_date) . '</div>',
                'venue_short_name' => '<div class="align-middle white-space-wrap fw-bold fs-8 ps-2">' . $venue->venue->short_name . '</div>',
                'venue' => '<div class="align-middle white-space-wrap fw-bold fs-8 ps-2">' . $venue->venue->title . '</div>',
                'rsp' => '<div class="align-middle white-space-wrap fw-bold fs-8 ps-2">' . $venue->rsp->title . '</div>',
                'time_slots' => '<div class="align-middle white-space-wrap fw-bold fs-8 ps-2">' . $venue->time_slots . '</div>',
                'created_at' => format_date($venue->created_at,  'H:i:s'),
                'updated_at' => format_date($venue->updated_at, 'H:i:s'),
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
