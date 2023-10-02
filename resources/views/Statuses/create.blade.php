@extends('Layouts.app')

@section('title', 'Create status')

@section('content')
<div class="mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Create a status
                </div>
                <div class="card-body">
                    <form action="{{route('createStatus', $kanbanBoard->id)}}" method="post">
                        @csrf
                        
                        <div class="row mb-3">
                            <label for="name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10 border-end border-danger border-3">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" maxlength="50" required value="{{old('name')}}"/>

                                @error('name')
                                <div class="invalid-feedback">
                                    Please give the applicant a name.
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputDescription" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <textarea class="form-control @error('description') is-invalid @enderror" id="inputDescription" name="description" maxlength="1000" rows="4" value="{{old('description')}}" autocomplete="off" onkeyup="displayCharCount(this, 'charCount')"></textarea>

                                @error('description')
                                <div class="invalid-feedback">
                                    Please provide a task description.
                                </div>
                                @enderror
                                <div id="charCount" class="text-end">
                                    0 / 1000
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputOrderNumber" class="col-sm-2 col-form-label">Order number</label>
                            <div class="col-sm-10 border-end border-danger border-3">
                                <input type="number" class="form-control @error('deadline') is-invalid @enderror" id="inputOrderNumber" name="order_number" min="0" max="100" value="{{old('order_number')}}" />

                                @error('order_number')
                                <div class="invalid-feedback">
                                    Please provide a order number.
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="enabled" class="col-md-2 col-form-label text-md-right">Kanban part</label>
                            <div class="col-sm-10 mt-2 border-end border-danger border-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="checkBoxPreparetion" name="preparetion" value="preparetion">
                                    <label class="form-check-label" for="checkBoxPreparetion">Preparetion</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="checkBoxActive" name="active" value="active">
                                    <label class="form-check-label" for="checkBoxActive">Active</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="checkBoxFinishing" name="finishing" value="finishing">
                                    <label class="form-check-label" for="checkBoxFinishing">Finishing</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="color" class="col-sm-2 col-form-label">Color</label>
                            <div class="col-sm-10 border-end border-danger border-3">
                                <input id="color" type="color" class="form-control form-control-color" name="color" required>
                            </div>

                            @error('color')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>                          

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-2">
                                <button type="submit" class="btn btn-success">Create status</button>
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