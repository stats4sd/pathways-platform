<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UnionScpcRequest;
use App\Models\UnionScpc;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class UnionScpcCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UnionScpcCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\UnionScpc::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/union_scpc');
        CRUD::setEntityNameStrings('union SCPC', 'unions SCPC');
    }

    protected function setupListOperation()
    {
        CRUD::column('nom');
        CRUD::column('commune_id')
            ->type('select')
            ->entity('commune')
            ->attribute('nom')
            ->label('Commune');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(UnionScpcRequest::class);

        CRUD::field('nom');
        CRUD::field('commune_id')
            ->type('select')
            ->entity('commune')
            ->attribute('nom')
            ->label('Commune');
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

}
