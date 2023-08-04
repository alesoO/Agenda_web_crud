<?php

use App\Models\Post;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Monolog\Handler\RotatingFileHandler;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Rotas de Paginas */
/* Rota da pagina inicial */
Route::get('/', function () {
    $posts = Post::all();
    return view('home', ['posts' => $posts]);
});
/* Rota da pagina de cadastro do usuario */
Route::get('/cadastrar', function () {
    return view('register');
});
/* Rota da pagina de adição de post */
Route::get('/newpost', function () {
    return view('post');
});

/* Rota da pagina de Login de post */
Route::get('/login', function () {
    return view('login');
});

//Rotas de Usuarios
/* Rota para função de cadastro no controlador de usuarios */
Route::post('/register', [UserController::class, 'cadastro']);
/* Rota para função de logout no controlador de usuarios */
Route::post('/logout', [UserController::class, 'logout']);
/* Rota para função de login no controlador de usuarios */
Route::post('/login', [UserController::class, 'login']);
/* Rota para função de chamado da tela de edição de usuarios no controlador de usuarios */
Route::post('/edituser/{user}', [UserController::class, 'telaEditarUser']);
/* Rota para função de edição de usuarios no controlador de usuarios */
Route::put('/edituser/{user}', [UserController::class, 'updateUser']);
/* Rota para função de exclusão de usuario no controlador de usuarios */
Route::delete('/deleteuser/{user}', [UserController::class, 'deleteUser']);

//Rotas dos Posts

/* Rota para função de chamado da tela de edição de posts no controlador de posts */
Route::post('/editpost/{post}', [PostController::class, 'telaEditarPost']);
/* Rota para função de edição de posts no controlador de posts */
Route::put('/editpost/{post}', [PostController::class, 'updatePost']);
/* Rota para função de adição de um post no controlador de posts */
Route::post('/createpost', [PostController::class, 'createPost']);
/* Rota para função de exclusão de posts no controlador de posts */
Route::delete('/deletepost/{post}', [PostController::class, 'deletePost']);

/* Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php'; */
