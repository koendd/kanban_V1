@extends('Layouts.app')

@section('title', 'Create subsystem')

@section('content')
<div class="mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Create a new subsystem
                </div>
                <div class="card-body">
                    <form action="{{route('createSubSystem', $kanbanBoard->id)}}" method="post">
                        @csrf
                        
                        <div class="row mb-3">
                            <label for="inputShortName" class="col-sm-2 col-form-label">Short name</label>
                            <div class="col-sm-10 border-end border-danger border-3">
                                <input type="text" class="form-control @error('name_short') is-invalid @enderror" id="inputShortName" name="name_short" maxlength="50" required value="{{old('name_short')}}"/>

                                @error('name_short')
                                <div class="invalid-feedback">
                                    Please give the subsystem a short name.
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputFullName" class="col-sm-2 col-form-label">Full name</label>
                            <div class="col-sm-10 border-end border-danger border-3">
                                <input type="text" class="form-control @error('name_full') is-invalid @enderror" id="inputFullName" name="name_full" maxlength="255" required value="{{old('name_full')}}"/>

                                @error('name_full')
                                <div class="invalid-feedback">
                                    Please give the subsystem a full name.
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputDescription" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <textarea class="form-control @error('description') is-invalid @enderror" id="inputDescription" name="description" maxlength="255" value="{{old('description')}}" onkeyup="displayCharCount(this, 'charCount')"></textarea>

                                @error('description')
                                <div class="invalid-feedback">
                                    Please provide a task description.
                                </div>
                                @enderror
                                <div id="charCount" class="text-end">
                                    0 / 255
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputSystem" class="col-sm-2 col-form-label">System</label>
                            <div class="col-sm-10 border-end border-danger border-3">
                                <select class="form-select @error('system_id') is-invalid @enderror" id="inputSystem" name="system_id" required>
                                    <option disabled selected>Choose a system</option>
                                    @foreach($systems as $system)
                                    <option value="{{$system->id}}">{{$system->name_short}}{{$system->name_full ? ' - ' . $system->name_full : ''}}</option>
                                    @endforeach
                                </select>

                                @error('system_id')
                                <div class="invalid-feedback">
                                    Please select a system.
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-2">
                                <button type="submit" class="btn btn-success">Create sub system</button>
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