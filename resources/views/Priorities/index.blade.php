@extends('Layouts.app')

@section('title', 'Priorities overview')

@section('content')
<div class="d-flex justify-content-between">
    <div class="p-2">
        <h1>Priorities</h1>
    </div>
    <div class="p-2">
        <div class="col-auto float-right">
            <div class="input-group mb-2">
                <div class="btn-group" role="group">
                    <a href="{{route('createPriority', $kanbanBoard->id)}}" type="button" class="btn btn-primary">Create new priority</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped align-middle table-bordered">
        <caption>List of all priorities, {{$priorities->count()}} in total</caption>
        <thead>
            <tr>
                <th scope="col" class="text-center align-middle">order number</th>
                <th scope="col" class="text-center align-middle">Status name</th>
                <th scope="col" class="text-center align-middle d-none d-sm-table-cell">Description</th>
                <th scope="col" class="text-center align-middle">Color</th>
                <th scope="col" class="text-center align-middle">Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($priorities as $priority)
            <tr>
                <td class="align-middle text-center">{{$priority->order_number}}</td>
                <th scope="row">{{$priority->name}}</th>
                <td class="d-none d-sm-table-cell d-none d-sm-table-cell">{{$priority->description}}</td>
                <td class="align-middle text-center">
                    <input type="color" value="#{{$priority->colorHex}}" disabled>
                </td>
                <td>
                    <div class="dropdown dropstart">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Actions
                        </button>
                        <ul class="dropdown-menu  dropdown-menu-dark">
                            <li><a href="{{ route('showPriority', [$kanbanBoard->id, $priority->id]) }}" class="dropdown-item text-primary" title="Show the info for this priority.">Info</a></li>
                            <li><a href="{{ route('editPriority', [$kanbanBoard->id, $priority->id]) }}" class="dropdown-item text-warning" title="Edit this priority.">Edit</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection