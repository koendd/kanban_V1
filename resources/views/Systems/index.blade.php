@extends('Layouts.app')

@section('title', 'Systems and Subsystems')

@section('content')
<div class="d-flex justify-content-between">
    <div class="p-2">
        <h1>Systems and sub&#45;systems</h1>
    </div>
    @can('manage_kanban_content')
    <div class="p-2">
        <div class="col-auto float-right">
            <div class="input-group mb-2">
                <div class="btn-group" role="group">
                    <div class="input-group-text" id="btnGroupAddon">Create</div>
                    <a href="{{route('createSystem', $kanbanBoard->id)}}" type="button" class="btn btn-primary">System</a>
                    <a href="{{route('createSubSystem', $kanbanBoard->id)}}" type="button" class="btn btn-primary">Sub-system</a>
                </div>
            </div>
        </div>
    </div>
    @endcan
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
                    <th scope="col" class="text-center align-middle">&#35; tasks</th>
                    <th scope="col" class="text-center align-middle">Actions</th>
                    <th scope="col"></th>
                    <th scope="col" class="text-center align-middle">Sub&#45;system id</th>
					<th scope="col" class="text-center align-middle">Sub&#45;system  name</th>
                    <th scope="col" class="text-center align-middle d-none d-sm-table-cell">Sub&#45;system description</th>
                    <th scope="col" class="text-center align-middle">&#35; tasks</th>
                    <th scope="col" class="text-center align-middle">Actions</th>
				</tr>
			</thead>
            <tbody>
                @foreach($systems as $system)
                <tr>
                    <td @if($system->SubSystems->count() > 0) rowspan="{{$system->SubSystems->count()}}" @endif class="text-center">{{$system->id}}</td>
                    <td @if($system->SubSystems->count() > 0) rowspan="{{$system->SubSystems->count()}}" @endif >{{$system->name_short}} &#45; {{$system->name_full}}</td>
                    <td @if($system->SubSystems->count() > 0) rowspan="{{$system->SubSystems->count()}}" @endif >{{$system->description}}</td>
                    <td @if($system->SubSystems->count() > 0) rowspan="{{$system->SubSystems->count()}}" @endif class="text-center">{{$system->Tasks->count()}}</td>
                    <td @if($system->SubSystems->count() > 0) rowspan="{{$system->SubSystems->count()}}" @endif class="text-center">
                        <div class="dropdown dropstart">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Actions
                            </button>
                            <ul class="dropdown-menu  dropdown-menu-dark">
                                <li><a href="{{ route('showSystem', [$kanbanBoard->id, $system->id]) }}" class="dropdown-item text-primary" title="Show the info for this system.">Info</a></li>
                                <li><a href="{{ route('editSystem', [$kanbanBoard->id, $system->id]) }}" class="dropdown-item text-warning" title="Edit this system.">Edit</a></li>
                            </ul>
                        </div>
                    </td>
                    </td>
                    <td @if($system->SubSystems->count() > 0) rowspan="{{$system->SubSystems->count()}}" @endif class="text-center"></td>

                    @if($system->SubSystems->count() > 0)
                    <td class="text-center">{{$system->SubSystems->first()->id}}</td>
                    <td>{{$system->SubSystems->first()->name_short}} &#45; {{$system->SubSystems->first()->name_full}}</td>
                    <td>{{$system->SubSystems->first()->description}}</td>
                    <td class="text-center">{{$system->SubSystems->first()->Tasks->count()}}</td>
                    <td>
                        <div class="dropdown dropstart">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Actions
                            </button>
                            <ul class="dropdown-menu  dropdown-menu-dark">
                                <li><a href="{{ route('showSubSystem', [$kanbanBoard->id, $system->SubSystems->first()->id]) }}" class="dropdown-item text-primary" title="Show the info for this system.">Info</a></li>
                                <li><a href="{{ route('editSubSystem', [$kanbanBoard->id, $system->SubSystems->first()->id]) }}" class="dropdown-item text-warning" title="Edit this system.">Edit</a></li>
                            </ul>
                        </div>
                    </td>
                    @else
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    @endif
                </tr>
                @foreach($system->SubSystems as $subSystem)
                @if (!$loop->first)
                <tr>
                    <td class="text-center">{{$subSystem->id}}</td>
                    <td>{{$subSystem->name_short}} &#45; {{$subSystem->name_full}}</td>
                    <td>{{$subSystem->description}}</td>
                    <td class="text-center">{{$subSystem->Tasks->count()}}</td>
                    <td>
                        <div class="dropdown dropstart">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Actions
                            </button>
                            <ul class="dropdown-menu  dropdown-menu-dark">
                                <li><a href="{{ route('showSubSystem', [$kanbanBoard->id, $subSystem->id]) }}" class="dropdown-item text-primary" title="Show the info for this sub&#45;system.">Info</a></li>
                                <li><a href="{{ route('editSubSystem', [$kanbanBoard->id, $subSystem->id]) }}" class="dropdown-item text-warning" title="Edit this sub system.">Edit</a></li>
                            </ul>
                        </div>
                    </td>
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