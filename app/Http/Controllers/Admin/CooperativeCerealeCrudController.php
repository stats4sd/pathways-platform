<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CooperativeCerealeRequest;
use App\Models\CooperativeCereale;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CooperativeCerealeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CooperativeCerealeCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\CooperativeCereale::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/cooperative_cereale');
        CRUD::setEntityNameStrings('coopérative céréale', 'coopératives céréales');
    }

    protected function setupListOperation()
    {
        CRUD::column('nom');
        CRUD::column('village_id')
            ->type('select')
            ->entity('village')
            ->attribute('nom')
            ->label('Village');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(CooperativeCerealeRequest::class);

        CRUD::field('nom');
        CRUD::field('village_id')
            ->type('select')
            ->entity('village')
            ->attribute('nom')
            ->label('Village');
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

}
