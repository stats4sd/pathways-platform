<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UnionCerealeRequest;
use App\Models\UnionCereale;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class UnionCerealeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UnionCerealeCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\UnionCereale::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/union_cereale');
        CRUD::setEntityNameStrings('union céréale', 'unions céréales');
    }

    protected function setupListOperation()
    {
        CRUD::column('nom');
        CRUD::column('cercle_id')
            ->type('select')
            ->entity('cercle')
            ->attribute('nom')
            ->label('Cercle');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(UnionCerealeRequest::class);

        CRUD::field('nom');
        CRUD::field('cercle_id')
            ->type('select')
            ->entity('cercle')
            ->attribute('nom')
            ->label('Cercle');
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

}
