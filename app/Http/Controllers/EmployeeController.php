<?php

namespace App\Http\Controllers;

use App\Models\AddressType;
use App\Models\Atest;
use App\Models\Audience;
use App\Models\BudgetName;
use App\Models\Client;
use App\Models\Country;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\EmployeeFile;
use App\Models\EmployeeType;
use App\Models\EventCategory;
use App\Models\Gender;
use App\Models\Language;
use App\Models\Location;
use App\Models\MaritalStatus;
use App\Models\Nationality;
use App\Models\ProjectType;
use App\Models\Relationship;
use App\Models\Salutation;
use App\Models\Status;
use App\Models\Tag;
use App\Models\Venue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Route as FacadesRoute;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $emps = Employee::all();
        $countries = Country::all();
        $nationalities = Nationality::all();
        $employee_types = EmployeeType::all();
        $salutations = Salutation::all();
        $genders = Gender::all();
        $marital_statuses = MaritalStatus::all();
        $departments = Department::all();
        $designations = Designation::all();
        $relationships = Relationship::all();
        $address_types = AddressType::all();

        return view('tracki.employee.list', compact(
            'emps',
            'countries',
            'nationalities',
            'employee_types',
            'salutations',
            'genders',
            'marital_statuses',
            'departments',
            'designations',
            'relationships',
            'address_types',
        ));
    }

    public function getProjectData($id = null)
    {

        // $user_department = auth()->user()->department_assignment_id;

        $workspace = session()->get('workspace_id');
        $employee = Employee::findOrFail($id);
        $projects = $employee->projects();

        $search = request('search');
        $sort = (request('sort')) ? request('sort') : "id";
        $order = (request('order')) ? request('order') : "DESC";
        // $sort = (request('sort')) ? request('sort') : "id";
        // $order = (request('order')) ? request('order') : "DESC";
        $status_id = (request('status')) ? request('status') : "";

        // Log::alert(request()->all());
        // Log::alert('getProjectData project_id: ' . $project_id);
        // Log::alert('getProjectData status_id: ' . $status_id);
        // Log::alert('getProjectData person_id: ' . $person_id);
        // Log::alert('getProjectData department_id: ' . $department_id);

        $where = [];

        // $projects = $projects::whereNull('archived')
        //     ->when($workspace, function ($query, $workspace) {
        //         return $query->where('events.workspace_id', $workspace);
        //     });

        if ($search) {
            $projects = $projects->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        }

        $projects = $projects->where($where)->orderBy($sort, $order);
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
                'id1' => '<div class="ms-3">' . $project->id . '</div>',
                'name' => '<div class="align-middle white-space-wrap fs-9"><a href="/tracki/task/' . $project->id . '/list" class="fw-bold text-body-emphasis">' . $project->name . '</a></div>',
                'workspace_id' => '<span class="badge badge-phoenix fs--2 badge-phoenix-warning">' . $project->workspaces?->title . '</span>',
                'start_date' => format_date($project->start_date,  'H:i:s'),
                'end_date' => '<span class="text-' . $due_date_text_color . '">' .  format_date($project->end_date,  'H:i:s') . '</spanc>',
                'budget' => $project->budget_allocation,
                'members' => $project->employees,
                'attributes' => (($project->notes->count()) ? '<button class="btn p-0 text-body-tertiary fs-10 me-2"><span class="fas fa-sticky-note me-1"></span>' . $project->notes->count() . '</button>' : "") .
                    (($project->files->count()) ? '<button class="btn p-0 text-body-tertiary fs-10 me-2"><span class="fas fa-paperclip me-1"></span>' . $project->files->count() . '</button>' : ""),
                'status' => '<span class="badge badge-phoenix fs--2 badge-phoenix-' . $project->status->color . ' "><span class="badge-label" data-bs-toggle="modal" data-bs-target="#projectStatusModal" id="editprojectStatus" data-id="' . $project->id . '" data-table="project_table">' . $project->status->title . '</span><span class="ms-1" data-feather="x" style="height:12.8px;width:12.8px;"></span></span>',
                'description' => $project->description,
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

        return response()->json([
            "rows" => $projects->items(),
            "total" => $total,
        ]);
    } //allTaskDt


    public function getTaskData($id = null)
    {
        $workspace = session()->get('workspace_id');

        $employee = Employee::findOrFail($id);
        $tasks = $employee->tasks();

        // if ($id) {
        //     $id = explode('_', $id);
        //     $showpage_id = $id[1];
        //     $showpage = $id[0];

        //     Log::alert('TaskController::allTaskDt');
        //     Log::alert('parameter showpage_id id: ' . $showpage_id);
        //     Log::alert('parameter showpage: ' . $showpage);


        //     if ($showpage == 'user') {

        //         $user = User::findOrFail($showpage_id);
        //         $tasks = $user->tasks();

        //         // dd($tasks);

        //         $tasks = $tasks->when($workspace, function ($query, $workspace) {
        //             return $query->where('tasks.workspace_id', $workspace);
        //         });
        //     } elseif ($showpage == 'list') {

        //         $event = Event::findOrFail($showpage_id);
        //         $tasks = $event->tasks();

        //         $tasks = $tasks->when($workspace, function ($query, $workspace) {
        //             return $query->where('tasks.workspace_id', $workspace);
        //         });
        //     }
        // } else {
        //     $tasks = Task::when($workspace, function ($query, $workspace) {
        //         return $query->where('tasks.workspace_id', $workspace);
        //     })->when($id, function ($query, $project_id) {
        //         return $query->where('tasks.event_id', $project_id);
        //     });
        // }


        // $task = Task::find(13);

        // dd($task->files->count());

        $user_department = auth()->user()->department_assignment_id;

        $search = request()->search;
        // $search = $request->input('search');
        $sort = (request()->sort) ? request()->sort : "id";
        $order = (request()->order) ? request()->order : "DESC";

        $project_id = (request()->project_id) ? request()->project_id : "";

        $status_id = (request()->status) ? request()->status : "";
        $person_id = (request()->person_id) ? request()->person_id : "";
        $department_id = (request()->department_id) ? request()->department_id : "";

        // Log::alert($request->all());
        // Log::info(request());
        // Log::info('request get: '.$request->get('project_id'));
        // Log::info('request(): '.request('project_id'));
        Log::alert('allTaskDt search: ' . $search);
        Log::alert('allTaskDt project_id: ' . $project_id);
        Log::alert('allTaskDt status_id: ' . $status_id);
        Log::alert('allTaskDt person_id: ' . $person_id);
        Log::alert('allTaskDt department_id: ' . $department_id);

        $where = [];
        // $tasks = Task::when($user_department, function ($query, $user_department) {
        //     return $query->where('tasks.department_assignment_id', $user_department);
        // })
        //     ->when(auth()->user()->functional_area_id, function ($query, $user_fa) {
        //         return $query->where('events.functional_area_id', $user_fa);
        //     });
        // ->first();

        // Log::info('route name:'.Route::current()->getName());
        // $user = User::find(4);
        // $tasks = $user->tasks();

        Log::info('workspace: ' . $workspace);
        Log::info('project_id1: ' . $project_id);

        // $tasks = Task::when($workspace, function ($query, $workspace) {
        //     return $query->where('tasks.workspace_id', $workspace);
        // })->when($id, function ($query, $project_id){
        //     return $query->where('tasks.event_id', $project_id);
        // });

        // $tasks = Task::all();
        $statuses = Status::all();

        // if ($user_id != '') {
        //     $where['assigned'] = $project_id;
        // }

        // $tasks = $tasks->where($where);

        // return Datatables::of($tasks)->make(true);

        $total = $tasks->count();

        $tasks = $tasks->orderBy($sort, $order)->paginate(request('limit'))->through(function ($task) use ($statuses) {

            $mytime = Carbon::now();

            $due_date_text_color = 'primary';
            if ($task->due_date < $mytime && $task->status->title != 'Completed') {
                $due_date_text_color = 'danger';
            } elseif ($task->status->title == 'Completed') {
                $due_date_text_color = 'success';
            }

            $statusOptions = '';
            foreach ($statuses as $status) {
                // $disabled = canSetStatus($status)  ? '' : 'disabled';
                $selected = $task->status_id == $status->id ? 'selected' : '';
                $statusOptions .= '<option value="' . $status->id . '" ' . $selected . '>' . $status->title . '</option>';
            }

            $icons = (($task->notes->count()) ? '<button class="btn p-0 text-body-tertiary fs-10 me-2"><span class="fas fa-sticky-note me-1"></span>' . $task->notes->count() . '</button>' : "") .
            (($task->files->count()) ? '<button class="btn p-0 text-body-tertiary fs-10 me-2"><span class="fas fa-paperclip me-1"></span>' . $task->files->count() . '</button>' : "").
            (($task->subtask->count()) ? '<button class="btn p-0 text-body-tertiary fs-10 me-2"><span class="fas fas fa-network-wired me-1"></span>' . $task->subtask->count() . '</button>' : "");

            return [
                'id1' => '<div class="ms-3">'.$task->id.'</div>',
                'id' => $task->id,
                'event_id' => '<div class="d-flex align-items-center"><div><a class="fw-bold mb-0 line-clamp-2 text-body-emphasis" href="/tracki/task/' . $task->event_id . '/list">' . $task->project?->name . '</a>',
                'name' => '<a class="fw-bold mb-0 line-clamp-2 text-body-emphasis" id="taskCardView" href="javascript:void(0);"  data-id="' . $task->id . '" data-table="task_table">' . $task->name . '</a><div class="d-flex align-items-center">'.
                '<p class="mb-0 text-body-highlight fw-semibold fs-10 me-2">'.$icons.'</p></div></div></div>',
                'workspace_id' =>   $task->workspaces?->title,
                'department_assignment_id' => $task->department->name,
                'assigned_by' => $task->assigned_by?->name,
                'assigned_to' => $task->employees,
                'start_date' =>  format_date($task->start_date,  'H:i:s'),
                'end_date' =>  '<span class="text-' . $due_date_text_color . '">' .  format_date($task->due_date,  'H:i:s') . '</spanc>',
                'budget' => $task->budget_allocation,
                'budget_consumed' => $task->actual_budget_allocated,
                'attributes' => (($task->notes->count()) ? '<button class="btn p-0 text-body-tertiary fs-10 me-2"><span class="fas fa-sticky-note me-1"></span>' . $task->notes->count() . '</button>' : "") .
                                (($task->files->count()) ? '<button class="btn p-0 text-body-tertiary fs-10 me-2"><span class="fas fa-paperclip me-1"></span>' . $task->files->count() . '</button>' : "").
                                (($task->subtask->count()) ? '<button class="btn p-0 text-body-tertiary fs-10 me-2"><span class="fas fas fa-network-wired me-1"></span>' . $task->subtask->count() . '</button>' : ""),
                // 'attributes' => '<div class="ms-3 text-secondary">'.(($task->files->count()) ? '<span class="fas fa-file-alt me-1"></span>':"").' '.(($task->notes->count()) ? '<span class="fas fa-clipboard me-1"></span>':"").'</div>',
                // 'status' => '<select  class="form-select select2-with-image" id="statusSelect'.$task->id.'" data-id="'.$task->id.'" data-original-status-id="'.$task->status->id.'" data-type="task">'.$statusOptions.'</select>',
                'status' => '<span class="badge badge-phoenix fs--2 badge-phoenix-' . $task->status->color . ' " style="cursor: pointer;" id="editTaskStatus" data-id="' . $task->id . '" data-table="task_table"><span class="badge-label">' . $task->status->title . '</span><span class="ms-1 uil-edit-alt" style="height:12.8px;width:12.8px;cursor: pointer;"></span></span>',
                'description' => $task->description,
                // 'description' => '<button class="btn btn-secondary m-1" type="button" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="Top Popover">Top Popover</button>',
                'created_at' => format_date($task->created_at,  'H:i:s'),
                'updated_at' => format_date($task->updated_at, 'H:i:s'),

            ];
        });


        foreach ($tasks->items() as $task => $collection) {
            foreach ($collection['assigned_to'] as $i => $emp) {
                $words = explode(" ", $emp->full_name);
                $acronym = "";

                foreach ($words as $w) {
                    $acronym .= mb_substr($w, 0, 1);
                }
                $collection['assigned_to'][$i] = '<a href="/tracki/employee/profile/' . $emp->id . '" target="_blank" role="button" title="' . $emp->full_name . '">
                    <div class="avatar avatar-s me-2 pull-up">
                      <div class="avatar-name rounded-circle me-2"><span>' . $acronym . '</span></div>
                    </div>
                  </a>';
            };
        }

        // dd($tasks);
        // foreach ($tasks->items() as $task => $collection) {
        //     foreach ($collection['assigned_to'] as $i => $user) {
        //             $collection['assigned_to'][$i] = "<a class='d-flex align-items-center text-900' href='/users/profile/" . $user->id . "' target='_blank'>
        //             <p class='mb-0 ms-3 text-900'>". $user->name."</p></a>";
        //     };
        // }

        // dd($tasks->items());

        return response()->json([
            "rows" => $tasks->items(),
            "total" => $total,
        ]);
    } //allTaskDt

    public function create()
    {
        //
        $emps = Employee::all();
        $countries = Country::all();
        $nationalities = Nationality::all();
        $employee_types = EmployeeType::all();
        $salutations = Salutation::all();
        $genders = Gender::all();
        $marital_statuses = MaritalStatus::all();
        $departments = Department::all();
        $designations = Designation::all();
        $relationships = Relationship::all();

        return view('tracki.employee.create', compact(
            'emps',
            'countries',
            'nationalities',
            'employee_types',
            'salutations',
            'genders',
            'marital_statuses',
            'departments',
            'designations',
            'relationships',
        ));
    }

    /**
     * add a new resource.
     */
    public function add()
    {
        //
        return view('tracki.employee.add');
    }

    /**
     * Show the form for creating a new resource.
     */

    // public function ateststore(Request $request)
    // {

    //     $op = new Atest();

    //     Log::alert($request->all());
    //     Log::alert($request->first_name);

    //     $op->first_name = $request->first_name;
    //     $op->last_name = $request->last_name;
    //     $op->address = $request->address;

    //     $op->save();

    //     $error = false;
    //     $message = 'Employee created .' . $op->id;

    //     return response()->json(['error' => $error, 'message' => $message]);
    // }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $id = Auth::user()->id;
        $op = new Employee();
        $data = new EmployeeFile();

        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        // dd($validator);

        Log::info($request->all());

        if ($validator->fails()) {
            Log::info($validator->errors());
            $error = true;
            $message = 'Employee not create.' . $op->id;
        } else {

            $error = false;
            $message = 'Employee created .' . $op->id;

            $op->employee_number = 'ABC' . $op->id;
            $op->national_identifier_number = $request->national_identifier_number;
            $op->salutation = $request->salutation;
            $op->first_name = $request->first_name;
            $op->middle_name = $request->middle_name;
            $op->last_name = $request->last_name;
            $op->full_name = $request->first_name . ' ' . $request->last_name;
            $op->gender  = $request->gender;
            $op->marital_status = $request->marital_status;
            $op->employee_type = $request->employee_type;
            $op->date_of_birth = Carbon::createFromFormat('d/m/Y', $request->date_of_birth);
            $op->date_of_hire = Carbon::createFromFormat('d/m/Y', $request->date_of_hire);
            $op->join_date = Carbon::createFromFormat('d/m/Y', $request->join_date);
            $op->town_of_birth = $request->town_of_birth;
            $op->country_of_birth = $request->country_of_birth;
            $op->personal_email_address = $request->personal_email_address;
            $op->work_email_address = $request->work_email_address;
            $op->phone_number = $request->phone_number;
            $op->alt_phone_number = $request->alt_phone_number;
            $op->nationality = $request->nationality_id;
            $op->reporting_to_id = $request->reporting_to_id;
            $op->department_id = $request->department_id;
            $op->designation_id = $request->designation_id;
            // $op->language = $request->language;

            $op->save();

            if ($request->file('profile_image_name')) {
                $file = $request->file('profile_image_name');
                $filename = rand() . date('ymdHis') . $file->getClientOriginalName();
                $file->move(public_path('storage/upload/profile_images'), $filename);
                $data->file_name = $filename;
                $data->original_file_name = $file->getClientOriginalName();
                $data->file_extension = $file->getClientOriginalExtension();
                $data->file_size = $_FILES['profile_image_name']['size']; //$request->file('profile_image_name')->getSize();
                $data->file_path = '/storage/upload/profile_images/';
                $data->user_id = $id;
                $data->employee_id = $op->id;

                $data->save();
            }
            // Log::info('EmployeeController::store $op->id: '.$op->id);

            // dd($op->number);
        }

        return response()->json(['error' => $error, 'message' => $message]);
    }

    public function list()
    {
        $search = request('search');
        $sort = (request('sort')) ? request('sort') : "id";
        $order = (request('order')) ? request('order') : "DESC";
        $employees = Employee::orderBy($sort, $order);

        if ($search) {
            $employees = $employees->where(function ($query) use ($search) {
                $query->where('first_name', 'like', '%' . $search . '%')
                    ->orWhere('id', 'like', '%' . $search . '%');
            });
        }
        $total = $employees->count();

        $employees = $employees->paginate(request("limit"))->through(function ($employees) {

            $full_name = $employees->first_name . ' ' . $employees->last_name;
            if ($employees->emp_files?->file_path) {
                $image = ' <div class="avatar avatar-m ">
                                <a  href="#" role="button" title="' . $full_name . '">
                                    <img class="rounded-circle pull-up" src="' . $employees->emp_files->file_path . $employees->emp_files->file_name . '" alt="" />
                                </a>
                            </div>';
            } else {
                $image = '  <div class="avatar avatar-m  me-1" id="project_team_members_init">
                                <a class="dropdown-toggle dropdown-caret-none d-inline-block" href="#" role="button" title="' . $full_name . '">
                                    <div class="avatar avatar-m  rounded-circle pull-up">
                                        <div class="avatar-name rounded-circle me-2"><span>' . generateInitials($full_name) . '</span></div>
                                    </div>
                                </a>
                            </div>';
            }

            $profile_url = route('tracki.employee.profile', $employees->id);

            return [
                'id1' => '<div class="ms-3">' . $employees->id . '</div>',
                'id' => $employees->id,
                'image' => $image,
                'employee_number' => '<div class="align-middle white-space-wrap fw-bold fs-9"><a href="' . $profile_url . '">' . $employees->employee_number . '</a></div>',
                'employee_type' => '<div class="align-middle white-space-wrap fw-bold fs-9">' . $employees->employee_types->title . '</div>',
                'reporting_to' => '<div class="align-middle white-space-wrap fw-bold fs-9">' . $employees->managers?->full_name . '</div>',
                // 'gender' => '<div class="align-middle white-space-wrap fw-bold fs-9">' . $employees->genders->title . '</div>',
                'full_name' => '<div class="align-middle white-space-wrap fw-bold fs-9">' . $employees->full_name . '</div>',
                // 'first_name' => '<div class="align-middle white-space-wrap fw-bold fs-9">' . $employees->first_name . '</div>',
                // 'last_name' => '<div class="align-middle white-space-wrap fw-bold fs-9">' . $employees->last_name . '</div>',
                'email_address' => '<div class="align-middle white-space-wrap fw-bold fs-9">' . $employees->work_email_address . '</div>',
                'created_at' => format_date($employees->created_at,  'H:i:s'),
                'updated_at' => format_date($employees->updated_at, 'H:i:s'),
            ];
        });

        return response()->json([
            "rows" => $employees->items(),
            "total" => $total,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    public function profile($id)
    {
        $emp = Employee::findOrFail($id);
        $countries = Country::all();
        $address_types = AddressType::all();

        // for projects
        $employees = Employee::all();
        $tags = Tag::all();
        $project_type = ProjectType::all();
        $event_category = EventCategory::all();
        $event_audience = Audience::all();
        $clients = Client::all();
        $event_venue = Venue::all();
        $event_location = Location::all();
        $fund_category = Location::all();
        $budget_name = BudgetName::all();


        return view('tracki.employee.profile', compact(
            'emp',
            'countries',
            'employees',
            'tags',
            'project_type',
            'event_category',
            'event_audience',
            'clients',
            'event_venue',
            'event_location',
            'fund_category',
            'budget_name',
            'address_types',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
        Log::alert('EmployeeController::update');
        $id = Auth::user()->id;
        $op = Employee::findOrFail($request->id);
        $data = EmployeeFile::where('employee_id', $request->id)->first();

        if (!$data) {
            Log::info('inside data not defined.  new employeefile');
            $data = new EmployeeFile;
        }

        $op->national_identifier_number = $request->national_identifier_number;
        $op->salutation = $request->salutation;
        $op->first_name = $request->first_name;
        $op->middle_name = $request->middle_name;
        $op->last_name = $request->last_name;
        $op->full_name = $request->first_name . ' ' . $request->last_name;
        $op->gender  = $request->gender;
        $op->marital_status = $request->marital_status;
        $op->employee_type = $request->employee_type;
        $op->date_of_birth = Carbon::createFromFormat('d/m/Y', $request->date_of_birth);
        $op->date_of_hire = Carbon::createFromFormat('d/m/Y', $request->date_of_hire);
        $op->join_date = Carbon::createFromFormat('d/m/Y', $request->join_date);
        $op->town_of_birth = $request->town_of_birth;
        $op->country_of_birth = $request->country_of_birth;
        $op->personal_email_address = $request->personal_email_address;
        $op->work_email_address = $request->work_email_address;
        $op->phone_number = $request->phone_number;
        $op->alt_phone_number = $request->alt_phone_number;
        $op->nationality = $request->nationality;
        // $op->language = $request->language;
        $op->reporting_to_id = $request->reporting_to_id;
        $op->department_id = $request->department_id;
        $op->designation_id = $request->designation_id;

        if ($request->file('profile_image_name')) {
            $file = $request->file('profile_image_name');
            $filename = rand() . date('ymdHis') . $file->getClientOriginalName();
            $file->move(public_path('storage/upload/profile_images'), $filename);
            $data->file_name = $filename;
            $data->original_file_name = $file->getClientOriginalName();
            $data->file_extension = $file->getClientOriginalExtension();
            $data->file_size = $_FILES['profile_image_name']['size']; //$request->file('profile_image_name')->getSize();
            $data->file_path = '/storage/upload/profile_images/';
            $data->user_id = $id;
            $data->employee_id = $request->id;

            $data->save();
        }

        $op->save();

        // Log::info($request->all());

        return response()->json([
            'error' => false,
            'message' => 'Employee updated successfully ',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        //
        Employee::where('id', '=', $id)->delete();

        $notification = array(
            'message'       => 'Employee deleted successfully',
            'alert-type'    => 'success'
        );

        // dd($taskId);

        return response()->json([
            'error' => false,
            'message' => 'Employee deleted successfully',
        ]);
    }

    // return the edit employee view
    public function getEmpEditView($id)
    {

        $emps = Employee::all();  // used for managers
        $emp = Employee::findOrFail($id);
        $countries = Country::all();
        $nationalities = Nationality::all();
        $employee_types = EmployeeType::all();
        $salutations = Salutation::all();
        $genders = Gender::all();
        $marital_statuses = MaritalStatus::all();
        $languages = Language::all();
        $departments = Department::all();
        $designations = Designation::all();

        // Log::alert('EmployeeController::getEmpEditView file_name: ' . $emp->emp_files?->file_name);

        $view = view('/tracki/employee/mv/edit', [
            'emp' => $emp,
            'emps' => $emps,
            'countries' => $countries,
            'nationalities' => $nationalities,
            'employee_types' => $employee_types,
            'salutations' => $salutations,
            'genders' => $genders,
            'marital_statuses' => $marital_statuses,
            'languages' => $languages,
            'departments' => $departments,
            'designations' => $designations,
        ])->render();

        return response()->json(['view' => $view]);
    }
}
