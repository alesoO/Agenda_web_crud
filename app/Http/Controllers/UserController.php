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

    /* Função para o cadastro de usuarios */
    public function cadastro(Request $request)
    {
        /* valida os valores dos campos */
        $validator = Validator::make($request->all(), [
            'name' => ['required', Rule::unique('users', 'name')],
            'email' => ['required', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8']
        ]);

        /* Informa erros com os valores aos usuarios */
        if ($validator->fails()) {
            return redirect('/')->with('error', 'Dados invalidos!');
        } else {
            $camposValores = $request->validate([
                'name' => ['required', Rule::unique('users', 'name')],
                'email' => ['required', Rule::unique('users', 'email')],
                'password' => ['required', 'min:8']
            ]);
        }
        /* cryptografa a senha e cadastra o usuario e realiza o seu login */
        $camposValores['password'] = bcrypt($camposValores['password']);
        $user = User::create($camposValores);
        auth()->login($user);
        /* Informa ao usuario que a operação foi bem sucedida */
        return redirect('/')->with('message', 'Usuario cadastrado com sucesso !');
    }
    /* Função para chamar e inserir os valores atuais na pagina de edição de usuario */
    public function telaEditarUser(User $user)
    {
        return view('edit-user', ['user' => $user]);
    }
    /* Função para a atualização do cadastro */
    public function updateUser(User $user, Request $request)
    {
        /* Verifica o usuario que esta fazendo a atualização */
        if (auth()->user()->id === $user->id) {

            /* Faz verficações separadas para cada um dos valores dos campos */
            $validatorName = Validator::make($request->all(), [
                'name' => ['required', Rule::unique('users', 'name')],
            ]);

            $validatorEmail = Validator::make($request->all(), [
                'email' => ['required', Rule::unique('users', 'email')]
            ]);

            /* Faz validação de cada um dos valores dos campos e os prepara para o banco de dados */
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

            /* Verifica a senha para a autorização da edição, e informa o usuario da situação do processo */

            if (Hash::check($camposValores['password'], $user->password)) {
                $user->update($camposValores);
            } else {
                return redirect('/')->with('error', 'Senha incorreta!');
            }
            return redirect('/')->with('message', 'Usuario editado com sucesso !');
        }
        return redirect('/')->with('error', 'Você não pode alterar um perfil que não é seu !');
    }
    /* Função para o encerramento da sessão do usuario */
    public function logout()
    {
        auth()->logout();
        return redirect('/')->with('info', 'Sessão encerrada com sucesso !');
    }
    /* Função para a exclusão do usuario */
    public function deleteUser(Request $request)
    {
        /* Verifica o ID do usuario para a autorização da exclusão */
        $user = User::find(Auth::user()->id);

        /* Verifica a senha para a autorização da exclusão, e informa o usuario da situação do processo */
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::logout();
            if ($user->delete()) {
                return redirect('/')->with('info', 'Sua conta foi excluída com sucesso.');
            }
        } else {
            return redirect('/')->with('error', 'Senha incorreta. Tente novamente.');
        }
    }

    /* Função para a realização do processo de Login */
    public function login(Request $request)
    {
        /* valida os valores dos campos */
        $camposValores = $request->validate([
            'email' => ['required'],
            'password' => ['required']
        ]);
        /* Verifica os valores apresentados com os cadastrados no banco de dados para o processo de login informa o usuario da situação do processo*/
        if (auth()->attempt(['email' => $camposValores['email'], 'password' => $camposValores['password']])) {
            $request->session()->regenerate();
        } else {
            return redirect('/login')->with('error', 'Login ou senha incorretos!');
        }
        return redirect('/')->with('message', 'Login realizado com sucesso !');
    }
}
