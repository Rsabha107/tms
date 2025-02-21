<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TagsController extends Controller
{
    //
    public function index()
    {
        $tags = Tag::all();
        return view('tracki.setup.tags.list', compact('tags'));
    }

    public function get($id)
    {
        $tags = Tag::findOrFail($id);
        return response()->json(['tags' => $tags]);
    }

    public function update(Request $request)
    {
        $formFields = $request->validate([
            'id' => ['required'],
            'title' => ['required'],
            'color' => ['required']
        ]);

        $tags = Tag::findOrFail($request->id);

        // dd($tags);

        if ($tags->update($formFields)) {
            return response()->json(['error' => false, 'message' => 'Tag updated     .', 'id' => $tags->id]);
        } else {
            return response()->json(['error' => true, 'message' => 'Tag couldn\'t updated.']);
        }
    }

    public function store(Request $request)
    {
        // dd('mainEvent');
        $op = new Tag();

        $rules = [
            'title' => 'required',
            'color' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        // dd($validator);

        if ($validator->fails()) {
            Log::info($validator->errors());
            $error = true;
            $message = 'Tag couldn\'t created id' . $op->id;
        } else {

            $error = false;
            $message = 'Tag created .' . $op->id;

            $op->title = $request->title;
            $op->color = $request->color;
            $op->active_flag = "1";
            $op->save();
        }

        return response()->json(['error' => $error, 'message' => $message]);
    } // store


    public function list()
    {
        $search = request('search');
        $sort = (request('sort')) ? request('sort') : "id";
        $order = (request('order')) ? request('order') : "DESC";
        $tags = Tag::orderBy($sort, $order);

        if ($search) {
            $tags = $tags->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('id', 'like', '%' . $search . '%');
            });
        }
        $total = $tags->count();
        $tags = $tags
            ->paginate(request("limit"))
            ->through(
                fn ($tags) => [
                    'id' => $tags->id,
                    'title' => '<div class="align-middle white-space-wrap fw-bold fs-8">' . $tags->title . '</div>',
                    'color' => '<span class="badge badge-phoenix" style="background-color:'.$tags->color.';">' . $tags->title . '</span>',
                    'created_at' => format_date($tags->created_at,  'H:i:s'),
                    'updated_at' => format_date($tags->updated_at, 'H:i:s'),
                ]
            );


        return response()->json([
            "rows" => $tags->items(),
            "total" => $total,
        ]);
    }

    public function delete($id)
    {
        Tag::where('id', '=', $id)->delete();

        $notification = array(
            'message'       => 'File deleted successfully',
            'alert-type'    => 'success'
        );

        // dd($taskId);

        return response()->json([
            'error' => false,
            'message' => 'Tag deleted successfully',
        ]);

        // Toastr::success('Has been add successfully :)','Success');
        // return Redirect::route('tracki.task.list', $task->event_id)->with($notification);
        // return redirect()->back()->with($notification);
    } // taskFileDelete


}
