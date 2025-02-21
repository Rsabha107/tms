<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Event;
use App\Models\Audience;
use App\Models\Attendance;
use App\Models\EventAttendance;
use App\Imports\AttendanceImport;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;


class AttendanceController extends Controller
{
    //
    // *********************************************** Attendace *********************************************************************
    public function attendance()
    {
        $allCount = Attendance::all()->count();

        $infCount = DB::table('master_guests_list')
            ->where('type_id', '=', '8')->count();

        $vicCount = DB::table('master_guests_list')
            ->where('type_id', '=', '9')->count();

        $vipCount = DB::table('master_guests_list')
            ->where('type_id', '=', '10')->count();


        $dataDetails = Attendance::leftJoin('event_audience', 'event_audience.id', '=', 'master_guests_list.type_id')
            ->get(([
                'master_guests_list.id',
                'master_guests_list.first_name',
                'master_guests_list.last_name',
                'master_guests_list.email_address',
                'master_guests_list.phone_number',
                'master_guests_list.type_id',
                'event_audience.name as attendance_type',
                'master_guests_list.active_flag',
            ]));

        $audience = Audience::all();

        return view('tracki.attendance.list', [
            'dataDetails'       => $dataDetails,
            'audience'          => $audience,
            'allCount'          => $allCount,
            'infCount'          => $infCount,
            'vicCount'          => $vicCount,
            'vipCount'          => $vipCount,
        ]);
    }

    public function attendanceInfo(Request $request)
    {

        // $attendData = EventAttendance::find($request->document_id);
        $attendData = EventAttendance::join('master_guests_list', 'event_attendance.guest_id', '=', 'master_guests_list.id')
            ->join('event_audience', 'event_audience.id', '=', 'master_guests_list.type_id')
            ->where('event_attendance.id', '=', $request->document_id)
            ->orderBy('master_guests_list.first_name', 'asc')
            ->get(([
                'event_attendance.id',
                'master_guests_list.first_name',
                'master_guests_list.last_name',
                'master_guests_list.email_address',
                'master_guests_list.phone_number',
                'event_audience.name',
            ]));

            // foreach ($attendData as $key => $item) {
            //     Log::info('Key: '.$key.' Item: '.$item);
            // }
            //$this->markAttendance($request);
            LOG::info($attendData->isEmpty());
            if (!$attendData->isEmpty()){
                $this->markAttendance($request);
            }
        return view('tracki.attendance.info', ['attendData' => $attendData]);
    }

    public function markAttendance(Request $request)
    {

        $eventAttendData = EventAttendance::find($request->document_id);
        $eventAttendData->guest_attended = 'Y';
        $eventAttendData->save();
        $notification = array(
            'message'       => 'Attendee updated successfully',
            'alert-type'    => 'success'
        );

        // return Redirect::route('tracki.attendance.checkin')->with($notification);
        // dd ('life is good');
    }

    public function attendanceAssignment()
    {
        $allCount = Attendance::all()->count();
        $eventData = Event::all();

        $infCount = DB::table('master_guests_list')
            ->where('type_id', '=', '8')->count();

        $vicCount = DB::table('master_guests_list')
            ->where('type_id', '=', '9')->count();

        $vipCount = DB::table('master_guests_list')
            ->where('type_id', '=', '10')->count();


        $dataDetails = Attendance::join('event_audience', 'event_audience.id', '=', 'master_guests_list.type_id')
            ->get(([
                'master_guests_list.id',
                'master_guests_list.first_name',
                'master_guests_list.last_name',
                'master_guests_list.email_address',
                'master_guests_list.phone_number',
                'master_guests_list.type_id',
                'event_audience.name as attendance_type',
                'master_guests_list.active_flag',
            ]));

        $audience = Audience::all();

        return view('tracki.attendance.assignment', [
            'dataDetails'       => $dataDetails,
            'audience'          => $audience,
            'allCount'          => $allCount,
            'infCount'          => $infCount,
            'vicCount'          => $vicCount,
            'vipCount'          => $vipCount,
            'eventData'         => $eventData,
        ]);
    }

