<?php

namespace App\Http\Controllers\Admin;

use App\Models\InterestPoint;
use App\Http\Requests\InterestPointRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Controllers\Admin\Traits\ExportMediaOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class InterestPointCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class InterestPointCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use ExportMediaOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\InterestPoint::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/interest_point');
        CRUD::setEntityNameStrings('point d\'intérêt', 'points d\'intérêt');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {

        CRUD::column('id')->label('ID');
        CRUD::column('farm_id')->label('UPA ID');
        CRUD::column('nom');
        CRUD::column('longitude');
        CRUD::column('latitude');
        CRUD::column('altitude');
        CRUD::column('accuracy')->label('Précision');

        CRUD::column('description_audio')
        ->type('url')
        ->wrapper(['href'=>function($crud, $column, $entry) {
            if(!empty($entry->description_audio)) {
                $mediaUrl = $entry->getMedia()->where('file_name', $entry->description_audio)->first()->getUrl();
                return $mediaUrl;
            }
        }]);

        CRUD::column('description_videos')
        ->type('url')
        ->wrapper(['href'=>function($crud, $column, $entry) {
            if(!empty($entry->description_videos)) {
                $mediaUrl = $entry->getMedia()->where('file_name', $entry->description_videos)->first()->getUrl();
                return $mediaUrl;
            }
        }]);

        CRUD::column('description_image')
        ->type('url')
        ->wrapper(['href'=>function($crud, $column, $entry) {
            if(!empty($entry->description_image)) {
                $mediaUrl = $entry->getMedia()->where('file_name', $entry->description_image)->first()->getUrl();
                return $mediaUrl;
            }
        }]);

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    protected function setupShowOperation()
    {
        $this->setupListOperation();
    }

}
