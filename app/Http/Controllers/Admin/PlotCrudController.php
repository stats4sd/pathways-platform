<?php

namespace App\Http\Controllers\Admin;

use App\Exports\EnrolmentWorkbookExport;
use App\Http\Requests\PlotRequest;
use App\Models\Crop;
use App\Models\Plot;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
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
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use ExportOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Plot::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/plot');
        CRUD::setEntityNameStrings('parcelle', 'parcelles');
        CRUD::set('export.exporter', EnrolmentWorkbookExport::class);
    }

    protected function setupListOperation()
    {
        CRUD::column('id')->label('ID');
        CRUD::column('field.id')->label('Champ ID');
        CRUD::column('field.farm.code')->label('UPA');
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

    protected function setupUpdateOperation()
    {
        CRUD::setValidation(PlotRequest::class);

        $this->crud->getRequest()->request->set('id', $this->crud->getCurrentEntry()->id);
        $this->crud->getRequest()->request->set('field_id', $this->crud->getCurrentEntry()->field_id);
        $this->crud->getRequest()->request->set('field.farm.code', $this->crud->getCurrentEntry()->field->farm->code);

        CRUD::field('id')
            ->type('number')
            ->attributes(['disabled' => 'disabled']);

        CRUD::field('field_id')
            ->label('Champ ID')
            ->attributes(['disabled' => 'disabled']);

        CRUD::field('field.farm.code')
            ->label('UPA')
            ->attributes(['disabled' => 'disabled']);

        CRUD::field('numero_parcelle')->type('number');

        CRUD::field('fertilite');

        CRUD::field('prev_crop_id')
            ->label('Culture Prev')
            ->type('select_from_array')
            ->options(
                Crop::all()->pluck('label_fr', 'id')->toArray()
            );

        CRUD::field('crop_id')
            ->label('Culture')
            ->type('select_from_array')
            ->options(
                Crop::all()->pluck('label_fr', 'id')->toArray()
            );

        CRUD::field('nom_variete_culture');
        CRUD::field('type_variete_culture');
        CRUD::field('date_semence');
        CRUD::field('quantite_semence')->type('number');
        CRUD::field('source_semence_culture');
        CRUD::field('autre_source_semence_cutture');
        CRUD::field('nombre_arbre')->type('number');
        CRUD::field('nom_arbres');
        CRUD::field('cultures_associations');
        CRUD::field('quantite_fumure_organique')->type('number');
        CRUD::field('type_fumure_organique');
        CRUD::field('autre_type_fumure_organique');
        CRUD::field('quantite_npk')->type('number')->attributes(['step' => '0.01']);
        CRUD::field('quantite_uree')->type('number')->attributes(['step' => '0.01']);
        CRUD::field('nom_autre_engrais');
        CRUD::field('superficie_estimee')->type('number')->attributes(['step' => '0.01']);
        CRUD::field('superficie_measuree')->type('number')->attributes(['step' => '0.01']);
        // CRUD::field('trace_superficie');

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

    public function export() 
    {
        return Excel::download(new EnrolmentWorkbookExport, 'donnees_de_UPA - '.Carbon::now()->format('Ymd_His').'.xlsx');
    }

}
