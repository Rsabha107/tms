<?php

namespace App\Http\Controllers\Mds\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mds\BookingSlot;
use App\Models\Mds\FunctionalArea;
use App\Models\Mds\DeliveryBooking;
use App\Models\Mds\DeliveryCargoType;
use App\Models\Mds\DeliveryRsp;
use App\Models\Mds\DeliverySchedule;
use App\Models\Mds\DeliverySchedulePeriod;
use App\Models\Mds\DeliveryType;
use App\Models\Mds\DeliveryVehicle;
use App\Models\Mds\DeliveryVehicleType;
use App\Models\Mds\DeliveryVenue;
use App\Models\Mds\DeliveryZone;
use App\Models\Mds\MdsDriver;
use App\Models\Mds\MdsEvent;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd(session()->get('EVENT_ID'));
        // if (session()->has('EVENT_ID')) {
        //     $current_event_id = session()->get('EVENT_ID');
        //     $bookings = DeliveryBooking::where('event_id', '=', $current_event_id)->get();
        // } else {
        //     return view('mds.admin.booking.pick');
        // }

        $current_event_id = session()->get('EVENT_ID');

        $bookings = DeliveryBooking::where('event_id', '=', $current_event_id)->get();
        // $bookings = DeliveryBooking::all();
        $intervals = DeliverySchedulePeriod::all();
        $venues = DeliveryVenue::all();
        $rsps = DeliveryRsp::all();
        $drivers = MdsDriver::all();
        $vehicles = DeliveryVehicle::all();
        $vehicle_types = DeliveryVehicle::all();
        $delivery_types = DeliveryType::all();
        $cargos = DeliveryType::all();
        $loading_zones = DeliveryZone::all();
        $clients = FunctionalArea::all();

        return view('mds.admin.booking.list', compact(
            'bookings',
            'intervals',
            'venues',
            'rsps',
            'drivers',
            'vehicles',
            'vehicle_types',
            'delivery_types',
            'cargos',
            'loading_zones',
            'clients'
        ));
    }

    public function listEvent(Request $request, String $id)
    {
        $start = date('Y-m-d', strtotime($request->start));
        $end = date('Y-m-d', strtotime($request->end));

        // $events = DeliverySchedulePeriod::where('venue_id', $id)
        //     ->where('available_slots', '>', 0)
        //     ->distinct()
        //     ->get('period_date')

        //     // dd($events);
        //     ->map(fn($item) => [
        //         // 'id' => $item->id,
        //         // 'title' => $item->period.' - ('.$item->available_slots.' slots)',
        //         'start' => $item->period_date,
        //         'end' => date('Y-m-d', strtotime($item->period_date . '+1 days')),
        //         // 'category' => $item->category,
        //         'className' => ['bg-warning']
        //     ]);

        // Log::info('BookingController::listEvent carbon yesterday: ' . Carbon::previous('2025-11-01')->setTime(17, 0, 0)->toDateTimeString());
        // $date = Carbon::createFromFormat('Y-m-d',  '2025-03-04');
        // $prevDate = $date->subDay()->setTimeFromTimeString('17:00:00');
        // $now = Carbon::now();
        $t = '7';
        // Log::info('BookingController::listEvent carbon this date: ' . $date);
        // Log::info('BookingController::listEvent carbon this now: ' . $now);
        // Log::info('today is greator than ..'. ($date->gt($now)));
        // Log::info('today is less than ..'. ($date->lt($now)));
        // Log::info('BookingController::listEvent carbon subDay: ' . $prevDate);
        $events = BookingSlot::where('venue_id', $id)
        ->where('event_id', session()->get('EVENT_ID'))
        ->where('bookings_slots_all', '>', 0)
        ->where('slot_visibility', '<=', Carbon::now())
        // ->whereRaw("DATE_ADD(booking_date, INTERVAL '-0 7' DAY_HOUR) > NOW()")
        ->where( function($query) use ($t) {
            $query->whereRaw("DATE_ADD(booking_date, INTERVAL '-0 $t' DAY_HOUR) > NOW()");
        })
        // ->where(Carbon::createFromFormat('Y-m-d','booking_date')->subDay()->setTimeFromTimeString('17:00:00')->gt(Carbon::now()))
        ->distinct()
        ->get('booking_date')

        // dd($events);
        ->map(fn($item) => [
            // 'id' => $item->id,
            // 'title' => $item->period.' - ('.$item->available_slots.' slots)',
            'start' => $item->booking_date,
            'end' => date('Y-m-d', strtotime($item->period_date . '+1 days')),
            'display'=> 'block',
            'backgroundColor' => 'green',
            // 'eventColor'=> 'green',
            // 'category' => $item->category,
            'className' => ['bg-warning'],
        ]);

        return response()->json($events);
    }

    public function list()
    {
        $search = request('search');
        $sort = (request('sort')) ? request('sort') : "id";
        $order = (request('order')) ? request('order') : "DESC";
        $booking = DeliveryBooking::orderBy($sort, $order);

        // if ($search) {
        //     $venue = $venue->where(function ($query) use ($search) {
        //         $query->where('status', 'like', '%' . $search . '%')
        //         ->orWhere('period', 'like', '%' . $search . '%')
        //         ->orWhere('period', 'like', '%' . $search . '%')
        //             ->orWhere('id', 'like', '%' . $search . '%');
        //     });
        // }
        if (session()->has('EVENT_ID')) {
            $current_event_id = session()->get('EVENT_ID');
            $booking = $booking->where('event_id', '=', $current_event_id);
        }

        if ($search) {

            $booking = $booking->whereHas('client', function ($query) use ($search) {
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

        $total = $booking->count();
        $booking = $booking->paginate(request("limit"))->through(function ($booking) {

            // $location = Location::find($booking->location_id);

            $actions =

                '<div class="font-sans-serif btn-reveal-trigger position-static">' .
                '<a href="javascript:void(0)" class="btn btn-sm" id="bookingDetails" data-id="' .
                $booking->id .
                '" data-table="bookings_table" data-bs-toggle="tooltip" data-bs-placement="right" title="View Booking Details">' .
                '<i class="fas fa-lightbulb text-warning"></i></a>' .
                '<a href="' . route('mds.admin.booking.pass.pdf', $booking->id) . '"  target="_blank" class="btn btn-sm" id="generateBookingPass" data-id="' .
                $booking->id .
                '" data-table="bookings_table" data-bs-toggle="tooltip" data-bs-placement="right" title="Generate Pass">' .
                '<i class="fas fa-passport text-success"></i></a>' .
                '<a href="' . route('mds.admin.booking.edit', $booking->id) . '" class="btn btn-sm" id="editBooking" data-id="' .
                $booking->id .
                '" data-table="bookings_table" data-bs-toggle="tooltip" data-bs-placement="right" title="Update">' .
                '<i class="fa-solid fa-pen-to-square text-primary"></i></a>' .
                '<a href="javascript:void(0)" class="btn btn-sm" data-table="bookings_table" data-id="' .
                $booking->id .
                '" id="deleteBooking" data-bs-toggle="tooltip" data-bs-placement="right" title="Delete">' .
                '<i class="bx bx-trash text-danger"></i></a></div></div>';

            return  [
                'id' => $booking->id,
                // 'id' => '<div class="align-middle white-space-wrap fw-bold fs-8 ps-2">' .$booking->id. '</div>',
                'delivery_status_id' => '<div class="align-middle white-space-wrap fw-bold fs-9 ps-2">' . $booking->status->title . '</div>',
                'booking_ref_number' => '<div class="align-middle white-space-wrap fw-bold fs-9 ps-2">' .  $booking->booking_ref_number . '</div>',
                'rsp_name' => '<div class="align-middle white-space-wrap fw-bold fs-9 ps-2">' . $booking->schedule->rsp?->title . '</div>',
                'client_group' => '<div class="align-middle white-space-wrap fw-bold fs-9 ps-2">' . $booking->client?->title . '</div>',
                'booking_date' => '<div class="align-middle white-space-wrap fw-bold fs-9 ps-2">' . format_date($booking->booking_date) . '</div>',
                // 'booking_time' => '<div class="align-middle white-space-wrap fw-bold fs-9 ps-2">' . time_range_segment($booking->schedule_period->period, 'from') . '</div>',
                'booking_time' => '<div class="align-middle white-space-wrap fw-bold fs-9 ps-2">' . $booking->schedule->rsp_booking_slot . '</div>',
                // 'booking_time' => '<div class="align-middle white-space-wrap fw-bold fs-9 ps-2">' . ($booking->schedule_period->period) . '</div>',
                'booking_party_company_name' => '<div class="align-middle white-space-wrap fw-bold fs-9 ps-2">' . $booking->booking_party_company_name . '</div>',
                'booking_party_contact_name' => '<div class="align-middle white-space-wrap fw-bold fs-9 ps-2">' . $booking->booking_party_contact_name . '</div>',
                'booking_party_contact_email' => '<div class="align-middle white-space-wrap fw-bold fs-9 ps-2">' . $booking->booking_party_contact_email . '</div>',
                'booking_party_contact_number' => '<div class="align-middle white-space-wrap fw-bold fs-9 ps-2">' . $booking->booking_party_contact_number . '</div>',
                'delivering_party_company_name' => '<div class="align-middle white-space-wrap fw-bold fs-9 ps-2">' . $booking->delivering_party_company_name . '</div>',
                'delivering_party_contact_number' => '<div class="align-middle white-space-wrap fw-bold fs-9 ps-2">' . $booking->delivering_party_contact_number . '</div>',
                'delivering_party_contact_email' => '<div class="align-middle white-space-wrap fw-bold fs-9 ps-2">' . $booking->delivering_party_contact_email . '</div>',
                'delivering_party_contact_email' => '<div class="align-middle white-space-wrap fw-bold fs-9 ps-2">' . $booking->delivering_party_contact_email . '</div>',
                'delivering_party_contact_email' => '<div class="align-middle white-space-wrap fw-bold fs-9 ps-2">' . $booking->delivering_party_contact_email . '</div>',
                'delivering_party_contact_email' => '<div class="align-middle white-space-wrap fw-bold fs-9 ps-2">' . $booking->delivering_party_contact_email . '</div>',
                'arrival_date_time' => '<div class="align-middle white-space-wrap fw-bold fs-9 ps-2">' . format_date($booking->arrival_date_time) . '</div>',
                'driver_first_name' => '<div class="align-middle white-space-wrap fw-bold fs-9 ps-2">' . $booking->driver->first_name . '</div>',
                'driver_last_name' => '<div class="align-middle white-space-wrap fw-bold fs-9 ps-2">' . $booking->driver->last_name . '</div>',
                'driver_national_id' => '<div class="align-middle white-space-wrap fw-bold fs-9 ps-2">' . $booking->driver->national_identifier_number . '</div>',
                'driver_phone_number' => '<div class="align-middle white-space-wrap fw-bold fs-9 ps-2">' . $booking->driver->mobile_number . '</div>',
                'vehicle_make' => '<div class="align-middle white-space-wrap fw-bold fs-9 ps-2">' . $booking->vehicle->make . '</div>',
                'license_plate' => '<div class="align-middle white-space-wrap fw-bold fs-9 ps-2">' . $booking->vehicle->license_plate . '</div>',
                'vehicle_type' => '<div class="align-middle white-space-wrap fw-bold fs-9 ps-2">' . $booking->vehicle_type->title . '</div>',
                'receiver_name' => '<div class="align-middle white-space-wrap fw-bold fs-9 ps-2">' . $booking->receiver_name . '</div>',
                'receiver_contact_number' => '<div class="align-middle white-space-wrap fw-bold fs-9 ps-2">' . $booking->receiver_contact_number . '</div>',
                'loading_zone' => '<div class="align-middle white-space-wrap fw-bold fs-9 ps-2">' . $booking->zone->title . '</div>',
                'cargo' => '<div class="align-middle white-space-wrap fw-bold fs-9 ps-2">' . $booking->cargo->title . '</div>',
                'delivery_type' => '<div class="align-middle white-space-wrap fw-bold fs-9 ps-2">' . $booking->delivery_type->title . '</div>',
                'booking' => '<div class="align-middle white-space-wrap fw-bold fs-9 ps-2">' . $booking->id . '</div>',
                'action' => $actions,
                'created_at' => format_date($booking->created_at,  'H:i:s'),
                'updated_at' => format_date($booking->updated_at, 'H:i:s'),
            ];
        });

        return response()->json([
            "rows" => $booking->items(),
            "total" => $total,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $schedules = DeliverySchedule::all();
        $intervals = DeliverySchedulePeriod::all();
        // $venues = DeliveryVenue::all();
        $venues = BookingSlot::select('venue_id','venue_name')
                        ->where('event_id', session()->get('EVENT_ID'))
                        ->distinct()
                        ->get();
        $rsps = DeliveryRsp::all();
        $drivers = MdsDriver::all();
        $vehicles = DeliveryVehicle::all();
        $vehicle_types = DeliveryVehicleType::all();
        $delivery_types = DeliveryType::all();
        $cargos = DeliveryCargoType::all();
        $loading_zones = DeliveryZone::all();
        $clients = FunctionalArea::all();

        return view('mds.admin.booking.create', compact(
            'schedules',
            'intervals',
            'venues',
            'rsps',
            'drivers',
            'vehicles',
            'vehicle_types',
            'delivery_types',
            'cargos',
            'loading_zones',
            'clients'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // dd($request);
        $user_id = Auth::user()->id;
        $booking = new DeliveryBooking();
        $timeslots = BookingSlot::findOrFail($request->schedule_period_id);
        // $timeslots = DeliverySchedulePeriod::findOrFail($request->schedule_period_id);

        $rules = [
            'booking_date' => 'required',
            'schedule_period_id' => 'required',
            'venue_id' => 'required',
            'driver_id' => 'required',
            'vehicle_id' => 'required',
            'vehicle_type_id' => 'required',
            'receiver_name' => 'required',
            'receiver_contact_number' => 'required',
            'dispatch_id' => 'required',
            'cargo_id' => 'required',
            'loading_zone_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            Log::info($validator->errors());
            $error = true;
            $message = 'Booking could not be created';
        } else {

            // check number of slots available.  if available slots = 0 then exit with a warning message.
            // this is incase a user grabed the last slot with this user is waiting ..

            if ($timeslots->available_slots > 0) {

                $error = false;
                $message = 'Booking created succesfully.' . $booking->id;

                $booking->booking_ref_number = 'MDS' . $booking->id;
                $booking->schedule_id =  $timeslots->delivery_schedule_id;
                $booking->schedule_period_id = $request->schedule_period_id;
                $booking->booking_date = $request->booking_date;
                $booking->event_id = session()->get('EVENT_ID');
                // $booking->booking_date = Carbon::createFromFormat('d/m/Y', $request->booking_date)->toDateString();
                $booking->venue_id = $request->venue_id;
                $booking->client_id = $request->client_id;
                $booking->booking_party_company_name = $request->booking_party_company_name;
                $booking->booking_party_contact_name = $request->booking_party_contact_name;
                $booking->booking_party_contact_email = $request->booking_party_contact_email;
                $booking->booking_party_contact_number = $request->booking_party_contact_number;
                $booking->delivering_party_company_name = $request->delivering_party_company_name;
                $booking->delivering_party_contact_number = $request->delivering_party_contact_number;
                $booking->delivering_party_contact_email = $request->delivering_party_contact_email;
                $booking->driver_id = $request->driver_id;
                $booking->vehicle_id = $request->vehicle_id;
                $booking->vehicle_type_id = $request->vehicle_type_id;
                $booking->receiver_name = $request->receiver_name;
                $booking->receiver_contact_number = $request->receiver_contact_number;
                $booking->dispatch_id = $request->dispatch_id;
                $booking->loading_zone_id = $request->loading_zone_id;
                $booking->cargo_id = $request->cargo_id;
                $booking->active_flag = $request->active_flag;
                $booking->created_by = $user_id;
                $booking->updated_by = $user_id;
                $booking->active_flag = 1;

                $timeslots->available_slots = $timeslots->available_slots - 1;
                $timeslots->used_slots = $timeslots->used_slots + 1;
                $timeslots->save();

                $booking->save();
            } else {
                $error = true;
                $message = 'Time slot choosing has been used please choose a different time slot.' . $booking->id;
            }
        }

        $notification = array(
            'message'       => $message,
            'alert-type'    => $error
        );

        // return redirect()->route('mds.booking.add')->with($notification);
        return view('mds.admin.booking.confirmation', ['data' => $booking]);


        // return response()->json(['error' => $error, 'message' => $message]);
    }

    public function delete($id)
    {
        // LOG::info('inside delete');
        $op = DeliveryBooking::find($id);

        // get the timeslot id
        $timeslot_id = $op->schedule_period_id;
        // get the timeslot
        $timeslot = BookingSlot::find($timeslot_id);

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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function detail($id)
    {
        $booking = DeliveryBooking::findOrFail($id);

        // dd($project);

        // Log::alert('EmployeeController::getEmpEditView file_name: ' . $emp->emp_files?->file_name);

        $view = view('/mds/admin/booking/mv/detail', [
            'booking' => $booking,
        ])->render();

        return response()->json(['view' => $view]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $booking = DeliveryBooking::find($id);
        $intervals = DeliverySchedulePeriod::all();
        $venues = DeliveryVenue::all();
        $rsps = DeliveryRsp::all();
        $drivers = MdsDriver::all();
        $vehicles = DeliveryVehicle::all();
        $vehicle_types = DeliveryVehicleType::all();
        $delivery_types = DeliveryType::all();
        $cargos = DeliveryType::all();
        $loading_zones = DeliveryZone::all();
        $clients = FunctionalArea::all();

        return view('mds.admin.booking.edit', compact(
            'booking',
            'intervals',
            'venues',
            'rsps',
            'drivers',
            'vehicles',
            'vehicle_types',
            'delivery_types',
            'cargos',
            'loading_zones',
            'clients'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
        // dd($request);
        $user_id = Auth::user()->id;
        $booking = DeliveryBooking::find($request->id);
        $timeslots = DeliverySchedulePeriod::findOrFail($request->schedule_period_id);


        $rules = [
            'booking_date' => 'required',
            'schedule_period_id' => 'required',
            'venue_id' => 'required',
            'driver_id' => 'required',
            'vehicle_id' => 'required',
            'vehicle_type_id' => 'required',
            'receiver_name' => 'required',
            'receiver_contact_number' => 'required',
            'dispatch_id' => 'required',
            'cargo_id' => 'required',
            'loading_zone_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            Log::info($validator->errors());
            $error = true;
            $message = 'Booking could not be created';
        } else {

            // check number of slots available.  if available slots = 0 then exit with a warning message.
            // this is incase a user grabed the last slot with this user is waiting ..

            if ($timeslots->available_slots > 0) {

                $error = false;
                $message = 'Booking updated succesfully.' . $booking->id;

                $booking->booking_ref_number = 'MDS' . $booking->id;
                $booking->schedule_id =  $timeslots->delivery_schedule_id;
                $booking->schedule_period_id = $request->schedule_period_id;
                // $booking->booking_date = Carbon::createFromFormat('Y/m/d', $request->booking_date)->toDateString();
                $booking->booking_date = $request->booking_date;
                $booking->venue_id = $request->venue_id;
                $booking->client_id = $request->client_id;
                $booking->booking_party_company_name = $request->booking_party_company_name;
                $booking->booking_party_contact_name = $request->booking_party_contact_name;
                $booking->booking_party_contact_email = $request->booking_party_contact_email;
                $booking->booking_party_contact_number = $request->booking_party_contact_number;
                $booking->delivering_party_company_name = $request->delivering_party_company_name;
                $booking->delivering_party_contact_number = $request->delivering_party_contact_number;
                $booking->delivering_party_contact_email = $request->delivering_party_contact_email;
                $booking->driver_id = $request->driver_id;
                $booking->vehicle_id = $request->vehicle_id;
                $booking->vehicle_type_id = $request->vehicle_type_id;
                $booking->receiver_name = $request->receiver_name;
                $booking->receiver_contact_number = $request->receiver_contact_number;
                $booking->dispatch_id = $request->dispatch_id;
                $booking->loading_zone_id = $request->loading_zone_id;
                $booking->cargo_id = $request->cargo_id;
                $booking->active_flag = $request->active_flag;
                $booking->created_by = $user_id;
                $booking->updated_by = $user_id;
                $booking->active_flag = 1;

                $timeslots->available_slots = $timeslots->available_slots - 1;
                $timeslots->used_slots = $timeslots->used_slots + 1;
                $timeslots->save();

                $booking->save();
            } else {
                $error = true;
                $message = 'Time slot choosing has been used. please choose a different time slot.' . $booking->id;
            }
        }

        $notification = array(
            'message'       => $message,
            'alert-type'    => $error
        );

        return redirect()->route('mds.admin.booking')->with($notification);
        // return view('mds.admin.booking');


        // return response()->json(['error' => $error, 'message' => $message]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function passPdf(Request $request, $id)
    {
        // set_time_limit(300);
        $booking = DeliveryBooking::findOrFail($id);
        $qr_code = getQrCode($booking->id, 100);


        $data = [
            'to' => 'Sam Example',
            'subtotal' => '5.00',
            'tax' => '.35',
            'total' => '5.35',
            'receipeint_company' => 'GWC Logistics',
            'booking' => $booking,
            'qr_code' => $qr_code,

        ];

        if ($request->has('preview')) {
            $data['css'] = asset('assets/css/invoice.css');
            return view('mds.booking.passx', $data);
        } else {
            $data['css'] = public_path('assets/css/invoice.css');
        }

        // Pdf::view('mds.booking.passx');
        // Pdf::view('mds.booking.passx')->save('/upload/passx.pdf');
        // return view('mds.booking.passx', $data);
        $pdf = Pdf::loadView('mds.admin.booking.passx', $data);
        // return $pdf->download('itsolutionstuff.pdf');
        return $pdf->stream();
    }  //taskDetailsPDF

    public function get_times($date, $venue_id)
    {
        // LOG::info('inside get_times');
        $formated_date = Carbon::createFromFormat('dmY', $date)->toDateString();
        // LOG::info('formated_date: '.$formated_date);
        // LOG::info('venue_id: '.$venue_id);
        $venue = DeliverySchedulePeriod::where('period_date', '=', $formated_date)
            ->where('venue_id', '=', $venue_id)
            // ->where('available_slots', '>', '0')
            ->get();

        // $venue = DeliverySchedulePeriod::all();

        return response()->json(['venue' => $venue]);
    }

    public function get_times_cal($date, $venue_id)
    {
        // LOG::info('inside get_times');
        // $formated_date = Carbon::createFromFormat('dmY', $date)->toDateString();
        // LOG::info('formated_date: '.$formated_date);
        // LOG::info('venue_id: '.$venue_id);
        // $venue = DeliverySchedulePeriod::where('period_date', '=', $date)
        //     ->where('venue_id', '=', $venue_id)
        //     // ->where('available_slots', '>', '0')
        //     ->get();

        $venue = BookingSlot::where('booking_date', '=', $date)
        ->where('venue_id', '=', $venue_id)
        ->where('bookings_slots_all', '>', '0')
        ->where('slot_visibility', '<=', Carbon::now())
        ->get();

        // $venue = DeliverySchedulePeriod::all();

        return response()->json(['venue' => $venue]);
    }

    public function switch($id)
    {
        if ($id) {
            if (MdsEvent::findOrFail($id)) {
                Log::info('Event ID: ' . $id);

                session()->put('EVENT_ID', $id);
                Log::info('Event ID: ' . session()->get('EVENT_ID'));
                // return redirect()->route('tracki.project.show.card')->with('message', 'Workspace switched successfully.');
                return redirect()->route('mds.admin.booking')->with('message', 'Event Switched.');
                // return back()->with('message', 'Event Switched.');
            } else {
                // return back()->with('error', 'Workspace not found.');
                // return redirect()->route('tracki.project.show.card')->with('error', 'Workspace not found.');
                return back()->with('error', 'Event not found.');
            }
        } else {
            session()->forget('EVENT_ID');
            // return redirect()->route('tracki.project.show.card')->with('message', 'Workspace switched successfully. now showing all workspace data');
            return back()->withInput();
        }
    }

    public function pickEvent(Request $request)
    {
        // $events = MdsEvent::all();
        // $this->switch($request->event_id);
        // return view('mds.admin.booking.pick', compact('events'));
        if ($request->event_id) {
            Log::info('Event ID: ' . $request->event_id);
            if (MdsEvent::findOrFail($request->event_id) && !session()->has('EVENT_ID')) {
                Log::info('Event ID: ' . $request->event_id);

                session()->put('EVENT_ID', $request->event_id);
                Log::info('Event ID: ' . session()->get('EVENT_ID'));
                // return redirect()->route('tracki.project.show.card')->with('message', 'Workspace switched successfully.');
                return redirect()->route('mds.admin.booking')->with('message', 'Event Switched.');
                // return back()->with('message', 'Event Switched.');
            }
        }
        //  else {
        // return back()->with('error', 'Workspace not found.');
        // return redirect()->route('tracki.project.show.card')->with('error', 'Workspace not found.');
        Log::info('event_id is null');
        return redirect()->route('mds.admin.booking')->with('error', 'Event not found.');
        // }
    }
}
