@extends('Layouts.app')

@section('title', 'Show task')

@section('content')
<div class="mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-5">
                <div class="card-header">
                    Show task: <span class="text-primary">{{$task->name}}</span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputName" name="name" value="{{$task->name}}" disabled/>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputDescription" class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="inputDescription" name="description" disabled>{{$task->description}}</textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputUsers" class="col-sm-2 col-form-label">Users</label>
                        <div class="col-sm-4">
                            <input id="user_ids" class="form-control" name="user_ids[]" value="{{$task->usersString}}" disabled />
                        </div>
                        <label for="inputApplicant" class="col-sm-2 col-form-label">Applicant</label>
                        <div class="col-sm-4">
                            <input class="form-control" id="inputApplicant" name="applicant_id" value="{{$task->Applicant->name ?? ''}}" disabled/>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputSystem" class="col-sm-2 col-form-label">System</label>
                        <div class="col-sm-4">
                            <input class="form-control" id="inputSystem" name="system_id" value="{{$task->System->name_short . ' - ' . $task->System->name_full}}" disabled/>
                        </div>
                        <label for="inputSubSystem" class="col-sm-2 col-form-label">Sub-system</label>
                        <div class="col-sm-4">
                            <input class="form-control" id="inputSubSystem" name="sub_system_id" value="@if(isset($task->SubSystem->name_short)) {{$task->SubSystem->name_short . ' - ' . $task->SubSystem->name_full}} @endif" disabled/>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputStatus" class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-4">
                            <input class="form-control" style="color: #{{$task->Status->ColorHex}};" id="inputStatus" name="status_id" value="{{$task->Status->name}}" disabled/>
                        </div>
                        <label for="inputPriority" class="col-sm-2 col-form-label">Priority</label>
                        <div class="col-sm-4">
                            <input class="form-control" style="color: #{{$task->Priority->ColorHex}};" id="inputPriority" name="priority_id" value="{{$task->Priority->name}}" disabled/>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputType" class="col-sm-2 col-form-label">Type</label>
                        <div class="col-sm-4">
                            <input class="form-control" id="inputType" name="task_type_id" value="{{$task->TaskType->name}}" disabled/>
                        </div>
                        <label for="inputDeadline" class="col-sm-2 col-form-label">Deadline</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" id="inputDeadline" name="deadline" value="{{$task->deadline}}" disabled/>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6 offset-md-2">
                            <a href="{{ url()->previous() }}" class="btn btn-danger">{{ __('Back') }}</a>
                            <a href="{{route('editTask', [$kanbanBoard->id, $task->id])}}" class="btn btn-warning">Edit</a>
                        </div>
                    </div>

                    <hr />

                    <div class="row mb-3">
                        <label for="inputId" class="col-sm-2 col-form-label">Task id</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="inputId" name="id" value="{{$task->id}}" disabled/>
                        </div>
                        <label for="inputStatus" class="col-sm-2 col-form-label">Creator</label>
                        <div class="col-sm-4">
                            <input class="form-control" id="inputStatus" name="status_id" value="{{$task->Creator->name}}" disabled/>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputType" class="col-sm-2 col-form-label">Creation date</label>
                        <div class="col-sm-4">
                            <input class="form-control" id="inputType" name="task_type_id" value="{{$task->created_at}}" disabled/>
                        </div>
                        <label for="inputType" class="col-sm-2 col-form-label">Last update date</label>
                        <div class="col-sm-4">
                            <input class="form-control" id="inputType" name="task_type_id" value="{{$task->updated_at}}" disabled/>
                        </div>
                    </div>
                    
                </div>
                <div class="card-footer">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 5em;">#</th>
                                <th scope="col" style="width: 10em;">Date</th>
                                <th scope="col">User</th>
                                <th scope="col">Log entry</th>
                                <th scope="col" style="width: 5em;"></th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            @foreach($task->TaskLogs as $log)
                            <tr>
                                <td>{{$log->id}}</td>
                                <td>{!!$log->Timestamp!!}</td>
                                <td>{{$log->User->name}}</td>
                                <td>{!!$log->descriptionFormatted!!}</td>
                                <td>
                                    @if($log->User->id == Auth::id())
                                    <a href="{{route('editLog', [$kanbanBoard->id, $log->id])}}" class="btn btn-warning">Edit</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection