<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RegionRequest;
use App\Models\Region;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class RegionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class RegionCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Region::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/region');
        CRUD::setEntityNameStrings('region', 'regions');
    }

    protected function setupListOperation()
    {

        CRUD::column('nom');

    }

    protected function setupCreateOperation()
    {

        CRUD::setValidation(RegionRequest::class);

        CRUD::field('nom');

    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

}
