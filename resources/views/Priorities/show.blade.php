@extends('Layouts.app')

@section('title', 'Priority info')

@section('content')
<div class="mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Info for priority: <span class="fw-bold fs-5 text-primary font-monospace">{{$priority->name}}</span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="{{$priority->name}}" disabled/>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputDescription" class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" rows="4" disabled>{{$priority->description}}</textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputOrderNumber" class="col-sm-2 col-form-label">Order number</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" value="{{$priority->order_number}}" disabled/>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="color" class="col-sm-2 col-form-label">Color</label>
                        <div class="col-sm-10">
                            <input id="color" type="color" class="form-control form-control-color" value="#{{$priority->ColorHex}}" disabled>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6 offset-md-2">
                            <a href="{{route('editPriority', [$kanbanBoard->id, $priority->id])}}" type="submit" class="btn btn-warning" title="Edit this priority">{{ __('Edit') }}</a>
                            <a href="{{ url()->previous() }}" class="btn btn-danger">{{ __('Cancel') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection