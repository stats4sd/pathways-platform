<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\PostPlanting;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MonitoringWorkbookExport;
use App\Http\Requests\PostPlantingRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use \Stats4sd\FileUtil\Http\Controllers\Operations\ExportOperation;

class PostPlantingCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use ExportOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\PostPlanting::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/post_planting');
        CRUD::setEntityNameStrings('post-semis', 'post-semis');
        CRUD::set('export.exporter', MonitoringWorkbookExport::class);
    }

    protected function setupListOperation()
    {

        CRUD::column('id')->label('ID');
        CRUD::column('farm_id')->label('UPA');
        CRUD::column('year');
        CRUD::column('cout_total');
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
        CRUD::setValidation(PostPlantingRequest::class);

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
        CRUD::field('cout_total')->type('number')->attributes(['step' => '0.01']);

    }

    public function export() 
    {
        return Excel::download(new MonitoringWorkbookExport, 'donnees_de_suivi - '.Carbon::now()->format('Ymd_His').'.xlsx');
    }
    
}
