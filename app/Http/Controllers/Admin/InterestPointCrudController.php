<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\InterestPointRequest;
use App\Models\InterestPoint;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class InterestPointCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class InterestPointCrudController extends CrudController
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
        CRUD::setModel(\App\Models\InterestPoint::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/interest_point');
        CRUD::setEntityNameStrings('point d\'intérêt', 'points d\'intérêt');
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
        CRUD::column('farm_id')->label('UPA ID');
        CRUD::column('nom');
        CRUD::column('longitude');
        CRUD::column('latitude');
        CRUD::column('altitude');
        CRUD::column('accuracy')->label('Précision');
        CRUD::column('description_audio');
        CRUD::column('description_videos');
        CRUD::column('description_image');
   

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

}
