@extends('Layouts.app')

@section('content')
<div class="mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Edit task: <span class="text-primary">{{$task->name}}</span>
                </div>
                <div class="card-body">
                    <form action="{{route('editTask', $task->id)}}" method="post">
                        @csrf
                        
                        <div class="row mb-3">
                            <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="inputName" name="name" maxlength="255" required value="{{$task->name}}"/>

                                @error('name')
                                <div class="invalid-feedback">
                                    Please give the task a name.
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputDescription" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <textarea class="form-control @error('description') is-invalid @enderror" id="inputDescription" name="description" maxlength="1000">{{$task->description}}</textarea>

                                @error('description')
                                <div class="invalid-feedback">
                                    Please provide a task description.
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputUsers" class="col-sm-2 col-form-label">Users</label>
                            <div class="col-sm-10">
                                <select id="user_ids" class="form-select" name="user_ids[]" multiple>
                                    @foreach ($users as $user)
                                    <option value="{{$user->id}}" {{$task->Users->contains($user->id) ? "selected" : ""}}>{{$user->name}}</option>
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
                            <label for="inputDeadline" class="col-sm-2 col-form-label">Deadline</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control @error('deadline') is-invalid @enderror" id="inputDeadline" name="deadline" value="{{$task->deadline}}" />

                                @error('deadline')
                                <div class="invalid-feedback">
                                    Please provide a deadline.
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputSystem" class="col-sm-2 col-form-label">System</label>
                            <div class="col-sm-10">
                                <select class="form-select @error('system_id') is-invalid @enderror" id="inputSystem" name="system_id" onchange="getSubSystems(this.value)" required>
                                    <option disabled>Choose a system</option>
                                    @foreach($systems as $system)
                                    <option value="{{$system->id}}" @if($system->id == $task->system_id) selected @endif>{{$system->name_short}}{{$system->name_full ? ' - ' . $system->name_full : ''}}</option>
                                    @endforeach
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
                            <div class="col-sm-10">
                                <select class="form-select @error('sub_system_id') is-invalid @enderror" id="inputSubSystem" name="sub_system_id">
                                    <option disabled>Choose a system first</option>
                                    @foreach($subSystems as $subSystem)
                                    <option value="{{$subSystem->id}}" @if($subSystem->id == $task->sub_system_id) selected @endif>{{$subSystem->name_short}}{{$subSystem->name_full ? ' - ' . $subSystem->name_full : ''}}</option>
                                    @endforeach
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
                            <div class="col-sm-10">
                                <select class="form-select @error('applicant_id') is-invalid @enderror" id="inputApplicant" name="applicant_id">
                                    <option disabled>Choose a applicant</option>
                                    @foreach($applicants as $applicant)
                                    <option value="{{$applicant->id}}" @if($applicant->id == $task->applicant_id) selected @endif>{{$applicant->name}}</option>
                                    @endforeach
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
                            <div class="col-sm-10">
                                <select class="form-select @error('priority_id') is-invalid @enderror" id="inputPriority" name="priority_id" required>
                                    <option disabled>Choose a priority</option>
                                    @foreach($priorities as $priority)
                                    <option value="{{$priority->id}}" @if($priority->id == $task->priority_id) selected @endif>{{$priority->name}}</option>
                                    @endforeach
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
                            <div class="col-sm-10">
                                <select class="form-select @error('status_id') is-invalid @enderror" id="inputStatus" name="status_id" required>
                                    <option disabled>Choose a status</option>
                                    @foreach($statuses as $status)
                                    <option value="{{$status->id}}" @if($status->id == $task->status_id) selected @endif>{{$status->name}}</option>
                                    @endforeach
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
                            <div class="col-sm-10">
                                <select class="form-select @error('task_type_id') is-invalid @enderror" id="inputType" name="task_type_id" required>
                                    <option disabled>Choose a type</option>
                                    @foreach($types as $type)
                                    <option value="{{$type->id}}" @if($type->id == $task->task_type_id) selected @endif>{{$type->name}}</option>
                                    @endforeach
                                </select>

                                @error('task_type_id')
                                <div class="invalid-feedback">
                                    Please select a type.
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-2">
                                <button type="submit" class="btn btn-success">Save task</button>
                                <button type="button" class="btn btn-danger">Cancel</button>
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
    function getSubSystems(systemId) {
        let token = document.querySelector("#token").value;
        axios.get("/api/system/" + systemId + "/subsystems", {params: { "api_token": token}})
            .then((response) => {
                //console.log(response.data);

                const select = document.querySelector("#inputSubSystem");
                for (var option in select) {
                    select.remove(option);
                }
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