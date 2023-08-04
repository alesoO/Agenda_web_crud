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
//Rotas de Paginas
Route::get('/', function () {
    $posts = Post::all();
    return view('home', ['posts' => $posts]);
});
Route::get('/cadastrar', function () {
    return view('register');
});
Route::get('/newpost', function () {
    return view('post');
});
//Rotas de Usuarios
Route::post('/register',[UserController::class, 'cadastro']);
Route::post('/logout', [UserController::class, 'logout']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/edituser/{user}', [UserController::class, 'telaEditarUser']);
Route::put('/edituser/{user}', [UserController::class, 'updateUser']);
Route::delete('/deleteuser/{user}', [UserController::class, 'deleteUser']);
//Rotas dos Posts
Route::post('/editpost/{post}', [PostController::class, 'telaEditarPost']);
Route::put('/editpost/{post}', [PostController::class, 'updatePost']);
Route::post('/createpost', [PostController::class, 'createPost']);
Route::delete('/deletepost/{post}', [PostController::class, 'deletePost']);

Route::get('/login', function () {
    return view('login');
});


/* Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php'; */
