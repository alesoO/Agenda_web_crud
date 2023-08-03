<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function cadastro(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required', Rule::unique('users', 'name')],
            'email' => ['required', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8']
        ]);

        if ($validator->fails()) {
            return redirect('/')->with('error', 'Dados invalidos!');
        } else {
            $camposValores = $request->validate([
                'name' => ['required', Rule::unique('users', 'name')],
                'email' => ['required', Rule::unique('users', 'email')],
                'password' => ['required', 'min:8']
            ]);
        }

        $camposValores['password'] = bcrypt($camposValores['password']);
        $user = User::create($camposValores);
        auth()->login($user);
        return redirect('/')->with('message', 'Usuario cadastrado com sucesso !');
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/')->with('info', 'Sessão encerrada com sucesso !');
    }

    public function login(Request $request)
    {

        $camposValores = $request->validate([
            'email' => ['required'],
            'password' => ['required']
        ]);
        if (auth()->attempt(['email' => $camposValores['email'], 'password' => $camposValores['password']])) {
            $request->session()->regenerate();
        }else{
            return redirect('/login')->with('error', 'Login ou senha incorretos!');
        }
        return redirect('/')->with('message', 'Login realizado com sucesso !');
    }
}
