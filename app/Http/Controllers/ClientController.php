<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    //
    public function index()
    {
        $clients = Client::all();

        return view('tracki.clients.all', [
            'clients' => $clients,
        ]);
    }

    public function get()
    {

        // $task = Task::find(13);

        // dd($task->files->count());

        $user_department = auth()->user()->department_assignment_id;

        $workspace = session()->get('workspace_id');

        $search = request('search');
        $sort = (request('sort')) ? request('sort') : "id";
        $order = (request('order')) ? request('order') : "DESC";

        // Log::alert('allTaskDt project_id: ' . $project_id);
        // Log::alert('allTaskDt status_id: ' . $status_id);
        // Log::alert('allTaskDt person_id: ' . $person_id);
        // Log::alert('allTaskDt department_id: ' . $department_id);

        $where = [];

        // $clientData = Client::all();
        $clientData = new Client();

            $clientData = $clientData->when($search, function ($query) use ($search) {
                return $query->where('first_name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%')
                    ->orWhere('company', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            });


        // return Datatables::of($clientData)->make(true);

        $total = $clientData->count();

        $clientData = $clientData->orderBy($sort, $order)->paginate(request('limit'))->through(function ($task) {
        $project_count =  $task->projects?->count()?$task->projects->count():0;

            return [
                'id1' => '<div class="ms-3">'.$task->id.'</div>',
                'id' => $task->id,
                'first_name' =>  $task->first_name,
                'last_name' =>  $task->last_name,
                'company' =>  $task->company,
                'email' =>  $task->email,
                'profile' => 'X',
                'phone' =>  $task->phone,
                'projects' => '<div class="col-auto order-md-1"><ul class="navbar-nav navbar-nav-icons flex-row"><li class="nav-item"><a class="nav-link px-2 icon-indicator icon-indicator-primary" href="#!" role="button"><span class="text-body-tertiary" data-feather="shopping-cart" style="height:20px;width:20px;"></span><span class="icon-indicator-number">'.$project_count.'</span></a></li></ul></div>',
                // 'tasks' =>  $task->tasks?->count()?$task->tasks->count():0,
                'status' =>  $task->status,
                'created_at' => format_date($task->created_at,  'H:i:s'),
                'updated_at' => format_date($task->updated_at, 'H:i:s'),

            ];
        });

        return response()->json([
            "rows" => $clientData->items(),
            "total" => $total,
        ]);
    } //get

    public function create(){
        return view('tracki.clients.create');
    }

    public function store(Request $request)
    {
        // dd('mainEvent');
        $workspace_id = session()->get('workspace_id');

        $op = new Client();

        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required|confirmed|min:8|max:16',
        ];

        $validator = Validator::make($request->all(), $rules);

        // dd($validator);

        if ($validator->fails()) {
            Log::info($validator->errors());
            return redirect()->back()
                ->withInput()
                ->withErrors($validator);
        }

        $error = false;
        $message = 'Client created .' . $op->id;

        $op->first_name = $request->first_name;
        $op->last_name = $request->last_name;
        $op->email = $request->email;
        $op->phone = $request->phone;
        $op->password = Hash::make($request->password);
        $op->company = $request->company;
        $op->address = $request->address;
        $op->country = $request->country;
        $op->workspace_id = $workspace_id;
        $op->city = $request->city;
        $op->state = $request->state;
        $op->zipcode = $request->zipcode;
        // $op->require_ev = $request->require_ev;
        $op->status = $request->status;
        $op->save();

        $notification = array(
            'message'       => 'Client created successfully',
            'alert-type'    => 'success'
        );

        return Redirect::route('tracki.client.manage')->with($notification);

    } // store
}
