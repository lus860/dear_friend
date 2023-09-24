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

// Google Auth
Route::post('/auth/redirect', [AuthController::class, 'auth/redirect'])->name('auth.redirect');
Route::post('/auth/callback', [AuthController::class, 'auth/callback'])->name('auth.callback');

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
Route::put('/letters/{id}', 'LetterController@update')->name('letters.update');
Route::delete('/letters/{id}', 'LetterController@destroy')->name('letters.destroy');

// Reports
Route::get('/reports', 'ReportController@index')->name('reports.index');
Route::post('/reports', 'ReportController@store')->name('reports.store');
Route::get('/reports/{id}', 'ReportController@show')->name('reports.show');
Route::put('/reports/{id}', 'ReportController@update')->name('reports.update');
Route::delete('/reports/{id}', 'ReportController@destroy')->name('reports.destroy');
