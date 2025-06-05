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

/**
 * Class FarmExpenseCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class FarmExpenseCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
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

    public function export() 
    {
        return Excel::download(new PlanningWorkbookExport, 'donnees_de_planification - '.Carbon::now()->format('Ymd_His').'.xlsx');
    }

}
