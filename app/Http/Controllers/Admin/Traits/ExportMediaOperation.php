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
            $this->crud->addButton('top', 'export-media', 'view', 'vendor.backpack.crud.buttons.export-media');
        });
    }


    // export media attachments for all submissions for a given Xlsform
    public function exportMedia()
    {

        $xlsform = Xlsform::find($this->crud->get('xlsform_id'));

        $submissions = $xlsform->submissions;

        $allMedia = $submissions->map(function (Submission $submission) {
            return $submission->getMedia();
        })->flatten();

        return MediaStream::create('media.zip')->addMedia($allMedia);

    }

}
