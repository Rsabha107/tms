<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Support\Facades\Redirect;
// use App\Models\Event;
// use App\Models\EventCategory;
// use App\Models\Planner;
// use App\Models\Audience;
// use App\Models\Venue;
// use App\Models\Location;
// use App\Models\Department;
// use App\Models\EventStatus;
// use App\Models\Person;
// use Spatie\Permission\Models\Role;
// use Spatie\Permission\Models\Permission;
// use App\Models\FileUpload;
use App\Models\Task;
// use App\Models\Color;
// use App\Models\TaskFileUpload;
// use App\Models\SendMailController;
// use App\Models\EventAttendance;
// use App\Models\TaskStatus;
// use App\Models\MultiLine;
// use App\Models\EventNote;
// use App\Models\ProjectType;
// use App\Models\TaskNote;
use Carbon\Carbon;
// use Illuminate\Contracts\Session\Session;
// use Illuminate\Support\Facades\Session;
// use Illuminate\Support\Facades\Crypt;
// use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Facades\File;
// use Illuminate\Support\Facades\Input;
// use SimpleSoftwareIO\QrCode\Facades\QrCode;

// use Illuminate\Support\Facades\Notification;
// use App\Notifications\AnnouncementCenter;
use App\Http\Controllers\UtilController;
use App\Models\BudgetFunctionalAreaMapping;
use App\Models\BudgetName;
use App\Models\FunctionalArea;
use App\Models\GlobalStatus;
use App\Models\HROrganization;
use App\Models\OrganizationBudget;

// use App\Models\OrganizationBudget;

class BudgetController extends Controller
{
    protected $UtilController;

    public function __construct(UtilController $UtilController)
    {
        $this->UtilController = $UtilController;
    }

