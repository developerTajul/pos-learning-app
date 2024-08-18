<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Middleware\TokenVerification;
use App\Http\Controllers\DashboardController;

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


// api routes
Route::get('/users', [UsersController::class, 'index']);
Route::get('/users/{id}', [UsersController::class, 'show'])->middleware([TokenVerification::class]);
Route::get('/users/{id}/edit', [UsersController::class, 'edit'])->middleware([TokenVerification::class]);
Route::put('/users/{id}/update', [UsersController::class, 'update'])->middleware([TokenVerification::class]);
Route::delete('/users/{id}/delete', [UsersController::class, 'destroy']);

Route::get('/user-profile', [UsersController::class, 'userProfile'])->middleware([TokenVerification::class]);
Route::post('/profile-update', [UsersController::class, 'profileUpdate'])->middleware([TokenVerification::class]);

Route::post('/register', [UsersController::class, 'store']);
Route::post('/login', [UsersController::class, 'login']);
Route::post('/forget-password', [UsersController::class, 'forgetPassword']);
Route::put('/verify-otp-code', [UsersController::class, 'verifyOtp']);
Route::put('/reset-password', [UsersController::class, 'resetPassword'])->middleware([TokenVerification::class]);

Route::get('/logout', [UsersController::class, 'userLogout']);

// routes for page
Route::get('/login', [UsersController::class, 'loginPage']);
Route::get('/register', [UsersController::class, 'create']);
Route::get('/forget-password', [UsersController::class, 'forgetPasswordPage']);
Route::get('/verify-otp-code', [UsersController::class, 'verifyOtpPage']);
Route::get('/reset-password', [UsersController::class, 'resetPasswordPage'])->middleware([TokenVerification::class]);;


Route::get('/dashboard', [DashboardController::class, 'index'])->middleware([TokenVerification::class]);