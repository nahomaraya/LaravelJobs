<?php

use App\Models\Jobs;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\UserController;


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




//all jobs
Route::get('/', [JobsController::class,'index']);
//new job
Route::get('/create',[JobsController::class, 'create'])->middleware('auth');
//store new job
Route::post('/',[JobsController::class, 'store'])->middleware('auth');
//edit job page
Route::get('/{job}/edit',[JobsController::class, 'edit'])->middleware('auth');
//store edit 
Route::put('/{job}',[JobsController::class, 'update'])->middleware('auth');
//delete job
Route::delete('/{job}',[JobsController::class, 'delete'])->middleware('auth');
//manage jobs
Route::get('/manage',[JobsController::class, 'manage'])->middleware('auth');
//show job

Route::get('/register',[UserController::class, 'create'])->middleware('guest');
Route::post('/users',[UserController::class, 'store']);

//login
Route::get('/login',[UserController::class, 'login'])->name('login')->middleware('guest');
Route::post('/users/authenticate', [UserController::class, 'authenticate']);

//Logout
Route::post('/logout',[UserController::class, 'logout'])->middleware('auth');

Route::get('/{job}',[JobsController::class, 'show']);








