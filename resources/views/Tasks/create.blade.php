@extends('Layouts.app')

@section('title', 'Create task')

@section('content')
<div class="mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Create a new task
                </div>
                <div class="card-body">
                    <form action="{{route('createTask', $kanbanBoard->id)}}" method="post">
                        @csrf
                        
                        <div class="row mb-3">
                            <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10 border-end border-danger border-3">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="inputName" name="name" maxlength="255" required value="{{old('name')}}" autocomplete="off"/>

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
                                <textarea class="form-control @error('description') is-invalid @enderror" id="inputDescription" name="description" maxlength="1000" rows="4" value="{{old('description')}}" autocomplete="off" onkeyup="displayCharCount(this, 'charCount')"></textarea>

                                @error('description')
                                <div class="invalid-feedback">
                                    Please provide a task description.
                                </div>
                                @enderror
                                <div id="charCount" class="text-end">
                                    0 / 1000
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputUsers" class="col-sm-2 col-form-label">Users</label>
                            <div class="col-sm-10 border-end border-danger border-3">
                                <select id="user_ids" class="form-select" name="user_ids[]" multiple>
                                    @foreach ($users as $user)
                                    <option value="{{$user->id}}" {{$user->id == Auth::id() ? "selected" : ""}}>{{$user->name}}</option>
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
                                <input type="date" class="form-control @error('deadline') is-invalid @enderror" id="inputDeadline" name="deadline" value="{{old('deadline')}}" />

                                @error('deadline')
                                <div class="invalid-feedback">
                                    Please provide a deadline.
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputSystem" class="col-sm-2 col-form-label">System</label>
                            <div class="col-sm-10 border-end border-danger border-3">
                                <select class="form-select @error('system_id') is-invalid @enderror" id="inputSystem" name="system_id" onchange="getSubSystems(this.value)" required>
                                    <option disabled selected>Choose a system</option>
                                    @foreach($systems as $system)
                                    <option value="{{$system->id}}">{{$system->name_short}}{{$system->name_full ? ' - ' . $system->name_full : ''}}</option>
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
                                    <option disabled selected>Choose a system first</option>
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
                                @if($applicants->count() > 1)
                                <select class="form-select @error('applicant_id') is-invalid @enderror" id="inputApplicant" name="applicant_id">
                                    <option disabled selected>Choose a applicant</option>
                                    @foreach($applicants as $applicant)
                                    <option value="{{$applicant->id}}">{{$applicant->name}}</option>
                                    @endforeach
                                </select>
                                @else
                                <input type="hidden" name="applicant_id" value="{{$applicants->first()->id}}" />
                                <input id="applicant_id" type="text" class="form-control disabled @error('applicant_id') is-invalid @enderror" value="{{ $applicants->first()->name }}" required disabled>
                                @endif

                                @error('applicant_id')
                                <div class="invalid-feedback">
                                    Please select a applicant.
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputPriority" class="col-sm-2 col-form-label">Priority</label>
                            <div class="col-sm-10 border-end border-danger border-3">
                                @if($priorities->count() > 1)
                                <select class="form-select @error('priority_id') is-invalid @enderror" id="inputPriority" name="priority_id" required>
                                    <option disabled selected>Choose a priority</option>
                                    @foreach($priorities as $priority)
                                    <option value="{{$priority->id}}">{{$priority->name}}</option>
                                    @endforeach
                                </select>
                                @else
                                <input type="hidden" name="priority_id" value="{{$priorities->first()->id}}" />
                                <input id="priority_id" type="text" class="form-control disabled @error('priority_id') is-invalid @enderror" value="{{ $priorities->first()->name }}" required disabled>
                                @endif

                                @error('priority_id')
                                <div class="invalid-feedback">
                                    Please select a priority.
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputStatus" class="col-sm-2 col-form-label">Status</label>
                            <div class="col-sm-10 border-end border-danger border-3">
                                @if($statuses->count() > 1)
                                <select class="form-select @error('status_id') is-invalid @enderror" id="inputStatus" name="status_id" required>
                                    <option disabled selected>Choose a status</option>
                                    @foreach($statuses as $status)
                                    <option value="{{$status->id}}">{{$status->name}}</option>
                                    @endforeach
                                </select>
                                @else
                                <input type="hidden" name="status_id" value="{{$statuses->first()->id}}" />
                                <input id="status_id" type="text" class="form-control disabled @error('status_id') is-invalid @enderror" value="{{ $statuses->first()->name }}" required disabled>
                                @endif

                                @error('status_id')
                                <div class="invalid-feedback">
                                    Please select a status.
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputType" class="col-sm-2 col-form-label">Type</label>
                            <div class="col-sm-10 border-end border-danger border-3">
                                @if($types->count() > 1)
                                <select class="form-select @error('task_type_id') is-invalid @enderror" id="inputType" name="task_type_id" required>
                                    <option disabled selected>Choose a type</option>
                                    @foreach($types as $type)
                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                    @endforeach
                                </select>
                                @else
                                <input type="hidden" name="task_type_id" value="{{$appltypesicants->first()->id}}" />
                                <input id="task_type_id" type="text" class="form-control disabled @error('task_type_id') is-invalid @enderror" value="{{ $types->first()->name }}" required disabled>
                                @endif

                                @error('task_type_id')
                                <div class="invalid-feedback">
                                    Please select a type.
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-2">
                                <button type="submit" class="btn btn-success">Create task</button>
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