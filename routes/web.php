<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [UserController::class, 'index']);


Route::post('/user-registration', [UserController::class, 'UserRegistration']);
Route::post('/user-login', [UserController::class, 'UserLogin']);
Route::post('/send-otp', [UserController::class, 'SendOTP']);
Route::post('/verify-otp', [UserController::class, 'VerifyOTP']);

//Posts Routes
Route::post('/public-posts', [PostController::class, 'PublicPosts']);

// Tags Routes
Route::post('/tags', [TagController::class, 'GetTags']);


Route::middleware(TokenVerificationMiddleware::class)->group(function () {
    //All User Routes
    Route::post('/dashboard', [UserController::class, 'Dashboard']);
    Route::post('/user-logout', [UserController::class, 'UserLogout']);
    Route::post('/reset-password', [UserController::class, 'ResetPassword']);


    //All Post Routes
    Route::post('/create-post', [PostController::class, 'CreatePost']);
    Route::post('/post-list', [PostController::class, 'PostList']);
    Route::post('/post-by-id', [PostController::class, 'PostById']);
    Route::post('/update-post', [PostController::class, 'PostUpdate']);
    Route::post('/delete-post/{id}', [PostController::class, 'PostDelete']);


    //All tags routes
    Route::post('/create-tag', [TagController::class, 'CreateTag']);



    // All Comment Routes
    Route::post('/posts/{postId}/comments', [CommentController::class, 'CommentCreate']);
    Route::post('/posts/{postId}/comment-list', [CommentController::class, 'CommentList']);
    Route::post('/comments/{commentId}', [CommentController::class, 'CommentUpdate']);
    Route::post('/comments/{commentId}', [CommentController::class, 'CommentDelete']);
});
