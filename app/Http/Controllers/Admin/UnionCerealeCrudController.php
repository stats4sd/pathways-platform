<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UnionCerealeRequest;
use App\Models\Cercle;
use App\Models\Region;
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
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\UnionCereale::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/union_cereale');
        CRUD::setEntityNameStrings('union céréale', 'unions céréales');
    }

    protected function setupListOperation()
    {
        CRUD::column('cercle.region.nom')->label('Région');
        CRUD::column('cercle_id')->label('Cercle');
        CRUD::column('nom');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(UnionCerealeRequest::class);

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
            ->data_source(backpack_url('union_cereale/fetch-cercles'))
            ->placeholder('Sélectionnez d\'abord une région')
            ->minimum_input_length(0)
            ->dependencies(['region_id'])
            ->include_all_form_fields(true);

        CRUD::field('nom');
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();

        $entry = $this->crud->getCurrentEntry();
        if ($entry && $entry->cercle) {
            CRUD::field('region_id')->value($entry->cercle->region_id);
        }
    }

    public function store()
    {
        $this->crud->getRequest()->request->remove('region_id');
        return $this->traitStore();
    }

    public function update()
    {
        $this->crud->getRequest()->request->remove('region_id');
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

}
