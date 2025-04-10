<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AnimalFeedCategoryRequest;
use App\Models\AnimalFeedCategory;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class AnimalFeedCategoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AnimalFeedCategoryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\AnimalFeedCategory::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/animal_feed_category');
        CRUD::setEntityNameStrings('Alimentation Animaux - Categorie', 'Alimentation Animaux - Categorie');
    }

    protected function setupListOperation()
    {
        CRUD::column('animalFeed.farm.code')->label('UPA');
        CRUD::column('animalFeed.id')->label('Alimentation Animaux ID');
        CRUD::column('categorie');
        CRUD::column('nb_animaux');
        CRUD::column('type_regime');
    }

}
