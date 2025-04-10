<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AnimalFeedRequest;
use App\Models\AnimalFeed;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class AnimalFeedCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AnimalFeedCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\AnimalFeed::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/animal_feed');
        CRUD::setEntityNameStrings('Alimentation Animaux', 'Alimentation Animaux');
    }

    protected function setupListOperation()
    {
        CRUD::column('id')->label('ID');
        CRUD::column('farm_id')->label('UPA');
        CRUD::column('year');
        CRUD::column('concentre_produit');
        CRUD::column('achat_sac_con_quanti');
        CRUD::column('note_quant_achat');
        CRUD::column('achat_sac_con_son');
        CRUD::column('quantite_stourteau');
        CRUD::column('quantite_sac_tourteau');
        CRUD::column('prix_sac_son');
        CRUD::column('cal_depense_son');
        CRUD::column('prix_sac_tourteau');
        CRUD::column('cal_depense_tour');
        CRUD::column('cal_superficie');
        CRUD::column('cal_depense_total');
        CRUD::column('appreciation_observation')->type('url')
            ->wrapper(['href'=>function($crud, $column, $entry) {
                if (!empty($entry->observation_audio)) {
                    $media = $entry->getMedia()->where('file_name', $entry->observation_audio)->first();
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
