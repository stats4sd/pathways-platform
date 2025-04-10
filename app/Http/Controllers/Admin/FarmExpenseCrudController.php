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
        CRUD::column('frais_condiment_annuel');
        CRUD::column('frais_sante_annuel');
        CRUD::column('frais_education_annuel');
        CRUD::column('frais_aliment_betail');
        CRUD::column('frais_veterinaire');
        CRUD::column('autre_frais');
        CRUD::column('montant_autre_frais');
        CRUD::column('invest_maison');
        CRUD::column('invest_mariage');
        CRUD::column('autre_invest');
        CRUD::column('montant_autre_invest');
        CRUD::column('depenses_recurrentes');
        CRUD::column('depenses_investissements');
        CRUD::column('depenes_total');
    }

}
