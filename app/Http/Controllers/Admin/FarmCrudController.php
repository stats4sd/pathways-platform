<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\FarmRequest;
use App\Models\Farm;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class FarmCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class FarmCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;


    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Farm::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/farm');
        CRUD::setEntityNameStrings('UPA', 'UPAs');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {

        CRUD::setFromDb();

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    protected function setupUpdateOperation()
    {
        CRUD::setValidation(FarmRequest::class);

        CRUD::field('code');
        CRUD::field('year');
        CRUD::field('num_phone');
        CRUD::field('chef_upa');
        CRUD::field('chef_travaux');
        CRUD::field('neo_alphabete');
        CRUD::field('activite_primaire');
        CRUD::field('activite_secondaire');
        CRUD::field('cereales_favoris_1');
        CRUD::field('cereales_favoris_2');
        CRUD::field('cereales_favoris_3');
        CRUD::field('superficie_possede_upa');
        CRUD::field('superficie_cultive_upa');
    }

}
