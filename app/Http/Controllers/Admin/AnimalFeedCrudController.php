<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PlanningWorkbookExport;
use App\Http\Requests\AnimalFeedRequest;
use App\Models\AnimalFeed;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Stats4sd\FileUtil\Http\Controllers\Operations\ExportOperation;

class AnimalFeedCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use ExportOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\AnimalFeed::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/animal_feed');
        CRUD::setEntityNameStrings('Alimentation Animaux', 'Alimentation Animaux');
        CRUD::set('export.exporter', PlanningWorkbookExport::class);
    }

    protected function setupListOperation()
    {
        CRUD::column('id')->label('ID');
        CRUD::column('farm_id')->label('UPA');
        CRUD::column('year');
        CRUD::column('total_concentre');
        CRUD::column('total_residu');
        CRUD::column('total_fane');
        CRUD::column('liste_cat_animales');
        CRUD::column('quantite_son');
        CRUD::column('quantite_tourteau');
        CRUD::column('concentre_produit');
        CRUD::column('achat_son_quantite');
        CRUD::column('prix_sac_son');
        CRUD::column('cal_depense_son');
        CRUD::column('prix_sac_tourteau');
        CRUD::column('cal_depense_tourteau');
        CRUD::column('cal_depense_tour');
        CRUD::column('cal_superficie');
        CRUD::column('cal_depense_total');
        CRUD::column('cal_depense_soins');
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
        CRUD::setValidation(AnimalFeedRequest::class);

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
        CRUD::field('total_concentre')->type('number')->attributes(['step' => 'any']);
        CRUD::field('total_residu')->type('number')->attributes(['step' => 'any']);
        CRUD::field('total_fane')->type('number')->attributes(['step' => 'any']);
        CRUD::field('liste_cat_animales');
        CRUD::field('quantite_son')->type('number')->attributes(['step' => 'any']);
        CRUD::field('quantite_tourteau')->type('number')->attributes(['step' => 'any']);
        CRUD::field('concentre_produit')->type('number');
        CRUD::field('achat_son_quantite')->type('number')->attributes(['step' => 'any']);
        CRUD::field('prix_sac_son')->type('number');
        CRUD::field('cal_depense_son')->type('number');
        CRUD::field('prix_sac_tourteau')->type('number')->attributes(['step' => 'any']);
        CRUD::field('cal_depense_tourteau')->type('number')->attributes(['step' => 'any']);
        CRUD::field('cal_depense_tour')->type('number')->attributes(['step' => 'any']);
        CRUD::field('cal_superficie')->type('number')->attributes(['step' => 'any']);
        CRUD::field('cal_depense_total')->type('number')->attributes(['step' => 'any']);
        CRUD::field('cal_depense_soins')->type('number')->attributes(['step' => 'any']);

    }

    public function export() 
    {
        return Excel::download(new PlanningWorkbookExport, 'donnees_de_planification - '.Carbon::now()->format('Ymd_His').'.xlsx');
    }
}
