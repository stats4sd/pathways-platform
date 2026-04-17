<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\AuthenticatedSessionFarmerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;

/**
 * No seperate Front-end
 *
 * Use these routes for platforms that only use the
 * Laravel Backpack interface and do not require a seperate
 * front-end.
 *
 * The routes here will automatically redirect any users to the
 * Backpack admin root. Logins will still be handled with Laravel / Breeze.
 */

Route::get('/', function () {
    return redirect(config('backpack.base.route_prefix'));
});

Route::get(config('backpack.base.route_prefix') . '/login', function () {
    return redirect('login');
});

/**
 * For platforms that *do* require a seperate front-end and
 * admin panel, use the routes below. This will not automatically redirect.
 * The groups are to seperate out front-end pages that are public vs
 * front-end pages that require authentication.
 */

// Route::get('/', function () {
//     return view('welcome');
// })->name('home');

Route::group([
    'middleware' => ['web', 'auth'],
], function () {
    Route::get('download/{path}', [FileController::class, 'download'])->where('path', '.*')->name('file.download');
    Route::get('farm/{farm}/FarmMapFrench', [App\Http\Controllers\FarmController::class,'getFarmCoords']);
});

Route::group([
    'middleware' => ['web', 'auth', 'farm.auth'],
], function () {
    Route::get('farm/{farm}', [App\Http\Controllers\FarmController::class, 'show']);
    Route::get('farm/{farm}/FarmYears', [App\Http\Controllers\FarmController::class,'getFarmYears']);
    Route::get('farm/{farm}/FarmMap/{year}', [App\Http\Controllers\FarmController::class,'getFarmCoords']);
    Route::get('farm/{farm}/FarmArea/{year}', [App\Http\Controllers\FarmController::class,'getFarmArea']);
    Route::get('farm/{farm}/FarmCosts/{year}', [App\Http\Controllers\FarmController::class,'getFarmCosts']);
    Route::get('farm/{farm}/FarmProduction/{year}', [App\Http\Controllers\FarmController::class,'getFarmProduction']);
    Route::get('farm/{farm}/FarmYield/{year}', [App\Http\Controllers\FarmController::class,'getFarmYield']);
    Route::get('farm/{farm}/FarmObservations/{year}', [App\Http\Controllers\FarmController::class,'getFarmObservations']);
    Route::get('farm/{farm}/FarmNeeds/{year}', [App\Http\Controllers\FarmController::class,'getFarmNeeds']);

});

require __DIR__ . '/auth.php';

// overwrite login routes
    Route::get('login', [AuthenticatedSessionFarmerController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionFarmerController::class, 'store'])
    ->name('post-login');


// farmer authentication
Route::get('login-researcher', [AuthenticatedSessionController::class, 'create'])
    ->name('login-researcher')
    ->middleware('guest');

Route::post('login-researcher', [AuthenticatedSessionController::class, 'store'])
    ->name('post-login-researcher')
    ->middleware('guest');

Route::post('admin/submissions/process', [SubmissionController::class, 'process'])->name('submission.process');
