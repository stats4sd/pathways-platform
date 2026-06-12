<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BaseScpcRequest;
use App\Models\BaseScpc;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BaseScpcCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BaseScpcCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\BaseScpc::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/base_scpc');
        CRUD::setEntityNameStrings('base SCPC', 'bases SCPC');
    }

    protected function setupListOperation()
    {
        CRUD::column('nom');
        CRUD::column('villages')
            ->type('relationship')
            ->attribute('nom')
            ->label('Villages');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(BaseScpcRequest::class);

        CRUD::field('nom');
        CRUD::field('villages')
            ->type('relationship')
            ->attribute('nom')
            ->label('Villages');
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

}