    public function eventAttendanceAssignment($id)
    {
        $allCount = Attendance::all()->count();
        $eventData = Event::all();

        $infCount = DB::table('master_guests_list')
            ->where('type_id', '=', '8')->count();

        $vicCount = DB::table('master_guests_list')
            ->where('type_id', '=', '9')->count();

        $vipCount = DB::table('master_guests_list')
            ->where('type_id', '=', '10')->count();


        $dataDetails = Attendance::join('event_audience', 'event_audience.id', '=', 'master_guests_list.type_id')
            ->get(([
                'master_guests_list.id',
                'master_guests_list.first_name',
                'master_guests_list.last_name',
                'master_guests_list.email_address',
                'master_guests_list.phone_number',
                'master_guests_list.type_id',
                'event_audience.name as attendance_type',
                'master_guests_list.active_flag',
            ]));

        $audience = Audience::all();

        // return Redirect::route('tracki.event.attendance.assignment', [
        return view('tracki.attendance.eventassignment', [
            'dataDetails'       => $dataDetails,
            'audience'          => $audience,
            'allCount'          => $allCount,
            'infCount'          => $infCount,
            'vicCount'          => $vicCount,
            'vipCount'          => $vipCount,
            'event_id'         => $id,
        ]);
    }

    // Assign attendance to an event
    public function assignAttendanceEvents(Request $request)
    {
        Log::info(($request));
        // dd($request->ids);



        foreach ($request->ids as $key => $item) {
            $eventAttendanceRelationship = new EventAttendance;
            Log::info('Key: ' . $key . ' Item: ' . $item);
            Log::info('event id: ' . $request->event_id);
            $eventAttendanceRelationship->event_id = $request->event_id;
            $eventAttendanceRelationship->guest_id = $item;

            $eventAttendanceRelationship->updateOrCreate(
                ['event_id' => $request->event_id, 'guest_id' => $item],
                ['guest_id' => $item],
            );
        }

        return response()->json(['success' => 'all good']);
    }

    public function attendanceInf()
    {
        //    $dataDetails = Attendance::all();
        $allCount = Attendance::all()->count();

        $infCount = DB::table('master_guests_list')
            ->where('type_id', '=', '8')->count();

        $vicCount = DB::table('master_guests_list')
            ->where('type_id', '=', '9')->count();

        $vipCount = DB::table('master_guests_list')
            ->where('type_id', '=', '10')->count();

        $dataDetails = Attendance::join('event_audience', 'event_audience.id', '=', 'master_guests_list.type_id')
            ->where('master_guests_list.type_id', '=', '8')
            ->get(([
                'master_guests_list.id',
                'master_guests_list.first_name',
                'master_guests_list.last_name',
                'master_guests_list.email_address',
                'master_guests_list.phone_number',
                'master_guests_list.type_id',
                'event_audience.name as attendance_type',
                'master_guests_list.active_flag',
            ]));

        $audience = Audience::all();

        return view('tracki.attendance.list', [
            'dataDetails'         => $dataDetails,
            'audience'            => $audience,
            'allCount'          => $allCount,
            'infCount'          => $infCount,
            'vicCount'          => $vicCount,
            'vipCount'          => $vipCount,
        ]);
    }

    public function attendanceVIC()
    {
        //    $dataDetails = Attendance::all();
        $allCount = Attendance::all()->count();

        $infCount = DB::table('master_guests_list')
            ->where('type_id', '=', '8')->count();

        $vicCount = DB::table('master_guests_list')
            ->where('type_id', '=', '9')->count();

        $vipCount = DB::table('master_guests_list')
            ->where('type_id', '=', '10')->count();

        $dataDetails = Attendance::join('event_audience', 'event_audience.id', '=', 'master_guests_list.type_id')
            ->where('master_guests_list.type_id', '=', '9')
            ->get(([
                'master_guests_list.id',
                'master_guests_list.first_name',
                'master_guests_list.last_name',
                'master_guests_list.email_address',
                'master_guests_list.phone_number',
                'master_guests_list.type_id',
                'event_audience.name as attendance_type',
                'master_guests_list.active_flag',
            ]));

        $audience = Audience::all();

        return view('tracki.attendance.list', [
            'dataDetails'         => $dataDetails,
            'audience'            => $audience,
            'allCount'          => $allCount,
            'infCount'          => $infCount,
            'vicCount'          => $vicCount,
            'vipCount'          => $vipCount,
        ]);
    }

