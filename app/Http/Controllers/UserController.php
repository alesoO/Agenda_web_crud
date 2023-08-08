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
    public function createUser(Request $request)
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
            $fieldValues = $request->validate([
                'name' => ['required', Rule::unique('users', 'name')],
                'email' => ['required', Rule::unique('users', 'email')],
                'password' => ['required', 'min:8']
            ]);
        }
        /* cryptografa a senha e cadastra o usuario e realiza o seu login */
        $fieldValues['password'] = bcrypt($fieldValues['password']);
        try {
            $user = User::create($fieldValues);
            auth()->login($user);
        } catch (\Exception $e) {
            $errormsg = $e->getMessage();
            return redirect('/')->with('error', $errormsg);
        }
        /* Informa ao usuario que a operação foi bem sucedida */
        return redirect('/')->with('message', 'Usuario cadastrado com sucesso !');
    }
    /* Função para chamar e inserir os valores atuais na pagina de edição de usuario */
    public function editUser(User $user)
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
                    $fieldValues = $request->validate([
                        'email' => ['required', Rule::unique('users', 'email')],
                        'password' => ['required']
                    ]);
                    $fieldValues['email'] = strip_tags($fieldValues['email']);
                }
            } elseif ($validatorEmail->fails()) {
                $fieldValues = $request->validate([
                    'name' => ['required', Rule::unique('users', 'name')],
                    'password' => ['required']
                ]);
                $fieldValues['name'] = strip_tags($fieldValues['name']);
            } else {
                $fieldValues = $request->validate([
                    'name' => ['required', Rule::unique('users', 'name')],
                    'email' => ['required', Rule::unique('users', 'email')],
                    'password' => ['required']
                ]);
                $fieldValues['name'] = strip_tags($fieldValues['name']);
                $fieldValues['email'] = strip_tags($fieldValues['email']);
            }

            /* Verifica a senha para a autorização da edição, e informa o usuario da situação do processo */
            try {
                if (Hash::check($fieldValues['password'], $user->password)) {
                    $user->update($fieldValues);
                } else {
                    return redirect('/')->with('error', 'Senha incorreta!');
                }
            } catch (\Exception $e) {
                $errormsg = $e->getMessage();
                return redirect('/')->with('error', $errormsg);
            }
            return redirect('/')->with('message', 'Usuario editado com sucesso !');
        }
        return redirect('/')->with('error', 'Você não pode alterar um perfil que não é seu !');
    }
    /* Função para o encerramento da sessão do usuario */
    public function logout()
    {
        try {
            auth()->logout();
        } catch (\Exception $e) {
            $errormsg = $e->getMessage();
            return redirect('/')->with('error', $errormsg);
        }
        return redirect('/')->with('info', 'Sessão encerrada com sucesso !');
    }
    /* Função para a exclusão do usuario */
    public function deleteUser(Request $request)
    {
        /* Verifica o ID do usuario para a autorização da exclusão */
        try {
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
        } catch (\Exception $e) {
            $errormsg = $e->getMessage();
            return redirect('/')->with('error', $errormsg);
        }
    }

    /* Função para a realização do processo de Login */
    public function login(Request $request)
    {
        try {
            /* valida os valores dos campos */
            $fieldValues = $request->validate([
                'email' => ['required'],
                'password' => ['required']
            ]);
            /* Verifica os valores apresentados com os cadastrados no banco de dados para o processo de login informa o usuario da situação do processo*/
            if (auth()->attempt(['email' => $fieldValues['email'], 'password' => $fieldValues['password']])) {
                $request->session()->regenerate();
            } else {
                return redirect('/login')->with('error', 'Login ou senha incorretos!');
            }
            return redirect('/')->with('message', 'Login realizado com sucesso !');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                return redirect('/')->with('error', 'Esse post não pode ser Deletado, pois ele possui relação com outro usuarios!');
            }
        } catch (\Exception $e) {
            $errormsg = $e->getMessage();
            return redirect('/')->with('error', $errormsg);
        }
    }
}
