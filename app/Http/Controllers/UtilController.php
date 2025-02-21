<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Status;
use App\Models\Task;
use App\Models\TaskFileUpload;
use App\Models\TaskNote;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Log;


class UtilController extends Controller
{
    //
    public static function getEventBudgetDetails($id)
    {
        Log::info('UtilController::getEventBudgetDetails with id: '.$id);
        // dd($id);
        $eventBudget = Event::find($id)?->budget_allocation;
        $totalTaskBudgetUsed = DB::table('tasks')
            ->select(DB::raw("sum(tasks.actual_budget_allocated) as sum_actual_budget"))
            ->where('event_id', '=', $id)
            ->get();

        $data_arr = [];

        $data_arr = (object) [
            "eventbudget" => $eventBudget,
            "task_total_budget" => $totalTaskBudgetUsed[0]->sum_actual_budget,
        ];

        return $data_arr;
    }

    public function getSumTaskProgress($id)
    {
        $user_department = auth()->user()->department_assignment_id;

        $sumTaskProgress = DB::table('tasks')
            ->select(DB::raw("sum(tasks.progress) as sum_progress"))
            ->where('event_id', '=', $id)
            ->when($user_department, function ($query, $user_department) {
                return $query->where('tasks.department_assignment_id', $user_department);
            })
            ->first();

        return $sumTaskProgress;
    }

    public function isTasksCompleted($id)
    {
        $status = false;

        // $taskCount = DB::table('tasks')
        //     ->where('event_id', '=', $id)
        //     ->count();

        $task = Task::where('event_id', '=', $id);

        $taskCount = $task->count();
        $sumTaskProgress = $task->sum('progress');

        if ($taskCount == 0) {
            $completionPercent = 0;
        } else {
            $completionPercent = $sumTaskProgress / $taskCount;
        }

        if ($completionPercent == '1') {
            $status = true;
            Log::info('task completion: ' . $sumTaskProgress / $taskCount);
        }

        $data = [
            'status' => $status,
            'progress' => $completionPercent,
        ];

        return $data;
    }

    public static function taskNotesExists($id){

        $ret = false;
        $taskNotes = TaskNote::where('task_notes.task_id',$id)->exists();

        if ($taskNotes) {
        Log::alert('taskNotesExists Task id: '.$id.' Yes');
            $ret = true;
        }

        return($ret);
    }

    public static function taskFilesExists($id){

        $ret = false;
        $taskFiles = TaskFileUpload::where('task_files.task_id',$id)->exists();

        if ($taskFiles) {
            $ret = true;
        }

        return($ret);
    }

    public function updateProjectStatus($id)
    {
        $is_project_completed = $this->isTasksCompleted($id);
        // dd($is_project_completed);
        $status = Status::all();
        Log::info($is_project_completed);
        if ($is_project_completed['status']) {
            // Log::info('project: ' . $id . ' is ' . config('tracki.project_status.completed'));
            Event::where('id', $id)
                ->update([
                    'event_status' => config('tracki.project_status.completed'),
                ]);
        } else {
            // Log::info('project: ' . $id . ' is ' . config('tracki.project_status.completed'));

            Event::where('id', $id)
                ->update([
                    'event_status' => config('tracki.project_status.inprogress'),
                ]);
        }
    }

    public static function getDateDiff($d1, $d2)
    {

        $start_date_d = Carbon::parse($d1)->format('d/m/y');
        $end_date_d = Carbon::parse($d2);
        $duration =  now()->diffInDays($end_date_d, false);

        return ($duration);
    }
    public static function getQrCode($id)
    {
        $qr_code = QrCode::size(50)->generate($id);
        return ($qr_code);
    }

    public static function getAssignedToName($id)
    {

        $id_array = explode(",", $id);

        $assignedTo = Person::whereIn('id', $id_array)
            //  ->where('source', '=','ASGTO')
            ->get([
                'person.name as assigned_to_name',
                'person.email_address',
            ]);

        return ($assignedTo);
    }

    public static function getAssignedToEmail($id)
    {

        $id_array = explode(",", $id);

        $assignedToEmail = Person::whereIn('id', $id_array)->pluck('email_address')->toArray();


        return ($assignedToEmail);
    }
}
