<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\models\User;

class ChangePasswordController extends Controller
{
    public function change() {
        return View('Authenticate.change');
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'current_password' => ['required', 'string', 'current_password'],
            'password' => ['required', 'confirmed', 'different:current_password', Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised()],
        ]);
        
        if(Hash::check($request->current_password, Auth::user()->password)) {
            $user = User::find(Auth::id());
            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->route('welcome');
        }

        return redirect()->back()->withErrors(['current_password' => "Your current password do not match!"]);
    }
}
