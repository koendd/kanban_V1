@extends('Layouts.app')

@section('title', 'Show sub-system')

@section('content')
<div class="mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Info for sub&#45;system: <span class="fw-bold fs-5 text-primary font-monospace">{{$subSystem->name}}</span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <label for="inputShortName" class="col-sm-2 col-form-label">Short name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputShortName" name="name_short" maxlength="50" disabled value="{{$subSystem->name_short}}"/>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputFullName" class="col-sm-2 col-form-label">Full name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputFullName" name="name_full" maxlength="255" disabled value="{{$subSystem->name_full}}"/>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputDescription" class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="inputDescription" name="description" maxlength="255" disabled>{{$subSystem->description}}</textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6 offset-md-2">
                            @can('manage_kanban_content')
                            <a href="{{ route('editSubSystem', [$kanbanBoard->id, $subSystem->id]) }}" type="submit" class="btn btn-warning" title="Edit this status">{{ __('Edit') }}</a>
                            @endcan
                            <a href="{{ url()->previous() }}" class="btn btn-danger">{{ __('Back') }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTasks">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTasks" aria-expanded="false" aria-controls="collapseTasks">Tasks &#40;{{$subSystem->Tasks->count()}}&#41;</button>
                            </h2>
                            <div id="collapseTasks" class="accordion-collapse collapse" aria-labelledby="headingTasks" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 5em;">Id</th>
                                                <th scope="col" style="width: 10em;">Name</th>
                                                <th scope="col" style="width: 5em;"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-group-divider">
                                            @foreach($subSystem->Tasks as $task)
                                            <tr>
                                                <td>{{$task->id}}</td>
                                                <td>{{$task->name}}</td>
                                                <td>
                                                    <a href="{{route('showTask', [$kanbanBoard->id, $task->id])}}" class="btn btn-primary">Show</a>
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
            </div>
        </div>
    </div>
</div>
@endsection