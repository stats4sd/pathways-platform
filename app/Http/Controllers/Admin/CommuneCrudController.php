<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CommuneRequest;
use App\Models\Commune;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CommuneCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CommuneCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Commune::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/commune');
        CRUD::setEntityNameStrings('commune', 'communes');
    }

    protected function setupListOperation()
    {

        CRUD::column('cercle_id');
        CRUD::column('nom');

    }

    protected function setupCreateOperation()
    {

        CRUD::setValidation(CommuneRequest::class);

        CRUD::field('nom');
        CRUD::field('cercle_id')->type('select');

    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

}
