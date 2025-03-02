@extends('Layouts.app')

@section('title', 'Applicants')

@section('content')
<div class="d-flex justify-content-between">
    <div class="p-2">
        <h1>Applicants</h1>
    </div>
    @can('manage_kanban_content')
    <div class="p-2">
        <div class="col-auto float-right">
            <div class="input-group mb-2">
                <div class="btn-group" role="group">
                    <a href="{{route('createApplicant', $kanbanBoard->id)}}" type="button" class="btn btn-primary">Create new applicant</a>
                </div>
            </div>
        </div>
    </div>
    @endcan
</div>

@if($applicants->count() > 0)
<div class="position-relative row">
    <div class="col-6 offset-md-3">
        <div class="table-responsive">
            <table class="table table-striped align-middle table-bordered border-dark">
                <caption>List of all applicants</caption>
                <thead>
                    <tr>
                        <th scope="col" class="text-center align-middle">Id</th>
                        <th scope="col" class="text-center align-middle">Name</th>
                        <th scope="col" class="text-center align-middle">&#35; tasks</th>
                        @can('manage_kanban_content')
                        <th scope="col" class="text-center align-middle">Actions</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach($applicants as $applicant)
                    <tr>
                        <td class="text-center">{{$applicant->id}}</td>
                        <td>{{$applicant->name}}</td>
                        <td class="text-center">{{$applicant->Tasks->count()}}</td>
                        @can('manage_kanban_content')
                        <td>
                            <a href="{{route('editApplicant', [$kanbanBoard->id, $applicant->id])}}" class="btn btn-warning">Edit</a>
                        </td>
                        @endcan
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