@extends('Layouts.app')

@section('title', 'Edit system')

@section('content')
<div class="mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Edit system: <span class="fw-bold fs-5 text-primary font-monospace">{{$system->name}}</span>
                </div>
                <div class="card-body">
                    <form action="{{route('editSystem', [$kanbanBoard->id, $system->id])}}" method="post">
                        @csrf
                        
                        <div class="row mb-3">
                            <label for="inputShortName" class="col-sm-2 col-form-label">Short name</label>
                            <div class="col-sm-10 border-end border-danger border-3">
                                <input type="text" class="form-control @error('name_short') is-invalid @enderror" id="inputShortName" name="name_short" maxlength="50" required value="{{$system->name_short}}"/>

                                @error('name_short')
                                <div class="invalid-feedback">
                                    Please give the system a short name.
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputFullName" class="col-sm-2 col-form-label">Full name</label>
                            <div class="col-sm-10 border-end border-danger border-3">
                                <input type="text" class="form-control @error('name_full') is-invalid @enderror" id="inputFullName" name="name_full" maxlength="255" required value="{{$system->name_full}}"/>

                                @error('name_full')
                                <div class="invalid-feedback">
                                    Please give the system a full name.
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputDescription" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <textarea class="form-control @error('description') is-invalid @enderror" id="inputDescription" name="description" maxlength="255" onkeyup="displayCharCount(this, 'charCount')">{{$system->description}}</textarea>

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
                            <label for="inputKanbanBoard" class="col-sm-2 col-form-label">Kanban Board</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('kanban_board_id') is-invalid @enderror" id="inputKanbanBoard" value="{{$kanbanBoard->name}}" readonly disabled/>
                                <input type="hidden" name="kanban_board_id" value="{{$kanbanBoard->id}}" />

                                @error('kanban_board_id')
                                <div class="invalid-feedback">
                                    The kanban board is not correct.
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-2">
                                <button type="submit" class="btn btn-success">Save system</button>
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