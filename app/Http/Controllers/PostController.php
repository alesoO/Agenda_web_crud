<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /* Função para a criação de um post */
    public function createPost(Request $request)
    {
        /* Verifica os valores de cada um dos campos */
        $validator = Validator::make($request->all(), [
            'title' => ['required'],
            'body' => ['required'],
            'imagem' => ['required', 'image']
        ]);

        if ($validator->fails()) {
            return redirect('/newpost')->with('error', 'Dados do post invalidos!');
        } else {
            $camposValores = $request->validate([
                'title' => ['required'],
                'body' => ['required'],
                'imagem' => ['required', 'image']
            ]);
        }
        /* armazena a imagem do campo nos arquivos do servidor e manda para o banco de dados o endreço dela no servidor */
        $imagemPath = $request->file('imagem')->store('public/uploads');
        $nomeArquivo = basename($imagemPath);

        $camposValores['title'] = strip_tags($camposValores['title']);
        $camposValores['body'] = strip_tags($camposValores['body']);
        $camposValores['user_id'] = auth()->id();
        $camposValores['imagem'] = 'storage/uploads/' . $nomeArquivo;
        Post::create($camposValores);
        return redirect('/')->with('message', 'Post cadastrado com sucesso !');
    }
    /* Função para chamar e inserir os valores atuais na pagina de edição de posts */
    public function telaEditarPost(Post $post)
    {
        return view('edit-post', ['post' => $post]);
    }
    /* Função para a atualização do post */
    public function updatePost(Post $post, Request $request)
    {
        /* Verifica o usuario que esta fazendo a atualização */
        if (auth()->user()->id === $post->user_id) {
            /* Faz verficações separadas para cada um dos valores dos campos */
            $validator = Validator::make($request->all(), [
                'title' => ['required'],
                'body' => ['required'],
            ]);
            /* Faz validação de cada um dos valores dos campos e os prepara para o banco de dados */
            if ($validator->fails()) {
                return redirect('/')->with('error', 'Dados da edição de post invalidos!');
            } else {
                $camposValores = $request->validate([
                    'title' => ['required'],
                    'body' => ['required'],
                ]);
            }

            $camposValores['title'] = strip_tags($camposValores['title']);
            $camposValores['body'] = strip_tags($camposValores['body']);
            /* Realiza o processo de atualização do post e informa o usuario */
            if ($request->hasFile('imagem')) {
                $imagemPath = $request->file('imagem')->store('public/uploads');
                $nomeArquivo = basename($imagemPath);
                $camposValores['imagem'] = 'storage/uploads/' . $nomeArquivo;
            }
            $post->update($camposValores);
        }
        return redirect('/')->with('message', 'Post editado com sucesso !');
    }
    /* Função para a exclusão do post */
    public function deletePost(Post $post)
    {
        if (auth()->user()->id === $post->user_id) {
            $post->delete();
        }
        return redirect('/')->with('info', 'Post deletado com sucesso !');
    }
}
