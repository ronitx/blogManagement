<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('/blogs', \App\Http\Controllers\BlogController::class);
Route::resource('/comments', \App\Http\Controllers\CommentController::class);
Route::get('/status-update/{id}', [\App\Http\Controllers\BlogController::class, 'statusUpdate']);

//Upvote and Downvote
Route::get('blogs/{id}/upvote', '\App\Http\Controllers\BlogController@upvote')->name('blogs.upvote');
Route::get('/blogs/{id}/downvote', '\App\Http\Controllers\BlogController@downvote')->name('blogs.downvote');
Route::post('/blogs/{id}/upvote', '\App\Http\Controllers\BlogController@upvote')->name('blogs.upvote');
Route::post('/blogs/{id}/downvote', '\App\Http\Controllers\BlogController@downvote')->name('blogs.downvote');