<?php

use App\Http\Controllers\ForumCommentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// //prefix adalah route sebelumnya
// Route::group([
// 'middleware' => 'api','prefix' => 'auth'
// ], function ($router) {

// Route::post('register', registercontroller@register);    
// Route::post('login', 'AuthController@login');
// Route::post('logout', 'AuthController@logout');
// Route::post('refresh', 'AuthController@refresh');
// Route::post('me', 'AuthController@me');

// });
Route::prefix('auth')->controller(RegisterController::class)->middleware('api')->group(function () {
    Route::post('/register', 'register')->name('auth.register');


  });

  Route::prefix('auth')->controller(AuthController::class)->middleware('api')->group(function () {
    Route::post('/login', 'login')->name('auth.login');
    Route::post('/logout', 'logout')->name('auth.logout');
    Route::post('/refresh', 'refresh')->name('auth.refresh');
    Route::post('/me', 'me')->name('auth.me');


  });

  Route::apiResource('forums', ForumController::class)->middleware('api');
  Route::apiResource('forums.comments', ForumCommentController::class)->middleware('api');
//forums/{idforum}/comments/{idcomment}

Route::get('forums/tags/{tag}',[ForumController::class, 'filtertag'])->middleware('api');

Route::get('user/@{username}',[UserController::class, 'show'])->middleware('api');

Route::get('user/@{username}/activity',[UserController::class, 'getActivity'])->middleware('api');