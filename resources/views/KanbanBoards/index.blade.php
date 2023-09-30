@extends('Layouts.app')

@section('title', 'Kanban boards')

@section('content')
<div class="d-flex justify-content-between">
    <div class="p-2">
        <h1>Kanban boards</h1>
    </div>
    <div class="p-2">
        <div class="col-auto float-right">
            <div class="input-group mb-2">
                <div class="btn-group" role="group">
                    <a href="{{route('createKanban')}}" type="button" class="btn btn-primary">Create new kanban boards</a>
                </div>
            </div>
        </div>
    </div>
</div>

@if($kanbanBoards->count() > 0)
<div class="position-relative row">
    <div class="col-6 offset-md-3">
        <div class="table-responsive">
            <table class="table table-striped align-middle table-bordered border-dark">
                <caption>List of all {{$kanbanBoards->count()}} kanban boards</caption>
                <thead>
                    <tr>
                        <th scope="col" class="text-center align-middle">Id</th>
                        <th scope="col" class="text-center align-middle">Name</th>
                        <th scope="col" class="text-center align-middle d-none d-sm-table-cell">Description</th>
                        <th scope="col" class="text-center align-middle">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kanbanBoards as $kanbanBoard)
                    <tr>
                        <td>{{$kanbanBoard->id}}</td>
                        <td>{{$kanbanBoard->name}}</td>
                        <td class="d-none d-sm-table-cell">{{$kanbanBoard->description}}</td>
                        <td><a href="{{route('editKanban', $kanbanBoard->id)}}" class="btn btn-warning">Edit</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@else
@endif

@endsection