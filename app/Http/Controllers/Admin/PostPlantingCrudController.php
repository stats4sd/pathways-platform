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

/**
 * Class PostPlantingCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PostPlantingCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use ExportOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\PostPlanting::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/post_planting');
        CRUD::setEntityNameStrings('post-semis', 'post-semis');
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

        CRUD::column('id')->label('ID');
        CRUD::column('farm_id')->label('UPA');
        CRUD::column('year');
        CRUD::column('cout_total');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    public function export() 
    {
        return Excel::download(new MonitoringWorkbookExport, 'donnees_de_suivi - '.Carbon::now()->format('Ymd_His').'.xlsx');
    }
    
}