    //
    public function budgetUtilization()
    {
        // $hasit = auth()->user()->hasRole('department restricted');
        $user_department = auth()->user()->department_assignment_id;

        // $util = new UtilController;
        // Log::info($user_department);
        // $hasit = auth()->user()->hasPermissionTo('project.menu');
        // $hasit = Auth::user()->hasPermissionTo('project.menu');
        // dd($hasit);

        // $budget_details = $this->UtilController->getEventBudgetDetails($id);

        // $remaining_budget = $budget_details->eventbudget - $budget_details->task_total_budget;

        // session(['attendance_view' => 'show']);
        //dd($delta);

        // $eventData = Event::find($id);
        // $taskData = Task::where('event_id', '=', $id)->get();
        $taskData = Task::join('events', 'events.id', '=', 'tasks.event_id')
            ->join('department', 'department.id', '=', 'tasks.department_assignment_id')
            ->join('person', 'person.id', '=', 'tasks.assignment_id')
            ->join('task_status', 'task_status.id', '=', 'tasks.status_id')
            ->leftjoin('colors', 'colors.id', '=', 'tasks.color_id')
            ->where('tasks.budget_allocation', '>', '0')
            // ->whereRaw('datediff(tasks.due_date, CURRENT_DATE) < 0')
            // ->where('tasks.progress', '<', 1)
            ->when($user_department, function ($query, $user_department) {
                return $query->where('tasks.department_assignment_id', $user_department);
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

        return view('main.budget.utilization', [
            // 'count' => $count,
            'taskData'  => $taskData,
            // 'eventData' => $eventData,
        ]);
    } //budgetUtilization

    public function showBudget()
    {

        $org_budget = DB::table('org_budget')
            ->join('hr_organization', 'hr_organization.id', 'org_budget.org_id')
            ->join('budget_name', 'budget_name.id', 'org_budget.budget_name_id')
            ->join('global_status', 'global_status.id', 'org_budget.active_flag')
            ->select('hr_organization.name as org_name', 'budget_name.name as budget_name', 'org_budget.*', 'global_status.name as active_flag')
            ->get();

        // dd($org_budget);
        return view('main/budget/list', [
            'org_budget'  => $org_budget,
        ]);
    }

    public function addBudget()
    {
        // $mainData = OrganizationBudget::all;
        $hr_org = HROrganization::all();
        $budget_name = BudgetName::all();
        $active_flag = GlobalStatus::all();

        // $count = $eventData->count();
        return view('main.budget.add', [
            'hr_org' => $hr_org,
            'budget_name' => $budget_name,
            'active_flag' => $active_flag,
        ]);
    }

    public function editBudget($id)
    {
        // dd('mainEvent');
        $main_data = OrganizationBudget::find($id);
        $hr_org = HROrganization::all();
        $budget_name = BudgetName::all();
        $active_flag = GlobalStatus::all();

        // dd($main_data);

        return view('main.budget.edit', [
            'main_data'         => $main_data,
            'hr_org'            => $hr_org,
            'budget_name'       => $budget_name,
            'active_flag'       => $active_flag,
        ]);
    } // editBudget

    public function createBudget(Request $request)
    {
        // dd('createEvent');
        $user_id = Auth::user()->id;
        $ob = new OrganizationBudget;


        $ob->org_id = 1; // $request->org_id;
        $ob->budget_name_id = $request->budget_name;
        $ob->type = $request->type;
        $ob->budget_amount = $request->budget_allocation;
        $ob->date_from = Carbon::createFromFormat('d/m/Y', $request->date_from);
        $ob->date_to = Carbon::createFromFormat('d/m/Y', $request->date_to);
        $ob->active_flag =  $request->active_flag;
        $ob->updated_by = $user_id;
        $ob->created_by = $user_id;

        $ob->save();

        $notification = array(
            'message'       => 'Budget setup updated successfully',
            'alert-type'    => 'success'
        );

        // Toastr::success('Has been add successfully :)','Success');
        return redirect()->route('main.budget.list')->with($notification);
    } // createBudget

    public function updateBudget(Request $request)
    {
        // dd('createEvent');
        $user_id = Auth::user()->id;
        $ob = OrganizationBudget::find($request->id);

        $ob->org_id = $request->org_id;
        $ob->budget_name_id = $request->budget_name_id;
        $ob->type = $request->type;
        $ob->budget_amount = $request->budget_amount;
        $ob->date_from = Carbon::createFromFormat('d/m/Y', $request->date_from);
        $ob->date_to = Carbon::createFromFormat('d/m/Y', $request->date_to);
        $ob->active_flag =  $request->active_flag;
        $ob->updated_by = $user_id;

        $ob->save();

        $notification = array(
            'message'       => 'Budget setup updated successfully',
            'alert-type'    => 'success'
        );

        // Toastr::success('Has been add successfully :)','Success');
        return redirect()->route('main.budget.list')->with($notification);
    } // updateBudget

    public function deleteBudget($id)
    {
        //  dd('deletLocation');
        OrganizationBudget::where('id', '=', $id)->delete();

        $notification = array(
            'message'       => 'Budget setup deleted successfully',
            'alert-type'    => 'success'
        );

        // Toastr::success('Has been add successfully :)','Success');
        return redirect()->route('main.budget.list')->with($notification);
    }


    public function showFamBudget()
    {

        $data = BudgetFunctionalAreaMapping::join('budget_name', 'budget_name.id', 'budget_fa_mapping.budget_name_id')
            ->join('global_status', 'global_status.id', 'budget_fa_mapping.active_flag')
            ->join('functional_areas', 'functional_areas.id', 'budget_fa_mapping.fa_name_id')
            ->select('budget_fa_mapping.id','budget_fa_mapping.active_flag as active_flag_id', 'functional_areas.name as fa_name', 'budget_name.name as budget_name', 'global_status.name as active_flag')
            ->get();

        // dd($org_budget);
        return view('main/budget/fam-list', [
            'data'  => $data,
        ]);
    }

    public function addFamBudget()
    {
        // $mainData = OrganizationBudget::all;
        $fa = FunctionalArea::all();
        $budget_name = BudgetName::all();
        $active_flag = GlobalStatus::all();

        // $count = $eventData->count();
        return view('main.budget.fam-add', [
            'fa' => $fa,
            'budget_name' => $budget_name,
            'active_flag' => $active_flag,
        ]);
    }

    public function createFamBudget(Request $request)
    {
        // dd('createEvent');
        $user_id = Auth::user()->id;
        $ob = new BudgetFunctionalAreaMapping();


        // $ob->org_id = 1; // $request->org_id;
        $ob->fa_name_id = $request->fa_name;
        $ob->budget_name_id = $request->budget_name;
        $ob->active_flag =  1; //$request->active_flag;
        $ob->updated_by = $user_id;
        $ob->created_by = $user_id;

        $ob->save();

        $notification = array(
            'message'       => 'Budget/Functional Area mapping created successfully',
            'alert-type'    => 'success'
        );

        // Toastr::success('Has been add successfully :)','Success');
        return redirect()->route('main.budget.fam.list')->with($notification);
    } // createBudget

    public function editFamBudget($id)
    {
        // dd('mainEvent');
        $mapping = BudgetFunctionalAreaMapping::find($id);
        $fa = FunctionalArea::all();
        $budget_name = BudgetName::all();
        $active_flag = GlobalStatus::all();

        // dd($main_data);

        return view('main.budget.fam-edit', [
            'mapping'         => $mapping,
            'fa'            => $fa,
            'budget_name'       => $budget_name,
            'active_flag'       => $active_flag,
        ]);
    } // editBudget

    public function updateFamBudget(Request $request)
    {
        // dd('createEvent');
        $user_id = Auth::user()->id;
        $ob = BudgetFunctionalAreaMapping::find($request->id);

        $ob->budget_name_id = $request->budget_name;
        $ob->fa_name_id = $request->fa_name;
        $ob->active_flag =  $request->active_flag;
        $ob->updated_by = $user_id;

        $ob->save();

        $notification = array(
            'message'       => 'Budget/Functional Area mapping updated successfully',
            'alert-type'    => 'success'
        );

        // Toastr::success('Has been add successfully :)','Success');
        return redirect()->route('main.budget.fam.list')->with($notification);
    } // updateFamBudget

    public function deleteFamBudget($id)
    {
        //  dd('deletLocation');
        BudgetFunctionalAreaMapping::where('id', '=', $id)->delete();

        $notification = array(
            'message'       => 'Budget/Functional Area mapping deleted successfully',
            'alert-type'    => 'success'
        );

        // Toastr::success('Has been add successfully :)','Success');
        return redirect()->route('main.budget.fam.list')->with($notification);
    } //deleteFamBudget

    public function createHROrganization(Request $request)
    {
        // dd('mainEvent');
        $validate_status = true;
        $validate_message = 'Organization created successfully';
        $lastInsertId = 0;

        $rules = [
            'name' => 'unique:hr_organization',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $validate_status = false;
            $validate_message = $request->name . ' already exists';
        } else {

            $op = new HROrganization();

            $op->name = $request->name;
            $op->active_flag = "1";

            $op->save();

            $notification = array(
                'message'       => 'Organization created successfully',
                'alert-type'    => 'success'
            );

            $lastInsertId = $op->id;
        }
        $valid['success'] = $validate_status;
        $valid['messages'] = $validate_message;
        $valid['lastInsertId'] = $lastInsertId;
        $valid['name'] = $request->name;

        // $response = ["retData"  => $data_arr];
        return response()->json($valid);

        // Toastr::success('Has been add successfully :)','Success');
        // return redirect()->route('main.setup.category')->with($notification);
    } // createHROrganization

    public function createBudgetName(Request $request)
    {
        // dd('mainEvent');
        $validate_status = true;
        $validate_message = 'Budget created successfully';
        $lastInsertId = 0;

        $rules = [
            'name' => 'unique:budget_name',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $validate_status = false;
            $validate_message = $request->name . ' already exists';
        } else {

            $op = new BudgetName();

            $op->name = $request->name;
            $op->active_flag = "1";

            $op->save();

            $notification = array(
                'message'       => 'Budget created successfully',
                'alert-type'    => 'success'
            );

            $lastInsertId = $op->id;
        }
        $valid['success'] = $validate_status;
        $valid['messages'] = $validate_message;
        $valid['lastInsertId'] = $lastInsertId;
        $valid['name'] = $request->name;

        // $response = ["retData"  => $data_arr];
        return response()->json($valid);

        // Toastr::success('Has been add successfully :)','Success');
        // return redirect()->route('main.setup.category')->with($notification);
    } // createBudget


}
