<?php

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

});

require __DIR__.'/auth.php';

Route::post('admin/submissions/process', [SubmissionController::class, 'process'])->name('submission.process');