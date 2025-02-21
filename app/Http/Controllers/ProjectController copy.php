<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

use App\Models\Event;
use App\Models\EventCategory;
use App\Models\Planner;
use App\Models\Audience;
use App\Models\Venue;
use App\Models\Location;
use App\Models\EventNote;
use App\Models\ProjectType;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\UtilController;
use Carbon\Carbon;
use App\Models\EventStatus;
use App\Models\FileUpload;
use App\Models\Color;
use App\Models\FundCategory;
use App\Exports\ProjectExport;
use App\Models\BudgetFunctionalAreaMapping;
use App\Models\FunctionalArea;
use App\Models\Operation;
use App\Models\Segment;
use Maatwebsite\Excel\Facades\Excel;


// use Barryvdh\DomPDF\Facade\Pdf;
// use App\Models\Department;
// use App\Models\Person;
// use Spatie\Permission\Models\Role;
// use Spatie\Permission\Models\Permission;
// use App\Models\Task;
// use App\Models\TaskFileUpload;
// use App\Models\SendMailController;
// use App\Models\EventAttendance;
// use App\Models\TaskStatus;
// use App\Models\MultiLine;
// use App\Models\TaskNote;
// use Illuminate\Contracts\Session\Session;
// use Illuminate\Support\Facades\Session;
// use Illuminate\Support\Facades\Crypt;
// use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Facades\Input;
// use SimpleSoftwareIO\QrCode\Facades\QrCode;
// use Illuminate\Support\Facades\Notification;
// use App\Notifications\AnnouncementCenter;
// use App\Http\Controllers\EventController;

class ProjectController extends Controller
{
    //
    public function addProject()
    {

        // $country_codes = DB::table('item_category')->orderBy('arabic_value', 'asc')->get();
        // $record_type = Crypt::decrypt($rt);
        // $record_type = Session::get('record_type');
        // Log::info('value from url: '.$record_type);

        $event_category = EventCategory::all();
        $event_planner = Planner::all();
        $event_audience = Audience::all();
        $event_venue = Venue::all();
        $event_location = Location::all();
        $event_status = EventStatus::all();
        $event_color = Color::all();
        $project_type = ProjectType::all();
        $fund_category = FundCategory::all();
        $functional_area = FunctionalArea::all();
        $segment = Segment::all();
        $operation = Operation::all();
        $budget_name = BudgetFunctionalAreaMapping::join('functional_areas', 'functional_areas.id', '=', 'budget_fa_mapping.fa_name_id')
            ->join('budget_name', 'budget_name.id', '=', 'budget_fa_mapping.budget_name_id')
            ->when(auth()->user()->functional_area_id, function ($query, $fa) {
                return $query->where('functional_areas.id', $fa);
            })->get(['budget_name.id', 'budget_name.name']);

        // dd($budget_name);

        return view('main/project/add', [
            'event_category'  => $event_category,
            'event_planner'  => $event_planner,
            'event_audience'  => $event_audience,
            'event_venue'  => $event_venue,
            'event_location'  => $event_location,
            'event_status'  => $event_status,
            'event_color'  => $event_color,
            'project_type'   => $project_type,
            'fund_category' => $fund_category,
            'functional_area' => $functional_area,
            'segment' => $segment,
            'operation' => $operation,
            'budget_name' => $budget_name,
        ]);
    }  // addProject

