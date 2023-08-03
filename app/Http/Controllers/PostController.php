<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function createPost(Request $request)
    {

        $camposValores = $request->validate([
            'title' => ['required'],
            'body' => ['required'],
            'imagem' => ['required', 'image']
        ]);

        $imagemPath = $request->file('imagem')->store('public/uploads');
        $nomeArquivo = basename($imagemPath);

        $camposValores['title'] = strip_tags($camposValores['title']);
        $camposValores['body'] = strip_tags($camposValores['body']);
        $camposValores['user_id'] = auth()->id();
        $camposValores['imagem'] = 'storage/uploads/' . $nomeArquivo;
        Post::create($camposValores);
        return redirect('/');
    }
    public function telaEditarPost(Post $post)
    {
        return view('edit-post', ['post' => $post]);
    }

    public function updatePost(Post $post, Request $request)
    {
        if (auth()->user()->id === $post('user_id')) {
            $camposValores = $request->validate([
                'title' => ['required'],
                'body' => ['required'],
            ]);

            $camposValores['title'] = strip_tags($camposValores['title']);
            $camposValores['body'] = strip_tags($camposValores['body']);

            if ($request->hasFile('imagem')) {
                $imagemPath = $request->file('imagem')->store('public/uploads');
                $nomeArquivo = basename($imagemPath);
                $camposValores['imagem'] = 'storage/uploads/' . $nomeArquivo;
            }
            $post->update($camposValores);
        }
        return redirect('/');
    }
    public function deletePost(Post $post)
    {
        if (auth()->user()->id === $post->user_id) {
            $post->delete();
        }
        return redirect('/');
    }
}
