@extends('Layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="d-flex justify-content-between mt-5">
    <div class="p-2">
        <h1>Welcome back {{ Auth::user()->name }}</h1>
    </div>
</div>

<ul class="list-group list-group-flush">
    @foreach($kanbanBoards as $board)
    <li class="list-group-item">
        <a href="{{route('home', $board->id)}}">
            <div class="ms-2 me-auto">
                <div class="fw-bold">{{$board->name}}</div>
                {{$board->description}}
            </div>
        </a> 
    </li>
    @endforeach
</ul>
@endsection