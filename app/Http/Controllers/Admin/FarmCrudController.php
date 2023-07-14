<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\FarmRequest;
use App\Models\Farm;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use src\View\Components\Qr;

/**
 * Class FarmCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class FarmCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Farm::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/farm');
        CRUD::setEntityNameStrings('UPA', 'UPAs');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {

        CRUD::setFromDb();

    }

    protected function show($id)
    {
        $farm = Farm::find($id);

        return view('farms.show', ['farm' => $farm]);
    }

}
