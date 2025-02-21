<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

// use Illuminate\Support\Facades\Redirect;

class DesignationController extends Controller
{
    //
    public function index()
    {
        $designations = Designation::all();
        $departments = Department::all();
        return view('tracki.setup.designation.list', compact('departments', 'designations'));
    }

    public function get($id)
    {
        $designation = Designation::findOrFail($id);
        return response()->json(['designation' => $designation]);
    }

    public function update(Request $request)
    {
        $formFields = $request->validate([
            'id' => ['required'],
            'name' => ['required'],
            'department_id' => 'nullable',
        ]);

        $designation = Designation::findOrFail($request->id);

        // dd($designation);

        if ($designation->update($formFields)) {
            return response()->json(['error' => false, 'message' => 'Designation updated successfully.', 'id' => $designation->id]);
        } else {
            return response()->json(['error' => true, 'message' => 'Designation couldn\'t updated.']);
        }
    }

    public function list()
    {
        $search = request('search');
        $sort = (request('sort')) ? request('sort') : "id";
        $order = (request('order')) ? request('order') : "DESC";
        $designation = Designation::orderBy($sort, $order);

        if ($search) {
            $designation = $designation->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('id', 'like', '%' . $search . '%');
            });
        }
        $total = $designation->count();
        $designation = $designation->paginate(request("limit"))->through(function ($designation) {

        $department = Department::find($designation->department_id);

            return  [
                'id' => $designation->id,
                'name' => '<div class="align-middle white-space-wrap fw-bold fs-8">' . $designation->name . '</div>',
                'department_id' => '<div class="align-middle white-space-wrap fw-bold fs-8">' . $department?->name . '</div>',
                'created_at' => format_date($designation->created_at,  'H:i:s'),
                'updated_at' => format_date($designation->updated_at, 'H:i:s'),
            ];
        });

        return response()->json([
            "rows" => $designation->items(),
            "total" => $total,
        ]);
    }

    public function store(Request $request)
    {
        //
        // dd($request);
        $user_id = Auth::user()->id;
        $designation = new Designation();

        $rules = [
            'name' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            Log::info($validator->errors());
            $error = true;
            $message = 'Designation could not be created';
        } else {

            $error = false;
            $message = 'Designation created succesfully.' . $designation->id;

            $designation->name = $request->name;
            $designation->department_id = $request->department_id;
            $designation->creator_id = $user_id;
            $designation->active_flag = 1;

            $designation->save();


        }

        $notification = array(
            'message'       => 'Designation created successfully',
            'alert-type'    => 'success'
        );

        return response()->json(['error' => $error, 'message' => $message]);

    }

    public function delete($id)
    {
        $ws = Designation::findOrFail($id);
        $ws->delete();

        $error = false;
        $message = 'Designation deleted succesfully.';

        $notification = array(
            'message'       => 'Designation deleted successfully',
            'alert-type'    => 'success'
        );

        return response()->json(['error' => $error, 'message' => $message]);
        // return redirect()->route('tracki.setup.workspace')->with($notification);
    } // delete

}
