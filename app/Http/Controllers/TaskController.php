<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
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
use App\Models\Department;
// use App\Models\EventStatus;
use App\Models\Person;
// use Spatie\Permission\Models\Role;
// use Spatie\Permission\Models\Permission;
use App\Models\FileUpload;
use App\Models\Task;
use App\Models\Color;
use App\Models\TaskFileUpload;
// use App\Models\SendMailController;
use App\Models\EventAttendance;
use App\Models\TaskStatus;
use App\Models\MultiLine;
use App\Models\EventNote;
use App\Models\ProjectType;
use App\Models\TaskNote;
use Carbon\Carbon;
// use Illuminate\Contracts\Session\Session;
// use Illuminate\Support\Facades\Session;
// use Illuminate\Support\Facades\Crypt;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
// use Illuminate\Support\Facades\Input;
// use SimpleSoftwareIO\QrCode\Facades\QrCode;

use Illuminate\Support\Facades\Notification;
use App\Notifications\AnnouncementCenter;
use App\Http\Controllers\UtilController;
use App\Models\BudgetName;
use App\Models\Client;
use App\Models\Employee;
use App\Models\FundCategory;
use App\Models\Status;
use App\Models\Subtask;
use App\Models\Tag;
use App\Models\Todo;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class TaskController extends Controller
{
    //
    protected $UtilController;

    public function __construct(UtilController $UtilController)
    {
        $this->UtilController = $UtilController;
    }

    public function index()
    {
        $projects = Event::all();
        $eventData = Event::all();
        $users = User::all();
        $employees = Employee::all();
        $statuses = Status::all();
        $departments = Department::all();

        return view('tracki.task.all', [
            'projects' => $projects,
            'users' => $users,
            'statuses' => $statuses,
            'departments' => $departments,
            'eventData' => $eventData,
            'employees' => $employees,
        ]);
    }

    // public function get_assignments

    public function getTaskNotesView($id)
    {
        $task = Task::findOrFail($id);
        $view = view('/tracki/task/notes', ['task' => $task])->render();
        return response()->json(['view' => $view]);
    }

    public function getTaskSubView($id)
    {
        $task = Task::findOrFail($id);
        $view = view('/tracki/task/subtask', ['task' => $task])->render();
        return response()->json(['view' => $view]);
    }

    public function getTaskFilesView($id)
    {
        $task = Task::findOrFail($id);
        $view = view('/tracki/task/files', ['task' => $task])->render();
        return response()->json(['view' => $view]);
    }

    public function allTaskDetails()
    {
        // $tasks = Task::all();
        // $projects = $tasks->project();
        // $persons = Person::all();

        return null;
    } //allTaskDetails

    public function getProjectUsers($id)
    {
        $ws_id = session()->get('workspace_id');
        $project = Event::findOrFail($id);
        $project_users = $project?->users;

        return response()->json(['projectusers' => $project_users]);
    }

    public function getTask($id)
    {
        // $task = Task::findOrFail($id);

        $task = Task::with('employees')->findOrFail($id);
        $project = $task->project()->with('employees')->firstOrFail();
        // $imploded = (implode($workspace->persons));
        // $asg = Workspace::with('persons')->firstOrFail();
        // dd($task->users);
        return response()->json(['task' => $task, 'project' => $project, 'asg' => $task->employees]);
        // return response()->json(['task' => $task, 'asg' => $task->users]);
    } // getTask

    public function getTaskView($id)
    {
        $task = Task::with('employees')->findOrFail($id);
        $project = $task->project()->with('employees')->firstOrFail();
        $departments = Department::all();
        $employees = Employee::all();

        // dd($project);

        // Log::alert('EmployeeController::getEmpEditView file_name: ' . $emp->emp_files?->file_name);

        $view = view('/tracki/task/mv/edit', [
            'task' => $task,
            'project' => $project,
            'departments' => $departments,
            'employees' => $employees,
        ])->render();

        return response()->json(['view' => $view]);
    }

    public function allTaskDt($id = null)
    {
        $workspace = session()->get('workspace_id');

        if ($id) {
            $id = explode('_', $id);
            $showpage_id = $id[1];
            $showpage = $id[0];

            Log::alert('TaskController::allTaskDt');
            Log::alert('parameter showpage_id id: ' . $showpage_id);
            Log::alert('parameter showpage: ' . $showpage);


            if ($showpage == 'user') {

                $user = User::findOrFail($showpage_id);
                $tasks = $user->tasks();

                // dd($tasks);

                $tasks = $tasks->when($workspace, function ($query, $workspace) {
                    return $query->where('tasks.workspace_id', $workspace);
                });
            } elseif ($showpage == 'list') {

                $event = Event::findOrFail($showpage_id);
                $tasks = $event->tasks();

                $tasks = $tasks->when($workspace, function ($query, $workspace) {
                    return $query->where('tasks.workspace_id', $workspace);
                });
            }
        } else {
            $tasks = Task::when($workspace, function ($query, $workspace) {
                return $query->where('tasks.workspace_id', $workspace);
            })->when($id, function ($query, $project_id) {
                return $query->where('tasks.event_id', $project_id);
            });
        }


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

        if ($search) {
            $tasks = $tasks->where(function ($query) use ($search) {
                $query->where('tasks.name', 'like', '%' . $search . '%');
            });
        }

        if ($department_id) {
            $where['department_assignment_id'] = $department_id;
            // dd($tasks);
        }

        if ($person_id) {
            $user = User::find($person_id);
            $tasks = $user->tasks()->orderBy($sort, $order);
            // dd($tasks);
            // Log::
        }

        if ($status_id != '') {
            $where['status_id'] = $status_id;
        }
        if ($project_id != '') {
            $where['event_id'] = $project_id;
        }
        // if ($user_id != '') {
        //     $where['assigned'] = $project_id;
        // }

        $tasks = $tasks->where($where);

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
                (($task->files->count()) ? '<button class="btn p-0 text-body-tertiary fs-10 me-2"><span class="fas fa-paperclip me-1"></span>' . $task->files->count() . '</button>' : "") .
                (($task->subtask->count()) ? '<button class="btn p-0 text-body-tertiary fs-10 me-2"><span class="fas fas fa-network-wired me-1"></span>' . $task->subtask->count() . '</button>' : "");

            $not_assigned_html = '<span class="badge text-black bg-light">Not assigned</span>';
            $assigned_to_html = null;


            foreach ($task->employees as $key => $user) {
                LOG::info($user->full_name);
                if ($user->emp_files?->file_path) {
                    LOG::info('inside file exists');
                    $assigned_to_html = $assigned_to_html .
                        '<a href="/tracki/employee/profile/' . $user->id . '" target="_blank" role="button" title="' . $user->full_name . '"><div class="avatar avatar-s me-2 pull-up">
                      <img class="rounded-circle pull-up" src="' . $user->emp_files->file_path . $user->emp_files->file_name . '" alt=""/>
                    </div></a>';
                } else {
                    $assigned_to_html = $assigned_to_html . '<a href="/tracki/employee/profile/' . $user->id . '" target="_blank" role="button" title="' . $user->full_name . '"><div class="avatar avatar-s me-2 pull-up">
                      <div class="avatar-name rounded-circle me-2"><span>' . generateInitials($user->full_name) . '</span></div>
                    </div></a>';
                }
            }

            return [
                'id1' => '<div class="ms-3">' . $task->id . '</div>',
                'id' => $task->id,
                'event_id' => '<div class="d-flex align-items-center"><div><a class="fw-bold mb-0 line-clamp-2 text-body-emphasis" href="/tracki/task/' . $task->event_id . '/list">' . $task->project?->name . '</a>',
                'name' => '<a class="fw-bold mb-0 line-clamp-2 text-body-emphasis" id="taskCardView" href="javascript:void(0);"  data-id="' . $task->id . '" data-table="task_table">' . $task->name . '</a><div class="d-flex align-items-center">' .
                    '<p class="mb-0 text-body-highlight fw-semibold fs-10 me-2">' . $icons . '</p></div></div></div>',
                'workspace_id' =>   $task->workspaces?->title,
                'department_assignment_id' => $task->department->name,
                'assigned_by' => $task->assigned_by?->name,
                'assigned_to' => $assigned_to_html ? $assigned_to_html : $not_assigned_html,
                // 'assigned_to' => $task->employees,
                'start_date' =>  format_date($task->start_date,  'H:i:s'),
                'end_date' =>  '<span class="text-' . $due_date_text_color . '">' .  format_date($task->due_date,  'H:i:s') . '</spanc>',
                'budget' => $task->budget_allocation,
                'budget_consumed' => $task->actual_budget_allocated,
                'attributes' => (($task->notes->count()) ? '<button class="btn p-0 text-body-tertiary fs-10 me-2"><span class="fas fa-sticky-note me-1"></span>' . $task->notes->count() . '</button>' : "") .
                    (($task->files->count()) ? '<button class="btn p-0 text-body-tertiary fs-10 me-2"><span class="fas fa-paperclip me-1"></span>' . $task->files->count() . '</button>' : "") .
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


        // foreach ($tasks->items() as $task => $collection) {
        //     foreach ($collection['assigned_to'] as $i => $emp) {
        //         $words = explode(" ", $emp->full_name);
        //         $acronym = "";

        //         foreach ($words as $w) {
        //             $acronym .= mb_substr($w, 0, 1);
        //         }
        //         $collection['assigned_to'][$i] = '<a href="/tracki/employee/profile/' . $emp->id . '" target="_blank" role="button" title="' . $emp->full_name . '">
        //             <div class="avatar avatar-s me-2 pull-up">
        //               <div class="avatar-name rounded-circle me-2"><span>' . $acronym . '</span></div>
        //             </div>
        //           </a>';
        //     };
        // }

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

    public function getTaskFiles($id)
    {

        $fileData = TaskFileUpload::where('task_id', $id);
        // $fileData = TaskFileUpload::find(65);

        // dd($fileData);

        // $user_department = auth()->user()->department_assignment_id;

        // $search = request('search');
        // $sort = 'id'; //(request('sort')) ? request('sort') : "id";
        // $order = "desc"; //(request('order')) ? request('order') : "DESC";

        $total = $fileData->count();
        // dd($total);
        $fileData = $fileData->paginate(request("limit"))->through(function ($file) {

            $original_file_name = '<div>'  . $file->users->name . ' | ' . $file->created_at->format('d/m/Y H:i:s') . '</div>
            <div class="align-middle white-space-wrap fw-bold fs-8"><a href="' . $file->file_path . $file->file_name . '" target="_blank">' . $file->original_file_name . '<a/></div>
           ';

            return [
                'id' => $file->id,
                'original_file_name' => $original_file_name,
                'file_size' => '<div class="align-middle white-space-wrap fw-bold fs-8">' . number_format($file->file_size / 1000, 2) . ' KB</div>',
                'created_at' => format_date($file->created_at,  'H:i:s'),
                'updated_at' => format_date($file->updated_at, 'H:i:s'),
            ];
        });

        return response()->json([
            "rows" => $fileData->items(),
            "total" => $total,
        ]);
    } //getTaskFiles

    public function getTaskNotes($id)
    {

        $noteData = TaskNote::where('task_id', $id);
        // $fileData = TaskFileUpload::find(65);

        // dd($fileData);

        // $user_department = auth()->user()->department_assignment_id;

        // $search = request('search');
        // $sort = 'id'; //(request('sort')) ? request('sort') : "id";
        // $order = "desc"; //(request('order')) ? request('order') : "DESC";

        $total = $noteData->count();
        // dd($total);
        // $taskData = $taskData->orderBy($sort, $order)->paginate(request('limit'))->through(function ($task) use ($statuses) {

        $noteData = $noteData->paginate(request("limit"))->through(
            function ($note) {

                $note_text = '<div>'  . $note->users->name . ' | ' . $note->created_at->format('d/m/Y H:i:s') . '</div>
                         <div class="align-middle white-space-wrap fw-bold fs-8">' . $note->note_text . '<a/></div>
                        ';

                return [
                    'id' => $note->id,
                    'note_text' => $note_text,
                    'user_name' => '<div class="align-middle white-space-wrap fw-bold fs-8">' . $note->users->name . '</div>',
                    'created_at' => $note->created_at->format('d/m/Y H:i:s'),
                    // 'created_at' => format_date($note->created_at,  'd/m/Y H:i:s'),
                    'updated_at' => format_date($note->updated_at, 'H:i:s'),
                ];
            }
        );

        return response()->json([
            "rows" => $noteData->items(),
            "total" => $total,
        ]);
    } //getTaskNotes

    public function addTask($id, $modal_yn = null)
    {
        $eventData = Event::find($id);
        $task_status = TaskStatus::all();
        $department = Department::all();
        $user = User::all();
        $color = Color::all();

        $call_modal = (request('modal_yn')) ? true : false;
        Log::info('calling from addTask TaskController the value of modal_yn: ' . $modal_yn);
        Log::info('calling from addTask TaskController the value of call_modal: ' . $call_modal);

        if ($call_modal) {
            return response()->json([
                'event_data' => $eventData,
                'status' => $task_status,
                'user' => $user,
            ]);
        } else {
            // $count = $eventData->count();
            return view('tracki.task.add', [
                'event_id' => $id,
                'task_status' => $task_status,
                'department' => $department,
                'user' => $user,
                'eventData' => $eventData,
                'event_color' => $color,
            ]);
        }
    } //addTask

    public function taskAdd($id)
    {
        $data = Event::find($id);
        return response()->json($data);
    }
    public function editTask($id)
    {
        // dd('test');
        $taskData = Task::with('users')->findOrFail($id);
        $project = $taskData->project()->with('users')->firstOrFail();
        $users = $project->users;

        // dd($users);


        // $taskData = Task::find($id);
        // $eventData = Event::find($id);
        $task_status = TaskStatus::all();
        $statuses = Status::all();
        $departments = Department::all();
        // $users = User::all();
        $event_color = Color::all();
        $project = Event::all();

        // $count = $eventData->count();
        return view('tracki.task.edit', [
            'taskData' => $taskData,
            'task_status' => $task_status,
            'departments' => $departments,
            'users' => $users,
            'statues' => $statuses,
            'event_color' => $event_color,
            'project' => $project,
        ]);
    } //addTask

    public function createTask(Request $request)
    {
        // dd('createTask');
        $user_id = Auth::user()->id;
        $task = new Task();
        // $util = new UtilController;

        $task->name = $request->name;
        $task->start_date = Carbon::createFromFormat('d/m/Y', $request->start_date)->toDateString();
        // $task->start_time = $request->start_time;
        $task->due_date = Carbon::createFromFormat('d/m/Y', $request->due_date);
        // $task->due_date =  $request->end_time;
        $task->budget_allocation = $request->budget_allocation;
        $task->department_assignment_id = $request->department_assignment_id;
        $task->assignment_id = $request->assignment_id;
        $task->description = $request->description;
        $task->status_id = $request->status_id;
        $task->event_id = $request->event_id;
        $task->color_id = $request->color_id;
        $task->actual_budget_allocated = $request->actual_budget_allocated;
        $task->progress = $request->progress / 100;
        $task->assignment_to_id = implode(',', $request->assignment_to_id);
        $task->created_by = $user_id;
        $task->updated_by = $user_id;
        $start_date_d = Carbon::createFromFormat('d/m/Y',  $request->start_date);
        $end_date_d = Carbon::createFromFormat('d/m/Y', $request->due_date);
        $duration =  $start_date_d->diffInDays($end_date_d, false);

        // Log::info('start_date_d: ' . $start_date_d . ' end_date_d: ' . $end_date_d . ' duration: ' . $duration);
        $completed_status = false;

        // Log::info('status_id: ' . $request->status_id . ' config completed: ' . config('tracki.task_status.completed') . ' completed_status: ' . $completed_status);

        // dd($duration);
        $task->duration = $duration;

        if ($request->status_id == config('tracki.task_status.completed')) {
            $task->progress = 1;
            $task->status_id = config('tracki.task_status.completed');
            $completed_status = true;
        }

        if (config('tracki.show_task_progress')) {
            if (!$completed_status) {
                if ($request->progress >= 100) {
                    $task->status_id = config('tracki.task_status.completed');
                } elseif ($request->progress == 0) {
                    $task->status_id = config('tracki.task_status.active');
                } else {
                    $task->status_id = config('tracki.task_status.inprogress');
                }
            }
        }

        $task->save();

        foreach ($request->assignment_to_id as $key => $data) {

            $task->users()->attach($request->assignment_to_id[$key]);
        }
        $util_controller = new UtilController;
        $update_project_status = $util_controller->updateProjectStatus($request->event_id);

        $details = [
            'subject' => 'Tracki Notification Center. New task assignment',
            'greeting' => 'Hi ' . $task->assigned_to_name . ',',
            'body' => 'task "' . $task->name . '" has been assigned to you and ready for some action. chop chop start churning',
            'startdate' => 'Start Date: ' . \Carbon\Carbon::parse($task->start_date)->format('d-M-Y'),
            'duedate' => 'Due by: ' . \Carbon\Carbon::parse($task->due_date)->format('d-M-Y'),
            'description' => $task->description,
            'actiontext' => 'Go to Tracki',
            'actionurl' => '/',
            'lastline' => 'Please check the task online for any notes or attachments',
        ];

        if (config('tracki.send_task_assignment_emails')) {
            Log::info('assignment to id: ' . $task->assignment_to_id);
            $emails = $this->UtilController->getAssignedToEmail($task->assignment_to_id);
            Notification::route('mail', $emails)->notify(new AnnouncementCenter($details));
        }



        // if (config('tracki.send_task_assignment_emails')) {
        //     $emails = $this->getAssignedToName($task->assignment_to_id);
        //     $response = $this->SendMailController->sendTaskAssignmentEmail($task, $emails);
        // }

        $notification = array(
            'message'       => 'Event created successfully',
            'alert-type'    => 'success'
        );

        // Toastr::success('Has been add successfully :)','Success');
        return Redirect::route('tracki.task.list', $request->event_id)->with($notification);
    } // createTask

    public function taskStore(Request $request)
    {
        // dd('createTask');

        Log::info('taskStore');
        Log::info($request);
        $user_id = Auth::user()->id;
        $task = new Task();
        $projects = Event::findOrFail($request->event_id);

        // $util = new UtilController;

        $task->name = $request->name;
        $task->start_date = Carbon::createFromFormat('d/m/Y', $request->start_date)->toDateString();
        // $task->start_time = $request->start_time;
        $task->due_date = Carbon::createFromFormat('d/m/Y', $request->due_date);
        // $task->due_date =  $request->end_time;
        $task->budget_allocation = $request->budget_allocation;
        $task->workspace_id = session()->get('workspace_id') ? session()->get('workspace_id') : $projects->workspace_id;
        $task->department_assignment_id = $request->department_assignment_id;
        $task->assignment_id = 10; //$request->assignment_id;
        $task->description = $request->description;
        $task->status_id = $request->status_id;
        $task->event_id = $request->event_id;
        $task->color_id = $request->color_id;
        $task->actual_budget_allocated = $request->actual_budget_allocated;
        $task->progress = $request->progress / 100;
        $task->assignment_to_id = implode(',', $request->assignment_to_id);
        $task->created_by = $user_id;
        $task->updated_by = $user_id;
        $start_date_d = Carbon::createFromFormat('d/m/Y',  $request->start_date);
        $end_date_d = Carbon::createFromFormat('d/m/Y', $request->due_date);
        $duration =  $start_date_d->diffInDays($end_date_d, false);

        // Log::info('start_date_d: ' . $start_date_d . ' end_date_d: ' . $end_date_d . ' duration: ' . $duration);
        $completed_status = false;

        // Log::info('status_id: ' . $request->status_id . ' config completed: ' . config('tracki.task_status.completed') . ' completed_status: ' . $completed_status);

        // dd($duration);
        $task->duration = $duration;

        Log::info('task request stored: ' . $task->status->title);


        if ($task->status->title == 'Completed') {
            $task->progress = 1;
            $completed_status = true;
        }

        if (config('tracki.show_task_progress')) {
            if (!$completed_status) {
                if ($request->progress >= 100) {
                    $task->status_id = config('tracki.task_status.completed');
                } elseif ($request->progress == 0) {
                    $task->status_id = config('tracki.task_status.active');
                } else {
                    $task->status_id = config('tracki.task_status.inprogress');
                }
            }
        }

        $task->save();

        Log::info('TaskController::taskStore task count: ' . $projects->tasks->count());
        Log::info('TaskController::taskStore sum progress: ' . $projects->tasks->sum('progress'));

        foreach ($request->assignment_to_id as $key => $data) {

            $task->employees()->attach($request->assignment_to_id[$key]);
        }

        $util_controller = new UtilController;
        $update_project_status = $util_controller->updateProjectStatus($request->event_id);

        $details = [
            'subject' => 'Tracki Notification Center. New task assignment',
            'greeting' => 'Hi ' . $task->assigned_to_name . ',',
            'body' => 'task "' . $task->name . '" has been assigned to you and ready for some action. chop chop start churning',
            'startdate' => 'Start Date: ' . \Carbon\Carbon::parse($task->start_date)->format('d-M-Y'),
            'duedate' => 'Due by: ' . \Carbon\Carbon::parse($task->due_date)->format('d-M-Y'),
            'description' => $task->description,
            'actiontext' => 'Go to Tracki',
            'actionurl' => '/',
            'lastline' => 'Please check the task online for any notes or attachments',
        ];

        if (config('tracki.send_task_assignment_emails')) {
            Log::info('assignment to id: ' . $task->assignment_to_id);
            $emails = $this->UtilController->getAssignedToEmail($task->assignment_to_id);
            Notification::route('mail', $emails)->notify(new AnnouncementCenter($details));
        }



        // if (config('tracki.send_task_assignment_emails')) {
        //     $emails = $this->getAssignedToName($task->assignment_to_id);
        //     $response = $this->SendMailController->sendTaskAssignmentEmail($task, $emails);
        // }

        $notification = array(
            'message'       => 'Event created successfully',
            'alert-type'    => 'success'
        );

        return response()->json([
            'error' => false,
            'message' => 'task added successfully to project ' . $task->project->name . '.',
            'user_name' => auth()->user()->username, //$data->users->username,
            // 'note_text' => $data->note_text,
            // 'note_date' => format_date($data->created_at,  'H:i:s'),
            'id' => $task->id
        ]);

        // Toastr::success('Has been add successfully :)','Success');
        // return Redirect::route('tracki.task.list', $request->event_id)->with($notification);
    } // createTask

    public function updateTask(Request $request)
    {
        Log::info('TaskController::updateTask');
        Log::info('request id: ' . $request->id);

        $user_id = Auth::user()->id;

        $task = Task::findOrFail($request->id);
        // $util = new UtilController;

        Log::info($request);
        $task->name = $request->name;
        Log::info('after name');
        $task->start_date = Carbon::createFromFormat('d/m/Y', $request->start_date);
        // $task->start_time = $request->start_time;
        $task->due_date = Carbon::createFromFormat('d/m/Y', $request->due_date);
        // $task->due_date =  $request->end_time;
        $task->budget_allocation = $request->budget_allocation;
        $task->actual_budget_allocated = $request->actual_budget_allocated;
        $task->department_assignment_id = $request->department_assignment_id;
        $task->assignment_id = $request->assignment_id;
        $task->description = $request->description;
        $task->status_id = $request->status_id;
        // $task->event_id = $request->event_id;
        $task->color_id = $request->color_id;
        // $task->event_id = $request->project_id;
        $task->progress = 0; //$request->progress / 100;
        $task->assignment_to_id = implode(',', $request->assignment_to_id);
        $task->updated_by = $user_id;

        $start_date_d = Carbon::createFromFormat('d/m/Y', $request->start_date);
        $end_date_d = Carbon::createFromFormat('d/m/Y', $request->due_date);
        $duration =  $start_date_d->diffInDays($end_date_d, false);

        // Log::info('start_date_d: ' . $start_date_d . ' end_date_d: ' . $end_date_d . ' duration: ' . $duration);

        // dd($duration);
        $completed_status = false;

        Log::debug('status_id: ' . $request->status_id . ' config completed: ' . config('tracki.task_status.completed') . ' completed_status: ' . $completed_status);

        // dd($duration);
        $task->duration = $duration;

        if ($request->status_id == config('tracki.task_status.completed')) {
            $task->progress = 1;
            $task->status_id = config('tracki.task_status.completed');
            $completed_status = true;
        }

        if (config('tracki.show_task_progress')) {
            if (!$completed_status) {
                Log::info('insided is completed status is true');
                if ($request->progress >= 100) {
                    $task->status_id = config('tracki.task_status.completed');
                } elseif ($request->progress == 0) {
                    $task->status_id = config('tracki.task_status.active');
                } else {
                    $task->status_id = config('tracki.task_status.inprogress');
                }
            }
        }

        $task->duration = $duration;

        // Log::debug('status_id: ' . $request->status_id . ' task->progress: ' . $task->progress . ' completed_status: ' . $completed_status);

        $task->save();

        $util_controller = new UtilController;
        $update_project_status = $util_controller->updateProjectStatus($request->event_id);


        $task->employees()->detach();

        foreach ($request->assignment_to_id as $key => $data) {

            $task->employees()->attach($request->assignment_to_id[$key]);
        }


        $notification = array(
            'message'       => 'Task updated successfully',
            'alert-type'    => 'success'
        );

        // Toastr::success('Has been add successfully :)','Success');
        return response()->json([
            'error' => false,
            'message' => 'Task ' . $task->name . ' Task updated successfully ',
        ]);
        // return Redirect::route('tracki.task.list', $request->event_id)->with($notification);
    } // updateTask

    public function deleteTask($id)
    {
        // dd('mainEvent');
        $task = Task::find($id);
        Task::where('id', '=', $id)->delete();

        $task->users()->detach();

        $notification = array(
            'message'       => 'Task deleted successfully',
            'alert-type'    => 'success'
        );

        // Toastr::success('Has been add successfully :)','Success');
        return response()->json([
            'error' => false,
            'message' => 'Task ' . $task->name . ' deleted successfully to task ',
        ]);

        // return Redirect::route('tracki.task.list', $task->event_id)->with($notification);
    } // deleteTask

    public function taskDetails(Request $request, $id)
    {
        // $hasit = auth()->user()->hasRole('department restricted');
        Log::alert('TaskController::taskDetails');
        $workspace = session()->get('workspace_id');

        Log::alert('TaskController::workspace' . $workspace);

        Log::info($request->url());
        $user_department = auth()->user()->department_assignment_id;

        $util_controller = new UtilController;

        $eventData = Event::find($id);
        // if (!$eventData){
        //     dd($eventData);
        // }
        $department = Department::all();
        $event_category = EventCategory::all();
        $clients = Client::all();
        $event_audience = Audience::all();
        $event_venue = Venue::all();
        $event_location = Location::all();
        $project_type = ProjectType::all();
        $fund_category = FundCategory::all();
        $budget_name = BudgetName::all();
        $employees = Employee::all();
        $tags = Tag::all();

        // foreach ($eventData->clients as $clnt) {
        //     $client_name = $clnt->first_name.' '.$clnt->last_name;
        //     // $client_first_name = $eventData->clients->pivot->first_name;
        // }
        // dd($client_name);

        // $util = new UtilController;
        // Log::info($user_department);
        // $hasit = auth()->user()->hasPermissionTo('project.menu');
        // $hasit = Auth::user()->hasPermissionTo('project.menu');
        // dd($hasit);


        $budget_details = $this->UtilController->getEventBudgetDetails($id);

        $remaining_budget = $budget_details->eventbudget - $budget_details->task_total_budget;

        $project_progress = get_project_progress($id);
        // session(['attendance_view' => 'show']);
        //dd($delta);

        $task_status_chart = Task::where('tasks.event_id', '=', $id)
            ->join('statuses', 'statuses.id', '=', 'tasks.status_id')
            ->select('statuses.title as name', DB::raw("count(statuses.title) as value"))
            ->groupBy('statuses.title')
            ->when($workspace, function ($query, $workspace) {
                return $query->where('tasks.workspace_id', $workspace);
            })
            ->having('value', '>', '0')
            ->get();

        // dd($task_status_chart);


        $attendeez = EventAttendance::join('master_guests_list', 'event_attendance.guest_id', '=', 'master_guests_list.id')
            ->join('event_audience', 'event_audience.id', '=', 'master_guests_list.type_id')
            ->where('event_attendance.event_id', '=', $id)
            ->orderBy('master_guests_list.first_name', 'asc')
            ->get(([
                'event_attendance.id',
                'master_guests_list.first_name',
                'master_guests_list.last_name',
                'master_guests_list.email_address',
                'master_guests_list.phone_number',
                'event_attendance.guest_attended',
                'event_audience.name',
            ]));

        $eventCategoryName = $eventData->categories?->name;
        $projectType = $eventData->types?->name;
        $AudienceName = $eventData->audiences?->name;
        $PlannerName = $eventData->planners?->name;
        $VenueName = $eventData->venues?->name;
        $LocationName = $eventData->locations?->name;
        $FundCategory = $eventData->fundCategories?->name;
        $eventNote = $eventData->notes;
        $FileName = $eventData->files;


        // ******************************* this is for the x-card
        $projects = Event::find($id);
        $users = User::all();
        $statuses = Status::all();
        //********************************************* */

        // dd($taskData);
        $count = $eventData->count();
        return view('tracki.task.list', [
            'count' => $count,
            'eventData' => $eventData,
            'employees' => $employees,
            'event_progress' => $project_progress * 100,
            'eventCategoryName' => $eventCategoryName,
            'audienceName' => $AudienceName,
            'plannerName' => $PlannerName,
            'venueName' => $VenueName,
            'locationName' => $LocationName,
            'fileName' => $FileName,
            'remainingBudget' => $remaining_budget,
            'attendeez' => $attendeez,
            'eventNote' => $eventNote,
            'projectType' => $projectType,
            'FundCategory' => $FundCategory,
            'statuses' => $statuses,
            'projects' => $projects,
            'users' => $users,
            'departments' => $department,
            'task_status_chart' => $task_status_chart,
            'project_type' => $project_type,
            'event_category' => $event_category,
            'clients' => $clients,
            'event_audience' => $event_audience,
            'event_venue' => $event_venue,
            'tags' => $tags,
            'event_location' => $event_location,
            'fund_category' => $fund_category,
            'budget_name' => $budget_name,
        ]);
    }

    public function ltTaskDetails()
    {
        // $hasit = auth()->user()->hasRole('department restricted');
        $user_department = auth()->user()->department_assignment_id;

        $taskData = Task::join('events', 'events.id', '=', 'tasks.event_id')
            ->join('department', 'department.id', '=', 'tasks.department_assignment_id')
            ->join('person', 'person.id', '=', 'tasks.assignment_id')
            ->join('task_status', 'task_status.id', '=', 'tasks.status_id')
            ->leftjoin('colors', 'colors.id', '=', 'tasks.color_id')
            // ->where('tasks.event_id', '=', $id)
            ->whereRaw('datediff(tasks.due_date, CURRENT_DATE) < 0')
            ->where('tasks.progress', '<', 1)
            ->when($user_department, function ($query, $user_department) {
                return $query->where('tasks.department_assignment_id', $user_department);
            })
            ->when(auth()->user()->functional_area_id, function ($query, $user_fa) {
                return $query->where('events.functional_area_id', $user_fa);
            })
            ->orderBy('tasks.start_date', 'asc')
            ->get(([
                'events.name as project_name',
                'tasks.name as task_name',
                'tasks.assignment_to_id',
                'department.name as department_name',
                'person.name as person_name',
                'task_status.name as status_name',
                'tasks.start_date',
                'tasks.due_date',
                'tasks.budget_allocation',
                'tasks.actual_budget_allocated',
                'tasks.event_id',
                'tasks.id',
                'tasks.duration',
                'tasks.progress as progress',
                'colors.name as color',
                'tasks.parent',
                'tasks.description',
            ]));

        return view('tracki.task.lt', [
            // 'count' => $count,
            'taskData'  => $taskData,
            // 'eventData' => $eventData,
        ]);
    } //ltTaskDetails

    public function endingSoonTaskDetails()
    {
        // $hasit = auth()->user()->hasRole('department restricted');
        $user_department = auth()->user()->department_assignment_id;

        $taskData = Task::join('events', 'events.id', '=', 'tasks.event_id')
            ->join('department', 'department.id', '=', 'tasks.department_assignment_id')
            ->join('person', 'person.id', '=', 'tasks.assignment_id')
            ->join('task_status', 'task_status.id', '=', 'tasks.status_id')
            ->leftjoin('colors', 'colors.id', '=', 'tasks.color_id')
            // ->where('tasks.event_id', '=', $id)
            ->whereRaw('datediff(tasks.due_date, CURRENT_DATE) < 3')
            ->whereRaw('datediff(tasks.due_date, CURRENT_DATE) >= 0')
            ->where('tasks.progress', '<', 1)
            ->when($user_department, function ($query, $user_department) {
                return $query->where('tasks.department_assignment_id', $user_department);
            })
            ->when(auth()->user()->functional_area_id, function ($query, $user_fa) {
                return $query->where('events.functional_area_id', $user_fa);
            })
            ->orderBy('tasks.start_date', 'asc')
            ->get(([
                'events.name as project_name',
                'tasks.name as task_name',
                'tasks.assignment_to_id',
                'department.name as department_name',
                'person.name as person_name',
                'task_status.name as status_name',
                'tasks.start_date',
                'tasks.due_date',
                'tasks.budget_allocation',
                'tasks.actual_budget_allocated',
                'tasks.event_id',
                'tasks.id',
                'tasks.duration',
                'tasks.progress as progress',
                'colors.name as color',
                'tasks.parent',
                'tasks.description',
            ]));

        return view('tracki.task.est', [
            // 'count' => $count,
            'taskData'  => $taskData,
            // 'eventData' => $eventData,
        ]);
    } //endingSoonTaskDetails

    public function startingSoonTaskDetails()
    {
        // $hasit = auth()->user()->hasRole('department restricted');
        $user_department = auth()->user()->department_assignment_id;

        $taskData = Task::join('events', 'events.id', '=', 'tasks.event_id')
            ->join('department', 'department.id', '=', 'tasks.department_assignment_id')
            ->join('person', 'person.id', '=', 'tasks.assignment_id')
            ->join('task_status', 'task_status.id', '=', 'tasks.status_id')
            ->leftjoin('colors', 'colors.id', '=', 'tasks.color_id')
            // ->where('tasks.event_id', '=', $id)
            ->whereRaw('datediff(tasks.start_date, CURRENT_DATE) < 3')
            ->whereRaw('datediff(tasks.start_date, CURRENT_DATE) >= 0')
            ->where('tasks.progress', '<', 1)
            ->when($user_department, function ($query, $user_department) {
                return $query->where('tasks.department_assignment_id', $user_department);
            })
            ->when(auth()->user()->functional_area_id, function ($query, $user_fa) {
                return $query->where('events.functional_area_id', $user_fa);
            })
            ->orderBy('tasks.start_date', 'asc')
            ->get(([
                'events.name as project_name',
                'tasks.name as task_name',
                'tasks.assignment_to_id',
                'department.name as department_name',
                'person.name as person_name',
                'task_status.name as status_name',
                'tasks.start_date',
                'tasks.due_date',
                'tasks.budget_allocation',
                'tasks.actual_budget_allocated',
                'tasks.event_id',
                'tasks.id',
                'tasks.duration',
                'tasks.progress as progress',
                'colors.name as color',
                'tasks.parent',
                'tasks.description',
            ]));

        return view('tracki.task.sst', [
            // 'count' => $count,
            'taskData'  => $taskData,
            // 'eventData' => $eventData,
        ]);
    } //startingSoonTaskDetails


    public function taskDetailsPDF($id)
    {
        // set_time_limit(300);
        $users = User::all();

        $data = [

                'quantity' => 1,
                'description' => '1 Year Subscription',
                'users' => $users

        ];

        // return view('mds.task.pdflist', $data);
        $pdf = Pdf::loadView('mds.task.pdflist', $data);
        // return $pdf->download('itsolutionstuff.pdf');
        return $pdf->stream();
    }  //taskDetailsPDF


    public function editTaskProgress($id)
    {
        //  dd('editTaskProgress');
        $data = Task::find($id);
        //dd($data);
        $data_arr = [];

        $data_arr[] = [
            "id"        => $data->id,
            "event_id"  => $data->event_id,
            "progress"  => $data->progress,
        ];

        $response = ["retData"  => $data_arr];
        return response()->json($response);
    } // editTaskProgress

    public function updateTaskProgress(Request $request)
    {

        //   dd($request);

        if ($request->prorgress_number >= 100) {
            Task::where('id', '=', $request->id)->update([
                'progress' => $request->prorgress_number / 100,
                'status_id' => config('tracki.task_status.completed'),
            ]);
        } elseif ($request->prorgress_number == 0) {
            Task::where('id', '=', $request->id)->update([
                'progress' => $request->prorgress_number,
                'status_id' => config('tracki.task_status.active'),
            ]);
        } else {
            Task::where('id', '=', $request->id)->update([
                'progress' => $request->prorgress_number / 100,
                'status_id' => config('tracki.task_status.inprogress'),
            ]);
        }

        $util_controller = new UtilController;
        $update_project_status = $util_controller->updateProjectStatus($request->event_id);

        $notification = array(
            'message'       => 'Task progress updated successfully',
            'alert-type'    => 'success'
        );

        // Toastr::success('Has been add successfully :)','Success');
        return redirect()->back()->with($notification);
        // deleteEvent
    }  //updateTaskProgress

    public function editTaskStatus($id)
    {
        //  dd('editTaskProgress');
        $data = Task::find($id);
        //dd($data);
        $data_arr = [];

        $data_arr[] = [
            "id"        => $data->id,
            "event_id"  => $data->event_id,
            "status_id"  => $data->status_id,
        ];

        $response = ["retData"  => $data_arr];
        return response()->json($response);
    } // editTaskStatus

    public function updateTaskStatus(Request $request)
    {

        $task = Task::findOrFail($request->id);
        $status_title = Status::findOrFail($request->status_id);

        Log::info($status_title->title);
        if (($status_title->title == 'Completed') || ($status_title->title == 'Suspended')) {
            $task->update([
                'status_id' => $request->status_id,
                'progress' => 1
            ]);
        } else {
            $task->update([
                'status_id' => $request->status_id,
                'progress' => 0
            ]);
        }



        $util_controller = new UtilController;
        $update_project_status = $util_controller->updateProjectStatus($request->event_id);

        $notification = array(
            'message'       => 'Task status updated successfully',
            'alert-type'    => 'success'
        );

        return response()->json(['error' => false, 'message' => 'Task Status updated successfully.', 'id' => $task->id]);

        // Toastr::success('Has been add successfully :)','Success');
        // return redirect()->back()->with($notification);
        // deleteEvent
    } //updateTaskStatus

    // *********************************************** task overview  *********************************************************************
    public function taskOverview($id)
    {
        // dd('mainEvent');
        // $data = Task::leftJoin('department', 'department.id', '=', 'tasks.department_assignment_id')
        //     ->leftJoin('person', 'person.id', '=', 'tasks.assignment_id')
        //     ->leftJoin('events', 'events.id', '=', 'tasks.event_id')
        //     ->leftJoin('statuses', 'statuses.id', '=', 'tasks.status_id')
        //     ->leftjoin('colors', 'colors.id', '=', 'tasks.color_id')
        //     ->where('tasks.id', '=', $id)
        //     ->orderBy('tasks.start_date', 'asc')
        //     ->get(([
        //         'tasks.name',
        //         'events.name as project_title',
        //         'tasks.assignment_to_id',
        //         'department.name as department_name',
        //         'person.name as person_name',
        //         'statuses.title as status_name',
        //         'statuses.color as status_color',
        //         'tasks.start_date',
        //         'tasks.due_date',
        //         'tasks.budget_allocation',
        //         'tasks.actual_budget_allocated',
        //         'tasks.event_id',
        //         'tasks.id',
        //         'tasks.duration',
        //         'tasks.progress as progress',
        //         'colors.name as color',
        //         'tasks.parent',
        //         'tasks.description',
        //     ]));

        $taskData = Task::where('id', $id);
        $taskData = $taskData->paginate(request('limit'))->through(function ($task) {
            // $taskData = $taskData
            //     ->paginate(request("limit"))
            //     ->through(
            //         fn ($task) =>
            return  [
                'id' => $task->id,
                'project_title' => $task->project->name,
                // 'project_name' => $task->project->name,
                'name' => $task->name,
                'department_name' => $task->department->name,
                'assigned_by' => $task->assigned_by?->name,
                'assigned_to' => $task->employees,
                'status_name' => $task->status->title,
                'status_color' => $task->status->color,
                'start_date' => format_date($task->start_date,  'H:i:s'),
                'due_date' => format_date($task->due_date,  'H:i:s'),
                'budget_allocation' => $task->budget_allocation,
                'actual_budget_allocated' => $task->actual_budget_allocated,
                'event_id' => $task->event_id,
                'notes' => $task->notes,
                'files' => $task->files,
                'subtasks' => $task->subtask,
                'workspace' => $task->workspaces->title,
                'attributes' => (($task->notes->count()) ? '<button class="btn p-0 text-body-tertiary fs-10 me-2"><span class="fas fa-sticky-note me-1"></span>' . $task->notes->count() . '</button>' : "") .
                    (($task->files->count()) ? '<button class="btn p-0 text-body-tertiary fs-10 me-2"><span class="fas fa-paperclip me-1"></span>' . $task->files->count() . '</button>' : ""),
                // 'attributes' => '<div class="ms-3 text-secondary">'.(($task->files->count()) ? '<span class="fas fa-file-alt me-1"></span>':"").' '.(($task->notes->count()) ? '<span class="fas fa-clipboard me-1"></span>':"").'</div>',
                'status' => '<span class="badge badge-phoenix fs--2 badge-phoenix-' . $task->status->color . ' "><span class="badge-label" data-bs-toggle="modal" data-bs-target="#taskStatusModal" id="editTaskStatus" data-id="' . $task->id . '" data-table="task_table">' . $task->status->title . '</span><span class="ms-1" data-feather="x" style="height:12.8px;width:12.8px;"></span></span>',
                'workspace_formated' => '<span class="badge badge-phoenix fs--2 badge-phoenix-warning"><span class="badge-label" data-bs-toggle="modal" data-bs-target="#taskStatusModal" id="editTaskStatus" data-id="' . $task->workspaces->id . '" data-table="task_table">' . $task->workspaces->title . '</span><span class="ms-1" data-feather="x" style="height:12.8px;width:12.8px;"></span></span>',
                'description' => $task->description,
                // 'description' => '<button class="btn btn-secondary m-1" type="button" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="Top Popover">Top Popover</button>',
                'created_at' => format_date($task->created_at,  'H:i:s'),
                'updated_at' => format_date($task->updated_at, 'H:i:s'),
            ];
        });

        // dd($taskData);
        // foreach ($taskData->items() as $task => $collection) {
        //     foreach ($collection['notes'] as $i => $user) {
        //             $collection['assigned_to'][$i] = $user->users->name;
        //     };
        // }

        // $tasks = Task::find($id);
        // $assigned_to = $tasks->persons;
        // dd($taskData->items());
        // return response()->json(['data'=>$taskData, 'assigned_to'=>$assigned_to]);
        return response()->json(['data' => $taskData,]);
    } // taskOverview

    public function taskOverviewAssignedto($id)
    {
        //
        $task = Task::find($id);
        $assigned_to = $task->persons;

        foreach ($assigned_to as $task => $collection) {
            // foreach ($collection as $i => $user) {
            $words = explode(" ", $collection->name);
            $acronym = "";

            foreach ($words as $w) {
                $acronym .= mb_substr($w, 0, 1);
            }
            $xx = '<a href="/users/profile/' . $collection->id . '" target="_blank" role="button" title="' . $collection['name'] . '">
                        <div class="avatar avatar-s me-2">
                          <div class="avatar-name rounded-circle me-2"><span>' . $acronym . '</span></div>
                        </div>
                      </a>';
            // };
        }


        //  dd($xx);
        return response()->json($assigned_to);
    } // taskOverviewAssignedto

    // *********************************************** task overview notes  *********************************************************************
    public function taskOverviewNotes($id)
    {
        // dd('mainEvent');
        // $data = Task::find($id);
        $data = TaskNote::leftJoin('users', 'users.id', '=', 'task_notes.user_id')
            ->where('task_id', '=', $id)
            ->get([
                'task_notes.id as task_note_id',
                'task_notes.note_text as task_note_text',
                'users.name as task_note_user_name',
                'task_notes.created_at as task_note_created_at',
            ]);

        return response()->json($data);
    } // taskOverviewNotes

    // *********************************************** task overview notes  *********************************************************************
    public function deleteTaskNote($id)
    {
        // dd('mainEvent');
        // $data = EventNote::find($id);
        // dd('inside deleteTaskNote: '.$id);
        TaskNote::where('id', '=', $id)->delete();

        $notification = array(
            'message'       => 'Task Note deleted successfully',
            'alert-type'    => 'success'
        );

        return response()->json([
            'error' => false,
            'message' => 'Note deleted successfully',
        ]);
    } // deleteTaskNote

    // *********************************************** task overview files  *********************************************************************
    public function taskOverviewFiles($id)
    {
        // dd('mainEvent');
        // $data = Task::find($id);
        $destinationPath = public_path('storage/upload/event_files');

        // dd($destinationPath);
        $data = TaskFileUpload::leftJoin('users', 'users.id', '=', 'task_files.user_id')
            ->where('task_id', '=', $id)
            ->get([
                'task_files.id as task_file_id',
                'task_files.original_file_name',
                'task_files.file_name',
                'task_files.file_path',
                'task_files.file_size',
                'task_files.file_extension',
                'users.name as file_user_name',
                'task_files.created_at as file_created_at',
            ]);

        return response()->json($data);
    } // taskOverviewNotes

    // *********************************************** Save Task Note *********************************************************************

    public function taskNoteStore(Request $request)
    {

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
            $data = new TaskNote();
            $task = Task::findOrFail($request->task_id);
            $project = Event::findOrFail($task->event_id);

            $data->note_text = $request->note_text;
            $data->user_id = $id;
            $data->task_id = $request->task_id;

            $data->save();

            $details = [
                'subject' => 'Tracki Notification Center. Note added to Task',
                'greeting' => 'Hi ' . $task->assigned_to_name . ',',
                'body' => 'A note was added to  "' . $task->name . '" of project "' . $project->name . '"',
                'description' => $data->note_text,
                'actiontext' => 'Go to Tracki',
                'actionurl' => '/',
                'lastline' => 'Please check the task online for any more details',
                'startdate' => 'Start Date: ' . \Carbon\Carbon::parse($task->start_date)->format('d-M-Y'),
                'duedate' => 'Due by: ' . \Carbon\Carbon::parse($task->due_date)->format('d-M-Y'),
            ];

            Log::info($details);
            if (config('tracki.send_task_assignment_emails')) {
                Log::info('assignment to id: ' . $task->assignment_to_id);
                $emails = $this->UtilController->getAssignedToEmail($task->assignment_to_id);
                Notification::route('mail', $emails)->notify(new AnnouncementCenter($details));
            }

            $notification = array(
                'message'       => 'Task note added successfully',
                'alert-type'    => 'success'
            );

            return response()->json([
                'error' => false,
                'message' => 'Note added successfully to task ' . $task->name . '.',
                'user_name' => auth()->user()->username, //$data->users->username,
                'note_text' => $data->note_text,
                'note_date' => format_date($data->created_at,  'H:i:s'),
                'id' => $task->id
            ]);
        }
        // return redirect()->back();
    } //taskNoteStore

    // *********************************************** Task File Upload *********************************************************************

    public function taskFileStore(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'file_name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => 'file name field is required',
                'user_name' => null,
                'note_text' => null,
                'note_date' => null,
                'id' => null
            ]);
        } else {
            $id = Auth::user()->id;
            $task = Task::findOrFail($request->task_id);
            $data = new TaskFileUpload();

            // dd($request->task_id);

            if ($request->file('file_name')) {
                $file = $request->file('file_name');
                $filename = rand() . date('ymdHis') . $file->getClientOriginalName();
                $file->move(public_path('storage/upload/event_files'), $filename);
                $data->file_name = $filename;
                $data->original_file_name = $file->getClientOriginalName();
                $data->file_extension = $file->getClientOriginalExtension();
                $data->file_size = $_FILES['file_name']['size']; //$request->file('file_name')->getSize();
                $data->file_path = '/storage/upload/event_files/';
                $data->user_id = $id;
                $data->task_id = $request->task_id;
            }

            $data->save();

            $notification = array(
                'message'       => 'File added successfully',
                'alert-type'    => 'success'
            );

            // return response()->json(['success'=>'You have successfully upload file.']);
            return response()->json([
                'error' => false,
                'message' => 'file added successfully to task ' . $task->name . '.', 'id' => $task->id,
                'user_name' => auth()->user()->username, //$data->users->username,
                'original_file_name' => $data->original_file_name,
                'task_file_id' => $data->id,
                'file_size' => $data->file_size,
                'created_at' => format_date($data->created_at,  'H:i:s'),
                'file_extension' => $data->file_extension,
                'file_name' => $data->file_name,
                'file_path' => $data->file_path,
            ]);
        }
        // return redirect()->back();
    } //taskFileStore

    public function taskFileDelete($id)
    {
        $fileDetails = TaskFileUpload::find($id);

        // dd($fileDetails);
        // Log::info('file to delete: ' . 'upload/event_files/' . $fileDetails->file_name);

        // $url = \File::allFiles(public_path('upload/event_files/'.$fileDetails->file_name));
        // dd($url);

        if (File::exists(public_path('storage/upload/event_files/' . $fileDetails->file_name))) {
            File::delete(public_path('storage/upload/event_files/' . $fileDetails->file_name));
        }

        TaskFileUpload::where('id', '=', $id)->delete();

        $notification = array(
            'message'       => 'File deleted successfully',
            'alert-type'    => 'success'
        );

        // dd($taskId);

        return response()->json([
            'error' => false,
            'message' => 'file ' . $fileDetails->original_file_name . ' deleted successfully',
        ]);
        // Toastr::success('Has been add successfully :)','Success');
        // return Redirect::route('tracki.task.list', $task->event_id)->with($notification);
        // return redirect()->back()->with($notification);
    } // taskFileDelete

}
