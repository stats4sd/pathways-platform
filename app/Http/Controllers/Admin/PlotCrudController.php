<?php

namespace App\Http\Controllers\Admin;

use App\Models\Plot;
use Illuminate\Support\Carbon;
use App\Http\Requests\PlotRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EnrolmentWorkbookExport;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Stats4sd\FileUtil\Http\Controllers\Operations\ExportOperation;

/**
 * Class PlotCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PlotCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use ExportOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Plot::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/plot');
        CRUD::setEntityNameStrings('parcelle', 'parcelles');
        CRUD::set('export.exporter', EnrolmentWorkbookExport::class);
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {

        CRUD::column('field.farm.code')->label('UPA');
        CRUD::column('id')->label('ID');
        CRUD::column('field.id')->label('Champ ID');
        CRUD::column('numero_parcelle');
        CRUD::column('fertilite');
        CRUD::column('prev_crop_id')->label('Culture Prev');
        CRUD::column('crop_id')->label('Culture');
        CRUD::column('nom_variete_culture');
        CRUD::column('type_variete_culture');
        CRUD::column('date_semence');
        CRUD::column('quantite_semence');
        CRUD::column('source_semence_culture');
        CRUD::column('autre_source_semence_cutture');
        CRUD::column('nombre_arbre');
        CRUD::column('nom_arbres');
        CRUD::column('cultures_associations');
        CRUD::column('quantite_fumure_organique');
        CRUD::column('type_fumure_organique');
        CRUD::column('autre_type_fumure_organique');
        CRUD::column('quantite_npk');
        CRUD::column('quantite_uree');
        CRUD::column('nom_autre_engrais');
        CRUD::column('superficie_estimee');
        CRUD::column('superficie_measuree');
        CRUD::column('trace_superficie')->type('text')->limit(1000);
        CRUD::column('observation_audio')
                ->type('url')
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
        CRUD::column('observation_image')
                ->type('url')
                ->wrapper(['href'=>function($crud, $column, $entry) {
                    if(!empty($entry->observation_image)) {
                        $media = $entry->getMedia()->where('file_name', $entry->observation_image)->first();
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
    }

    public function export() 
    {
        return Excel::download(new EnrolmentWorkbookExport, 'donnees_de_UPA - '.Carbon::now()->format('Ymd_His').'.xlsx');
    }

}
