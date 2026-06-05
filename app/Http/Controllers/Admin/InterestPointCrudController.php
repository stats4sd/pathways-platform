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
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use ExportMediaOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\InterestPoint::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/interest_point');
        CRUD::setEntityNameStrings('point d\'intérêt', 'points d\'intérêt');
    }

    protected function setupListOperation()
    {

        CRUD::column('id')->label('ID');
        CRUD::column('farm_id')->label('UPA');
        CRUD::column('year');
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
    }

    protected function setupUpdateOperation()
    {
        CRUD::setValidation(InterestPointRequest::class);

        $this->crud->getRequest()->request->set('id', $this->crud->getCurrentEntry()->id);
        $this->crud->getRequest()->request->set('farm_id', $this->crud->getCurrentEntry()->farm_id);

        CRUD::field('id')
            ->type('number')
            ->label('ID')
            ->attributes(['disabled' => 'disabled']);

        CRUD::field('farm_id')
            ->label('UPA')
            ->attributes(['disabled' => 'disabled']);

        CRUD::field('year')->type('number');
        CRUD::field('nom');
        CRUD::field('longitude')->type('number')->attributes(['step' => 'any']);
        CRUD::field('latitude')->type('number')->attributes(['step' => 'any']);
        CRUD::field('altitude')->type('number')->attributes(['step' => 'any']);
        CRUD::field('accuracy')->type('number')->attributes(['step' => 'any'])->label('Précision');

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

}
