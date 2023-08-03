<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function createPost(Request $request)
    {
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

        $imagemPath = $request->file('imagem')->store('public/uploads');
        $nomeArquivo = basename($imagemPath);

        $camposValores['title'] = strip_tags($camposValores['title']);
        $camposValores['body'] = strip_tags($camposValores['body']);
        $camposValores['user_id'] = auth()->id();
        $camposValores['imagem'] = 'storage/uploads/' . $nomeArquivo;
        Post::create($camposValores);
        return redirect('/')->with('message', 'Post cadastrado com sucesso !');
    }
    public function telaEditarPost(Post $post)
    {
        return view('edit-post', ['post' => $post]);
    }

    public function updatePost(Post $post, Request $request)
    {
        if (auth()->user()->id === $post->user_id) {

            $validator = Validator::make($request->all(), [
                'title' => ['required'],
                'body' => ['required'],
            ]);

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

            if ($request->hasFile('imagem')) {
                $imagemPath = $request->file('imagem')->store('public/uploads');
                $nomeArquivo = basename($imagemPath);
                $camposValores['imagem'] = 'storage/uploads/' . $nomeArquivo;
            }
            $post->update($camposValores);
        }
        return redirect('/')->with('message', 'Post editado com sucesso !');
    }
    public function deletePost(Post $post)
    {
        if (auth()->user()->id === $post->user_id) {
            $post->delete();
        }
        return redirect('/')->with('info', 'Post deletado com sucesso !');
    }
}
