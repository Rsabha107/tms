<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;

use App\Models\Event;
use Carbon\Carbon;


class EventController extends Controller
{

    protected $UtilController;


    public function __construct(UtilController $UtilController)
    {
        $this->UtilController = $UtilController;
    }

    public function showCalendar()
    {

        return view('/tracki/calendar/calendar');
    }

    public function showCalendarData()
    {
        // $record_type = Crypt::decrypt($rt);
        // $record_type = Session::get('record_type');
        // $record_type = Session::get('record_type');
        $eventData = Event::join('event_status', 'event_status.id', '=', 'events.event_status')
            ->join('event_planner', 'event_planner.id', '=', 'events.planner_id')
            ->join('project_type', 'project_type.id', '=', 'events.project_type_id')
            // ->where('record_type','=', $record_type)
            ->whereNull('archived')
            ->orderBy('events.start_date')
            ->get(([
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
                'project_type.name as project_type',
            ]));
        $count = $eventData->count();
        // dd($eventData);
        $data_arr = [];

        $text_color_array = array("text-info", "text-warning", "text-primary","text-secondary", "text-dark");

        foreach ($eventData as $key => $record) {

            if ($record->status == 'Completed'){
                $text_color = "text-success";
            } else {
                $random_key = array_rand($text_color_array);
                $text_color = $text_color_array[$random_key];
            }

            $progress = 0;
            $taskCount = DB::table('tasks')
                ->where('event_id', '=', $record->id)->count();

            $budget_details = $this->UtilController->getEventBudgetDetails($record->id);

            $sumofprogresstask = $this->UtilController->getSumTaskProgress($record->id);

            // dd($sumofprogresstask->sum_progress);

            if ($taskCount) {
                $progress = round(($sumofprogresstask->sum_progress / $taskCount), 2);
            }

            $remaining_budget = $budget_details->eventbudget - $budget_details->task_total_budget;

            // $data_arr_["task_count"] = $taskCount;
            $end_date = Carbon::createFromFormat('Y-m-d', $record->end_date)->subDays(1);
            $end_date = Carbon::parse($record->end_date)->format('Y-m-d');

            $data_arr[] = [
                "id"                => $record->id,
                "title"             => $record->name.' ('. $record->status.')',
                "status"            => $record->status,
                "planner"           => $record->planner,
                "start"             => $record->start_date . ' 08:00:00',
                "end"               => $record->end_date . ' 23:59:59',
                "budget_allocation" => $record->budget_allocation,
                "progress"          => $progress * 100,
                "task_count"        => $taskCount,
                "remaining_budget"  => $remaining_budget,
                "description"       => $record->description,
                "project_type"      => $record->project_type_id,
                "success"           => true,
                "className"         => $text_color,

            ];

            // $data_arr += ["task_count"  => $taskCount];
            // array_push($data_arr,
            //    ["task_count"  => $taskCount],
            // );
        }
        //   dd($data_arr);
        return response()->json($data_arr);
    }  //showCalendarData

}
