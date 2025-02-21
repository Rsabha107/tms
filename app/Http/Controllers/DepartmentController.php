<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Department;
use App\Models\Person;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

// use Illuminate\Support\Facades\Redirect;

class DepartmentController extends Controller
{
    //
    public function index()
    {
        $departments = Department::all();

        return view('tracki.setup.department.list', compact('departments'));
    }

    public function get($id)
    {
        $department = Department::findOrFail($id);
        return response()->json(['department' => $department]);
    }

    public function update(Request $request)
    {
        $formFields = $request->validate([
            'id' => ['required'],
            'name' => ['required'],
            'parent_id' => 'nullable',

        ]);

        $department = Department::findOrFail($request->id);

        // dd($department);

        if ($department->update($formFields)) {
            return response()->json(['error' => false, 'message' => 'Department updated successfully.', 'id' => $department->id]);
        } else {
            return response()->json(['error' => true, 'message' => 'Department couldn\'t updated.']);
        }
    }

    public function list()
    {
        $search = request('search');
        $sort = (request('sort')) ? request('sort') : "id";
        $order = (request('order')) ? request('order') : "DESC";
        $department = Department::orderBy($sort, $order);

        if ($search) {
            $department = $department->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('id', 'like', '%' . $search . '%');
            });
        }
        $total = $department->count();
        $department = $department->paginate(request("limit"))->through(function ($department) {

        $department_parent = Department::find($department->parent_id);

            return  [
                'id' => $department->id,
                'name' => $department->name,
                'parent_id' =>$department_parent?->name,
                'created_at' => format_date($department->created_at,  'H:i:s'),
                'updated_at' => format_date($department->updated_at, 'H:i:s'),
            ];
        });

        return response()->json([
            "rows" => $department->items(),
            "total" => $total,
        ]);
    }

    public function store(Request $request)
    {
        //
        // dd($request);
        $user_id = Auth::user()->id;
        $department = new Department();

        $rules = [
            'name' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            Log::info($validator->errors());
            $error = true;
            $message = 'Department could not be created';
        } else {

            $error = false;
            $message = 'Department created succesfully.' . $department->id;

            $department->name = $request->name;
            $department->parent_id = $request->parent_id;
            $department->creator_id = $user_id;
            $department->active_flag = 1;

            $department->save();


        }

        $notification = array(
            'message'       => 'Department created successfully',
            'alert-type'    => 'success'
        );

        return response()->json(['error' => $error, 'message' => $message]);

    }

    public function delete($id)
    {
        $ws = Department::findOrFail($id);
        $ws->delete();

        $error = false;
        $message = 'Department deleted succesfully.';

        $notification = array(
            'message'       => 'Department deleted successfully',
            'alert-type'    => 'success'
        );

        return response()->json(['error' => $error, 'message' => $message]);
        // return redirect()->route('tracki.setup.workspace')->with($notification);
    } // delete

}
