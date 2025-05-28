<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\HumanCerealNeedRequest;
use App\Models\HumanCerealNeed;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class HumanCerealNeedCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class HumanCerealNeedCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\HumanCerealNeed::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/human_cereal_need');
        CRUD::setEntityNameStrings('Besoins Cereales Humain', 'Besoins Cereales Humain');
    }

    protected function setupListOperation()
    {
        CRUD::column('farm_id')->label('UPA');
        CRUD::column('year');
        CRUD::column('type_menage');
        CRUD::column('personnes_nourrir');
        CRUD::column('besoin_cereale_exploitation');
        CRUD::column('sac_mais');
        CRUD::column('sac_mil');
        CRUD::column('sac_sorgho');
        CRUD::column('sac_cereales');
        CRUD::column('sac_cereales_diff');
        CRUD::column('rend_moyen_mais');
        CRUD::column('rend_moyen_mil');
        CRUD::column('rend_moyen_sorgho');
        CRUD::column('superficie_mais');
        CRUD::column('superficie_mil');
        CRUD::column('superficie_sorgho');
        CRUD::column('superficie_totale');
        CRUD::column('observation_texte');
        CRUD::column('observation_audio')->type('url')
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
        CRUD::column('observation_videos')->type('url')
            ->wrapper(['href'=>function($crud, $column, $entry) {
                if (!empty($entry->observation_videos)) {
                    $media = $entry->getMedia()->where('file_name', $entry->observation_videos)->first();
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
        CRUD::column('observation_appreciation')->type('url')
            ->wrapper(['href'=>function($crud, $column, $entry) {
                if (!empty($entry->observation_appreciation)) {
                    $media = $entry->getMedia()->where('file_name', $entry->observation_appreciation)->first();
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
