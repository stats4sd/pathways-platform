<?php

namespace App\Http\Controllers\Admin;

use \Stats4sd\FileUtil\Http\Controllers\Operations\ExportOperation;
use App\Exports\MonitoringWorkbookExport;
use App\Http\Controllers\Admin\Traits\ExportMediaOperation;
use App\Http\Requests\PostPlantingDetailRequest;
use App\Models\Crop;
use App\Models\PostPlantingDetail;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class PostPlantingDetailCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use ExportOperation;
    use ExportMediaOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\PostPlantingDetail::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/post_planting_detail');
        CRUD::setEntityNameStrings('post-semis - culture', 'post-semis - culture');
        CRUD::set('export.exporter', MonitoringWorkbookExport::class);
    }

    protected function setupListOperation()
    {
        CRUD::column('id')->label('ID');
        CRUD::column('postPlanting.id')->label('Post-Semis ID');
        CRUD::column('postPlanting.farm.code')->label('UPA');
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

        CRUD::column('superficie_sarclage');
        CRUD::column('cout_sarclage');
        CRUD::column('superficie_desherbage');
        CRUD::column('cout_desherbage');
        CRUD::column('quantite_npk');
        CRUD::column('cout_npk');
        CRUD::column('quantite_uree');
        CRUD::column('cout_uree');
        CRUD::column('quantite_herbicide');
        CRUD::column('cout_herbicide');
        CRUD::column('superficie_butee');
        CRUD::column('cout_buttage');
        CRUD::column('quantite_insecticide');
        CRUD::column('cout_insecticide');
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
        CRUD::setValidation(PostPlantingDetailRequest::class);

        $this->crud->getRequest()->request->set('id', $this->crud->getCurrentEntry()->id);
        $this->crud->getRequest()->request->set('post_planting_id', $this->crud->getCurrentEntry()->post_planting_id);

        CRUD::field('id')
            ->type('number')
            ->label('ID')
            ->attributes(['disabled' => 'disabled']);

        CRUD::field('post_planting_id')
            ->label('Post-Semis ID')
            ->attributes(['disabled' => 'disabled']);

        CRUD::field('postPlanting.farm.code')
            ->label('UPA')
            ->attributes(['disabled' => 'disabled']);

        CRUD::field('crop_id')
            ->label('Culture')
            ->type('select_from_array')
            ->options(
                Crop::all()->pluck('label_fr', 'id')->toArray()
            );
        CRUD::field('superficie_sarclage')->type('number')->attributes(['step' => '0.01']);
        CRUD::field('cout_sarclage')->type('number');
        CRUD::field('superficie_desherbage')->type('number')->attributes(['step' => '0.01']);
        CRUD::field('cout_desherbage')->type('number');
        CRUD::field('quantite_npk')->type('number')->attributes(['step' => '0.01']);
        CRUD::field('cout_npk')->type('number');
        CRUD::field('quantite_uree')->type('number')->attributes(['step' => '0.01']);
        CRUD::field('cout_uree')->type('number');
        CRUD::field('quantite_herbicide')->type('number');
        CRUD::field('cout_herbicide')->type('number');
        CRUD::field('superficie_butee')->type('number')->attributes(['step' => '0.01']);
        CRUD::field('cout_buttage')->type('number');
        CRUD::field('quantite_insecticide')->type('number');
        CRUD::field('cout_insecticide')->type('number');
        CRUD::field('cout')->type('number');

    }
    
    public function export() 
    {
        return Excel::download(new MonitoringWorkbookExport, 'donnees_de_suivi - '.Carbon::now()->format('Ymd_His').'.xlsx');
    }

}
