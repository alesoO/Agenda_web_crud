<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

    public function telaEditarUser(User $user)
    {
        return view('edit-user', ['user' => $user]);
    }

    public function updateUser(User $user, Request $request)
    {
        if (auth()->user()->id === $user->id) {

            $validatorName = Validator::make($request->all(), [
                'name' => ['required', Rule::unique('users', 'name')],
            ]);

            $validatorEmail = Validator::make($request->all(), [
                'email' => ['required', Rule::unique('users', 'email')]
            ]);

            if ($validatorName->fails()) {
                if ($validatorEmail->fails()) {
                    return redirect('/')->with('error', 'Dados da edição de usuario invalidos!');
                } else {
                    $camposValores = $request->validate([
                        'email' => ['required', Rule::unique('users', 'email')],
                        'password' => ['required']
                    ]);
                    $camposValores['email'] = strip_tags($camposValores['email']);
                }
            } elseif ($validatorEmail->fails()) {
                $camposValores = $request->validate([
                    'name' => ['required', Rule::unique('users', 'name')],
                    'password' => ['required']
                ]);
                $camposValores['name'] = strip_tags($camposValores['name']);
            } else {
                $camposValores = $request->validate([
                    'name' => ['required', Rule::unique('users', 'name')],
                    'email' => ['required', Rule::unique('users', 'email')],
                    'password' => ['required']
                ]);
                $camposValores['name'] = strip_tags($camposValores['name']);
                $camposValores['email'] = strip_tags($camposValores['email']);
            }

            if (Hash::check($camposValores['password'], $user->password)) {
                $user->update($camposValores);
            } else {
                return redirect('/')->with('error', 'Senha incorreta!');
            }
            return redirect('/')->with('message', 'Usuario editado com sucesso !');
        }
        return redirect('/')->with('message', 'Usuario editado com sucesso !');
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/')->with('info', 'Sessão encerrada com sucesso !');
    }

    public function deleteUser(Request $request)
    {
        $user = User::find(Auth::user()->id);

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::logout();
            if ($user->delete()) {
                return redirect('/')->with('info', 'Sua conta foi excluída com sucesso.');
            }
        } else {
            return redirect('/')->with('error', 'Senha incorreta. Tente novamente.');
        }
    }

    public function login(Request $request)
    {

        $camposValores = $request->validate([
            'email' => ['required'],
            'password' => ['required']
        ]);
        if (auth()->attempt(['email' => $camposValores['email'], 'password' => $camposValores['password']])) {
            $request->session()->regenerate();
        } else {
            return redirect('/login')->with('error', 'Login ou senha incorretos!');
        }
        return redirect('/')->with('message', 'Login realizado com sucesso !');
    }
}
