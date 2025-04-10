<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\OrganicFertiliserRequest;
use App\Models\OrganicFertiliser;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class OrganicFertiliserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class OrganicFertiliserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\OrganicFertiliser::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/organic_fertiliser');
        CRUD::setEntityNameStrings('Fumure Organique', 'Fumure Organiques');
    }

    protected function setupListOperation()
    {
        CRUD::column('farm_id')->label('UPA');
        CRUD::column('year');
        CRUD::column('superficie_exploitation');
        CRUD::column('protion_fertilisable');
        CRUD::column('superficie_rotation');
        CRUD::column('superficie_cycle');
        CRUD::column('gap_annuel');
        CRUD::column('gap_cycle');
        CRUD::column('nb_annee');
    }

}