    public function showCard($status = null)
    {
        // dd(auth()->user()->getPermissionsViaRoles());
        // $record_type = Crypt::decrypt($rt);
        // $record_type = Session::get('record_type');
        // $record_type = Session::get('record_type');
        $active_all = 'active';
        $active_inprogress = null;
        $active_completed = null;
        $active_active = null;
        $active_unbudgeted = null;
        $archived = null;
        $user_department = auth()->user()->department_assignment_id;
        $user_fa = auth()->user()->functional_area_id;
        $fund_category = FundCategory::all();
        $functional_area = FunctionalArea::all();

        $eventData = Event::leftJoin('tasks', 'tasks.event_id', '=', 'events.id')
            ->leftJoin('event_status', 'event_status.id', '=', 'events.event_status')
            ->leftJoin('funds_category', 'funds_category.id', '=', 'events.fund_category_id')
            ->leftJoin('functional_areas', 'functional_areas.id', '=', 'events.functional_area_id')
            ->leftJoin('event_planner', 'event_planner.id', '=', 'events.planner_id')
            ->leftJoin('project_type', 'project_type.id', '=', 'events.project_type_id')
            ->when($user_department, function ($query, $user_department) {
                return $query->where('tasks.department_assignment_id', $user_department);
            })
            // ->when($user_fa, function ($query, $user_fa1) {
            //     return $query->where('events.functional_area_id', $user_fa1);
            // })
            // ->when($status, function ($query, $status) {
            //     return $query->where('events.event_status', $status);
            // })
            // ->where('record_type','=', $record_type)
            ->whereNull('archived')
            ->orderBy('events.start_date')
            ->distinct();

        if ($status == 'completed') {
            $active_all = null;
            $active_active = null;
            $active_inprogress = null;
            $active_completed = 'active';
            $active_unbudgeted = null;
            $archived = null;
            $eventData->where('events.event_status', config('tracki.project_status.completed'));
        } elseif ($status == 'inprogress') {
            $active_all = null;
            $active_active = null;
            $active_completed = null;
            $active_inprogress = 'active';
            $active_unbudgeted = null;
            $archived = null;
            $eventData->where('events.event_status', config('tracki.project_status.inprogress'));
        } elseif ($status == 'active') {
            $active_all = null;
            $active_active = 'active';
            $active_completed = null;
            $active_inprogress = null;
            $active_unbudgeted = null;
            $archived = null;
            $eventData->where('events.event_status', config('tracki.project_status.active'));
        } elseif ($status == 'unbudgeted') {
            $active_all = null;
            $active_active = null;
            $active_completed = null;
            $active_inprogress = null;
            $active_unbudgeted = 'active';
            $archived = null;
            $eventData->where('events.fund_category_id', 2);
        }

        $eventData = $eventData->get(([
            'events.id',
            'events.name',
            'event_status.name as status',
            'event_planner.name as planner',
            'events.budget_allocation',
            'events.progress',
            'events.start_date',
            'events.end_date',
            'events.project_type_id',
            'events.description',
            'events.total_sales',
            'project_type.name as project_type',
            'funds_category.name as fund_name',
            'functional_areas.name as fa_name',
        ]));

        $count = $eventData->count();
        // dd($eventData);

        $util_controller = new UtilController;
        $data_arr = [];

        // $user_department = auth()->user()->department_assignment_id;

        foreach ($eventData as $key => $record) {

            $progress = 0;
            $taskCount = DB::table('tasks')
                ->where('event_id', '=', $record->id)
                ->when($user_department, function ($query, $user_department) {
                    return $query->where('tasks.department_assignment_id', $user_department);
                })->count();

            $budget_details = $util_controller->getEventBudgetDetails($record->id);

            $sumofprogresstask = $util_controller->getSumTaskProgress($record->id);

            // dd($sumofprogresstask[0]->sum_progress);

            if ($taskCount) {
                $progress = round(($sumofprogresstask->sum_progress / $taskCount), 2);
            }

            $remaining_budget = $budget_details->eventbudget - $budget_details->task_total_budget;

            // if ($util_controller->isTasksCompleted($record->id)['status']){
            //     Log::info('project: '.$record->id. ' is '.config('tracki.project_status.completed'));
            // }

            // $data_arr_["task_count"] = $taskCount;
            $data_arr[] = [
                "id"                => $record->id,
                "name"              => $record->name,
                "status"            => $record->status,
                "planner"           => $record->planner,
                "start_date"        => $record->start_date,
                "end_date"          => $record->end_date,
                "budget_allocation" => $record->budget_allocation,
                "progress"          => $progress * 100,
                "task_count"        => $taskCount,
                "remaining_budget"  => $remaining_budget,
                "project_type"      => $record->project_type,
                "description"       => $record->desciption,
                "total_sales"       => $record->total_sales,
                "fund_name"         => $record->fund_name,
                "fa_name"           => $record->fa_name,
            ];

            // $data_arr += ["task_count"  => $taskCount];
            // array_push($data_arr,
            //    ["task_count"  => $taskCount],
            // );
        }
        //  dd($data_arr);
        return view('main.project.card', [
            'count'                 => $count,
            'functional_area'       => $functional_area,
            'eventData'             => $data_arr,
            "active_all"            => $active_all,
            "active_inprogress"     => $active_inprogress,
            "active_completed"      => $active_completed,
            "active_active"         => $active_active,
            "active_unbudgeted"     => $active_unbudgeted,
            "fund_category"         => $fund_category,
            "archived"              => $archived,
        ]);
    }  //showCard

