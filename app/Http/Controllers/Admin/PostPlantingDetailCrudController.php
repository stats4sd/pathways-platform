<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\PostPlantingDetail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MonitoringWorkbookExport;
use App\Http\Requests\PostPlantingDetailRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Controllers\Admin\Traits\ExportMediaOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use \Stats4sd\FileUtil\Http\Controllers\Operations\ExportOperation;

/**
 * Class PostPlantingDetailCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PostPlantingDetailCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use ExportOperation;
    use ExportMediaOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\PostPlantingDetail::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/post_planting_detail');
        CRUD::setEntityNameStrings('post-semis - culture', 'post-semis - culture');
        CRUD::set('export.exporter', MonitoringWorkbookExport::class);
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('postPlanting.farm.code')->label('UPA');
        CRUD::column('postPlanting.id')->label('Post-Semis ID');
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

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    protected function setupShowOperation()
    {
        $this->setupListOperation();
    }
    
    public function export() 
    {
        return Excel::download(new MonitoringWorkbookExport, 'donnees_de_suivi - '.Carbon::now()->format('Ymd_His').'.xlsx');
    }

}
