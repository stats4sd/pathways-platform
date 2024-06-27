<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\FarmCrudController;
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
    Route::get('farm/{farm}/map', [FarmCrudController::class, 'renderMap']);
    Route::crud('planting', 'PlantingCrudController');
    Route::crud('planting_detail', 'PlantingDetailCrudController');
    Route::crud('post_planting', 'PostPlantingCrudController');
    Route::crud('post_planting_detail', 'PostPlantingDetailCrudController');
    Route::crud('harvest', 'HarvestCrudController');
    Route::crud('harvest_detail', 'HarvestDetailCrudController');
    Route::crud('plot', 'PlotCrudController');
    Route::crud('field', 'FieldCrudController');
    Route::crud('interest_point', 'InterestPointCrudController');
    Route::crud('region', 'RegionCrudController');
    Route::crud('cercle', 'CercleCrudController');
    Route::crud('commune', 'CommuneCrudController');
    Route::crud('village', 'VillageCrudController');

}); // this should be the absolute last line of this file
