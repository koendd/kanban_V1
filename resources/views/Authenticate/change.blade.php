@extends('Layouts.app')

@section('title', 'Change password')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center h3">{{ __('Wijzig wachtwoord voor ') . config('app.name', 'Kanban koendd.be') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password_change') }}">
                        @csrf

                        <div class="form-group row mb-3">
                            <label for="current_password" class="col-md-4 col-form-label text-md-right">{{ __('Huidig wachtwoord') }}</label>

                            <div class="col-md-6">
                                <input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" required autocomplete="off">

                                @error('current_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Nieuw wachtwoord') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="off">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="password_confirmation" class="col-md-4 col-form-label text-md-right">{{ __('Herhaal nieuw wachtwoord') }}</label>

                            <div class="col-md-6">
                                <input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required autocomplete="off">

                                @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Wijzig wachtwoord') }}
                                </button>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="password_confirmation" class="col-md-4 col-form-label text-md-right">{{  __('Vereiste voor wachtwoord') }}</label>

                            <div class="col-md-6">
                                <ul class="list-group list-group-flush rounded">
                                    <li id="passwordContainsSmallLetters" class="list-group-item list-group-item-danger">Bevat kleine letters</li>
                                    <li id="passwordContainsBigLetters" class="list-group-item list-group-item-danger">Bevat grote letters</li>
                                    <li id="passwordContainsNumbers" class="list-group-item list-group-item-danger">Bevat een getal</li>
                                    <li id="passwordContainsSymbols" class="list-group-item list-group-item-danger">Bevat een speciaal teken</li>
                                    <li id="passwordContainsMin8" class="list-group-item list-group-item-danger">Bevat minimaal 8 tekens</li>
                                </ul>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="password_confirmation" class="col-md-4 col-form-label text-md-right">{{ __('Mogelijke speciale tekens') }}</label>

                            <div class="col-md-6">
                                <input type="text" readonly class="form-control-plaintext" value="&#x26;&#x20;&#x7c;&#x20;&#x40;&#x20;&#x22;&#x20;&#x23;&#x20;&#x27;&#x20;&#x28;&#x20;&#xa7;&#x20;&#x5e;&#x20;&#x21;&#x20;&#x7b;&#x20;&#x7d;&#x20;&#x29;&#x20;&#xb0;&#x20;&#x5c;&#x20;&#x2d;&#x20;&#x5f;&#x20;&#x20ac;&#x20;&#x5b;&#x20;&#x24;&#x20;&#x5d;&#x20;&#x2a;&#x20;&#x25;&#x20;&#xa3;&#x20;&#x2c;&#x20;&#x3f;&#x20;&#x3b;&#x20;&#x2e;&#x20;&#x3a;&#x20;&#x2f;&#x20;&#x3d;&#x20;&#x2b;&#x20;&#x7e;&#x20;&#x3c;&#x20;&#x3e;">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelector("#password").onkeyup = () => {
        // check for lowercase letters
        if(document.querySelector("#password").value.match(/(?=.*[a-z])/)) {
            document.querySelector("#passwordContainsSmallLetters").classList.remove("list-group-item-danger");
            document.querySelector("#passwordContainsSmallLetters").classList.add("list-group-item-success");
        } else {
            document.querySelector("#passwordContainsSmallLetters").classList.remove("list-group-item-success");
            document.querySelector("#passwordContainsSmallLetters").classList.add("list-group-item-danger");
        }

        // check for uppercase letters
        if(document.querySelector("#password").value.match(/(?=.*[A-Z])/)) {
            document.querySelector("#passwordContainsBigLetters").classList.remove("list-group-item-danger");
            document.querySelector("#passwordContainsBigLetters").classList.add("list-group-item-success");
        } else {
            document.querySelector("#passwordContainsBigLetters").classList.remove("list-group-item-success");
            document.querySelector("#passwordContainsBigLetters").classList.add("list-group-item-danger");
        }

        // check for numbers
        if(document.querySelector("#password").value.match(/(?=.*\d)/)) {
            document.querySelector("#passwordContainsNumbers").classList.remove("list-group-item-danger");
            document.querySelector("#passwordContainsNumbers").classList.add("list-group-item-success");
        } else {
            document.querySelector("#passwordContainsNumbers").classList.remove("list-group-item-success");
            document.querySelector("#passwordContainsNumbers").classList.add("list-group-item-danger");
        }

        // check for symbols
        if(document.querySelector("#password").value.match(/[&|@"#'(§^!{})°\\\-_€\[$\]*%£,?;.:/=+~<>]/)) {
            document.querySelector("#passwordContainsSymbols").classList.remove("list-group-item-danger");
            document.querySelector("#passwordContainsSymbols").classList.add("list-group-item-success");
        } else {
            document.querySelector("#passwordContainsSymbols").classList.remove("list-group-item-success");
            document.querySelector("#passwordContainsSymbols").classList.add("list-group-item-danger");
        }

        // check for min 8 characters
        if(document.querySelector("#password").value.match(/(?=.{8,})/)) {
            document.querySelector("#passwordContainsMin8").classList.remove("list-group-item-danger");
            document.querySelector("#passwordContainsMin8").classList.add("list-group-item-success");
        } else {
            document.querySelector("#passwordContainsMin8").classList.remove("list-group-item-success");
            document.querySelector("#passwordContainsMin8").classList.add("list-group-item-danger");
        }

        if(document.querySelector("#password").value.match(/(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[&|@"#'(§^!{})°\\\-_€\[$\]*%£,?;.:/=+~<>])(?=.{8,}).*$/)) {
            document.querySelector("#password").classList.remove("is-invalid")
            document.querySelector("#password").classList.add("is-valid")
        } else {
            document.querySelector("#password").classList.remove("is-valid")
            document.querySelector("#password").classList.add("is-invalid")
        }
    }

    document.querySelector("#password_confirmation").onkeyup = () => {
        if(document.querySelector("#password_confirmation").value == document.querySelector("#password").value) {
            document.querySelector("#password_confirmation").classList.remove("is-invalid")
            document.querySelector("#password_confirmation").classList.add("is-valid")
        } else {
            document.querySelector("#password_confirmation").classList.remove("is-valid")
            document.querySelector("#password_confirmation").classList.add("is-invalid")
        }
    }
</script>
@endsection