<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\HarvestDetailRequest;
use App\Models\HarvestDetail;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class HarvestDetailCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class HarvestDetailCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\HarvestDetail::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/harvest_detail');
        CRUD::setEntityNameStrings('récolte - culture', 'récolte - cuture');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('harvest.farm.code')->label('UPA');
        CRUD::column('harvest.id')->label('Récolte ID');
        CRUD::column('crop_id')->label('Culture');
        CRUD::column('superficie_recolte_prestation');
        CRUD::column('cout_total_prestation_recolte');
        CRUD::column('production');
        CRUD::column('cout_total_battage');
        CRUD::column('production_residu_culture');
        CRUD::column('nombre_botte');
        CRUD::column('cout');
        CRUD::column('observation_audio');
        CRUD::column('observation_videos');
        CRUD::column('observation_texte');
        CRUD::column('observation_image');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

}
