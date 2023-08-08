<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /* Função para a criação de um post */
    public function createpost(Request $request)
    {
        /* Verifica os valores de cada um dos campos */
        $validator = Validator::make($request->all(), [
            'title' => ['required'],
            'body' => ['required'],
            'image' => ['required', 'image']
        ]);

        if ($validator->fails()) {
            return redirect('/newpost')->with('error', 'Dados do post invalidos!');
        } else {
            $fieldValues = $request->validate([
                'title' => ['required'],
                'body' => ['required'],
                'image' => ['required', 'image'],
                'emailAuthor2' => [],
                'emailAuthor3' => [],
                'emailAuthor4' => [],
                'emailAuthor5' => [],
                'emailAuthor6' => []
            ]);
        }

        /* armazena a image do campo nos arquivos do servidor e manda para o banco de dados o endreço dela no servidor */
        $imagePath = $request->file('image')->store('public/uploads');
        $nomeArquivo = basename($imagePath);

        $fieldValues['title'] = strip_tags($fieldValues['title']);
        $fieldValues['body'] = strip_tags($fieldValues['body']);
        $fieldValues['user_id'] = auth()->id();
        $fieldValues['image'] = 'storage/uploads/' . $nomeArquivo;

        try {
            $post = Post::create($fieldValues);
            $post->users()->sync($fieldValues['user_id']);
        } catch (\Exception $e) {
            $errormsg = $e->getMessage();
            return redirect('/')->with('error', $errormsg);
        }

        $multipleAuthors = $request->input('multiple_authors', 0);
        if ($multipleAuthors == 1) {
            $count = 2;
            $userIds = [];
            $userIds[] = auth()->id();

            do {
                $field = 'emailAuthor' . $count;
                $emailValue = Arr::get($fieldValues, $field);

                if (!empty($emailValue)) {
                    $user = User::where('email', $emailValue)->first();

                    if ($user) {
                        $userIds[] = $user->id;
                    }
                }

                $count++;
            } while ($count <= 6);

            try {
                $post->users()->sync($userIds);
            } catch (\Exception $e) {
                $errormsg = $e->getMessage();
                return redirect('/')->with('error', $errormsg);
            }

            return redirect('/')->with('message', 'Post cadastrado e relação criada com sucesso !');
        } else {
            return redirect('/')->with('message', 'Post cadastrado com sucesso !');
        }
    }
    /* Função para chamar e inserir os valores atuais na pagina de edição de posts */
    public function editPost(Post $post)
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
                $fieldValues = $request->validate([
                    'title' => ['required'],
                    'body' => ['required'],
                ]);
            }

            $fieldValues['title'] = strip_tags($fieldValues['title']);
            $fieldValues['body'] = strip_tags($fieldValues['body']);
            /* Realiza o processo de atualização do post e informa o usuario */
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('public/uploads');
                $nomeArquivo = basename($imagePath);
                $fieldValues['image'] = 'storage/uploads/' . $nomeArquivo;
            }
            try {
                $post->update($fieldValues);
            } catch (\Exception $e) {
                $errormsg = $e->getMessage();
                return redirect('/')->with('error', $errormsg);
            }
        }
        return redirect('/')->with('message', 'Post editado com sucesso !');
    }
    /* Função para a exclusão do post */
    public function deletePost(Post $post)
    {
        if (auth()->user()->id === $post->user_id) {

            try {
                $post->delete();
            } catch (\Illuminate\Database\QueryException $e) {
                if ($e->getCode() == 23000) {
                    return redirect('/')->with('error', 'Esse post não pode ser Deletado, pois ele possui relação com outro usuarios!');
                }
            } catch (\Exception $e) {
                $errormsg = $e->getMessage();
                return redirect('/')->with('error', $errormsg);
            }
        }
        return redirect('/')->with('info', 'Post deletado com sucesso !');
    }
}
