<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function cadastro(Request $request)
    {
        $camposValores = $request->validate([
            'name' => ['required', Rule::unique('users', 'name')],
            'email' => ['required', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8']
        ]);

        $camposValores['password'] = bcrypt($camposValores['password']);
        $user = User::create($camposValores);
        auth()->login($user);
        return redirect('/');
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/');
    }
    public function login(Request $request){

        $camposValores = $request->validate([
            'email' => ['required'],
            'password' => ['required']
        ]);
        if(auth()->attempt(['email' => $camposValores['email'], 'password' => $camposValores['password']])){
            $request->session()->regenerate();
        }
        return redirect('/');

    }
}
