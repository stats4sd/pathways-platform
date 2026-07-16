<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\VillageRequest;
use App\Models\Cercle;
use App\Models\Commune;
use App\Models\Region;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class VillageCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class VillageCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Village::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/village');
        CRUD::setEntityNameStrings('village', 'villages');
    }

    protected function setupListOperation()
    {
        CRUD::column('commune.cercle.region.nom')->label('Région');
        CRUD::column('commune.cercle.nom')->label('Cercle');

        CRUD::column('commune_id')->label('Commune');
        CRUD::column('nom')->label('Village');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(VillageRequest::class);

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
            ->data_source(backpack_url('village/fetch-cercles'))
            ->placeholder('Sélectionnez d\'abord une région')
            ->minimum_input_length(0)
            ->dependencies(['region_id'])
            ->include_all_form_fields(true);

        CRUD::field('commune_id')
            ->type('select2_from_ajax')
            ->label('Commune')
            ->model(Commune::class)
            ->attribute('nom')
            ->data_source(backpack_url('village/fetch-communes'))
            ->placeholder('Sélectionnez d\'abord un cercle')
            ->minimum_input_length(0)
            ->dependencies(['cercle_id'])
            ->include_all_form_fields(true);

        CRUD::field('nom');
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();

        $village = $this->crud->getCurrentEntry();
        if ($village && $village->commune) {
            $cercle = $village->commune->cercle;
            if ($cercle) {
                CRUD::field('region_id')->value($cercle->region_id);
                CRUD::field('cercle_id')->value($cercle->id);
            }
        }
    }

    public function store()
    {
        $this->crud->getRequest()->request->remove('region_id');
        $this->crud->getRequest()->request->remove('cercle_id');
        return $this->traitStore();
    }

    public function update()
    {
        $this->crud->getRequest()->request->remove('region_id');
        $this->crud->getRequest()->request->remove('cercle_id');
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

        $search = request()->input('q');

        $cercles = Cercle::when($regionId, fn($q) => $q->where('region_id', $regionId))
            ->when($search, fn($q) => $q->where('nom', 'like', "%{$search}%"))
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

        $search = request()->input('q');

        $communes = Commune::when($cercleId, fn($q) => $q->where('cercle_id', $cercleId))
            ->when($search, fn($q) => $q->where('nom', 'like', "%{$search}%"))
            ->orderBy('nom')
            ->get(['id', 'nom']);

        return response()->json($communes);
    }

}
