<?php

namespace App\Http\Controllers\Admin\Traits;

use Illuminate\Support\Facades\Route;
use Spatie\MediaLibrary\Support\MediaStream;
use Stats4sd\OdkLink\Models\Submission;
use Stats4sd\OdkLink\Models\Xlsform;

trait ExportMediaOperation
{

    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupExportMediaRoutes($segment, $routeName, $controller)
    {
        Route::get($segment . '/export-media', [
            'as' => $routeName . '.export-media',
            'uses' => $controller . '@exportMedia',
            'operation' => 'exportMedia',
        ]);
    }

    protected function setupExportMediaDefaults()
    {
        $this->crud->allowAccess('exportMedia');

        $this->crud->operation('exportMedia', function () {
            $this->crud->loadDefaultOperationSettingsFromConfig();
        });

        $this->crud->operation('list', function () {

            // check if the model has a media library
            // only show the export media button if the model has media.
            if (method_exists(new($this->crud->getModel()), 'getMedia')) {
                $this->crud->addButton('top', 'export-media', 'view', 'vendor.backpack.crud.buttons.export-media');
            }

        });
    }


    // export media attachments for all submissions for a given Xlsform
    public function exportMedia()
    {

        $entries = $this->crud->getModel()::all();

        $allMedia = $entries->map(function ($entry) {
            return $entry->getMedia();
        })->flatten();

        return MediaStream::create($this->crud->entity_name_plural . ' - media.zip')->addMedia($allMedia);

    }

}
