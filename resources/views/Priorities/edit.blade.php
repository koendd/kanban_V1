@extends('Layouts.app')

@section('title', 'Edit priority')

@section('content')
<div class="mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8 col-xl-6">
            <div class="card">
                <div class="card-header">
                    Edit priority: <span class="fw-bold fs-5 text-primary font-monospace">{{$priority->name}}</span>
                </div>
                <div class="card-body">
                    <form action="{{route('editPriority', [$kanbanBoard->id, $priority->id])}}" method="post">
                        @csrf
                        
                        <div class="row mb-3">
                            <label for="name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10 border-end border-danger border-3">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" maxlength="50" required value="{{$priority->name}}"/>

                                @error('name')
                                <div class="invalid-feedback">
                                    Please give the priority a name.
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputDescription" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <textarea class="form-control @error('description') is-invalid @enderror" id="inputDescription" name="description" maxlength="1000" rows="4" autocomplete="off" onkeyup="displayCharCount(this, 'charCount')" placeholder="max 1000 characters are allowed">{{$priority->description}}</textarea>

                                @error('description')
                                <div class="invalid-feedback">
                                    Please provide a priority description.
                                </div>
                                @enderror
                                <div id="charCount" class="text-end">
                                    {{Str::length($priority->description)}} / 1000
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputOrderNumber" class="col-sm-2 col-form-label">Order number</label>
                            <div class="col-sm-10 border-end border-danger border-3">
                                <input type="number" class="form-control @error('order_number') is-invalid @enderror" id="inputOrderNumber" name="order_number" min="0" max="100" value="{{$priority->order_number}}" />

                                @error('order_number')
                                <div class="invalid-feedback">
                                    Please provide a order number.
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="color" class="col-sm-2 col-form-label">Color</label>
                            <div class="col-sm-10 border-end border-danger border-3">
                                <input id="color" type="color" class="form-control form-control-color" name="color" required value="#{{$priority->ColorHex}}">
                            </div>

                            @error('color')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-2">
                                <button type="submit" class="btn btn-success">Save priority</button>
                                <a href="{{ url()->previous() }}" class="btn btn-danger">{{ __('Cancel') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection