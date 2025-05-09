<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FirebaseController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DiseaseController;

Route::get('/disease', [DiseaseController::class, 'index'])->name('disease.index');
Route::post('/disease', [DiseaseController::class, 'store'])->name('disease.store');
Route::put('/diseases/{name}', [DiseaseController::class, 'update'])->name('disease.update');
Route::delete('/diseases/{name}', [DiseaseController::class, 'destroy'])->name('disease.destroy');


Route::get('/admin/derma-users', [AdminController::class, 'showDermaUsers'])->name('admin.derma-users');
Route::post('/admin/verify-user/{uid}', [AdminController::class, 'verifyUser'])->name('admin.verify-user');
Route::get('/admin/delete-user/{uid}', [AdminController::class, 'deleteUser'])->name('admin.delete-user');
Route::post('/admin/reject-user/{uid}', [AdminController::class, 'rejectUser'])->name('admin.reject-user');
    

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'adminLogin']);
Route::post('/logout', [AuthController::class, 'adminLogout'])->name('logout');

Route::get('/blog-posts', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog-posts/{postId}/edit', [BlogController::class, 'edit'])->name('blog.edit');
Route::post('/blog-posts/{postId}/update', [BlogController::class, 'update'])->name('blog.update');
Route::delete('/blog-posts/{postId}', [BlogController::class, 'destroy'])->name('blog.destroy');

Route::get('/comment/edit/{commentId}', [BlogController::class, 'editComment'])->name('comment.edit');
Route::post('/comment/update/{commentId}', [BlogController::class, 'updateComment'])->name('comment.update');
Route::delete('/comment/delete/{commentId}', [BlogController::class, 'destroyComment'])->name('comment.delete');
Route::post('/comment/store', [BlogController::class, 'storeComment'])->name('comment.store');

Route::get('/user-info/{id}', [FirebaseController::class, 'showUserInfo'])->name('user.show');

Route::get('/userlist', [FirebaseController::class, 'listUsers'])->name('users.index');


Route::get('/user/edit/{id}', [FirebaseController::class, 'editUser'])->name('user.edit');
Route::post('/user/update/{id}', [FirebaseController::class, 'updateUser'])->name('user.update');
Route::get('/user/delete/{id}', [FirebaseController::class, 'deleteUser'])->name('user.delete');

Route::get('/', function () {
    return view('mainapp');
})->name('mainapp');

