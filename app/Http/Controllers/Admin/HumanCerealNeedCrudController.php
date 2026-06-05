<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\HumanCerealNeed;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PlanningWorkbookExport;
use App\Http\Requests\HumanCerealNeedRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Stats4sd\FileUtil\Http\Controllers\Operations\ExportOperation;

class HumanCerealNeedCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use ExportOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\HumanCerealNeed::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/human_cereal_need');
        CRUD::setEntityNameStrings('Besoins Cereales Humain', 'Besoins Cereales Humain');
        CRUD::set('export.exporter', PlanningWorkbookExport::class);
    }

    protected function setupListOperation()
    {
        CRUD::column('id')->label('ID');
        CRUD::column('farm_id')->label('UPA');
        CRUD::column('year');
        CRUD::column('type_menage');
        CRUD::column('personnes_nourrir');
        CRUD::column('besoin_cereale_exploitation');
        CRUD::column('sac_mais');
        CRUD::column('sac_mil');
        CRUD::column('sac_sorgho');
        CRUD::column('sac_cereales');
        CRUD::column('sac_cereales_diff');
        CRUD::column('rend_moyen_mais');
        CRUD::column('rend_moyen_mil');
        CRUD::column('rend_moyen_sorgho');
        CRUD::column('superficie_mais');
        CRUD::column('superficie_mil');
        CRUD::column('superficie_sorgho');
        CRUD::column('superficie_totale');
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
        CRUD::setValidation(HumanCerealNeedRequest::class);

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
        CRUD::field('type_menage');
        CRUD::field('personnes_nourrir')->type('number');
        CRUD::field('besoin_cereale_exploitation')->type('number');
        CRUD::field('sac_mais')->type('number');
        CRUD::field('sac_mil')->type('number');
        CRUD::field('sac_sorgho')->type('number');
        CRUD::field('sac_cereales')->type('number');
        CRUD::field('sac_cereales_diff')->type('number');
        CRUD::field('rend_moyen_mais')->type('number');
        CRUD::field('rend_moyen_mil')->type('number');
        CRUD::field('rend_moyen_sorgho')->type('number');
        CRUD::field('superficie_mais')->type('number');
        CRUD::field('superficie_mil')->type('number');
        CRUD::field('superficie_sorgho')->type('number');
        CRUD::field('superficie_totale')->type('number');

    }

    public function export() 
    {
        return Excel::download(new PlanningWorkbookExport, 'donnees_de_planification - '.Carbon::now()->format('Ymd_His').'.xlsx');
    }

}