    public function attendanceVIP()
    {
        //    $dataDetails = Attendance::all();
        $allCount = Attendance::all()->count();

        $infCount = DB::table('master_guests_list')
            ->where('type_id', '=', '8')->count();

        $vicCount = DB::table('master_guests_list')
            ->where('type_id', '=', '9')->count();

        $vipCount = DB::table('master_guests_list')
            ->where('type_id', '=', '10')->count();

        $dataDetails = Attendance::join('event_audience', 'event_audience.id', '=', 'master_guests_list.type_id')
            ->where('master_guests_list.type_id', '=', '10')
            ->get(([
                'master_guests_list.id',
                'master_guests_list.first_name',
                'master_guests_list.last_name',
                'master_guests_list.email_address',
                'master_guests_list.phone_number',
                'master_guests_list.type_id',
                'event_audience.name as attendance_type',
                'master_guests_list.active_flag',
            ]));

        $audience = Audience::all();

        return view('tracki.attendance.list', [
            'dataDetails'       => $dataDetails,
            'audience'          => $audience,
            'allCount'          => $allCount,
            'infCount'          => $infCount,
            'vicCount'          => $vicCount,
            'vipCount'          => $vipCount,
        ]);
    }

    public function createAttendance(Request $request)
    {
        // dd('mainEvent');
        $op = new Attendance;

        $op->first_name = $request->first_name;
        $op->last_name = $request->last_name;
        $op->email_address = $request->email_address;
        $op->phone_number = $request->phone_number;
        $op->type_id = $request->type_id;
        $op->active_flag = "1";

        $op->save();

        $notification = array(
            'message'       => 'Event created successfully',
            'alert-type'    => 'success'
        );

        // Toastr::success('Has been add successfully :)','Success');
        return Redirect::route('tracki.attendance.list')->with($notification);
    } // saveEvent

    public function editAttendance($id)
    {
        // dd('mainEvent');
        $data = Attendance::find($id);
        //dd($data);
        $data_arr = [];

        $data_arr[] = [
            "id"      => $data->id,
            "first_name"    => $data->first_name,
            "last_name"    => $data->last_name,
            "email_address"    => $data->email_address,
            "phone_number"    => $data->phone_number,
            "type_id"    => $data->type_id,
            "active_flag"    => $data->active_flag,
        ];


        $response = ["retData"  => $data_arr];

        return response()->json($response);
    } // editlocation


    public function updateAttendance(Request $request)
    {
        //  dd('id:'.$request->id);
        Attendance::where('id', '=', $request->id)->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email_address' => $request->email_address,
            'phone_number' => $request->phone_number,
            'type_id' => $request->type_id,
            'active_flag' => $request->active_flag,
        ]);


        $notification = array(
            'message'       => 'Event updated successfully',
            'alert-type'    => 'success'
        );

        // Toastr::success('Has been add successfully :)','Success');
        return Redirect::route('tracki.attendance.list')->with($notification);
        // return view('');

    }

    public function deleteAttendance($id)
    {
        //  dd('deletLocation');
        Attendance::where('id', '=', $id)->delete();

        $notification = array(
            'message'       => 'Master entry removed successfully',
            'alert-type'    => 'success'
        );

        // Toastr::success('Has been add successfully :)','Success');
        return redirect()->back()->with($notification);
        // return Redirect::route('tracki.task.list', $event_id)->with($notification);
    }

    public function deleteEventAssignment($id)
    {
        //  dd('deletLocation');
        EventAttendance::where('id', '=', $id)->delete();

        $notification = array(
            'message'       => 'Assignment removed successfully',
            'alert-type'    => 'success'
        );

        // Toastr::success('Has been add successfully :)','Success');
        return redirect()->back()->with($notification);
        // return Redirect::route('tracki.task.list', $event_id)->with($notification);
    }


    // Import methods
    public function ImportAttendance()
    {

        return view('tracki.attendance.import');
    }

    public function ImportNowAttendance(Request $request){

        Excel::import(new AttendanceImport, $request->file('import_file'));

        $notification = array(
            'message'       => 'Master Guest list imported successfully',
            'alert-type'    => 'success'
        );

        // Toastr::success('Has been add successfully :)','Success');
        return Redirect::route('tracki.attendance.list')->with($notification);
    }
}
