<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\FarmCrudController;

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
    Route::get('union_cereale/fetch-cercles', 'UnionCerealeCrudController@fetchCercles');
    Route::crud('union_cereale', 'UnionCerealeCrudController');
    Route::get('cooperative_cereale/fetch-cercles', 'CooperativeCerealeCrudController@fetchCercles');
    Route::get('cooperative_cereale/fetch-unions', 'CooperativeCerealeCrudController@fetchUnions');
    Route::get('cooperative_cereale/fetch-villages', 'CooperativeCerealeCrudController@fetchVillages');
    Route::crud('cooperative_cereale', 'CooperativeCerealeCrudController');
    Route::crud('federation_scpc', 'FederationScpcCrudController');
    Route::get('union_scpc/fetch-cercles', 'UnionScpcCrudController@fetchCercles');
    Route::get('union_scpc/fetch-communes', 'UnionScpcCrudController@fetchCommunes');
    Route::crud('union_scpc', 'UnionScpcCrudController');
    Route::get('base_scpc/fetch-cercles', 'BaseScpcCrudController@fetchCercles');
    Route::get('base_scpc/fetch-communes', 'BaseScpcCrudController@fetchCommunes');
    Route::get('base_scpc/fetch-villages', 'BaseScpcCrudController@fetchVillages');
    Route::crud('base_scpc', 'BaseScpcCrudController');
    Route::crud('cercle', 'CercleCrudController');
    Route::get('commune/fetch-cercles', 'CommuneCrudController@fetchCercles');
    Route::crud('commune', 'CommuneCrudController');
    Route::get('village/fetch-cercles', 'VillageCrudController@fetchCercles');
    Route::get('village/fetch-communes', 'VillageCrudController@fetchCommunes');
    Route::crud('village', 'VillageCrudController');
    Route::crud('farm_expense', 'FarmExpenseCrudController');
    Route::crud('organic_fertiliser', 'OrganicFertiliserCrudController');
    Route::crud('human_cereal_need', 'HumanCerealNeedCrudController');
    Route::crud('animal_feed', 'AnimalFeedCrudController');
    Route::crud('animal_feed_category', 'AnimalFeedCategoryCrudController');
    Route::crud('audit', 'AuditCrudController');

}); // this should be the absolute last line of this file
