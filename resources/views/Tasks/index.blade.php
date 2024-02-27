@extends('Layouts.app')

@section('title', 'Tasks overview')

@section('content')
<div >
    <div class="p-2">
        <h1>Tasks overview</h1>
    </div>
    <div class="p-2">
        <form method='get' action="{{ route('tasks', $kanbanBoard->id) }}" class="row gy-2 gx-3 align-items-center">
            @csrf

            <div class="row mb-1">
                <div class="col-md-3">
                    <div class="input-group">
                        <div class="input-group-text" style="width: 7rem;">System</div>
                        <select class="form-select" id="system" name="system_id" onchange="getSubSystems(this.value)">
                            <option value="0" @if(!isset($request['system_id'])) selected @endif>Select system</option>
                        @foreach($systems as $system)
                            <option value="{{$system->id}}" @if(isset($request['system_id'])) {{$system->id == $request['system_id'] ? "selected" : "" }} @endif>{{$system->name_short}}{{$system->name_full ? ' - ' . $system->name_full : ''}}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <div class="input-group-text" style="width: 7rem;">Sub-system</div>
                        <select class="form-select" id="inputSubSystem" name="sub_system_id">
                            <option value="0" @if(!isset($request['sub_system_id'])) selected @endif>Select system first</option>
                        @if(isset($request['system_id']))
                        @foreach($systems->where('id', $request['system_id'])->first()->SubSystems as $subSystem)
                            <option value="{{$subSystem->id}}" @if(isset($request['sub_system_id'])) {{$subSystem->id == $request['sub_system_id'] ? "selected" : "" }} @endif>{{$subSystem->name_short}}{{$subSystem->name_full ? ' - ' . $subSystem->name_full : ''}}</option>
                        @endforeach
                        @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <div class="input-group-text" style="width: 7rem;">Text search</div>
                        <input type="text" class="form-control" name="text_search" id="text_search" placeholder="Search task name or description" value="{{$searchString}}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <div class="input-group-text" style="width: 7rem;">Order by</div>
                        <select class="form-select" id="orderBy" name="orderBy">
                            <option value="name" @if($orderBy == 'name') selected @endif title="Order by task name">Name</option>
                            <option value="system" @if($orderBy == 'system') selected @endif title="Order by system full name">System</option>
                            <option value="priority" @if($orderBy == 'priority') selected @endif title="Order by priority order number">Priority</option>
                            <option value="status" @if($orderBy == 'status') selected @endif title="Order by status order number">Status</option>
                            <option value="task_type" @if($orderBy == 'task_type') selected @endif title="Order by task type name">Task type</option>
                            <option value="applicant" @if($orderBy == 'applicant') selected @endif title="Order by applicant name">Applicant</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <div class="input-group">
                        <div class="input-group-text" style="width: 7rem;">Priority</div>
                        <select class="form-select" id="priority" name="priority_id">
                            <option value="0" @if(!isset($request['priority_id'])) selected @endif>Select priority</option>
                        @foreach($priorities as $priority)
                            <option value="{{$priority->id}}" @if(isset($request['priority_id'])) {{$priority->id == $request['priority_id'] ? "selected" : "" }} @endif>{{$priority->name}}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="input-group">
                        <div class="input-group-text" style="width: 7rem;">Status</div>
                        <select class="form-select" id="status" name="status_id">
                            <option value="0" @if(!isset($request['status_id'])) selected @endif>Select status</option>
                        @foreach($statuses as $status)
                            <option value="{{$status->id}}" @if(isset($request['status_id'])) {{$status->id == $request['status_id'] ? "selected" : "" }} @endif>{{$status->name}}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="input-group">
                        <div class="input-group-text" style="width: 7rem;">Task type</div>
                        <select class="form-select" id="taskType" name="task_type_id">
                            <option value="0" @if(!isset($request['task_type_id'])) selected @endif>Select task type</option>
                        @foreach($taskTypes as $taskType)
                            <option value="{{$taskType->id}}" @if(isset($request['task_type_id'])) {{$taskType->id == $request['task_type_id'] ? "selected" : "" }} @endif>{{$taskType->name}}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-2">
                    <button type="submit" class="btn btn-primary">Search</button>
                    <a href="{{ route('tasks', $kanbanBoard->id) }}" class="btn btn-secondary">{{ __('Reset') }}</a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped align-middle table-bordered">
        <caption>List of all tasks, {{$tasks->count()}} in total</caption>
        <thead>
            <tr>
                <th scope="col" class="text-center align-middle">Task name</th>
                <th scope="col" class="text-center align-middle d-none d-sm-table-cell">Description</th>
                <th scope="col" class="text-center align-middle">System</th>
                <th scope="col" class="text-center align-middle">Sub-system</th>
                <th scope="col" class="text-center align-middle">Priority</th>
                <th scope="col" class="text-center align-middle">Status</th>
                <th scope="col" class="text-center align-middle">Task type</th>
                <th scope="col" class="text-center align-middle">applicant</th>
                <th scope="col" class="text-center align-middle">&#35; logs</th>
                <th scope="col" class="text-center align-middle">Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($tasks as $task)
            <tr>
                <th scope="row">{{$task->task_name}}</th>
                <td class="d-none d-sm-table-cell">{{$task->task_description}}</td>
                <td class="align-middle text-center">{{$task->system_name}}</td>
                <td class="align-middle text-center">{{$task->sub_system_name ?? ''}}</td>
                <td class="align-middle text-center">{{$task->priority_name}}</td>
                <td class="align-middle text-center">{{$task->status_name}}</td>
                <td class="align-middle text-center">{{$task->task_type_name}}</td>
                <td class="align-middle text-center">{{$task->applicant_name}}</td>
                <td class="align-middle text-center">{{$task->TaskLogs->count()}}</td>
                <td>
                    <div class="dropdown dropstart">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Actions
                        </button>
                        <ul class="dropdown-menu  dropdown-menu-dark">
                            <li><a href="{{ route('showTask', [$kanbanBoard->id, $task->id]) }}" class="dropdown-item text-primary" title="Show the info for this task.">Info</a></li>
                            @can('manage_tasks')
                            <li><a href="{{ route('editTask', [$kanbanBoard->id, $task->id]) }}" class="dropdown-item text-warning" title="Edit this task.">Edit</a></li>
                            @endcan
                        </ul>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<input type="hidden" value="{{ Auth::user()->api_token }}" id="token" />

<script>
    function getSubSystems(systemId) {
        let token = document.querySelector("#token").value;
        axios.get("/api/system/" + systemId + "/subsystems", {params: { "api_token": token}})
            .then((response) => {
                //console.log(response.data);

                const select = document.querySelector("#inputSubSystem");
                for (var option in select) {
                    select.remove(option);
                }

                let newOption = document.createElement('option');
                newOption.value = 0;
                newOption.text = "Select sub-system";
                select.add(newOption, undefined);

                response.data.forEach((element) => {
                    //console.log(element);
                    let newOption = document.createElement('option');
                    newOption.value = element.id;
                    newOption.text = element.name_short;
                    if (element.name_full) {
                        newOption.text += " - " + element.name_full;
                    }
                    select.add(newOption, undefined);
                });
            })
            .catch((err) => {
                console.error(err);
            });
    }
</script>
@endsection