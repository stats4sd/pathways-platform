<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\VillageRequest;
use App\Models\Village;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class VillageCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class VillageCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Village::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/village');
        CRUD::setEntityNameStrings('village', 'villages');
    }

    protected function setupListOperation()
    {

        CRUD::column('nom');

    }

    protected function setupCreateOperation()
    {

        CRUD::setValidation(VillageRequest::class);

        CRUD::field('nom');

    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

}
