<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Task;
use App\Models\System;
use App\Models\Applicant;
use App\Models\Priority;
use App\Models\Status;
use App\Models\TaskType;
use App\Models\User;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $systems = System::orderBy('name_short', 'asc')->get();
        $applicants = Applicant::orderBy('name', 'asc')->get();
        $priorities = Priority::orderBy('order_number', 'asc')->get();
        $statuses = Status::orderBy('order_number', 'asc')->get();
        $types = TaskType::orderBy('name', 'asc')->get();
        $users = User::orderBy('name', 'asc')->get();
        return view('Tasks.create', compact(['systems', 'applicants', 'priorities', 'statuses', 'types', 'users']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string'],
            'description' => ['string', 'nullable'],
            'deadline' => ['date', 'nullable'],
            'system_id' => ['required', 'exists:systems,id'],
            'sub_system_id' => ['nullable', 'exists:sub_systems,id'],
            'applicant_id' => ['nullable', 'exists:applicants,id'],
            'priority_id' => ['required', 'exists:priorities,id'],
            'status_id' => ['required', 'exists:statuses,id'],
            'task_type_id' => ['required', 'exists:task_types,id'],
            'user_ids' => ['array', 'exists:users,id'],
        ]);
        $task = new Task($validatedData);
        $task->creator_id = Auth::id();
        $task->save();

        // add new users if they not already exists
        foreach($validatedData['user_ids'] as $user_id) {
            if(!$task->Users->contains($user_id)) {
                $task->Users()->attach($user_id);
            }
        }

        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
