@extends('Layouts.app')

@section('title', 'Login')

@section('content')
<div class="mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Please log in
                </div>
                <div class="card-body">
                    <form action="{{route('login')}}" method="post">
                        @csrf

                        <div class="row mb-3">
                            <label for="inputEmail" class="col-sm-2 offset-sm-2 col-form-label">Email</label>
                            <div class="col-sm-6">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="inputEmail" name="email" onfocusout="checkEmailAddress(this)" focus required/>

                                @error('email')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="inputPassword" class="col-sm-2 offset-sm-2 col-form-label">Password</label>
                            <div class="col-sm-6">
                                <input type="password" class="form-control" id="inputPassword" name="password" required/>
                            </div>
                        </div>

                        <div class="col-12 offset-sm-4">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection