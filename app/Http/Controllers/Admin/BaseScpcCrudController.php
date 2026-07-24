<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BaseScpcRequest;
use App\Models\Cercle;
use App\Models\Commune;
use App\Models\Region;
use App\Models\Village;
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
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\BaseScpc::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/base_scpc');
        CRUD::setEntityNameStrings('base SCPC', 'bases SCPC');
    }

    protected function setupListOperation()
    {
        CRUD::column('villages')
            ->type('relationship')
            ->attribute('nom')
            ->label('Villages');

        CRUD::column('nom');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(BaseScpcRequest::class);
        CRUD::setValidation(['villages' => 'required|array']);

        CRUD::field('region_id')
            ->type('select')
            ->label('Région')
            ->model(Region::class)
            ->attribute('nom');

        CRUD::field('cercle_id')
            ->type('select2_from_ajax')
            ->label('Cercle')
            ->model(Cercle::class)
            ->attribute('nom')
            ->data_source(backpack_url('base_scpc/fetch-cercles'))
            ->placeholder('Sélectionnez d\'abord une région')
            ->minimum_input_length(0)
            ->dependencies(['region_id'])
            ->include_all_form_fields(true);

        CRUD::field('commune_id')
            ->type('select2_from_ajax')
            ->label('Commune')
            ->model(Commune::class)
            ->attribute('nom')
            ->data_source(backpack_url('base_scpc/fetch-communes'))
            ->placeholder('Sélectionnez d\'abord un cercle')
            ->minimum_input_length(0)
            ->dependencies(['cercle_id'])
            ->include_all_form_fields(true);

        CRUD::field('villages')
            ->type('select2_from_ajax_multiple')
            ->label('Villages')
            ->model(Village::class)
            ->attribute('nom')
            ->data_source(backpack_url('base_scpc/fetch-villages'))
            ->placeholder('Sélectionnez d\'abord une commune')
            ->minimum_input_length(0)
            ->dependencies(['commune_id'])
            ->include_all_form_fields(true)
            ->pivot(true);

        CRUD::field('nom');
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function store()
    {
        $this->crud->getRequest()->request->remove('region_id');
        $this->crud->getRequest()->request->remove('cercle_id');
        $this->crud->getRequest()->request->remove('commune_id');
        return $this->traitStore();
    }

    public function update()
    {
        $this->crud->getRequest()->request->remove('region_id');
        $this->crud->getRequest()->request->remove('cercle_id');
        $this->crud->getRequest()->request->remove('commune_id');
        return $this->traitUpdate();
    }

    public function fetchCercles()
    {
        $regionId = null;
        foreach (request()->input('form', []) as $field) {
            if (($field['name'] ?? null) === 'region_id') {
                $regionId = $field['value'] ?? null;
                break;
            }
        }

        $cercles = Cercle::when($regionId, fn($q) => $q->where('region_id', $regionId))
            ->when(request()->input('q'), fn($q, $s) => $q->where('nom', 'like', "%{$s}%"))
            ->orderBy('nom')
            ->get(['id', 'nom']);

        return response()->json($cercles);
    }

    public function fetchCommunes()
    {
        $cercleId = null;
        foreach (request()->input('form', []) as $field) {
            if (($field['name'] ?? null) === 'cercle_id') {
                $cercleId = $field['value'] ?? null;
                break;
            }
        }

        $communes = Commune::when($cercleId, fn($q) => $q->where('cercle_id', $cercleId))
            ->when(request()->input('q'), fn($q, $s) => $q->where('nom', 'like', "%{$s}%"))
            ->orderBy('nom')
            ->get(['id', 'nom']);

        return response()->json($communes);
    }

    public function fetchVillages()
    {
        $communeId = null;
        foreach (request()->input('form', []) as $field) {
            if (($field['name'] ?? null) === 'commune_id') {
                $communeId = $field['value'] ?? null;
                break;
            }
        }

        $villages = Village::when($communeId, fn($q) => $q->where('commune_id', $communeId))
            ->when(request()->input('q'), fn($q, $s) => $q->where('nom', 'like', "%{$s}%"))
            ->orderBy('nom')
            ->get(['id', 'nom']);

        return response()->json($villages);
    }

}
