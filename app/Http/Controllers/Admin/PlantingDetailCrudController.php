<?php

namespace App\Http\Controllers\Admin;

use \Stats4sd\FileUtil\Http\Controllers\Operations\ExportOperation;
use App\Exports\MonitoringWorkbookExport;
use App\Http\Controllers\Admin\Traits\ExportMediaOperation;
use App\Http\Requests\PlantingDetailRequest;
use App\Models\Crop;
use App\Models\PlantingDetail;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class PlantingDetailCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use ExportOperation;
    use ExportMediaOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\PlantingDetail::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/planting_detail');
        CRUD::setEntityNameStrings('semis - culture', 'semis - culture');
        CRUD::set('export.exporter', MonitoringWorkbookExport::class);

    }

    protected function setupListOperation()
    {
        CRUD::column('id')->label('ID');
        CRUD::column('planting.id')->label('Semis ID');
        CRUD::column('planting.farm.code')->label('UPA');
        CRUD::column('crop_id')->label('Culture');

        CRUD::column('observation_image')
                ->type('url')
                ->wrapper(['href'=>function($crud, $column, $entry) {
                    if(!empty($entry->observation_image)) {
                        $mediaUrl = $entry->getMedia()->where('file_name', $entry->observation_image)->first()->getUrl();
                        return $mediaUrl;
                    }
                }]);

        CRUD::column('observation_audio')
                ->type('url')
                ->wrapper(['href'=>function($crud, $column, $entry) {
                    if(!empty($entry->observation_audio)) {
                        $mediaUrl = $entry->getMedia()->where('file_name', $entry->observation_audio)->first()->getUrl();
                        return $mediaUrl;
                    }
                }]);

        CRUD::column('observation_videos')
                ->type('url')
                ->wrapper(['href'=>function($crud, $column, $entry) {
                    if(!empty($entry->observation_videos)) {
                        $mediaUrl = $entry->getMedia()->where('file_name', $entry->observation_videos)->first()->getUrl();
                        return $mediaUrl;
                    }
                }]);

        CRUD::column('observation_texte');

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

        CRUD::column('superficie_ha');
        CRUD::column('culture_prev');
        CRUD::column('quantite_fumure_organique');
        CRUD::column('cout_transport');
        CRUD::column('quantite_chaux_agricole');
        CRUD::column('cout_chaux_agricole');
        CRUD::column('quantite_pnt_png');
        CRUD::column('cout_pnt_png');
        CRUD::column('superficie_labouree');
        CRUD::column('cout_superficie_labouree');
        CRUD::column('date_semence');
        CRUD::column('quantite_semence');
        CRUD::column('quantite_semence_achetee');
        CRUD::column('cout_semence_achetee');
        CRUD::column('quantite_herbicide_prelevee');
        CRUD::column('cout_herbicide_prelevee');
        CRUD::column('cout');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
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
        CRUD::setValidation(PlantingDetailRequest::class);

        $this->crud->getRequest()->request->set('id', $this->crud->getCurrentEntry()->id);
        $this->crud->getRequest()->request->set('planting_id', $this->crud->getCurrentEntry()->planting_id);

        CRUD::field('id')
            ->type('number')
            ->label('ID')
            ->attributes(['disabled' => 'disabled']);

        CRUD::field('planting_id')
            ->label('Planting ID')
            ->attributes(['disabled' => 'disabled']);

        CRUD::field('planting.farm.code')
            ->label('UPA')
            ->attributes(['disabled' => 'disabled']);

        CRUD::field('crop_id')
            ->label('Culture')
            ->type('select_from_array')
            ->options(
                Crop::all()->pluck('label_fr', 'id')->toArray()
            );

        CRUD::field('superficie_ha')->type('number')->attributes(['step' => '0.01']);

        CRUD::field('culture_prev')
            ->type('select_from_array')
            ->options(
                Crop::all()->pluck('label_fr', 'id')->toArray()
            );
            
        CRUD::field('quantite_fumure_organique')->type('number');
        CRUD::field('cout_transport')->type('number')->attributes(['step' => '0.01']);
        CRUD::field('quantite_chaux_agricole')->type('number');
        CRUD::field('cout_chaux_agricole')->type('number')->attributes(['step' => '0.01']);
        CRUD::field('quantite_pnt_png')->type('number');
        CRUD::field('cout_pnt_png')->type('number')->attributes(['step' => '0.01']);
        CRUD::field('superficie_labouree')->type('number')->attributes(['step' => '0.01']);
        CRUD::field('cout_superficie_labouree')->type('number')->attributes(['step' => '0.01']);
        CRUD::field('date_semence');
        CRUD::field('quantite_semence')->type('number')->attributes(['step' => '0.01']);
        CRUD::field('quantite_semence_achetee')->type('number')->attributes(['step' => '0.01']);
        CRUD::field('cout_semence_achetee')->type('number')->attributes(['step' => '0.01']);
        CRUD::field('quantite_herbicide_prelevee')->type('number');
        CRUD::field('cout_herbicide_prelevee')->type('number')->attributes(['step' => '0.01']);
        CRUD::field('cout')->type('number')->attributes(['step' => '0.01']);

    }

    public function export()
    {
        return Excel::download(new MonitoringWorkbookExport, 'donnees_de_suivi - '.Carbon::now()->format('Ymd_His').'.xlsx');
    }

}
