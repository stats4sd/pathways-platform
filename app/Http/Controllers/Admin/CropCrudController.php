<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CropRequest;
use App\Models\Crop;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CropCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CropCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Crop::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/crop');
        CRUD::setEntityNameStrings('culture', 'cultures');
        CRUD::orderBy('order');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {

        CRUD::column('id')->label('Name');
        CRUD::column('label_fr');
        CRUD::column('label_bm');
        CRUD::column('nom_fichier_image');
        CRUD::column('type');
        CRUD::column('order');
        CRUD::column('farm.code')->label('UPA code');

        $this->crud->addFilter([
            'name' => 'type',
            'type' => 'dropdown',
        ],
        function () {
            return Crop::all()->pluck('type', 'type')->unique()->toArray();
        },
        function ($value) {
                $this->crud->addClause('where', 'type', $value);
            }
        );

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    protected function setupCreateOperation()
    {

        CRUD::setValidation(CropRequest::class);

        CRUD::field('id')->label('Choice List Name');
        CRUD::field('label_fr');
        CRUD::field('label_bm');
        CRUD::field('nom_fichier_image');
        CRUD::field('type')->type('select_from_array')->options(['primaire' => 'Primaire', 'secondaire' => 'Secondaire']);
        CRUD::field('order');
        CRUD::field('farm_id');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */

    }

        /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

}
