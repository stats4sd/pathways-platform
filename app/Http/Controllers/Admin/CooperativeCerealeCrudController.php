<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CooperativeCerealeRequest;
use App\Models\Cercle;
use App\Models\Region;
use App\Models\UnionCereale;
use App\Models\Village;
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
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\CooperativeCereale::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/cooperative_cereale');
        CRUD::setEntityNameStrings('coopérative céréale', 'coopératives céréales');
    }

    protected function setupListOperation()
    {
        CRUD::column('unionCereale.cercle.region.nom')->label('Région');
        CRUD::column('unionCereale.cercle.nom')->label('Cercle');
        CRUD::column('unionCereale.nom')->label('Union céréale');
        CRUD::column('village.nom')->label('Village');
        CRUD::column('nom');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(CooperativeCerealeRequest::class);

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
            ->data_source(backpack_url('cooperative_cereale/fetch-cercles'))
            ->placeholder('Sélectionnez d\'abord une région')
            ->minimum_input_length(0)
            ->dependencies(['region_id'])
            ->include_all_form_fields(true);

        CRUD::field('union_cereale_id')
            ->type('select2_from_ajax')
            ->label('Union céréale')
            ->model(UnionCereale::class)
            ->attribute('nom')
            ->data_source(backpack_url('cooperative_cereale/fetch-unions'))
            ->placeholder('Sélectionnez d\'abord un cercle')
            ->minimum_input_length(0)
            ->dependencies(['cercle_id'])
            ->include_all_form_fields(true)
            ->attributes(['required' => 'required'])
            ->showAsterisk(true);

        CRUD::field('village_id')
            ->type('select2_from_ajax')
            ->label('Village')
            ->model(Village::class)
            ->attribute('nom')
            ->data_source(backpack_url('cooperative_cereale/fetch-villages'))
            ->placeholder('Sélectionnez d\'abord un cercle')
            ->minimum_input_length(0)
            ->dependencies(['cercle_id'])
            ->include_all_form_fields(true)
            ->attributes(['required' => 'required'])
            ->showAsterisk(true);

        CRUD::field('nom');
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();

        $entry = $this->crud->getCurrentEntry();
        $cercle = null;
        if ($entry && $entry->unionCereale) {
            $cercle = $entry->unionCereale->cercle;
        } elseif ($entry && $entry->village && $entry->village->commune) {
            $cercle = $entry->village->commune->cercle;
        }
        if ($cercle) {
            CRUD::field('region_id')->value($cercle->region_id);
            CRUD::field('cercle_id')->value($cercle->id);
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

        $cercles = Cercle::when($regionId, fn($q) => $q->where('region_id', $regionId))
            ->when(request()->input('q'), fn($q, $s) => $q->where('nom', 'like', "%{$s}%"))
            ->orderBy('nom')
            ->get(['id', 'nom']);

        return response()->json($cercles);
    }

    public function fetchUnions()
    {
        $cercleId = null;
        foreach (request()->input('form', []) as $field) {
            if (($field['name'] ?? null) === 'cercle_id') {
                $cercleId = $field['value'] ?? null;
                break;
            }
        }

        $unions = UnionCereale::when($cercleId, fn($q) => $q->where('cercle_id', $cercleId))
            ->when(request()->input('q'), fn($q, $s) => $q->where('nom', 'like', "%{$s}%"))
            ->orderBy('nom')
            ->get(['id', 'nom']);

        return response()->json($unions);
    }

    public function fetchVillages()
    {
        $cercleId = null;
        foreach (request()->input('form', []) as $field) {
            if (($field['name'] ?? null) === 'cercle_id') {
                $cercleId = $field['value'] ?? null;
                break;
            }
        }

        $villages = Village::when($cercleId, fn($q) => $q->whereHas('commune', fn($q2) => $q2->where('cercle_id', $cercleId)))
            ->when(request()->input('q'), fn($q, $s) => $q->where('nom', 'like', "%{$s}%"))
            ->orderBy('nom')
            ->get(['id', 'nom']);

        return response()->json($villages);
    }

}
