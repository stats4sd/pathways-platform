<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Farm;
use App\Http\Requests\FarmRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EnrolmentWorkbookExport;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use src\View\Components\Qr;
use \Stats4sd\FileUtil\Http\Controllers\Operations\ExportOperation;

/**
 * Class FarmCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class FarmCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use ExportOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Farm::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/farm');
        CRUD::setEntityNameStrings('UPA', 'UPAs');
        CRUD::set('export.exporter', EnrolmentWorkbookExport::class);
    }

    protected function setupListOperation()
    {

        CRUD::column('code');
        CRUD::column('type');
        CRUD::column('phone_number');
        CRUD::column('chef_upa');

        CRUD::button('map')
        ->stack('line')
        ->type('view')
        ->view('crud::buttons.map')
        ->after('update');
    }

    protected function setupUpdateOperation()
    {
        CRUD::setValidation(FarmRequest::class);

        $this->crud->getRequest()->request->set('code', $this->crud->getCurrentEntry()->code);

        CRUD::field('code')
            ->attributes(['disabled' => 'disabled']);

        CRUD::field('type');
        CRUD::field('phone_number');
        CRUD::field('chef_upa');

    }

    protected function setupShowOperation()
    {
        $this->setupListOperation();
        
        CRUD::column('created_at')
            ->type('datetime')
            ->label('Créé le');

        CRUD::column('updated_at')
            ->type('datetime')
            ->label('Mis à jour le');
    }

    public function export() 
    {
        return Excel::download(new EnrolmentWorkbookExport, 'donnees_de_UPA - '.Carbon::now()->format('Ymd_His').'.xlsx');
    }

    public function renderMap(Farm $farm)
    {
        return view('farms.map', ['farm' => $farm]);
    }
    
}