<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\FederationScpcRequest;
use App\Models\FederationScpc;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class FederationScpcCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class FederationScpcCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\FederationScpc::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/federation_scpc');
        CRUD::setEntityNameStrings('fédération régionale des SCPC', 'fédérations régionales des SCPC');
    }

    protected function setupListOperation()
    {
        CRUD::column('regions')
            ->type('relationship')
            ->attribute('nom')
            ->label('Régions');
        CRUD::column('nom');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(FederationScpcRequest::class);
        CRUD::setValidation(['regions' => 'required|array']);

        CRUD::field('regions')
            ->type('relationship')
            ->attribute('nom')
            ->label('Régions');

        CRUD::field('nom');
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

}
