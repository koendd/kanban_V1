@extends('Layouts.app')

@section('content')
<div class="d-flex justify-content-between">
    <div class="p-2">
        <h1>Systems and sub&#45;systems</h1>
    </div>
    <div class="p-2">
        <div class="col-auto float-right">
            <div class="input-group mb-2">
                <a href="#" class="btn btn-primary form-control">Toevoegen</a>
            </div>
        </div>
    </div>
</div>

@if($systems->count() > 0)
<div class="position-relative">
	<div class="table-responsive">	
		<table class="table table-striped align-middle table-bordered border-dark">
			<caption>List of all systems, {{$systems->count()}} in total</caption>
			<thead>
				<tr>
                    <th scope="col" class="text-center align-middle">Id</th>
					<th scope="col" class="text-center align-middle">Name</th>
                    <th scope="col" class="text-center align-middle d-none d-sm-table-cell">Description</th>
                    <th scope="col" class="text-center align-middle">sub&#45;system id</th>
					<th scope="col" class="text-center align-middle">sub&#45;system  name</th>
                    <th scope="col" class="text-center align-middle d-none d-sm-table-cell">sub&#45;system description</th>
				</tr>
			</thead>
            <tbody>
                @foreach($systems as $system)
                <tr>
                    <td @if($system->SubSystems->count() > 0) rowspan="{{$system->SubSystems->count()}}" @endif >{{$system->id}}</td>
                    <td @if($system->SubSystems->count() > 0) rowspan="{{$system->SubSystems->count()}}" @endif >{{$system->name_short}} &#45; {{$system->name_full}}</td>
                    <td @if($system->SubSystems->count() > 0) rowspan="{{$system->SubSystems->count()}}" @endif >{{$system->description}}</td>

                    @if($system->SubSystems->count() > 0)
                    <td>{{$system->SubSystems->first()->id}}</td>
                    <td>{{$system->SubSystems->first()->name_short}} &#45; {{$system->SubSystems->first()->name_full}}</td>
                    <td>{{$system->SubSystems->first()->description}}</td>
                    @else
                    <td></td>
                    <td></td>
                    <td></td>
                    @endif
                </tr>
                @foreach($system->SubSystems as $subSystem)
                @if (!$loop->first)
                <tr>
                    <td>{{$subSystem->id}}</td>
                    <td>{{$subSystem->name_short}} &#45; {{$subSystem->name_full}}</td>
                    <td>{{$subSystem->description}}</td>
                </tr>
                @endif                
                @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@else
@endif
@endsection