    public function showList($status = null)
    {
        // dd(auth()->user()->getPermissionsViaRoles());
        // $record_type = Crypt::decrypt($rt);
        // $record_type = Session::get('record_type');
        // $record_type = Session::get('record_type');
        $active_all = 'active';
        $active_inprogress = null;
        $active_completed = null;
        $active_active = null;
        $active_unbudgeted = null;
        $archived = null;
        $user_department = auth()->user()->department_assignment_id;
        $user_fa = auth()->user()->functional_area_id;
        $fund_category = FundCategory::all();


        $eventData = Event::leftJoin('tasks', 'tasks.event_id', '=', 'events.id')
            ->leftJoin('event_status', 'event_status.id', '=', 'events.event_status')
            ->leftJoin('funds_category', 'funds_category.id', '=', 'events.fund_category_id')
            ->leftJoin('functional_areas', 'functional_areas.id', '=', 'events.functional_area_id')
            ->leftJoin('event_planner', 'event_planner.id', '=', 'events.planner_id')
            ->leftJoin('project_type', 'project_type.id', '=', 'events.project_type')
            ->when($user_department, function ($query, $user_department) {
                return $query->where('tasks.department_assignment_id', $user_department);
            })
            // ->when($user_fa, function ($query, $user_fa) {
            //     return $query->where('events.functional_area_id', $user_fa);
            // })
            // ->when($status, function ($query, $status) {
            //     return $query->where('events.event_status', $status);
            // })
            // ->where('record_type','=', $record_type)
            ->whereNull('archived')
            ->orderBy('events.start_date')
            ->distinct();

        if ($status == 'completed') {
            $active_all = null;
            $active_active = null;
            $active_inprogress = null;
            $active_completed = 'active';
            $active_unbudgeted = null;
            $archived = null;
            $eventData->where('events.event_status', config('tracki.project_status.completed'));
        } elseif ($status == 'inprogress') {
            $active_all = null;
            $active_active = null;
            $active_completed = null;
            $active_inprogress = 'active';
            $active_unbudgeted = null;
            $archived = null;
            $eventData->where('events.event_status', config('tracki.project_status.inprogress'));
        } elseif ($status == 'active') {
            $active_all = null;
            $active_active = 'active';
            $active_completed = null;
            $active_inprogress = null;
            $active_unbudgeted = null;
            $archived = null;
            $eventData->where('events.event_status', config('tracki.project_status.active'));
        } elseif ($status == 'unbudgeted') {
            $active_all = null;
            $active_active = null;
            $active_completed = null;
            $active_inprogress = null;
            $active_unbudgeted = 'active';
            $archived = null;
            $eventData->where('events.fund_category_id', 2);
        }

        $eventData = $eventData->get(([
            'events.id',
            'events.name',
            'event_status.name as status',
            'event_planner.name as planner',
            'events.budget_allocation',
            'events.progress',
            'events.start_date',
            'events.end_date',
            'events.project_type',
            'events.description',
            'events.total_sales',
            'project_type.name as project_type',
            'funds_category.name as fund_name',
            'functional_areas.name as fa_name',
        ]));

        $count = $eventData->count();
        // dd($eventData);

        $util_controller = new UtilController;
        $data_arr = [];

        // $user_department = auth()->user()->department_assignment_id;

        foreach ($eventData as $key => $record) {

            $progress = 0;
            $taskCount = DB::table('tasks')
                ->where('event_id', '=', $record->id)
                ->when($user_department, function ($query, $user_department) {
                    return $query->where('tasks.department_assignment_id', $user_department);
                })->count();

            $budget_details = $util_controller->getEventBudgetDetails($record->id);

            $sumofprogresstask = $util_controller->getSumTaskProgress($record->id);

            // dd($sumofprogresstask[0]->sum_progress);

            if ($taskCount) {
                $progress = round(($sumofprogresstask->sum_progress / $taskCount), 2);
            }

            $remaining_budget = $budget_details->eventbudget - $budget_details->task_total_budget;

            // if ($util_controller->isTasksCompleted($record->id)['status']){
            //     Log::info('project: '.$record->id. ' is '.config('tracki.project_status.completed'));
            // }

            // $data_arr_["task_count"] = $taskCount;
            $data_arr[] = [
                "id"                => $record->id,
                "name"              => $record->name,
                "status"            => $record->status,
                "planner"           => $record->planner,
                "start_date"        => $record->start_date,
                "end_date"          => $record->end_date,
                "budget_allocation" => $record->budget_allocation,
                "progress"          => $progress * 100,
                "task_count"        => $taskCount,
                "remaining_budget"  => $remaining_budget,
                "project_type"      => $record->project_type,
                "description"       => $record->desciption,
                "total_sales"       => $record->total_sales,
                "fund_name"         => $record->fund_name,
                "fa_name"           => $record->fa_name,
            ];

            // $data_arr += ["task_count"  => $taskCount];
            // array_push($data_arr,
            //    ["task_count"  => $taskCount],
            // );
        }
        //  dd($data_arr);
        return view('main.project.list', [
            'count' => $count,
            // 'record_type' => $record_type,
            'eventData' => $data_arr,
            "active_all"            => $active_all,
            "active_inprogress"     => $active_inprogress,
            "active_completed"      => $active_completed,
            "active_active"         => $active_active,
            "active_unbudgeted"     => $active_unbudgeted,
            "fund_category"         => $fund_category,
            "archived"              => $archived,
        ]);
    }  //showList

