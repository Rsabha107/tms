<?php

namespace App\Http\Controllers;

use App\Models\Priority;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PriorityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        {
            return view('tracki.setup.priority.list');
        }
    }

    public function get($id)
    {
        $priority = Priority::findOrFail($id);
        return response()->json(['priority' => $priority]);
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
                // dd('mainEvent');
                $op = new Priority();

                $rules = [
                    'title' => 'required',
                    'color' => 'required',
                ];

                $validator = Validator::make($request->all(), $rules);

                // dd($validator);

                if ($validator->fails()) {
                    Log::info($validator->errors());
                    $error = true;
                    $message = 'Priority couldn\'t created' . $op->id;
                } else {

                    $error = false;
                    $message = 'Priority created .' . $op->id;

                    $op->title = $request->title;
                    $op->color = $request->color;
                    $op->active_flag = "1";
                    $op->save();
                }

                return response()->json(['error' => $error, 'message' => $message]);
    }

    public function list()
    {
        $search = request('search');
        $sort = (request('sort')) ? request('sort') : "id";
        $order = (request('order')) ? request('order') : "DESC";
        $priority = Priority::orderBy($sort, $order);

        if ($search) {
            $priority = $priority->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('id', 'like', '%' . $search . '%');
            });
        }
        $total = $priority->count();
        $priority = $priority
            ->paginate(request("limit"))
            ->through(
                fn ($priority) => [
                    'id' => $priority->id,
                    'title' => '<div class="align-middle white-space-wrap fw-bold fs-8">' . $priority->title . '</div>',
                    'color' => '<span class="badge badge-phoenix badge-phoenix-' . $priority->color . '">' . $priority->title . '</span>',
                    'created_at' => format_date($priority->created_at,  'H:i:s'),
                    'updated_at' => format_date($priority->updated_at, 'H:i:s'),
                ]
            );


        return response()->json([
            "rows" => $priority->items(),
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
        $formFields = $request->validate([
            'id' => ['required'],
            'title' => ['required'],
            'color' => ['required']
        ]);

        $status = Priority::findOrFail($request->id);

        // dd($status);

        if ($status->update($formFields)) {
            return response()->json(['error' => false, 'message' => 'Status updated     .', 'id' => $status->id]);
        } else {
            return response()->json(['error' => true, 'message' => 'Status couldn\'t updated.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function delete($id)
    {
        Priority::where('id', '=', $id)->delete();

        $notification = array(
            'message'       => 'File deleted successfully',
            'alert-type'    => 'success'
        );

        // dd($taskId);

        return response()->json([
            'error' => false,
            'message' => 'Status deleted successfully',
        ]);

        // Toastr::success('Has been add successfully :)','Success');
        // return Redirect::route('tracki.task.list', $task->event_id)->with($notification);
        // return redirect()->back()->with($notification);
    } // delete
}
