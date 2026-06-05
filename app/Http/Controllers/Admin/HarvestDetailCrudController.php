<?php

namespace App\Http\Controllers\Admin;

use \Stats4sd\FileUtil\Http\Controllers\Operations\ExportOperation;
use App\Exports\MonitoringWorkbookExport;
use App\Http\Controllers\Admin\Traits\ExportMediaOperation;
use App\Http\Requests\HarvestDetailRequest;
use App\Models\Crop;
use App\Models\HarvestDetail;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class HarvestDetailCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class HarvestDetailCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use ExportOperation;
    use ExportMediaOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\HarvestDetail::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/harvest_detail');
        CRUD::setEntityNameStrings('récolte - culture', 'récolte - culture');
        CRUD::set('export.exporter', MonitoringWorkbookExport::class);
    }

    protected function setupListOperation()
    {
        CRUD::column('id')->label('ID');
        CRUD::column('harvest.id')->label('Récolte ID');
        CRUD::column('harvest.farm.code')->label('UPA');
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

        CRUD::column('superficie_recolte_prestation');
        CRUD::column('cout_total_prestation_recolte');
        CRUD::column('production');
        CRUD::column('cout_total_battage');
        CRUD::column('production_residu_culture');
        CRUD::column('nombre_botte');
        CRUD::column('cout');

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
        CRUD::setValidation(HarvestDetailRequest::class);

        $this->crud->getRequest()->request->set('id', $this->crud->getCurrentEntry()->id);
        $this->crud->getRequest()->request->set('harvest_id', $this->crud->getCurrentEntry()->harvest_id);

        CRUD::field('id')
            ->type('number')
            ->label('ID')
            ->attributes(['disabled' => 'disabled']);

        CRUD::field('harvest_id')
            ->label('Récolte ID')
            ->attributes(['disabled' => 'disabled']);

        CRUD::field('harvest.farm.code')
            ->label('UPA')
            ->attributes(['disabled' => 'disabled']);

        CRUD::field('crop_id')
            ->label('Culture')
            ->type('select_from_array')
            ->options(
                Crop::all()->pluck('label_fr', 'id')->toArray()
            );

        CRUD::field('superficie_recolte_prestation')->type('number')->attributes(['step' => '0.01']);
        CRUD::field('cout_total_prestation_recolte')->type('number');
        CRUD::field('production')->type('number')->attributes(['step' => '0.01']);
        CRUD::field('cout_total_battage')->type('number');
        CRUD::field('production_residu_culture')->type('number')->attributes(['step' => '0.01']);
        CRUD::field('nombre_botte')->type('number');
        CRUD::field('cout')->type('number');


    }

    public function export() 
    {
        return Excel::download(new MonitoringWorkbookExport, 'donnees_de_suivi - '.Carbon::now()->format('Ymd_His').'.xlsx');
    }

}
