@extends('Layouts.app')

@section('content')
<div class="mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Create a new system
                </div>
                <div class="card-body">
                    <form action="{{route('createSystem')}}" method="post">
                        @csrf
                        
                        <div class="row mb-3">
                            <label for="inputShortName" class="col-sm-2 col-form-label">Short name</label>
                            <div class="col-sm-10">
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
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('name_full') is-invalid @enderror" id="inputFullName" name="name_full" maxlength="50" required value="{{old('name_full')}}"/>

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
                                <textarea class="form-control @error('description') is-invalid @enderror" id="inputDescription" name="description" maxlength="1000" value="{{old('description')}}"></textarea>

                                @error('description')
                                <div class="invalid-feedback">
                                    Please provide a task description.
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputKanbanBoard" class="col-sm-2 col-form-label">Kanban Board</label>
                            <div class="col-sm-10">
                                <select class="form-select @error('kanban_board_id') is-invalid @enderror" id="inputKanbanBoard" name="kanban_board_id" required>
                                    <option disabled selected>Choose a kanban board</option>
                                    @foreach($kanbanBoards as $kanbanBoard)
                                    <option value="{{$kanbanBoard->id}}">{{$kanbanBoard->name}}</option>
                                    @endforeach
                                </select>

                                @error('kanban_board_id')
                                <div class="invalid-feedback">
                                    Please select a kanban board.
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-2">
                                <button type="submit" class="btn btn-success">Create sub system</button>
                                <button type="Button" class="btn btn-danger">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection