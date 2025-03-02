@extends('Layouts.app')

@section('title', 'Create applicant')

@section('content')
<div class="mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8 col-xl-6">
            <div class="card">
                <div class="card-header">
                    Create a kanban board
                </div>
                <div class="card-body">
                    <form action="{{route('editKanban', $kanbanBoard->id)}}" method="post">
                        @csrf
                        
                        <div class="row mb-3">
                            <label for="name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10 border-end border-danger border-3">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" maxlength="255" required value="{{$kanbanBoard->name}}"/>

                                @error('name')
                                <div class="invalid-feedback">
                                    Please give the board a name.
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputDescription" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <textarea class="form-control @error('description') is-invalid @enderror" id="inputDescription" name="description" maxlength="255" onkeyup="displayCharCount(this, 'charCount')" placeholder="max 255 characters are allowed">{{$kanbanBoard->description}}</textarea>

                                @error('description')
                                <div class="invalid-feedback">
                                    Please provide a board description.
                                </div>
                                @enderror
                                <div id="charCount" class="text-end">
                                    0 / 255
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-2">
                                <button type="submit" class="btn btn-success">Update kanban board</button>
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