@extends('Layouts.app')

@section('title', 'Show status info')

@section('content')
<div class="mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Info for status: <span class="fw-bold fs-5 text-primary font-monospace">{{$status->name}}</span>
                </div>
                <div class="card-body">
                    <form action="{{route('createStatus', $kanbanBoard->id)}}" method="post">
                        @csrf
                        
                        <div class="row mb-3">
                            <label for="name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control"required value="{{$status->name}}" disabled/>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputDescription" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="4" disabled>{{$status->description}}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputOrderNumber" class="col-sm-2 col-form-label">Order number</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" value="{{$status->order_number}}" disabled/>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="enabled" class="col-md-2 col-form-label text-md-right">Kanban part</label>
                            <div class="col-sm-10 mt-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" @if($status->preparetion) checked @endif disabled>
                                    <label class="form-check-label" for="checkBoxPreparetion">Preparetion</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" @if($status->active) checked @endif disabled>
                                    <label class="form-check-label" for="checkBoxActive">Active</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" @if($status->finishing) checked @endif disabled>
                                    <label class="form-check-label" for="checkBoxFinishing">Finishing</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="color" class="col-sm-2 col-form-label">Color</label>
                            <div class="col-sm-10">
                                <input id="color" type="color" class="form-control form-control-color" value="#{{$status->ColorHex}}" disabled>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-2">
                                @can('manage_kanban_content')
                                <a href="{{route('editStatus', [$kanbanBoard->id, $status->id])}}" type="submit" class="btn btn-warning" title="Edit this status">{{ __('Edit') }}</a>
                                @endcan
                                <a href="{{ url()->previous() }}" class="btn btn-danger">{{ __('Back') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTasks">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTasks" aria-expanded="false" aria-controls="collapseTasks">Tasks &#40;{{$status->Tasks->count()}}&#41;</button>
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
                                            @foreach($status->Tasks as $task)
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