<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/all', [HomeController::class, 'all'])->name('home.all');

//Admin
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

//Rutas del Admin
Route::namespace('App/Http/Controllers')->prefix('admin')->group(function(){
    //Articles
    Route::resource('articles', 'ArticleController')
        ->except('show')
        ->names('admin.articles');

    //Categories
    Route::resource('categories', 'CategoryController')
        ->except('show')
        ->names('admin.categories');

    //Comments
    Route::resource('comments', 'CommentController')
        ->only(['index', 'destroy'])
        ->names('admin.comments');
});

//Articles
Route::resource('articles', ArticleController::class)
    ->except('show')
    ->names('articles');

// Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
// Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
// Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
// Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');
// Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
// Route::put('/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
// Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');

//Categories
Route::resource('categories', CategoryController::class)
    ->except('show')
    ->names('categories');

//Ver Articulos
Route::get('articles/{article}', [ArticleController::class, 'show'])
    ->name('articles.show');

// Articulos por Categoría
Route::get('category/{category}', [CategoryController::class, 'detail'])
    ->name('categories.detail');

//Comentarios
Route::resource('comments', CommentController::class)
    ->only(['index', 'destroy'])
    ->names('comments');

//Usuarios
Route::resource('users', UserController::class)
    ->except('create','store','show')
    ->names('users');

//Roles
Route::resource('roles', RoleController::class)
    ->except('show')
    ->names('roles');


// Route::post('comments', [CommentController::class, 'store'])->name('comments.store');

Route::post('/comment',[CommentController::class, 'store'])->name('comments.store'); 

Route::resource('profiles', ProfileController::class)
    ->names('profiles');
    
Auth::routes();    