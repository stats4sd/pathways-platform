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

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    protected function setupShowOperation()
    {
        $farm = $this->crud->getCurrentEntry();

        $qrCode = QrCode::size(150)->generate($farm->code);

        Widget::add()
            ->to('before_content')
            ->type('card')
            ->content([
                'body' => "
                    <div class='row'>
                        <div class='col-md-6 col-lg-4'>
                            $qrCode
                        </div>
                        <div class='col-md-6 d-flex flex-column justify-content-center'>
                            <div class='d-flex'>
                                <span class='w-50 font-weight-bold text-right mr-3'>CODE:</span>
                                <span>$farm->code</span>
                            </div>
                            <div class='d-flex'>
                                <span class='w-50 font-weight-bold text-right mr-3'>CHEF UPA:</span>
                                <span>$farm->chef_upa</span>
                            </div>
                            <div class='d-flex'>
                                <span class='w-50 font-weight-bold text-right mr-3'>CHEF TRAVAUX:</span>
                                <span>$farm->chef_travaux</span>
                            </div>
                        </div>
                    </div>
                ",
            ])
        ->wrapper([
            'class' => 'pl-0 col-12 col-lg-6 col-xl-4 offset-xl-2'
        ]);

        $this->setupListOperation();
    }

}