    public function showArchive()
    {
        // dd(auth()->user()->getPermissionsViaRoles());
        // $record_type = Crypt::decrypt($rt);
        // $record_type = Session::get('record_type');
        // $record_type = Session::get('record_type');
        $user_department = auth()->user()->department_assignment_id;

        $eventData = Event::leftJoin('tasks', 'tasks.event_id', '=', 'events.id')
            ->leftJoin('event_status', 'event_status.id', '=', 'events.event_status')
            ->leftJoin('funds_category', 'funds_category.id', '=', 'events.fund_category_id')
            ->leftJoin('event_planner', 'event_planner.id', '=', 'events.planner_id')
            ->leftJoin('project_type', 'project_type.id', '=', 'events.project_type')
            ->when($user_department, function ($query, $user_department) {
                return $query->where('tasks.department_assignment_id', $user_department);
            })
            // ->when($status, function ($query, $status) {
            //     return $query->where('events.event_status', $status);
            // })
            // ->where('record_type','=', $record_type)
            // ->whereNull('archived')
            ->where('archived', 'Y')
            ->orderBy('events.start_date')
            ->distinct();

        $eventData = $eventData->get(([
            'events.id',
            'events.name',
            'event_status.name as status',
            'event_planner.name as planner',
            'events.budget_allocation',
            'events.progress',
            'events.start_date',
            'events.end_date',
            'events.project_type',
            'events.description',
            'events.total_sales',
            'project_type.name as project_type',
            'funds_category.name as fund_name',
        ]));

        $count = $eventData->count();
        // dd($eventData);

        $util_controller = new UtilController;
        $data_arr = [];

        // $user_department = auth()->user()->department_assignment_id;

        foreach ($eventData as $key => $record) {

            $progress = 0;
            $taskCount = DB::table('tasks')
                ->where('event_id', '=', $record->id)
                ->when($user_department, function ($query, $user_department) {
                    return $query->where('tasks.department_assignment_id', $user_department);
                })->count();

            $budget_details = $util_controller->getEventBudgetDetails($record->id);

            $sumofprogresstask = $util_controller->getSumTaskProgress($record->id);

            // dd($sumofprogresstask[0]->sum_progress);

            if ($taskCount) {
                $progress = round(($sumofprogresstask->sum_progress / $taskCount), 2);
            }

            $remaining_budget = $budget_details->eventbudget - $budget_details->task_total_budget;

            // if ($util_controller->isTasksCompleted($record->id)['status']){
            //     Log::info('project: '.$record->id. ' is '.config('tracki.project_status.completed'));
            // }

            // $data_arr_["task_count"] = $taskCount;
            $data_arr[] = [
                "id"                => $record->id,
                "name"              => $record->name,
                "status"            => $record->status,
                "planner"           => $record->planner,
                "start_date"        => $record->start_date,
                "end_date"          => $record->end_date,
                "budget_allocation" => $record->budget_allocation,
                "progress"          => $progress * 100,
                "task_count"        => $taskCount,
                "remaining_budget"  => $remaining_budget,
                "project_type"      => $record->project_type,
                "description"       => $record->desciption,
                "total_sales"       => $record->total_sales,
                "fund_name"         => $record->fund_name,
            ];

            // $data_arr += ["task_count"  => $taskCount];
            // array_push($data_arr,
            //    ["task_count"  => $taskCount],
            // );
        }
        //  dd($data_arr);
        return view('main.project.archive', [
            'count' => $count,
            // 'record_type' => $record_type,
            'eventData' => $data_arr,
        ]);
    }  //showCard

