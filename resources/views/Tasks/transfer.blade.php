@extends('Layouts.app')

@section('title', 'Transfer task')

@section('content')
<div class="mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    Transfer task: <span class="text-primary" id="modalTitle">{{$task->name}}</span>
                </div>
                <div class="card-body">
                    <form action="{{route('transferTask', ['kanbanBoard' => $kanbanBoard->id, 'task' => $task->id])}}" method="post">
                        @csrf
                        
                        <div class="row mb-3">
                            <label for="inputName" class="col-sm-2 col-form-label">Kanban board</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="{{$kanbanBoard->name}}" disabled/>
                            </div>
                            <div class="col-sm-1 text-center">
                                <i class="bi bi-arrow-right fs-4 fw-bold"></i>
                            </div>
                            <div class="col-sm-5">
                                <select id="kanban_board" class="form-select" name="kanban_board_id" onchange="getTaskTransferData(this.value)">
                                    <option disabled selected>Choose a kanban board</option>
                                    @foreach ($kanbanBoards as $board)
                                    <option value="{{$board->id}}">{{$board->name}}</option>
                                    @endforeach
                                </select>

                                @error('user_ids')
                                <div class="invalid-feedback">
                                    Please provide one or many users handling this task.
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="{{$task->name}}" disabled/>
                            </div>
                            <div class="col-sm-1 text-center">
                                <i class="bi bi-arrow-right fs-4 fw-bold"></i>
                            </div>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <input type="text" class="form-control" value="Adopted" disabled/>
                                    <span class="input-group-text" id="user-addon" title="This value remains unchanged! In case a change is needed, this can be done after the transfer."><i class="bi bi-info-circle"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputDescription" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-4">
                                <textarea class="form-control" disabled>{{$task->description}}</textarea>
                            </div>
                            <div class="col-sm-1 text-center align-middle">
                                <i class="bi bi-arrow-right fs-4 fw-bold"></i>
                            </div>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <input type="text" class="form-control" value="Adopted" disabled/>
                                    <span class="input-group-text" id="user-addon" title="This value remains unchanged! In case a change is needed, this can be done after the transfer."><i class="bi bi-info-circle"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputUsers" class="col-sm-2 col-form-label">Users</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="{{$task->usersString}}" disabled/>
                            </div>
                            <div class="col-sm-1 text-center">
                                <i class="bi bi-arrow-right fs-4 fw-bold"></i>
                            </div>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <input type="text" class="form-control" value="Adopted" disabled aria-label="" aria-describedby="user-addon"/>
                                    <span class="input-group-text" id="user-addon" title="This value remains unchanged! In case a change is needed, this can be done after the transfer."><i class="bi bi-info-circle"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputDeadline" class="col-sm-2 col-form-label">Deadline</label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" value="{{$task->deadline}}" disabled/>
                            </div>
                            <div class="col-sm-1 text-center">
                                <i class="bi bi-arrow-right fs-4 fw-bold"></i>
                            </div>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <input type="text" class="form-control" value="Adopted" disabled/>
                                    <span class="input-group-text" id="user-addon" title="This value remains unchanged! In case a change is needed, this can be done after the transfer."><i class="bi bi-info-circle"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputSystem" class="col-sm-2 col-form-label">System</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="{{$task->System->Name}}" disabled/>
                            </div>
                            <div class="col-sm-1 text-center">
                                <i class="bi bi-arrow-right fs-4 fw-bold"></i>
                            </div>
                            <div class="col-sm-5">
                                <select class="form-select @error('system_id') is-invalid @enderror" id="inputSystem" name="system_id" onchange="getSubSystems(this.value)" disabled>
                                    <option disabled selected>Choose a destination kanban board first</option>
                                </select>

                                @error('system_id')
                                <div class="invalid-feedback">
                                    Please select a system.
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputSubSystem" class="col-sm-2 col-form-label">Sub-system</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="@if($task->SubSystem){{$task->SubSystem->Name}}@endif" disabled/>
                            </div>
                            <div class="col-sm-1 text-center">
                                <i class="bi bi-arrow-right fs-4 fw-bold"></i>
                            </div>
                            <div class="col-sm-5">
                                <select class="form-select @error('sub_system_id') is-invalid @enderror" id="inputSubSystem" name="sub_system_id" disabled>
                                    <option disabled selected>Choose a destination system first</option>
                                </select>

                                @error('sub_system_id')
                                <div class="invalid-feedback">
                                    Please select a sub-system.
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputApplicant" class="col-sm-2 col-form-label">Applicant</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="{{$task->Applicant->name ?? ''}}" disabled/>
                            </div>
                            <div class="col-sm-1 text-center">
                                <i class="bi bi-arrow-right fs-4 fw-bold"></i>
                            </div>
                            <div class="col-sm-5">
                                <select class="form-select @error('applicant_id') is-invalid @enderror" id="inputApplicant" name="applicant_id" disabled>
                                    <option disabled selected>Choose a destination kanban board first</option>
                                </select>

                                @error('applicant_id')
                                <div class="invalid-feedback">
                                    Please select a applicant.
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputPriority" class="col-sm-2 col-form-label">Priority</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="{{$task->Priority->name}}" disabled/>
                            </div>
                            <div class="col-sm-1 text-center">
                                <i class="bi bi-arrow-right fs-4 fw-bold"></i>
                            </div>
                            <div class="col-sm-5">
                                <select class="form-select @error('priority_id') is-invalid @enderror" id="inputPriority" name="priority_id" disabled>
                                    <option disabled selected>Choose a destination kanban board first</option>
                                </select>

                                @error('priority_id')
                                <div class="invalid-feedback">
                                    Please select a priority.
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputStatus" class="col-sm-2 col-form-label">Status</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="{{$task->Status->name}}" disabled/>
                            </div>
                            <div class="col-sm-1 text-center">
                                <i class="bi bi-arrow-right fs-4 fw-bold"></i>
                            </div>
                            <div class="col-sm-5">
                                <select class="form-select @error('status_id') is-invalid @enderror" id="inputStatus" name="status_id" disabled>
                                    <option disabled selected>Choose a destination kanban board first</option>
                                </select>

                                @error('status_id')
                                <div class="invalid-feedback">
                                    Please select a status.
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputType" class="col-sm-2 col-form-label">Type</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="{{$task->TaskType->name}}" disabled/>
                            </div>
                            <div class="col-sm-1 text-center">
                                <i class="bi bi-arrow-right fs-4 fw-bold"></i>
                            </div>
                            <div class="col-sm-5">
                                <select class="form-select @error('task_type_id') is-invalid @enderror" id="inputTaskType" name="task_type_id" disabled>
                                    <option disabled selected>Choose a destination kanban board first</option>
                                </select>

                                @error('task_type_id')
                                <div class="invalid-feedback">
                                    Please select a task type.
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-5 offset-md-7">
                                <button type="submit" class="btn btn-success">Transfer task</button>
                                <a href="{{ url()->previous() }}" class="btn btn-danger">{{ __('Cancel') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" value="{{ Auth::user()->api_token }}" id="token" />

<script>
    function getTaskTransferData(kanban_board_id) {
        let token = document.querySelector("#token").value;
        axios.get("/api/task/getTransferDestinationData/" + kanban_board_id, {params: { "api_token": token}})
            .then((response) => {
                rebuildSelect("inputSystem", response.data.systems, "Select a system");
                rebuildSelect("inputApplicant", response.data.applicants);
                rebuildSelect("inputPriority", response.data.priorities);
                rebuildSelect("inputStatus", response.data.statuses);
                rebuildSelect("inputTaskType", response.data.taskTypes);

                document.querySelector("#inputSubSystem").disabled = false;
            })
            .catch((err) => {
                console.error(err);
            });
    }

    function getSubSystems(systemId) {
        let token = document.querySelector("#token").value;
        axios.get("/api/system/" + systemId + "/subsystems", {params: { "api_token": token}})
            .then((response) => {
                rebuildSelect("inputSubSystem", response.data);
            })
            .catch((err) => {
                console.error(err);
            });
    }
</script>
@endsection