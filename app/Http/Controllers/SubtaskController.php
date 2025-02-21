<?php

namespace App\Http\Controllers;

use App\Models\Subtask;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SubtaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // dd($request);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'priority_id' => 'required|string',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => 'fields in red are required',
                'title' => null,
                'priority_id' => null,
                'description' => null,
            ]);
        } else {

            $user_id = Auth::user()->id;
            $task = Task::findOrFail($request->parent_task_id);
            $data = new Subtask();


            $data->workspace_id = 0; //($request->workspace_id? 1: $request->workspace_id);
            $data->parent_task_id = $request->parent_task_id;
            $data->title = $request->title;
            $data->description = $request->description;
            $data->priority_id = $request->priority_id;
            // $data->status_id = $request->status_id;
            $data->is_completed = 0; //$request->is_completed;
            $data->creator_id = $user_id;

            $data->save();

            return response()->json([
                'error' => false,
                'message' => 'Subtask added successfully to task ' . $task->name . '.',
                'user_name' => auth()->user()->username, //$data->users->username,
                'subtask_title' => $data->title,
                'subtask_priority_title' => $data->priority->title,
                'subtask_color' => $data->priority->color,
                'create_at' => $data->create_at,
                // 'note_date' => format_date($data->created_at,  'H:i:s'),
                'id' => $data->id
            ]);
        }
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    // *********************************************** task overview Subtasks  *********************************************************************
    public function overview($id)
    {
        // dd('mainEvent');
        // $data = Task::find($id);
        $data = Subtask::leftJoin('users', 'users.id', '=', 'subtasks.creator_id')
            ->leftJoin('priorities', 'priorities.id', '=', 'subtasks.priority_id')
            ->where('parent_task_id', '=', $id)
            ->get([
                'subtasks.id as id',
                'subtasks.title as subtask_title',
                'users.name as subtask_user_name',
                'subtasks.created_at as subtask_created_at',
                'priorities.title as priority_title',
                'priorities.color as priority_color',
                'subtasks.is_completed',
            ]);

        // dd($data);
        return response()->json($data);
    } // overview


    public function updateStatus(Request $request)
    {
        $formFields = $request->validate([
            'id' => ['required'],
            'status' => ['required']

        ]);

        Log::info('insiode SubtaskController::updateStatus');
        Log::info($request->all());

        $id = $request->id;
        $status = $request->status;
        $op = Subtask::findOrFail($id);
        $op->is_completed = $status;
        // $statusText = $status == 1 ? 'Completed' : 'Pending';
        if ($op->save()) {
            return response()->json(['error' => false, 'message' => 'Subtask status updated successfully.']);
        } else {
            return response()->json(['error' => true, 'message' => 'Subtask status couldn\'t updated.']);
        }
    }  //update_status
}