    public function editProject($id)
    {
        // dd('mainEvent');
        $eventData = Event::find($id);
        $event_category = EventCategory::all();
        $event_planner = Planner::all();
        $event_audience = Audience::all();
        $event_venue = Venue::all();
        $event_location = Location::all();
        $event_status = EventStatus::all();
        $event_color = Color::all();
        $project_type = ProjectType::all();
        $fund_category = FundCategory::all();
        $functional_area = FunctionalArea::all();
        $segment = Segment::all();
        $operation = Operation::all();

        $budget_name = BudgetFunctionalAreaMapping::join('functional_areas', 'functional_areas.id', '=', 'budget_fa_mapping.fa_name_id')
            ->join('budget_name', 'budget_name.id', '=', 'budget_fa_mapping.budget_name_id')
            ->when(auth()->user()->functional_area_id, function ($query, $fa) {
                return $query->where('functional_areas.id', $fa);
            })->get(['budget_name.id', 'budget_name.name']);

        // dd($eventData->start_date);

        return view('main.project.edit', [
            'eventData'         => $eventData,
            'event_category'  => $event_category,
            'event_planner'  => $event_planner,
            'event_audience'  => $event_audience,
            'event_venue'  => $event_venue,
            'event_location'  => $event_location,
            'event_status'  => $event_status,
            'event_color'  => $event_color,
            'project_type' => $project_type,
            'fund_category' => $fund_category,
            'functional_area' => $functional_area,
            'segment' => $segment,
            'operation' => $operation,
            'budget_name' => $budget_name,
        ]);

        // dd($eventData);
        // return view('main.event.event-edit', compact('eventData'));


    } // editProject

