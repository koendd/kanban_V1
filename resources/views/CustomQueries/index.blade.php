@extends('Layouts.app')

@section('title', 'Custom queries')

@section('content')
<div class="d-flex justify-content-between">
    <div class="p-2">
        <h1>Custom queries</h1>
    </div>
</div>

@if(count($queries) > 0)
<div class="position-relative row">
    <div class="col-6 offset-md-3">
        <div class="table-responsive">
            <table class="table table-striped align-middle table-bordered border-dark">
                <caption>List of all custom queries, {{count($queries)}} in total</caption>
                <thead>
                    <tr>
                        <th scope="col" class="text-center align-middle">Name</th>
                        <th scope="col" class="text-center align-middle d-none d-sm-table-cell">Description</th>
                        <th scope="col" class="text-center align-middle">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($queries as $queryName => $query)
                    <tr>
                        <td>{{$query['name']}}</td>
                        <td>{{$query['description']}}</td>
                        <td>
                            <a href="{{route('runCustomQuery', $queryName)}}" class="btn btn-warning">Run</a>
                        </td>
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