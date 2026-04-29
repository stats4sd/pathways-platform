<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\FarmExpense;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PlanningWorkbookExport;
use App\Http\Requests\FarmExpenseRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Stats4sd\FileUtil\Http\Controllers\Operations\ExportOperation;

class FarmExpenseCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use ExportOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\FarmExpense::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/farm_expense');
        CRUD::setEntityNameStrings('Dépense UPA', 'Dépenses UPA');
        CRUD::set('export.exporter', PlanningWorkbookExport::class);
    }

    protected function setupListOperation()
    {
        CRUD::column('id')->label('ID');
        CRUD::column('farm_id')->label('UPA');
        CRUD::column('year');
        CRUD::column('frais_condiment_jour');
        CRUD::column('frais_condiment_annuel');
        CRUD::column('nombre_personne_upa');
        CRUD::column('frais_sante_annuel');
        CRUD::column('frais_education_annuel');
        CRUD::column('nom_autre_frais');
        CRUD::column('montant_autre_frais');
        CRUD::column('invest_maison');
        CRUD::column('invest_mariage');
        CRUD::column('invest_equipment');
        CRUD::column('autre_invest');
        CRUD::column('montant_autre_invest');
        CRUD::column('depenses_recurrentes');
        CRUD::column('depenses_investissements');
        CRUD::column('depenes_total');
        CRUD::column('observation_texte');
        CRUD::column('observation_audio')->type('url')
            ->wrapper(['href'=>function($crud, $column, $entry) {
                if (!empty($entry->observation_audio)) {
                    $media = $entry->getMedia()->where('file_name', $entry->observation_audio)->first();
                    if ($media) {
                        return $media->getUrl();
                    } else {
                        return '';
                    }
                }
                return null;
            }]);
        CRUD::column('observation_videos')->type('url')
            ->wrapper(['href'=>function($crud, $column, $entry) {
                if (!empty($entry->observation_videos)) {
                    $media = $entry->getMedia()->where('file_name', $entry->observation_videos)->first();
                    if ($media) {
                        return $media->getUrl();
                    } else {
                        return '';
                    }
                }
                return null;
            }]);
        CRUD::column('observation_image')->type('url')
            ->wrapper(['href'=>function($crud, $column, $entry) {
                if (!empty($entry->observation_image)) {
                    $media = $entry->getMedia()->where('file_name', $entry->observation_image)->first();
                    if ($media) {
                        return $media->getUrl();
                    } else {
                        return '';
                    }
                }
                return null;
            }]);
        CRUD::column('observation_appreciation')->type('url')
            ->wrapper(['href'=>function($crud, $column, $entry) {
                if (!empty($entry->observation_appreciation)) {
                    $media = $entry->getMedia()->where('file_name', $entry->observation_appreciation)->first();
                    if ($media) {
                        return $media->getUrl();
                    } else {
                        return '';
                    }
                }
                return null;
            }]);

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
        CRUD::setValidation(FarmExpenseRequest::class);

        $this->crud->getRequest()->request->set('id', $this->crud->getCurrentEntry()->id);
        $this->crud->getRequest()->request->set('farm_id', $this->crud->getCurrentEntry()->farm_id);

        CRUD::field('id')
            ->type('number')
            ->label('ID')
            ->attributes(['disabled' => 'disabled']);

        CRUD::field('farm_id')
            ->label('UPA')
            ->attributes(['disabled' => 'disabled']);

        CRUD::field('year')->type('number');
        CRUD::field('frais_condiment_jour')->type('number')->attributes(['step' => '0.01']);
        CRUD::field('frais_condiment_annuel')->type('number')->attributes(['step' => '0.01']);
        CRUD::field('nombre_personne_upa')->type('number');
        CRUD::field('frais_sante_annuel')->type('number')->attributes(['step' => '0.01']);
        CRUD::field('frais_education_annuel')->type('number')->attributes(['step' => '0.01']);
        CRUD::field('nom_autre_frais');
        CRUD::field('montant_autre_frais')->type('number')->attributes(['step' => '0.01']);
        CRUD::field('invest_maison')->type('number')->attributes(['step' => '0.01']);
        CRUD::field('invest_mariage')->type('number')->attributes(['step' => '0.01']);
        CRUD::field('invest_equipment');
        CRUD::field('autre_invest');
        CRUD::field('montant_autre_invest')->type('number')->attributes(['step' => '0.01']);
        CRUD::field('depenses_recurrentes')->type('number')->attributes(['step' => '0.01']);
        CRUD::field('depenses_investissements')->type('number')->attributes(['step' => '0.01']);
        CRUD::field('depenes_total')->type('number')->attributes(['step' => '0.01']);

    }

    public function export() 
    {
        return Excel::download(new PlanningWorkbookExport, 'donnees_de_planification - '.Carbon::now()->format('Ymd_His').'.xlsx');
    }

}
