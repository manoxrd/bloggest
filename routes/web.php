<?php

use App\Http\Controllers\AttachmentsController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ForgotPasswrodController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {


  Route::delete('/logout', [SessionController::class, 'destroy']);

  Route::get('/profile', function (Request $request) {
    $user = $request->user();

    return redirect("/@{$user->username}");
  });

  Route::get('/profile/edit', [UserController::class, 'edit']); // the profile editing page
  Route::patch('/profile/edit', [UserController::class, 'update']); //a patch request to that page
  Route::delete('/profile/destroy', [UserController::class, 'destroy']); // if this happened the guest data will be deleted completly and he will be redirected to the homepage

  Route::get('/blog/create', [PostController::class, 'create'])->name('post.create');
  Route::post('/blog/create', [PostController::class, 'store'])->name('post.store');
  Route::get('/blog/{post:slug}/edit', [PostController::class, 'edit'])->name('post.edit');
  Route::patch('/blog/{post:slug}', [PostController::class, 'update'])->name('post.update');
  Route::delete('/blog/{post:slug}', [PostController::class, 'destroy'])->name('post.destroy');

  Route::post('/attachments', [AttachmentsController::class, 'store']);
  Route::delete('/attachments', [AttachmentsController::class, 'destroy']);

  
  Route::post('/@{user:username}/{post:slug}/like', [LikeController::class, 'store']);
  Route::delete('/@{user:username}/{post:slug}/like', [LikeController::class, 'destroy']);
  
  Route::post('/@{user:username}/{post:slug}/comments', [CommentController::class, 'store'])->name('comment.create');
  Route::patch('/@{user:username}/{post:slug}/comments/{comment}', [CommentController::class, 'update'])->scopeBindings()->name('comment.update');
  Route::delete('/@{user:username}/{post:slug}/comments/{comment}', [CommentController::class, 'destroy'])->scopeBindings()->name('comment.delete');

  Route::post('/@{user:username}/posts', [UserController::class, 'indexPosts']);
  Route::post('/@{user:username}/comments', [UserController::class, 'indexComments']);
});


Route::middleware(['guest'])->group(function () {


  Route::get('/register', [RegisterUserController::class, 'create'])->name('register');
  Route::post('/register', [RegisterUserController::class, 'store']);

  Route::get('/login', [SessionController::class, 'create'])->name('login');
  Route::post('/login', [SessionController::class, 'store']);

  Route::get('/forgot-password', [ForgotPasswrodController::class, 'create'])->name('password.request');
  Route::post('/forgot-password', [ForgotPasswrodController::class, 'store'])->name('password.email');

  Route::get('/reset-password/{token}', [ForgotPasswrodController::class, 'edit'])->name('password.reset');
  Route::patch('/reset-password', [ForgotPasswrodController::class, 'update'])->name('password.update');
});


Route::get('/', [PostController::class, 'index']);

Route::get('/@{user:username}', [UserController::class, 'show']); // the public view

Route::get("/@{user:username}/{post:slug}", [PostController::class, 'show'])->name('post.show');

Route::get('/blog', [BlogController::class, 'index'])->name('blog');

Route::get('/search', SearchController::class);

Route::get('/tags/{tag:tag}', TagController::class);