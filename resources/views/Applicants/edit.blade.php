@extends('Layouts.app')

@section('title', 'Edit applicant')

@section('content')
<div class="mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8 col-xl-6">
            <div class="card">
                <div class="card-header">
                    Create a applicant
                </div>
                <div class="card-body">
                    <form action="{{route('editApplicant', [$kanbanBoard->id, $applicant->id])}}" method="post">
                        @csrf
                        
                        <div class="row mb-3">
                            <label for="name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10 border-end border-danger border-3">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" maxlength="50" required value="{{$applicant->name}}"/>

                                @error('name')
                                <div class="invalid-feedback">
                                    Please give the applicant a name.
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-2">
                                <button type="submit" class="btn btn-success">Update applicant</button>
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