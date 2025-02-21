<?php

namespace App\Http\Controllers;

use App\Models\AddressType;
use App\Models\Country;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\employeeAddress;
use App\Models\EmployeeFile;
use App\Models\EmployeeType;
use App\Models\Gender;
use App\Models\Language;
use App\Models\MaritalStatus;
use App\Models\Nationality;
use App\Models\Relationship;
use App\Models\Salutation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Route as FacadesRoute;
use Illuminate\Support\Facades\Validator;

class EmployeeAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        //
        // dd($id);
        $emps = Employee::findOrFail($id);
        // dd($emps);
        $countries = Country::all();
        $nationalities = Nationality::all();
        $employee_types = EmployeeType::all();
        $salutations = Salutation::all();
        $genders = Gender::all();
        $marital_statuses = MaritalStatus::all();
        $departments = Department::all();
        $designations = Designation::all();
        $relationships = Relationship::all();
        $addresses = EmployeeAddress::all();
        $address_types = AddressType::all();

        // dd(FacadesRoute::currentRouteName());
        // dd(FacadesRequest::url());
        return view('tracki.employee.address.list', compact(
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
            'addresses',
            'address_types',
        ));
    }


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
        $address_types = AddressType::all();

        // dd(FacadesRoute::currentRouteName());
        // dd(FacadesRequest::url());
        return view('tracki.employee.address.create', compact(
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

    /**
     * add a new resource.
     */
    public function add()
    {
        //
        return view('tracki.employee.address.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $id = Auth::user()->id;
        $op = new employeeAddress();
        // $emp = new Employee();
        $data = new employeeAddress();

        $rules = [
            'employee_address1' => 'required',
            'employee_address_country' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        // dd($validator);

        Log::info($request->all());

        if ($validator->fails()) {
            Log::info($validator->errors());
            $error = true;
            $message = 'Employee Address not create.' . $op->id;
        } else {
            $error = false;
            $message = 'Employee Address created .' . $op->id;

            $op->address_type = $request->employee_address_type;
            $op->employee_id = $request->id;
            $op->address1 = $request->employee_address1;
            $op->address2 = $request->employee_address2;
            $op->city = $request->employee_city;
            $op->state = $request->employee_state;
            $op->zipcode = $request->employee_zipcode;
            $op->country_id = $request->employee_address_country;
            $op->primary_address = $request->employee_address_primary;
            $op->creator_id = $id;

            $op->save();

            // dd($op->number);
        }

        return response()->json(['error' => $error, 'message' => $message]);
    }

    public function list($id)
    {

        // dd('test');
        $search = request('search');
        $sort = (request('sort')) ? request('sort') : "id";
        $order = (request('order')) ? request('order') : "DESC";
        $employee_addresses = employeeAddress::where('employee_id',$id)->orderBy($sort, $order);

        // dd($employee_addresses);


        if ($search) {
            $employee_addresses = $employee_addresses->where(function ($query) use ($search) {
                $query->where('address1', 'like', '%' . $search . '%')
                    ->orWhere('city', 'like', '%' . $search . '%');
            });
        }
        $total = $employee_addresses->count();

        $employee_addresses = $employee_addresses->paginate(request("limit"))->through(function ($employee_addresses) {


            // $profile_url = route('tracki.employee.profile', $employee_addresses->id);

            return [
                'id1' => '<div class="ms-3">' . $employee_addresses->id . '</div>',
                'id' => $employee_addresses->id,
                'address1' =>'<div class="ms-3">'.$employee_addresses->address1.'</div>' ,
                'address2' =>$employee_addresses->address2 ,
                'city' =>$employee_addresses->city ,
                'state' =>$employee_addresses->state ,
                'zipcode' =>$employee_addresses->zipcode ,
                'country' =>$employee_addresses->country?->country_name ,
                'primary_address' => $employee_addresses->primary_address ,
                'created_at' => format_date($employee_addresses->created_at,  'H:i:s'),
                'updated_at' => format_date($employee_addresses->updated_at, 'H:i:s'),
            ];
        });

        return response()->json([
            "rows" => $employee_addresses->items(),
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
        // Log::alert('EmployeeController::update');
        $id = Auth::user()->id;
        $op = Employee::findOrFail($request->id);
        $data = EmployeeFile::where('employee_id', $request->id)->first();

        if (!$data) {
            // Log::info('inside data not defined.  new employeefile');
            $data = new EmployeeFile;
        }

        $op->employee_id = $request->employee_id;
        $op->address1 = $request->address1;
        $op->address2 = $request->address2;
        $op->primary_address = $request->primary_address;
        $op->city = $request->city;
        $op->state = $request->state;
        $op->zipcode = $request->zipcode;
        $op->country_id = $request->country_id;

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
        employeeAddress::where('id', '=', $id)->delete();

        $notification = array(
            'message'       => 'Employee address deleted successfully',
            'alert-type'    => 'success'
        );

        // dd($taskId);

        return response()->json([
            'error' => false,
            'message' => 'Employee address deleted successfully',
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
