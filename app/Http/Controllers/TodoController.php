<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\Todo;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $workspace_id = session()->get('workspace_id')?session()->get('workspace_id'):0;
        $workspace = Workspace::find($workspace_id);
        $todos = Todo::all();
        $users = $workspace?->users;

        return view('tracki.todo.list', [
            'users' => $users,
            'todos' => $todos,
        ]);
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
        $workspace_id = session()->get('workspace_id');

        $user_id = Auth::user()->id;
        $todo = new Todo();


        $todo->workspace_id = $workspace_id; //($request->workspace_id? 1: $request->workspace_id);
        $todo->title = $request->title;
        $todo->description = $request->description;
        $todo->priority_id = $request->priority_id;
        // $todo->status_id = $request->status_id;
        $todo->is_completed = 0; //$request->is_completed;
        $todo->creator_id = $user_id;

        // dd($request->assigned_to_id);
        $todo->save();


        foreach ($request->assigned_to_id as $key => $data) {
            $todo->users()->attach($request->assigned_to_id[$key]);
        }

        $notification = array(
            'message'       => 'Todo created successfully',
            'alert-type'    => 'success'
        );

        return Redirect::route('tracki.todo.manage')->with($notification);
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
    public function destroy($id)
    {
        //
        //  dd('deletLocation');
        Todo::where('id', '=', $id)->delete();

        $notification = array(
            'message'       => 'Todo deleted successfully',
            'alert-type'    => 'success'
        );

        // Toastr::success('Has been add successfully :)','Success');
        return Redirect::route('tracki.todo.manage')->with($notification);
    }

    public function updateStatus(Request $request)
    {
        $formFields = $request->validate([
            'id' => ['required'],
            'status' => ['required']

        ]);
        $id = $request->id;
        $status = $request->status;
        $op = Todo::findOrFail($id);
        $op->is_completed = $status;
        // $statusText = $status == 1 ? 'Completed' : 'Pending';
        if ($op->save()) {
            return response()->json(['error' => false, 'message' => 'Todo status updated successfully.']);
        } else {
            return response()->json(['error' => true, 'message' => 'Todo status couldn\'t updated.']);
        }
    }  //update_status
}
