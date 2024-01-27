@extends('Layouts.app')

@section('title', 'Statuses overview')

@section('content')
<div class="d-flex justify-content-between">
    <div class="p-2">
        <h1>Statuses</h1>
    </div>
    @can('manage_kanban_content')
    <div class="p-2">
        <div class="col-auto float-right">
            <div class="input-group mb-2">
                <div class="btn-group" role="group">
                    <a href="{{route('createStatus', $kanbanBoard->id)}}" type="button" class="btn btn-primary">Create new status</a>
                </div>
            </div>
        </div>
    </div>
    @endcan
</div>

<div class="table-responsive">
    <table class="table table-striped align-middle table-bordered">
        <caption>List of all statuses, {{$statuses->count()}} in total</caption>
        <thead>
            <tr>
                <th scope="col" class="text-center align-middle">order number</th>
                <th scope="col" class="text-center align-middle">Status name</th>
                <th scope="col" class="text-center align-middle d-none d-sm-table-cell">Description</th>
                <th scope="col" class="text-center align-middle">preparetion</th>
                <th scope="col" class="text-center align-middle">Active</th>
                <th scope="col" class="text-center align-middle">Finishing</th>
                <th scope="col" class="text-center align-middle">Color</th>
                <th scope="col" class="text-center align-middle">Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($statuses as $status)
            <tr>
                <td class="align-middle text-center">{{$status->order_number}}</td>
                <th scope="row">{{$status->name}}</th>
                <td class="d-none d-sm-table-cell d-none d-sm-table-cell">{{$status->description}}</td>
                <td class="align-middle text-center">
                    @if($status->preparetion)
                    <i class="bi bi-check-lg text-success"></i>
                    @else
                    <i class="bi bi-x-lg text-danger"></i>
                    @endif
                </td>
                <td class="align-middle text-center">
                    @if($status->active)
                    <i class="bi bi-check-lg text-success"></i>
                    @else
                    <i class="bi bi-x-lg text-danger"></i>
                    @endif
                </td>
                <td class="align-middle text-center">
                    @if($status->finishing)
                    <i class="bi bi-check-lg text-success"></i>
                    @else
                    <i class="bi bi-x-lg text-danger"></i>
                    @endif
                </td>
                <td class="align-middle text-center">
                    <input type="color" value="#{{$status->colorHex}}" disabled>
                </td>
                <td>
                    <div class="dropdown dropstart">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Actions
                        </button>
                        <ul class="dropdown-menu  dropdown-menu-dark">
                            <li><a href="{{ route('showStatus', [$kanbanBoard->id, $status->id]) }}" class="dropdown-item text-primary" title="Show the info for this status.">Info</a></li>
                            @can('manage_kanban_content')
                            <li><a href="{{ route('editStatus', [$kanbanBoard->id, $status->id]) }}" class="dropdown-item text-warning" title="Edit this status.">Edit</a></li>
                            @endcan
                        </ul>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection