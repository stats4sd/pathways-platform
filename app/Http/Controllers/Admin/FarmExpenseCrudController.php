<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\FarmExpenseRequest;
use App\Models\FarmExpense;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class FarmExpenseCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class FarmExpenseCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\FarmExpense::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/farm_expense');
        CRUD::setEntityNameStrings('Depense UPA', 'Depenses UPA');
    }

    protected function setupListOperation()
    {
        CRUD::column('farm_id')->label('UPA');
        CRUD::column('year');
        CRUD::column('frais_condiment_jour');
        CRUD::column('frais_condiment_annuel');
        CRUD::column('nombre_personne_upa');
        CRUD::column('frais_sante_annuel');
        CRUD::column('frais_education_annuel');
        CRUD::column('nom_autre_frais');
        CRUD::column('montant_autre_frais');
        CRUD::column('invest_maison');
        CRUD::column('invest_mariage');
        CRUD::column('invest_equipment');
        CRUD::column('autre_invest');
        CRUD::column('montant_autre_invest');
        CRUD::column('depenses_recurrentes');
        CRUD::column('depenses_investissements');
        CRUD::column('depenes_total');
        CRUD::column('observation_text');
        CRUD::column('observation_vocal')->type('url')
            ->wrapper(['href'=>function($crud, $column, $entry) {
                if (!empty($entry->observation_vocal)) {
                    $media = $entry->getMedia()->where('file_name', $entry->observation_vocal)->first();
                    if ($media) {
                        return $media->getUrl();
                    } else {
                        return '';
                    }
                }
                return null;
            }]);
        CRUD::column('observation_video')->type('url')
            ->wrapper(['href'=>function($crud, $column, $entry) {
                if (!empty($entry->observation_video)) {
                    $media = $entry->getMedia()->where('file_name', $entry->observation_video)->first();
                    if ($media) {
                        return $media->getUrl();
                    } else {
                        return '';
                    }
                }
                return null;
            }]);
        CRUD::column('observation_image')->type('url')
            ->wrapper(['href'=>function($crud, $column, $entry) {
                if (!empty($entry->observation_image)) {
                    $media = $entry->getMedia()->where('file_name', $entry->observation_image)->first();
                    if ($media) {
                        return $media->getUrl();
                    } else {
                        return '';
                    }
                }
                return null;
            }]);
        CRUD::column('appreciation_observation')->type('url')
            ->wrapper(['href'=>function($crud, $column, $entry) {
                if (!empty($entry->appreciation_observation)) {
                    $media = $entry->getMedia()->where('file_name', $entry->appreciation_observation)->first();
                    if ($media) {
                        return $media->getUrl();
                    } else {
                        return '';
                    }
                }
                return null;
            }]);

    }

}
