<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Traits\ExportMediaOperation;
use Carbon\Carbon;
use App\Models\PlantingDetail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MonitoringWorkbookExport;
use App\Http\Requests\PlantingDetailRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use \Stats4sd\FileUtil\Http\Controllers\Operations\ExportOperation;

/**
 * Class PlantingDetailCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PlantingDetailCrudController extends CrudController
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
        CRUD::setModel(\App\Models\PlantingDetail::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/planting_detail');
        CRUD::setEntityNameStrings('semis - culture', 'semis - culture');
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
        CRUD::column('planting.farm.code')->label('UPA');
        CRUD::column('planting.id')->label('Semis ID');
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
    }

    public function export()
    {
        return Excel::download(new MonitoringWorkbookExport, 'donnees_de_suivi - '.Carbon::now()->format('Ymd_His').'.xlsx');
    }

}
