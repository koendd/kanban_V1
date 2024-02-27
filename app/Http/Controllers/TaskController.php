<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Builder;

use App\Models\KanbanBoard;
use App\Models\Task;
use App\Models\System;
use App\Models\SubSystem;
use App\Models\Applicant;
use App\Models\Priority;
use App\Models\Status;
use App\Models\TaskType;
use App\Models\User;
use App\Models\TaskLog;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(KanbanBoard $kanbanBoard, Request $request)
    {
        $searchString = $request['text_search'];
        $orderBy = "";

        $taskQuery = Task::Query();
        $taskQuery->whereRelation('System', 'kanban_board_id', '=', $kanbanBoard->id);

        if($request->has('text_search')) {
            $taskQuery->where(function (Builder $query) use ($searchString) {
                $query->where('tasks.name', 'like', '%' . $searchString . '%');
                $query->orWhere('tasks.description', 'like', '%' . $searchString . '%');
            });
        }

        $taskQuery->join('systems', 'systems.id', '=', 'tasks.system_id');
        $taskQuery->leftjoin('sub_systems', 'sub_systems.id', '=', 'tasks.sub_system_id');
        $taskQuery->join('priorities', 'priorities.id', '=', 'tasks.priority_id');
        $taskQuery->join('statuses', 'statuses.id', '=', 'tasks.status_id');
        $taskQuery->join('task_types', 'task_types.id', '=', 'tasks.task_type_id');
        $taskQuery->join('applicants', 'applicants.id', '=', 'tasks.applicant_id');

        if($request->has('_token')) {
            if($request->has('orderBy')){
                $orderBy = $request['orderBy'];
            }

            if($request->has('system_id')) {
                if(System::where('id', $request['system_id'])->exists()) {
                    $taskQuery->where('systems.id', '=', $request['system_id']);
                }

                if($request->has('sub_system_id')) {
                    if(SubSystem::where('id', $request['sub_system_id'])->exists()) {
                        $taskQuery->where('sub_systems.id', '=', $request['sub_system_id']);
                    }
                }
            }

            if($request->has('status_id')) {
                if(Status::where('id', $request['status_id'])->exists()) {
                    $taskQuery->where('statuses.id', '=', $request['status_id']);
                }
            }

            if($request->has('priority_id')) {
                if(Priority::where('id', $request['priority_id'])->exists()) {
                    $taskQuery->where('priorities.id', '=', $request['priority_id']);
                }
            }

            if($request->has('task_type_id')) {
                if(TaskType::where('id', $request['task_type_id'])->exists()) {
                    $taskQuery->where('task_types.id', '=', $request['task_type_id']);
                }
            }
        }
            
        if($orderBy == 'name') {
            $taskQuery->orderBy('tasks.name', 'asc');
        } elseif($orderBy == 'system'){
            $taskQuery->orderBy('systems.name_full', 'asc');
            $taskQuery->orderBy('sub_systems.name_full', 'asc');
        } elseif($orderBy == 'priority'){
            $taskQuery->orderBy('priorities.order_number', 'asc');
        } elseif($orderBy == 'status'){
            $taskQuery->orderBy('statuses.order_number', 'asc');
        } elseif($orderBy == 'task_type'){
            $taskQuery->orderBy('task_types.name', 'asc');
        } elseif($orderBy == 'applicant'){
            $taskQuery->orderBy('applicants.name', 'asc');
        } else {
            $taskQuery->orderBy('tasks.id', 'desc');
        }
        
        $taskQuery->select('tasks.id', 'tasks.name as task_name', 'tasks.description as task_description', 'systems.name_full as system_name', 'sub_systems.name_full as sub_system_name', 'priorities.name as priority_name', 'statuses.name as status_name', 'task_types.name as task_type_name', 'applicants.name as applicant_name');
        $tasks = $taskQuery->get();

        $systems = System::where('kanban_board_id', $kanbanBoard->id)->orderBy('name_short', 'asc')->get();
        $statuses = Status::where('kanban_board_id', $kanbanBoard->id)->orderBy('order_number', 'asc')->get();
        $priorities = Priority::where('kanban_board_id', $kanbanBoard->id)->orderBy('order_number', 'asc')->get();
        $taskTypes = TaskType::where('kanban_board_id', $kanbanBoard->id)->orderBy('name', 'asc')->get();

        return view('Tasks.index', compact(['kanbanBoard', 'tasks', 'systems', 'statuses', 'priorities', 'taskTypes', 'request', 'searchString', 'orderBy']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(KanbanBoard $kanbanBoard)
    {
        $systems = System::where('kanban_board_id', $kanbanBoard->id)->orderBy('name_short', 'asc')->get();
        $applicants = Applicant::where('kanban_board_id', $kanbanBoard->id)->orderBy('name', 'asc')->get();
        $priorities = Priority::where('kanban_board_id', $kanbanBoard->id)->orderBy('order_number', 'asc')->get();
        $statuses = Status::where('kanban_board_id', $kanbanBoard->id)->orderBy('order_number', 'asc')->get();
        $types = TaskType::where('kanban_board_id', $kanbanBoard->id)->orderBy('name', 'asc')->get();
        $users = User::orderBy('name', 'asc')->get();
        return view('Tasks.create', compact(['kanbanBoard', 'systems', 'applicants', 'priorities', 'statuses', 'types', 'users']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KanbanBoard $kanbanBoard, Request $request)
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

        return redirect()->route('home', $kanbanBoard->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Kanbanboard $kanbanBoard, Task $task)
    {
        //dd($task->TaskLogs->first()->Timestamp);
        return view('Tasks.show', compact(['kanbanBoard', 'task']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Kanbanboard $kanbanBoard, Task $task)
    {
        $systems = System::where('kanban_board_id', $kanbanBoard->id)->orderBy('name_short', 'asc')->get();
        $subSystems = SubSystem::where('system_id', $task->system_id)->get();
        $applicants = Applicant::where('kanban_board_id', $kanbanBoard->id)->orderBy('name', 'asc')->get();
        $priorities = Priority::where('kanban_board_id', $kanbanBoard->id)->orderBy('order_number', 'asc')->get();
        $statuses = Status::where('kanban_board_id', $kanbanBoard->id)->orderBy('order_number', 'asc')->get();
        $types = TaskType::where('kanban_board_id', $kanbanBoard->id)->orderBy('name', 'asc')->get();
        $users = User::orderBy('name', 'asc')->get();
        return view('Tasks.edit', compact(['kanbanBoard', 'task', 'systems', 'subSystems', 'applicants', 'priorities', 'statuses', 'types', 'users']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Kanbanboard $kanbanBoard, Request $request, Task $task)
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

        $task->name = $request->name;
        $task->description = $request->description;
        $task->deadline = $request->deadline;
        $task->system_id = $request->system_id;
        $task->sub_system_id = $request->sub_system_id;
        $task->applicant_id = $request->applicant_id ?? null;
        $task->priority_id = $request->priority_id;
        $task->status_id = $request->status_id;
        $task->task_type_id = $request->task_type_id;
        $task->save();

        if(array_key_exists('user_ids', $validatedData)) {
            // add new user if they not already exists
            foreach($validatedData['user_ids'] as $user_id) {
                if(!$task->Users->contains($user_id)) {
                    $task->Users()->attach($user_id);
                }
            }

            // remove an existing user
            foreach($task->Users as $user) {
                if(!in_array($user->id, $validatedData['user_ids'])) {
                    $task->Users()->detach($user->id);
                }
            }
        } else {
            foreach($task->Users as $user) {
                $task->Users()->detach($user_id);
            }
        }

        return redirect()->route('home', $kanbanBoard->id);
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

    /**
     * Show the form for transfering the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function transfer(Kanbanboard $kanbanBoard, Task $task)
    {
        $kanbanBoards = KanbanBoard::orderBy('name', 'asc')->get();
        
        return view('Tasks.transfer', compact(['kanbanBoard', 'task', 'kanbanBoards']));
    }

    /**
     * move the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function move(Kanbanboard $kanbanBoard, Request $request, Task $task)
    {
        /*$validatedData = $request->validate([
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
        ]);*/

        $task->system_id = $request->system_id;
        $task->sub_system_id = $request->sub_system_id;
        $task->applicant_id = $request->applicant_id ?? null;
        $task->priority_id = $request->priority_id;
        $task->status_id = $request->status_id;
        $task->task_type_id = $request->task_type_id;
        $task->save();

        return redirect()->route('home', $request->kanban_board_id);
    }

    /**
     * Show the form for editing the specified resource task_log.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editLog(Kanbanboard $kanbanBoard, TaskLog $taskLog) {
        // don't allow this action for the root and system user
        if($taskLog->user_id != Auth::id()) {
            abort(403);
        }

        return view('Tasks.editLog', compact(['kanbanBoard', 'taskLog']));
    }

    /**
     * Update the specified task_log resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateLog(Kanbanboard $kanbanBoard, Request $request, TaskLog $taskLog)
    {
        $taskLog->description = $request['description'];
        $taskLog->save();
        $task = $taskLog->Task;
        
        return redirect()->route('showTask', compact(['kanbanBoard', 'task']));
    }
}
