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
use App\Models\BudgetName;
use App\Models\Client;
use App\Models\Employee;
use App\Models\FunctionalArea;
use App\Models\Operation;
use App\Models\Segment;
use App\Models\Tag;
use App\Models\User;
use App\Models\Workspace;
use Maatwebsite\Excel\Facades\Excel;


class ProjectController extends Controller
{
    //

    public function getProjectOv($id)
    {
        $project = Event::findOrFail($id);
        $project_user = $project->users;

        return response()->json(['data' => $project, 'project_user' => $project_user,]);
    }

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
        $budget_name = BudgetName::all();
        // $budget_name = BudgetFunctionalAreaMapping::join('workspaces', 'workspaces.id', '=', 'budget_fa_mapping.fa_name_id')
        //     ->join('budget_name', 'budget_name.id', '=', 'budget_fa_mapping.budget_name_id')
        //     ->when(auth()->user()->workspace_id, function ($query, $fa) {
        //         return $query->where('workspaces.id', $fa);
        //     })->get(['budget_name.id', 'budget_name.name']);

        // dd($budget_name);

        return view('tracki/project/add', [
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

    public function getProjectCards($id)
    {

        // {
            // dd(auth()->user()->getPermissionsViaRoles());
            // $record_type = Crypt::decrypt($rt);
            // $record_type = Session::get('record_type');
            // $record_type = Session::get('record_type');

            $ws_dropdown = null;
            $where = [];

            $employee = Employee::findOrFail($id);

            $eventData = $employee->projects();

            // dd($eventData);

            // if ($id > 0){
            //     $eventData = Event::where('id', $id)->whereNull('archived')
            //     ->orderBy('events.start_date');
            // } else {
            //     $eventData = Event::whereNull('archived')
            //     ->orderBy('events.start_date');
            // }

            $active_all = 'active';
            $active_inprogress = null;
            $active_completed = null;
            $active_active = null;
            $active_unbudgeted = null;
            $archived = null;
            $user_department = auth()->user()->department_assignment_id;
            $workspace = session()->get('workspace_id');

            $workspaces = Workspace::all();
            $event_category = EventCategory::all();
            $clients = Client::all();
            $event_audience = Audience::all();
            $event_venue = Venue::all();
            $event_location = Location::all();
            $project_type = ProjectType::all();
            $fund_category = FundCategory::all();
            $budget_name = BudgetName::all();
            $tags = Tag::all();
            $users = User::all();

            // dd($users);
            // $eventData = Event::whereNull('archived')
            //     ->orderBy('events.start_date');
            // ->when($workspace, function ($query, $workspace) {
            //     return $query->where('events.workspace_id', $workspace);
            // });


            $eventData = $eventData->where($where);

            $eventData = $eventData->get();
            $count = $eventData->count();

            $util_controller = new UtilController;
            $data_arr = [];

            // $user_department = auth()->user()->department_assignment_id;

            // dd($users);
            $view =  view('tracki.project.vw.cards', [
                // 'count'                 => $count,
                // 'functional_area'       => $functional_area,
                'eventData'             => $eventData,
                "active_all"            => $active_all,
                "active_inprogress"     => $active_inprogress,
                "active_completed"      => $active_completed,
                "active_active"         => $active_active,
                "active_unbudgeted"     => $active_unbudgeted,
                "project_type"          => $project_type,
                "event_category"        => $event_category,
                "clients"               => $clients,
                "event_audience"        => $event_audience,
                "event_venue"           => $event_venue,
                "event_location"        => $event_location,
                "fund_category"         => $fund_category,
                "budget_name"           => $budget_name,
                "tags"                  => $tags,
                "users"                 => $users,
                "workspaces"            => $workspaces,
                'ws_dropdown'           => $ws_dropdown,
                // "archived"              => $archived,
            ])->render();
        // }  //showCard

        // $task = Task::findOrFail($id);
        // $view = view('/tracki/task/notes', ['task' => $task])->render();
        return response()->json(['view' => $view]);
    }


    public function test($status = null)
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
        $workspace = session()->get('workspace_id');

        $event_category = EventCategory::all();
        $clients = Client::all();
        $event_audience = Audience::all();
        $event_venue = Venue::all();
        $event_location = Location::all();
        $project_type = ProjectType::all();
        $fund_category = FundCategory::all();
        $budget_name = BudgetName::all();
        $tags = Tag::all();

        // dd($clients);
        $eventData = Event::whereNull('archived')
            ->orderBy('events.start_date');
        // ->when($workspace, function ($query, $workspace) {
        //     return $query->where('events.workspace_id', $workspace);
        // });

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

        $eventData = $eventData->get();
        $count = $eventData->count();

        $util_controller = new UtilController;
        $data_arr = [];

        // $user_department = auth()->user()->department_assignment_id;

        return view('tracki.users.create-new', [
            // 'count'                 => $count,
            // 'functional_area'       => $functional_area,
            'eventData'             => $eventData,
            "active_all"            => $active_all,
            "active_inprogress"     => $active_inprogress,
            "active_completed"      => $active_completed,
            "active_active"         => $active_active,
            "active_unbudgeted"     => $active_unbudgeted,
            "project_type"          => $project_type,
            "event_category"        => $event_category,
            "clients"               => $clients,
            "event_audience"        => $event_audience,
            "event_venue"           => $event_venue,
            "event_location"        => $event_location,
            "fund_category"         => $fund_category,
            "budget_name"           => $budget_name,
            "tags"                  => $tags,
            // "fund_category"         => $fund_category,
            // "archived"              => $archived,
        ]);
    }  //test

    public function showCard($status = null)
    {
        // dd(auth()->user()->getPermissionsViaRoles());
        // $record_type = Crypt::decrypt($rt);
        // $record_type = Session::get('record_type');
        // $record_type = Session::get('record_type');



        $ws_dropdown = null;
        $where = [];
        if (request()->ws) {
            //    dd(request()->ws);
            $ws_dropdown = Workspace::findOrFail(request()->ws)->title;

            $where['events.workspace_id'] = request()->ws;
        }

        $venue_dropdown = null;
        if (request()->venue) {
            //    dd(request()->ws);
            $venue_dropdown = Venue::findOrFail(request()->venue)->name;
            $where['events.venue_id'] = request()->venue;
        }


        $active_all = 'active';
        $active_inprogress = null;
        $active_completed = null;
        $active_active = null;
        $active_unbudgeted = null;
        $archived = null;
        $user_department = auth()->user()->department_assignment_id;
        $workspace = session()->get('workspace_id');

        $workspaces = Workspace::all();
        $event_category = EventCategory::all();
        $clients = Client::all();
        $event_audience = Audience::all();
        $event_venue = Venue::all();
        $event_location = Location::all();
        $project_type = ProjectType::all();
        $fund_category = FundCategory::all();
        $budget_name = BudgetName::all();
        $tags = Tag::all();
        $users = User::all();
        $employees = Employee::all();

        // dd($users);
        $eventData = Event::whereNull('archived')
            ->orderBy('events.start_date');
        // ->when($workspace, function ($query, $workspace) {
        //     return $query->where('events.workspace_id', $workspace);
        // });
        // $eventData = Event::findOrFail(11)->orderBy('events.start_date');


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

        $eventData = $eventData->where($where);

        $eventData = $eventData->get();

        // dd($eventData);

        $count = $eventData->count();

        $util_controller = new UtilController;
        $data_arr = [];

        // $user_department = auth()->user()->department_assignment_id;

        // dd($users);
        return view('tracki.project.card', [
            // 'count'                 => $count,
            // 'functional_area'       => $functional_area,
            'eventData'             => $eventData,
            "active_all"            => $active_all,
            "active_inprogress"     => $active_inprogress,
            "active_completed"      => $active_completed,
            "active_active"         => $active_active,
            "active_unbudgeted"     => $active_unbudgeted,
            "project_type"          => $project_type,
            "event_category"        => $event_category,
            "clients"               => $clients,
            "event_audience"        => $event_audience,
            "event_venue"           => $event_venue,
            "event_location"        => $event_location,
            "fund_category"         => $fund_category,
            "budget_name"           => $budget_name,
            "tags"                  => $tags,
            "users"                 => $users,
            "workspaces"            => $workspaces,
            'ws_dropdown'           => $ws_dropdown,
            'venue_dropdown'        => $venue_dropdown,
            'employees'        => $employees,
            // "archived"              => $archived,
        ]);
    }  //showCard

    public function showList()
    {

        $project = Event::whereNull('archived');
        $count = $project->count();

        $event_category = EventCategory::all();
        $event_planner = Planner::all();
        $event_audience = Audience::all();
        $event_venue = Venue::all();
        $event_location = Location::all();
        $project_type = ProjectType::all();
        $fund_category = FundCategory::all();
        $budget_name = BudgetName::all();
        $employees = Employee::all();
        $users = User::all();
        $tags = Tag::all();
        $clients = Client::all();

        return view('tracki.project.list', [
            'project_count'     => $count,
            "project_type"      => $project_type,
            "event_category"    => $event_category,
            "event_planner"     => $event_planner,
            "event_audience"    => $event_audience,
            "event_venue"       => $event_venue,
            "event_location"    => $event_location,
            "fund_category"     => $fund_category,
            "budget_name"       => $budget_name,
            "users"             => $users,
            "employees"         => $employees,
            "tags"              => $tags,
            "clients"           => $clients,
        ]);
    }



    public function getProjectData($status = null, $project_id = null)
    {

        // $user_department = auth()->user()->department_assignment_id;

        $workspace = session()->get('workspace_id');

        $search = request('search');
        $sort = (request('sort')) ? request('sort') : "id";
        $order = (request('order')) ? request('order') : "DESC";
        // $sort = (request('sort')) ? request('sort') : "id";
        // $order = (request('order')) ? request('order') : "DESC";
        $status_id = (request('status')) ? request('status') : "";

        Log::alert(request()->all());
        // Log::alert('getProjectData project_id: ' . $project_id);
        Log::alert('getProjectData status_id: ' . $status_id);
        // Log::alert('getProjectData person_id: ' . $person_id);
        // Log::alert('getProjectData department_id: ' . $department_id);

        $where = [];

        $projects = Event::whereNull('archived')
            ->when($workspace, function ($query, $workspace) {
                return $query->where('events.workspace_id', $workspace);
            });


        if ($search) {
            $projects = $projects->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        }


        $projects = $projects->where($where)->orderBy($sort, $order);

        // return Datatables::of($projects)->make(true);

        $total = $projects->count();

        $projects = $projects->orderBy($sort, $order)->paginate(request('limit'))->through(function ($project) {


            $mytime = Carbon::now();

            $due_date_text_color = 'primary';
            if ($project->end_date < $mytime && $project->status->title != 'Completed') {
                $due_date_text_color = 'danger';
            } elseif ($project->status->title == 'Completed') {
                $due_date_text_color = 'success';
            }

            return [
                'id' => $project->id,
                'id1' => '<div class="ms-3">'.$project->id.'</div>',
                'name' => '<div class="align-middle white-space-wrap fw-bold fs-8"><a href="/tracki/task/' . $project->id . '/list">' . $project->name . '</a></div>',
                // 'project_name' => $project->project->name,
                // 'workspace_id' => '<span class="badge badge-phoenix fs-10 badge-phoenix-secondary"><span class="badge-label">Primary</span><span class="ms-1" data-feather="package" style="height:12.8px;width:12.8px;"></span></span>',
                'workspace_id' => '<span class="badge badge-phoenix fs--2 badge-phoenix-warning">' . $project->workspaces?->title . '</span>',
                'start_date' => format_date($project->start_date,  'H:i:s'),
                'end_date' => '<span class="text-' . $due_date_text_color . '">' .  format_date($project->end_date,  'H:i:s') . '</spanc>',
                'budget' => $project->budget_allocation,
                'members' => $project->employees,
                'attributes' => (($project->notes->count()) ? '<button class="btn p-0 text-body-tertiary fs-10 me-2"><span class="fas fa-sticky-note me-1"></span>' . $project->notes->count() . '</button>' : "") .
                    (($project->files->count()) ? '<button class="btn p-0 text-body-tertiary fs-10 me-2"><span class="fas fa-paperclip me-1"></span>' . $project->files->count() . '</button>' : ""),
                // 'attributes' => '<div class="ms-3 text-secondary">'.(($project->files->count()) ? '<span class="fas fa-file-alt me-1"></span>':"").' '.(($project->notes->count()) ? '<span class="fas fa-clipboard me-1"></span>':"").'</div>',
                'status' => '<span class="badge badge-phoenix fs--2 badge-phoenix-' . $project->status->color . ' "><span class="badge-label" data-bs-toggle="modal" data-bs-target="#projectStatusModal" id="editprojectStatus" data-id="' . $project->id . '" data-table="project_table">' . $project->status->title . '</span><span class="ms-1" data-feather="x" style="height:12.8px;width:12.8px;"></span></span>',
                'description' => $project->description,
                // 'description' => '<button class="btn btn-secondary m-1" type="button" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="Top Popover">Top Popover</button>',
                'created_at' => format_date($project->created_at,  'H:i:s'),
                'updated_at' => format_date($project->updated_at, 'H:i:s'),

            ];
        });

        foreach ($projects->items() as $project => $collection) {
            foreach ($collection['members'] as $i => $member) {
                $words = explode(" ", $member->full_name);
                $acronym = "";

                foreach ($words as $w) {
                    $acronym .= mb_substr($w, 0, 1);
                }
                $collection['members'][$i] = '<a href="/tracki/employee/profile/' . $member->id . '" target="_blank" role="button" title="' . $member->full_name . '">
                    <div class="avatar avatar-s me-2 pull-up">
                      <div class="avatar-name rounded-circle me-2"><span>' . $acronym . '</span></div>
                    </div>
                  </a>';
            };
        }
        // dd($taskData->items());

        return response()->json([
            "rows" => $projects->items(),
            "total" => $total,
        ]);
    } //allTaskDt

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
            ->leftJoin('project_type', 'project_type.id', '=', 'events.project_type_id')
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
            'events.project_type_id',
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
                "project_type"      => $record->project_type_id,
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
        return view('tracki.project.archive', [
            'count' => $count,
            // 'record_type' => $record_type,
            'eventData' => $data_arr,
        ]);
    }  //showCard

