<?php

use App\Http\Controllers\SubmissionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TeamCrudController;
use Stats4sd\TeamManagement\Http\Controllers\TeamMemberController;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('crop', 'CropCrudController');
    Route::crud('farm', 'FarmCrudController');
    Route::crud('planting', 'PlantingCrudController');
    Route::crud('planting_detail', 'PlantingDetailCrudController');
    Route::crud('post_planting', 'PostPlantingCrudController');
    Route::crud('post_planting_detail', 'PostPlantingDetailCrudController');
    Route::crud('harvest', 'HarvestCrudController');
    Route::crud('harvest_detail', 'HarvestDetailCrudController');
    Route::crud('plot', 'PlotCrudController');
    Route::crud('field', 'FieldCrudController');
}); // this should be the absolute last line of this file
