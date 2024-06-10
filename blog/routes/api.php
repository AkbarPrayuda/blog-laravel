<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PostsController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return response()->json([
        'status' => 'Akses tidak Diperbolehkan'
    ], 401);
})->name('login');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json([
        'status' => true,
        'message' => 'Success',
        'data' => $request->user()
    ], 200);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user/posts', [UserController::class, 'index']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('comment/{post}', [CommentsController::class, 'store']);
    Route::post('comment/{comments}/delete', [CommentsController::class, 'destroy']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('posts', [PostsController::class, 'index']);
    Route::get('posts/{post}', [PostsController::class, 'show']);
    Route::post('posts', [PostsController::class, 'store']);
    Route::post('posts/{post}/update', [PostsController::class, 'update']);
    Route::post('posts/{post}/delete', [PostsController::class, 'destroy']);
});