    public function createProject(Request $request)
    {
        // dd('createEvent');
        $user_id = Auth::user()->id;
        $event = new Event;

        $event->name = $request->name;
        $event->category_id = $request->category_id;
        $event->audience_id = $request->audience_id;
        $event->planner_id = $request->planner_id;
        $event->venue_id = $request->venue_id;
        $event->location_id = $request->location_id;
        if ($request->start_date) {
            $event->start_date = Carbon::createFromFormat('d/m/Y', $request->start_date);
        }
        $event->start_time = $request->start_time;
        if ($request->end_date) {
            $event->end_date = Carbon::createFromFormat('d/m/Y', $request->end_date);
        }
        $event->end_time =  $request->end_time;
        $event->budget_allocation = $request->budget_allocation;
        $event->attendance_forcast = $request->attendance_forcast;
        $event->event_status = config('tracki.project_status.inprogress');
        $event->description = $request->description;
        $event->color_id = 14; //$request->color_id;
        $event->progress = $request->progress / 100;
        $event->project_type = $request->project_type;
        $event->total_sales = $request->project_sales;
        $event->fund_category_id = $request->fund_category_id;
        $event->functional_area_id = $request->functional_area_id;
        $event->operation_id = $request->operation_id;
        $event->segment_id = $request->segment_id;
        $event->budget_name_id = $request->budget_name_id;
        $event->org_id = 1;
        $event->created_by = $user_id;
        $event->updated_by = $user_id;

        if ($request->start_date && $request->end_date) {
            $start_date_d = Carbon::createFromFormat('d/m/Y', $request->start_date);
            $end_date_d = Carbon::createFromFormat('d/m/Y', $request->end_date);
            $duration =  $start_date_d->diffInDays($end_date_d, false);
            $event->duration = $duration;
        }



        // Log::info('start_date_d: ' . $start_date_d . ' end_date_d: ' . $end_date_d . ' duration: ' . $duration);

        // dd($duration);

        $event->save();

        $notification = array(
            'message'       => 'Event created successfully',
            'alert-type'    => 'success'
        );

        // Toastr::success('Has been add successfully :)','Success');
        return Redirect::route('main.project.show.card')->with($notification);
    } // createProject

    public function updateProject(Request $request)
    {
        // dd('createEvent');
        $user_id = Auth::user()->id;
        $event = Event::find($request->id);

        $event->name = $request->name;
        $event->category_id = $request->category_id;
        $event->audience_id = $request->audience_id;
        $event->planner_id = $request->planner_id;
        $event->venue_id = $request->venue_id;
        $event->location_id = $request->location_id;
        $event->start_date = Carbon::createFromFormat('d/m/Y', $request->start_date);
        $event->start_time = $request->start_time;
        $event->end_date = Carbon::createFromFormat('d/m/Y', $request->end_date);
        $event->end_time =  $request->end_time;
        $event->budget_allocation = $request->budget_allocation;
        $event->attendance_forcast = $request->attendance_forcast;
        $event->event_status = $request->status;
        $event->description = $request->description;
        $event->color_id = $request->color_id;
        $event->progress = $request->progress / 100;
        $event->project_type = $request->project_type;
        $event->total_sales = $request->project_sales;
        $event->fund_category_id = $request->fund_category_id;
        $event->functional_area_id = $request->functional_area_id;
        $event->operation_id = $request->operation_id;
        $event->segment_id = $request->segment_id;
        $event->budget_name_id = $request->budget_name_id;
        $event->updated_by = $user_id;

        $start_date_d = Carbon::createFromFormat('d/m/Y', $request->start_date);
        $end_date_d = Carbon::createFromFormat('d/m/Y', $request->end_date);
        $duration =  $start_date_d->diffInDays($end_date_d, false);


        Log::info('start_date_d: ' . $start_date_d . ' end_date_d: ' . $end_date_d . ' duration: ' . $duration);

        // dd($duration);
        $event->duration = $duration;

        $event->save();

        $notification = array(
            'message'       => 'Event updated successfully',
            'alert-type'    => 'success'
        );

        // Toastr::success('Has been add successfully :)','Success');
        return Redirect::route('main.project.show.card')->with($notification);
    } // updateProject


