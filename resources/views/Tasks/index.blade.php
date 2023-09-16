@extends('Layouts.app')

@section('title', 'Tasks overview')

@section('content')
<div >
    <div class="p-2">
        <h1>Tasks overview</h1>
    </div>
    <div class="p-2">
        <div class="col-auto float-right">
            <div class="input-group mb-2">
                <form method='get' action="{{ route('tasks', $kanbanBoard->id) }}" class="row gy-2 gx-3 align-items-center">
                    @csrf
                    
                    <div class="col-auto">
                        <label class="visually-hidden" for="system">System</label>
                        <div class="input-group">
                            <div class="input-group-text">System</div>
                            <select class="form-select" id="system" name="system_id" onchange="getSubSystems(this.value)">
                            @foreach($systems as $system)
                                <option value="{{$system->id}}" @if(isset($searchParameters['system_id'])) {{$system->id == $searchParameters['system_id'] ? "selected" : "" }} @endif>{{$system->name_short}}{{$system->name_full ? ' - ' . $system->name_full : ''}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-auto">
                        <label class="visually-hidden" for="sub_system">Sub-system</label>
                        <div class="input-group">
                            <div class="input-group-text">Sub-system</div>
                            <select class="form-select" id="inputSubSystem" name="sub_system_id">
                            @if(isset($searchParameters['system_id']))
                            @foreach($systems->where('id', $searchParameters['system_id'])->first()->SubSystems as $subSystem)
                                <option value="{{$subSystem->id}}" @if(isset($searchParameters['sub_system_id'])) {{$subSystem->id == $searchParameters['sub_system_id'] ? "selected" : "" }} @endif>{{$subSystem->name_short}}{{$subSystem->name_full ? ' - ' . $subSystem->name_full : ''}}</option>
                            @endforeach
                            @else
                            @foreach($systems->first()->SubSystems as $subSystem)
                                <option value="{{$subSystem->id}}">{{$subSystem->name_short}}{{$subSystem->name_full ? ' - ' . $subSystem->name_full : ''}}</option>
                            @endforeach
                            @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Search</button>
                        <a href="{{ route('tasks', $kanbanBoard->id) }}" class="btn btn-secondary">{{ __('Reset') }}</a>
                    </div>
                </form>
            </div>
        </div>
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
                <th scope="col" class="text-center align-middle">Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($tasks as $task)
            <tr>
                <th scope="row">{{$task->name}}</th>
                <td class="d-none d-sm-table-cell">{{$task->description}}</td>
                <td>{{$task->System->name_full}}</td>
                <td>{{$task->SubSystem->name_full ?? ''}}</td>
                <td>{{$task->Priority->name}}</td>
                <td>{{$task->Status->name}}</td>
                <td><a href="{{route('showTask', [$kanbanBoard->id, $task->id])}}" class="btn btn-primary">Show</a></td>
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