<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/auth/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth:sanctum');

// Google Auth
Route::post('/auth/redirect', [AuthController::class, 'redirectToGoogle'])->name('auth.redirect');
Route::post('/auth/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.callback');

// Affirmations
Route::get('/affirmations', 'AffirmationController@index')->name('affirmations.index');
Route::post('/affirmations', 'AffirmationController@store')->name('affirmations.store');
Route::get('/affirmations/{id}', 'AffirmationController@show')->name('affirmations.show');
Route::put('/affirmations/{id}', 'AffirmationController@update')->name('affirmations.update');
Route::delete('/affirmations/{id}', 'AffirmationController@destroy')->name('affirmations.destroy');

// Letters
Route::get('/letters', 'LetterController@index')->name('letters.index');
Route::post('/letters', 'LetterController@store')->name('letters.store');
Route::get('/letters/{id}', 'LetterController@show')->name('letters.show');
Route::post('/letters/update/{id}', 'LetterController@update')->name('letters.update');
Route::delete('/letters/{id}', 'LetterController@destroy')->name('letters.destroy');
Route::post('/letters/change_status', 'LetterController@changeStatus')->name('letters.change_status');

// Reports
Route::get('/reports', 'ReportController@index')->name('reports.index');
Route::post('/reports', 'ReportController@store')->name('reports.store');
Route::get('/reports/{id}', 'ReportController@show')->name('reports.show');
Route::put('/reports/{id}', 'ReportController@update')->name('reports.update');
Route::delete('/reports/{id}', 'ReportController@destroy')->name('reports.destroy');

// Countries
Route::get('/countries', 'CountryController@index')->name('countries.index');

// Users
Route::get('/users_count', 'UserController@getUsersCount')->name('users.count');
Route::get('/auth_user', 'UserController@getAuthUser')->name('user.auth');

// Forgot Password
Route::post('/password/email', 'ForgotPasswordController@forgotPassword');
Route::post('/password/reset', 'ForgotPasswordController@reset')->name('password.reset');
