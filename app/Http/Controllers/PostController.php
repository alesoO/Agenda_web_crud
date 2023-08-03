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
}