    public function deleteProject($id)
    {
        // dd('mainEvent');
        Event::where('id', '=', $id)->update(['archived' => 'Y']);
        // Event::where('event_id', '=', $id)->delete();

        $notification = array(
            'message'       => 'Project deleted successfully',
            'alert-type'    => 'success'
        );

        // Toastr::success('Has been add successfully :)','Success');
        return Redirect::route('main.project.show.card')->with($notification);
    } // deleteProject

    public function restoreProject($id)
    {
        // dd('mainEvent');
        Event::where('id', '=', $id)->update(['archived' => null]);
        // Event::where('event_id', '=', $id)->delete();

        $notification = array(
            'message'       => 'Project restored successfully',
            'alert-type'    => 'success'
        );

        // Toastr::success('Has been add successfully :)','Success');
        return Redirect::route('main.project.show.card')->with($notification);
    } // restoreProject

    //****************************File Methods */
    public function fileStore(Request $request)
    {

        $id = Auth::user()->id;
        $data = new FileUpload;

        if ($request->file('file_name')) {
            $file = $request->file('file_name');
            $filename = rand() . date('ymdHis') . $file->getClientOriginalName();
            $file->move(public_path('upload/event_files'), $filename);
            $data->file_name = $filename;
            $data->original_file_name = $file->getClientOriginalName();
            $data->file_extension = $file->getClientOriginalExtension();
            $data->file_size = $_FILES['file_name']['size'];; //$request->file('file_name')->getSize();
            $data->user_id = $id;
            $data->event_id = $request->event_id;
        }

        $data->save();

        $notification = array(
            'message'       => 'File added successfully',
            'alert-type'    => 'success'
        );
    }  //fileStore

    public function fileDelete($id)
    {
        // dd('mainEvent');
        $fileDetails = FileUpload::find($id);

        Log::info('file to delete: ' . 'upload/event_files/' . $fileDetails->file_name);

        // $url = \File::allFiles(public_path('upload/event_files/'.$fileDetails->file_name));
        // dd($url);

        if (File::exists(public_path('upload/event_files/' . $fileDetails->file_name))) {
            File::delete(public_path('upload/event_files/' . $fileDetails->file_name));
        }

        FileUpload::where('id', '=', $id)->delete();

        $notification = array(
            'message'       => 'File deleted successfully',
            'alert-type'    => 'success'
        );

        // Toastr::success('Has been add successfully :)','Success');
        // return Redirect::route('main.task.list', $task->event_id)->with($notification);
        return redirect()->back()->with($notification);
    } // fileDelete

    // *********************************************** Save Event Note *********************************************************************

    public function noteStore(Request $request)
    {

        $id = Auth::user()->id;
        $data = new EventNote;

        $data->note_text = $request->note_text;
        $data->user_id = $id;
        $data->event_id = $request->event_id;

        $data->save();

        $notification = array(
            'message'       => 'Event note added successfully',
            'alert-type'    => 'success'
        );

        return redirect()->back();
    }

    // *********************************************** Delete Event Note *********************************************************************
    public function deleteEventNote($id)
    {
        // dd('mainEvent');
        // $data = EventNote::find($id);
        EventNote::where('id', '=', $id)->delete();

        $notification = array(
            'message'       => 'Note deleted successfully',
            'alert-type'    => 'success'
        );

        // Toastr::success('Has been add successfully :)','Success');
        return redirect()->back();
        // return Redirect::route('main.task.list', $task->event_id)->with($notification);
    } // deleteEventNote

    // *********************************************** Export projects into excel *********************************************************************
    public function ExportNowProjects()
    {

        return Excel::download(new ProjectExport, 'pd_projects.xlsx');
    } // ExportNowProjects
}
