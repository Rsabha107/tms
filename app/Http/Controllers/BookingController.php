<?php

namespace App\Http\Controllers;

use App\Models\Mds\DeliveryBooking;
use App\Models\Mds\DeliveryBookingNote;
use App\Models\Mds\DeliveryCargoType;
use App\Models\Mds\DeliveryRsp;
use App\Models\Mds\DeliverySchedule;
use App\Models\Mds\DeliverySchedulePeriod;
use App\Models\Mds\DeliveryType;
use App\Models\Mds\DeliveryVehicle;
use App\Models\Mds\DeliveryVehicleType;
use App\Models\Mds\DeliveryVenue;
use App\Models\Mds\DeliveryZone;
use App\Models\FunctionalArea;
use App\Models\Mds\MdsDriver;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\Datatables;

// use Spatie\LaravelPdf\Facades\Pdf;

// use Illuminate\Support\Facades\Redirect;

class BookingController extends Controller
{

    public function test(Request $request)
    {

        $data = DeliveryBooking::all();

        // json_encode( $output );
        // dd($output);
        // dd($booking);
        if ($request->ajax()) {

            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('venue_id', function ($data) {
                    return $data->venue->title;
                })
                ->addColumn('action', function ($data) {
                    $actions =
                        '<div class="font-sans-serif btn-reveal-trigger position-static">' .
                        '<a href="' . route('mds.booking.pass.pdf', $data->id) . '"  target="_blank" class="btn btn-sm" id="generateBookingPass" data-id="' .
                        $data->id .
                        '" data-table="bookings_table" data-bs-toggle="tooltip" data-bs-placement="right" title="Generate Pass">' .
                        '<i class="fas fa-passport text-success"></i></a>' .
                        '<a href="javascript:void(0)" class="btn btn-sm" id="editBooking" data-id="' .
                        $data->id .
                        '" data-table="bookings_table" data-bs-toggle="tooltip" data-bs-placement="right" title="Update">' .
                        '<i class="fa-solid fa-pen-to-square text-primary"></i></a>' .
                        '<a href="javascript:void(0)" class="btn btn-sm delete" data-table="bookings_table" data-id="' .
                        $data->id .
                        '" id="deleteBooking" data-bs-toggle="tooltip" data-bs-placement="right" title="Delete">' .
                        '<i class="bx bx-trash text-danger"></i></a></div></div>';

                    //     $actionBtn = '<a href="javascript:void(0)"
                    //   class="edit btn btn-success btn-sm">Edit</a>
                    //   <a href="javascript:void(0)"
                    //   class="delete btn btn-danger btn-sm">Delete
                    //   </a>';
                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('mds.booking.test');
    }

    //
    public function confirmation($id)
    {

        $booking = DeliveryBooking::findOrFail($id);
        $qr_code = getQrCode($booking->id, 50);

        $data = [
            'qr_code' => $qr_code,
            'booking' => $booking,
        ];

        return view('mds.booking.confirmation', $data);
    }

    public function detail($id)
    {
        $booking = DeliveryBooking::findOrFail($id);

        // dd($project);

        // Log::alert('EmployeeController::getEmpEditView file_name: ' . $emp->emp_files?->file_name);

        $view = view('/mds/booking/mv/detail', [
            'booking' => $booking,
        ])->render();

        return response()->json(['view' => $view]);
    }

    public function add()
    {
        $schedules = DeliverySchedule::all();
        $intervals = DeliverySchedulePeriod::all();
        $venues = DeliveryVenue::all();
        $rsps = DeliveryRsp::all();
        $drivers = MdsDriver::all();
        $vehicles = DeliveryVehicle::all();
        $vehicle_types = DeliveryVehicleType::all();
        $delivery_types = DeliveryType::all();
        $cargos = DeliveryCargoType::all();
        $loading_zones = DeliveryZone::all();
        $clients = FunctionalArea::all();


        return view('mds.booking.add', compact(
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

    public function index1(Request $request)
    {

        if ($request->ajax()) {

            $data = DeliveryBooking::all();

            dd($data);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">Edit</a>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('mds.booking.list');
    }

    public function index()
    {
        $bookings = DeliveryBooking::all();
        $intervals = DeliverySchedulePeriod::all();
        $venues = DeliveryVenue::all();
        $rsps = DeliveryRsp::all();
        $drivers = MdsDriver::all();
        $vehicles = DeliveryVehicle::all();
        $vehicle_types = DeliveryVehicle::all();
        $delivery_types = DeliveryType::all();
        $cargos = DeliveryType::all();
        $loading_zone = DeliveryZone::all();
        $clients = FunctionalArea::all();

        return view('mds.booking.list', compact(
            'bookings',
            'intervals',
            'venues',
            'rsps',
            'drivers',
            'vehicles',
            'vehicle_types',
            'delivery_types',
            'cargos',
            'loading_zone',
            'clients'
        ));
    }

    public function get($id)
    {
        $venue = DeliverySchedulePeriod::findOrFail($id);
        return response()->json(['venue' => $venue]);
    }

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

    public function update(Request $request)
    {

        $user_id = Auth::user()->id;
        $venue = DeliverySchedule::findOrFail($request->id);

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
            $message = 'Booking could not be updated';
        } else {

            $venue->delivery_ref_number = 'MDS' . $venue->id;
            $venue->schedule_period_id = $request->schedule_period_id;
            $venue->booking_date = Carbon::createFromFormat('d/m/Y', $request->booking_date)->toDateString();
            $venue->venue_id = $request->venue_id;
            $venue->client_id = $request->client_id;
            $venue->booking_party_company_name = $request->booking_party_company_name;
            $venue->booking_party_contact_name = $request->booking_party_contact_name;
            $venue->booking_party_contact_email = $request->booking_party_contact_email;
            $venue->booking_party_contact_number = $request->booking_party_contact_number;
            $venue->delivering_party_company_name = $request->delivering_party_company_name;
            $venue->delivering_party_contact_number = $request->delivering_party_contact_number;
            $venue->delivering_party_contact_email = $request->delivering_party_contact_email;
            $venue->driver_id = $request->driver_id;
            $venue->vehicle_id = $request->vehicle_id;
            $venue->vehicle_type_id = $request->vehicle_type_id;
            $venue->receiver_name = $request->receiver_name;
            $venue->receiver_contact_number = $request->receiver_contact_number;
            $venue->dispatch_id = $request->dispatch_id;
            $venue->loading_zone_id = $request->loading_zone_id;
            $venue->cargo_id = $request->cargo_id;
            $venue->active_flag = $request->active_flag;
            $venue->created_by = $user_id;
            $venue->updated_by = $user_id;
            $venue->active_flag = 1;

            if ($venue->save()) {
                return response()->json(['error' => false, 'message' => 'Booking updated successfully.', 'id' => $venue->id]);
            } else {
                return response()->json(['error' => true, 'message' => 'Booking couldn\'t updated.']);
            }
        }
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
                '<a href="' . route('mds.booking.pass.pdf', $booking->id) . '"  target="_blank" class="btn btn-sm" id="generateBookingPass" data-id="' .
                $booking->id .
                '" data-table="bookings_table" data-bs-toggle="tooltip" data-bs-placement="right" title="Generate Pass">' .
                '<i class="fas fa-passport text-success"></i></a>' .
                '<a href="javascript:void(0)" class="btn btn-sm" id="editBooking" data-id="' .
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
                'rsp_name' => '<div class="align-middle white-space-wrap fw-bold fs-9 ps-2">' . $booking->schedule->rsp->title . '</div>',
                'client_group' => '<div class="align-middle white-space-wrap fw-bold fs-9 ps-2">' . $booking->client?->title . '</div>',
                'booking_date' => '<div class="align-middle white-space-wrap fw-bold fs-9 ps-2">' . format_date($booking->booking_date) . '</div>',
                'booking_time' => '<div class="align-middle white-space-wrap fw-bold fs-9 ps-2">' . time_range_segment($booking->schedule_period->period, 'from') . '</div>',
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

    public function store(Request $request)
    {
        //
        dd($request);
        $user_id = Auth::user()->id;
        $venue = new DeliveryBooking();
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
                $message = 'Booking created succesfully.' . $venue->id;

                $venue->booking_ref_number = 'MDS' . $venue->id;
                $venue->schedule_id =  $timeslots->delivery_schedule_id;
                $venue->schedule_period_id = $request->schedule_period_id;
                $venue->booking_date = Carbon::createFromFormat('d/m/Y', $request->booking_date)->toDateString();
                $venue->venue_id = $request->venue_id;
                $venue->client_id = $request->client_id;
                $venue->booking_party_company_name = $request->booking_party_company_name;
                $venue->booking_party_contact_name = $request->booking_party_contact_name;
                $venue->booking_party_contact_email = $request->booking_party_contact_email;
                $venue->booking_party_contact_number = $request->booking_party_contact_number;
                $venue->delivering_party_company_name = $request->delivering_party_company_name;
                $venue->delivering_party_contact_number = $request->delivering_party_contact_number;
                $venue->delivering_party_contact_email = $request->delivering_party_contact_email;
                $venue->driver_id = $request->driver_id;
                $venue->vehicle_id = $request->vehicle_id;
                $venue->vehicle_type_id = $request->vehicle_type_id;
                $venue->receiver_name = $request->receiver_name;
                $venue->receiver_contact_number = $request->receiver_contact_number;
                $venue->dispatch_id = $request->dispatch_id;
                $venue->loading_zone_id = $request->loading_zone_id;
                $venue->cargo_id = $request->cargo_id;
                $venue->active_flag = $request->active_flag;
                $venue->created_by = $user_id;
                $venue->updated_by = $user_id;
                $venue->active_flag = 1;

                $timeslots->available_slots = $timeslots->available_slots - 1;
                $timeslots->used_slots = $timeslots->used_slots + 1;
                $timeslots->save();

                $venue->save();
            } else {
                $error = true;
                $message = 'Time slot choosing has been used please choose a different time slot.' . $venue->id;
            }
        }

        $notification = array(
            'message'       => $message,
            'alert-type'    => $error
        );

        // return redirect()->route('mds.booking.add')->with($notification);
        return view('mds.admin.booking.confirmation', ['data' => $venue]);


        // return response()->json(['error' => $error, 'message' => $message]);
    }

    public function delete($id)
    {
        // LOG::info('inside delete');
        $op = DeliveryBooking::find($id);
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
        $pdf = Pdf::loadView('mds.booking.passx', $data);
        // return $pdf->download('itsolutionstuff.pdf');
        return $pdf->stream();
    }  //taskDetailsPDF


    // *********************************************** Get Booking Note *********************************************************************
    public function getNotesView($id)
    {
        $booking = DeliveryBooking::findOrFail($id);
        $view = view('/mds/booking/mv/notes', ['booking' => $booking])->render();
        return response()->json(['view' => $view]);
    }

    // *********************************************** Save Booking Note *********************************************************************
    public function noteStore(Request $request)
    {

        LOG::info('inisde noteStore');
        Log::info($request->all());
        $validator = Validator::make($request->all(), [
            'note_text' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => 'Comment field is required',
                'user_name' => null,
                'note_text' => null,
                'note_date' => null,
                'id' => null
            ]);
        } else {

            $id = Auth::user()->id;
            $note = new DeliveryBookingNote();
            $booking = DeliveryBooking::findOrFail($request->booking_id);

            $note->note_text = $request->note_text;
            $note->user_id = $id;
            $note->booking_id = $request->booking_id;

            $note->save();

            // $details = [
            //     'subject' => 'Tracki Notification Center. Note added to Task',
            //     'greeting' => 'Hi ' . $booking->assigned_to_name . ',',
            //     'body' => 'A note was added to  "' . $booking->name . '" of project "' . $project->name . '"',
            //     'description' => $data->note_text,
            //     'actiontext' => 'Go to Tracki',
            //     'actionurl' => '/',
            //     'lastline' => 'Please check the task online for any more details',
            //     'startdate' => 'Start Date: ' . \Carbon\Carbon::parse($task->start_date)->format('d-M-Y'),
            //     'duedate' => 'Due by: ' . \Carbon\Carbon::parse($task->due_date)->format('d-M-Y'),
            // ];

            // Log::info($details);
            // if (config('tracki.send_task_assignment_emails')) {
            //     Log::info('assignment to id: ' . $task->assignment_to_id);
            //     $emails = $this->UtilController->getAssignedToEmail($task->assignment_to_id);
            //     Notification::route('mail', $emails)->notify(new AnnouncementCenter($details));
            // }

            $notification = array(
                'message'       => 'Task note added successfully',
                'alert-type'    => 'success'
            );

            return response()->json([
                'error' => false,
                'message' => 'Note added successfully to booking ' . $booking->booking_ref_number . '.',
                'user_name' => auth()->user()->username, //$data->users->username,
                'note_text' => $note->note_text,
                'note_date' => format_date($note->created_at,  'H:i:s'),
                'id' => $booking->id
            ]);
        }
        // return redirect()->back();
    } //noteStore

    public function deleteNote($id)
    {
        LOG::info('inside deleteNote');
        // dd('mainEvent');
        // $data = EventNote::find($id);
        // dd('inside deleteTaskNote: '.$id);
        DeliveryBookingNote::where('id', '=', $id)->delete();

        $notification = array(
            'message'       => 'Note deleted successfully',
            'alert-type'    => 'success'
        );

        return response()->json([
            'error' => false,
            'message' => 'Note deleted successfully',
        ]);
    } // deleteTaskNote

}
