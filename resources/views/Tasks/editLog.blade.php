@extends('Layouts.app')

@section('title', 'Edit log entry')

@section('content')
<div class="mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-12 col-xl-8">
            <div class="card">
                <div class="card-header">
                    Edit log entry for task: <span class="text-primary">{{$taskLog->Task->name}}</span>
                </div>
                <div class="card-body">
                    <form action="{{route('editLog', [$kanbanBoard->id, $taskLog->id])}}" method="post">
                        @csrf

                        <div class="row mb-3">
                            <label for="inputDescription" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <textarea class="form-control @error('description') is-invalid @enderror" id="inputdescription" name="description" maxlength="1000" rows="10" required onkeyup="displayCharCount(this)">{{$taskLog->description}}</textarea>

                                @error('description')
                                <div class="invalid-feedback">
                                    Please give the task a name.
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-2">
                                <button type="submit" class="btn btn-success">Save log entry</button>
                                <a href="{{ url()->previous() }}" class="btn btn-danger">{{ __('Cancel') }}</a>
                            </div>
                            <div class="col-md-2 offset-md-2">
                                <p id="charCount" class="col-form-label font-monospace">{{Str::length($taskLog->description)}} / 1000</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function displayCharCount(element) {
        document.querySelector("#charCount").innerHTML = element.value.length.toString() + " / 1000";
        //console.log(element.value.length);
    }
</script>
@endsection