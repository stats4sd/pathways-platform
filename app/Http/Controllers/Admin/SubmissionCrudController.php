<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Stats4sd\OdkLink\Models\Xlsform;
use Stats4sd\OdkLink\Models\Submission;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Stats4sd\OdkLink\Http\Controllers\Admin\SubmissionCrudController as Stats4sdSubmissionCrudController;

/**
 * Class SubmissionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class SubmissionCrudController extends Stats4sdSubmissionCrudController
{
    use ListOperation;


    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     * @throws Exception
     */
    public function setup(): void
    {
        CRUD::setModel(Submission::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/submission');
        CRUD::setEntityNameStrings('submission', 'submissions');

    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation(): void
    {

        CRUD::column('xlsform_title')->label('XLS Form')->limit(1000);
        CRUD::column('xlsformVersion')->label('Form Version')->type('relationship')->attribute('version');
        CRUD::column('id')->label('Submission ID');
        CRUD::column('submitted_at')->type('datetime')->format('YYYY-MM-DD HH:mm:ss');
        CRUD::column('processed')->label('Processed?')->type('boolean');
        CRUD::column('consent')
            ->label('Consent?')
            ->type('text')
            ->value(function($entry){
            if($entry->consent===0) {
                return 'Non';}
            elseif($entry->consent===1){
                return 'Oui';}});
        CRUD::column('errors')->label('Validation Errors')->type('submission_errors')->view_namespace('odk-link::columns')->limit(1000);
        CRUD::column('entries')->label('Db Entries Created')->type('submission_entries')->view_namespace('odk-link::columns')->limit(1000);

        CRUD::filter('xlsform')
            ->type('select2')
            ->label('Filter by Xls Form')
            ->values(function () {
                return Xlsform::get()->pluck('title', 'id')->toArray();
            })
            ->whenActive(function ($value) {
                $this->crud->query->whereHas('xlsformVersion', function ($query) use ($value) {
                    $query->where('xlsform_id', $value);
                });
            });

        CRUD::filter('errors')
            ->type('simple')
            ->label('Show submissions with errors')
            ->whenActive(function () {
                CRUD::addClause('where', 'errors', '!=', null);
            });

        CRUD::filter('consent')
            ->type('simple')
            ->label('Show submissions without consent')
            ->values(function () {
                return Submission::get()->pluck('consent', 'consent')->toArray();
            })
            ->whenActive(function () {
                CRUD::addClause('where', 'consent', '=', 0);
            });

        Crud::button('reprocess')
            ->stack('line')
            ->view('odk-link::buttons.submissions.reprocess');
    }

}