    public function editProject($id, $source)
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

        return view('tracki.project.edit', [
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
            'source' => $source,
        ]);

        // dd($eventData);
        // return view('tracki.event.event-edit', compact('eventData'));


    } // editProject

    public function getWsUsers()
    {

        $ws_id = session()->get('workspace_id');
        $workspace = Workspace::findOrFail($ws_id);
        $ws_users = $workspace?->users;

        return response()->json(['wsusers' => $ws_users]);
    }

    public function getProject($id)
    {
        $project = Event::findOrFail($id);


        $ws_id = session()->get('workspace_id') ? session()->get('workspace_id') : $project->workspace_id;
        $workspace = Workspace::findOrFail($ws_id);
        $ws_users = $workspace?->employees;
        $project = Event::findOrFail($id);

        return response()->json(['project' => $project, 'tag' => $project->tags, 'assigned_to' => $project->employees, 'wsusers' => $ws_users]);
    } // getTask

    public function createProject(Request $request)
    {
        // dd('createEvent');
        $user_id = Auth::user()->id;
        $event = new Event;

        $workspace = session()->get('workspace_id');

        Log::info('workspace: ' . $workspace);

        $event->name = $request->name;
        $event->category_id = $request->category_id;
        $event->audience_id = $request->audience_id;
        $event->client_id = $request->client_id;
        $event->venue_id = $request->venue_id;
        $event->location_id = $request->location_id;
        if ($request->start_date) {
            $event->start_date = Carbon::createFromFormat('d/m/Y', $request->start_date);
        }
        if ($request->end_date) {
            $event->end_date = Carbon::createFromFormat('d/m/Y', $request->end_date);
        }
        $event->budget_allocation = $request->budget_allocation;
        $event->attendance_forcast = $request->attendance_forcast;
        $event->event_status = config('tracki.project_status.inprogress');
        $event->description = $request->description;
        $event->color_id = 14; //$request->color_id;
        $event->progress = $request->progress / 100;
        $event->project_type_id = $request->project_type_id;
        $event->total_sales = $request->project_sales;
        $event->fund_category_id = $request->fund_category_id;
        $event->budget_name_id = $request->budget_name_id;
        $event->workspace_id = session()->get('workspace_id'); //$request->workspace_id;
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

        // $task->users()->detach();
        $event->clients()->attach($request->client_id);

        foreach ($request->tag_id as $key => $data) {

            $event->tags()->attach($request->tag_id[$key]);
        }

        foreach ($request->assignment_to_id as $key => $data) {

            $event->employees()->attach($request->assignment_to_id[$key]);
        }

        $notification = array(
            'message'       => 'Event created successfully',
            'alert-type'    => 'success'
        );

        return response()->json([
            'error' => false,
            'message' => 'Project ' . $event->name . ' created successfully ',
        ]);
        // Toastr::success('Has been add successfully :)','Success');
        // return Redirect::route('tracki.project.show.card')->with($notification);
    } // createProject

    public function updateProject(Request $request)
    {
        // dd('createEvent');
        $user_id = Auth::user()->id;
        $event = Event::find($request->id);

        $event->name = $request->name;
        $event->category_id = $request->category_id;
        $event->audience_id = $request->audience_id;
        $event->client_id = $request->client_id;
        $event->venue_id = $request->venue_id;
        $event->location_id = $request->location_id;
        $event->start_date = Carbon::createFromFormat('d/m/Y', $request->start_date);
        $event->end_date = Carbon::createFromFormat('d/m/Y', $request->end_date);
        $event->budget_allocation = $request->budget_allocation;
        $event->attendance_forcast = $request->attendance_forcast;
        $event->description = $request->description;
        $event->color_id = $request->color_id;
        $event->progress = $request->progress / 100;
        $event->project_type_id = $request->project_type_id;
        $event->total_sales = $request->project_sales;
        $event->fund_category_id = $request->fund_category_id;
        $event->budget_name_id = $request->budget_name_id;
        // $event->workspace_id = $request->workspace_id;
        $event->updated_by = $user_id;

        $start_date_d = Carbon::createFromFormat('d/m/Y', $request->start_date);
        $end_date_d = Carbon::createFromFormat('d/m/Y', $request->end_date);
        $duration =  $start_date_d->diffInDays($end_date_d, false);


        Log::info('start_date_d: ' . $start_date_d . ' end_date_d: ' . $end_date_d . ' duration: ' . $duration);

        // dd($duration);
        $event->duration = $duration;

        $event->save();

        if ($request->tag_id) {
            $event->tags()->detach();
            foreach ($request->tag_id as $key => $data) {
                $event->tags()->attach($request->tag_id[$key]);
            }
        }

        if ($request->client_id) {
            $event->clients()->detach();
            $event->clients()->attach($request->client_id);
        }

        $event->employees()->detach();
        $event->employees()->attach($request->assignment_to_id);


        $notification = array(
            'message'       => 'Event updated successfully',
            'alert-type'    => 'success'
        );

        return response()->json([
            'error' => false,
            'message' => 'Project ' . $event->name . ' updated successfully ',
        ]);

        // // Toastr::success('Has been add successfully :)','Success');
        // if ($request->source == 'plist') {
        //     return Redirect::route('tracki.task.list', $request->id)->with($notification);
        // } else {
        //     return Redirect::route('tracki.project.show.card')->with($notification);
        // }
    } // updateProject


    public function deleteProject($id)
    {
        // dd('mainEvent');
        $project = Event::find($id);
        Event::where('id', '=', $id)->update(['archived' => 'Y']);
        // Event::where('event_id', '=', $id)->delete();

        $notification = array(
            'message'       => 'Project deleted successfully',
            'alert-type'    => 'success'
        );

        // Toastr::success('Has been add successfully :)','Success');
        return Redirect::route('tracki.project.show.card')->with($notification);
        // return response()->json([
        //     'error' => false,
        //     'message' => 'Project ' . $project->name . ' deleted successfully ',
        // ]);
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
        return Redirect::route('tracki.project.show.card')->with($notification);
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
        // return Redirect::route('tracki.task.list', $task->event_id)->with($notification);
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
        // return Redirect::route('tracki.task.list', $task->event_id)->with($notification);
    } // deleteEventNote

    // *********************************************** Export projects into excel *********************************************************************
    public function ExportNowProjects()
    {

        return Excel::download(new ProjectExport, 'pd_projects.xlsx');
    } // ExportNowProjects
}
