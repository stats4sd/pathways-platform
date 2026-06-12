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
    Route::crud('farm_detail', 'FarmDetailCrudController');
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
    Route::crud('union_cereale', 'UnionCerealeCrudController');
    Route::crud('cooperative_cereale', 'CooperativeCerealeCrudController');
    Route::crud('federation_scpc', 'FederationScpcCrudController');
    Route::crud('union_scpc', 'UnionScpcCrudController');
    Route::crud('base_scpc', 'BaseScpcCrudController');
    Route::crud('cercle', 'CercleCrudController');
    Route::crud('commune', 'CommuneCrudController');
    Route::crud('village', 'VillageCrudController');
    Route::crud('farm_expense', 'FarmExpenseCrudController');
    Route::crud('organic_fertiliser', 'OrganicFertiliserCrudController');
    Route::crud('human_cereal_need', 'HumanCerealNeedCrudController');
    Route::crud('animal_feed', 'AnimalFeedCrudController');
    Route::crud('animal_feed_category', 'AnimalFeedCategoryCrudController');
    Route::crud('audit', 'AuditCrudController');

}); // this should be the absolute last line of this file
