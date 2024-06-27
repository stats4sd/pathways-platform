<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CercleRequest;
use App\Models\Cercle;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CercleCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CercleCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Cercle::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/cercle');
        CRUD::setEntityNameStrings('cercle', 'cercles');
    }

    protected function setupListOperation()
    {

        CRUD::column('region_id');
        CRUD::column('nom');

    }

    protected function setupCreateOperation()
    {

        CRUD::setValidation(CercleRequest::class);

        CRUD::field('nom');
        CRUD::field('region_id')->type('select');

    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

}
