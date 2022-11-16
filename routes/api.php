<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ActionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//basic crud
Route::get('users', [UserController::class, 'index']);
Route::post('users/store', [UserController::class, 'store']);
Route::get('users/show/{id}', [UserController::class, 'show']);
Route::post('users/update/{id}', [UserController::class, 'update']);
Route::get('users/destroy/{id}', [UserController::class, 'destroy']);

//route app
Route::post('users/loginUser', [UserController::class, 'loginUser']);
Route::post('users/registerUser', [UserController::class, 'registerUser']);

Route::get('posts', [PostController::class, 'index']);
Route::post('posts/store', [PostController::class, 'store']);
Route::get('posts/show/{id}', [PostController::class, 'show']);
Route::get('posts/getPostLikeDetails/{id}', [PostController::class, 'getPostLikeDetails']);
Route::get('posts/getPostCommentDetails/{id}', [PostController::class, 'getPostCommentDetails']);
Route::post('posts/likePost', [PostController::class, 'likePost']);
Route::post('posts/unlikePost', [PostController::class, 'unlikePost']);
Route::post('posts/commentPost', [PostController::class, 'commentPost']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
