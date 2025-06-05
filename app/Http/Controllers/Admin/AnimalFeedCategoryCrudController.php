<?php

namespace App\Http\Controllers\Admin;

use App\Models\AnimalFeedCategory;
use App\Exports\PlanningWorkbookExport;
use App\Http\Requests\AnimalFeedCategoryRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Stats4sd\FileUtil\Http\Controllers\Operations\ExportOperation;

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
    use ExportOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\AnimalFeedCategory::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/animal_feed_category');
        CRUD::setEntityNameStrings('Alimentation Animaux - Categorie', 'Alimentation Animaux - Categorie');
        CRUD::set('export.exporter', PlanningWorkbookExport::class);
    }

    protected function setupListOperation()
    {
        CRUD::column('animalFeed.farm.code')->label('UPA');
        CRUD::column('animalFeed.id')->label('Alimentation Animaux ID');
        CRUD::column('categorie');
        CRUD::column('nb_animaux');
        CRUD::column('type_regime');
        CRUD::column('comp_faible_con');
        CRUD::column('comp_faible_resid');
        CRUD::column('comp_faible_fane');
        CRUD::column('comp_ameli_con');
        CRUD::column('comp_ameli_resid');
        CRUD::column('comp_ameli_fane');
        CRUD::column('stabulation_con');
        CRUD::column('stabulation_resid');
        CRUD::column('stabulation_fane');
    }

    public function export() 
    {
        return Excel::download(new PlanningWorkbookExport, 'donnees_de_planification - '.Carbon::now()->format('Ymd_His').'.xlsx');
    }

}
