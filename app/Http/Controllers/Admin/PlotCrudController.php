<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PlotRequest;
use App\Models\Plot;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

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
        CRUD::column('field_id')->label('Champ ID');
        CRUD::column('numero_parcelle');
        CRUD::column('nombre_arbre');
        CRUD::column('crop_id')->label('Culture');
        CRUD::column('cultures_associations');
        CRUD::column('superficie_estimee');
        CRUD::column('superficie_measuree');
        CRUD::column('trace_superficie');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

}
