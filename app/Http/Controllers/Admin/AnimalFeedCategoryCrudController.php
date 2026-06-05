<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PlanningWorkbookExport;
use App\Http\Requests\AnimalFeedCategoryRequest;
use App\Models\AnimalFeedCategory;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Stats4sd\FileUtil\Http\Controllers\Operations\ExportOperation;

class AnimalFeedCategoryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
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
        CRUD::column('id')->label('ID');
        CRUD::column('animalFeed.id')->label('Alimentation Animaux ID');
        CRUD::column('animalFeed.farm.code')->label('UPA');
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

    protected function setupShowOperation()
    {
        $this->setupListOperation();
        
        CRUD::column('created_at')
            ->type('datetime')
            ->label('Créé le');

        CRUD::column('updated_at')
            ->type('datetime')
            ->label('Mis à jour le');
    }

    protected function setupUpdateOperation()
    {
        CRUD::setValidation(AnimalFeedCategoryRequest::class);

        $this->crud->getRequest()->request->set('id', $this->crud->getCurrentEntry()->id);
        $this->crud->getRequest()->request->set('animal_feed_id', $this->crud->getCurrentEntry()->animal_feed_id);

        CRUD::field('id')
            ->type('number')
            ->label('ID')
            ->attributes(['disabled' => 'disabled']);

        CRUD::field('animal_feed_id')
            ->type('number')
            ->label('Alimentation Animaux ID')
            ->attributes(['disabled' => 'disabled']);

        CRUD::field('animalFeed.farm.code')
            ->label('UPA')
            ->attributes(['disabled' => 'disabled']);

        CRUD::field('categorie');
        CRUD::field('nb_animaux')->type('number');
        CRUD::field('type_regime');
        CRUD::field('comp_faible_con')->type('number')->attributes(['step' => 'any']);
        CRUD::field('comp_faible_resid')->type('number')->attributes(['step' => 'any']);
        CRUD::field('comp_faible_fane')->type('number')->attributes(['step' => 'any']);
        CRUD::field('comp_ameli_con')->type('number')->attributes(['step' => 'any']);
        CRUD::field('comp_ameli_resid')->type('number')->attributes(['step' => 'any']);
        CRUD::field('comp_ameli_fane')->type('number')->attributes(['step' => 'any']);
        CRUD::field('stabulation_con')->type('number')->attributes(['step' => 'any']);
        CRUD::field('stabulation_resid')->type('number')->attributes(['step' => 'any']);
        CRUD::field('stabulation_fane')->type('number')->attributes(['step' => 'any']);

    }

    public function export() 
    {
        return Excel::download(new PlanningWorkbookExport, 'donnees_de_planification - '.Carbon::now()->format('Ymd_His').'.xlsx');
    }

}
