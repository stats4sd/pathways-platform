<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\FarmDetail;
use App\Http\Requests\FarmDetailRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class FarmDetailCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class FarmDetailCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\FarmDetail::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/farm_detail');
        CRUD::setEntityNameStrings('Détails UPA', 'Détails UPA');
    }

    protected function setupListOperation()
    {
        CRUD::column('farm.code')->label('UPA');
        CRUD::column('year');
        CRUD::column('phone_number');
        CRUD::column('chef_upa');
        CRUD::column('type');
        CRUD::column('ratio_membre_terre')->type('number');
        CRUD::column('ratio_actif_terre')->type('number');
        CRUD::column('ratio_boeuflabour_terre')->type('number');
        CRUD::column('village_id');
        CRUD::column('longitude');
        CRUD::column('latitude');
        CRUD::column('altitude');
        CRUD::column('accuracy');
        CRUD::column('gender_chef');
        CRUD::column('age_chef');
        CRUD::column('chef_travaux');
        CRUD::column('neo_alphabete');
        CRUD::column('activite_primaire');
        CRUD::column('activite_secondaire');
        CRUD::column('cereales_favoris_1');
        CRUD::column('cereales_favoris_2');
        CRUD::column('cereales_favoris_3');
        CRUD::column('superficie_possede_upa')->type('number');;
        CRUD::column('superficie_cultive_upa')->type('number');;

        CRUD::column('nom_coop_coton_upa');
        CRUD::column('nom_coop_cereales_upa');
        CRUD::column('nom_union_cereales_upa');
        CRUD::column('upa_membres')->type('number');
        CRUD::column('upa_actifs')->type('number');
        CRUD::column('nombre_enfants')->type('number');
        CRUD::column('nombre_adolescents')->type('number');
        CRUD::column('nombre_femmes')->type('number');
        CRUD::column('nombre_hommes')->type('number');
        CRUD::column('nombre_femmes_agees')->type('number');
        CRUD::column('nombre_hommes_ages')->type('number');
        CRUD::column('nombre_charrues')->type('number');
        CRUD::column('nombre_multiculteurs')->type('number');
        CRUD::column('nombre_charrettes')->type('number');
        CRUD::column('nombre_tracteur')->type('number');
        CRUD::column('nombre_semoir')->type('number');
        CRUD::column('nombre_motoculteurs')->type('number');
        CRUD::column('nombre_pompe_traitement')->type('number');
        CRUD::column('nombre_pulverisateurs')->type('number');
        CRUD::column('nombre_corps_buteur')->type('number');
        CRUD::column('autre_materiel');
        CRUD::column('nombre_autre_materiel')->type('number');
        CRUD::column('nombre_boeuf_labour')->type('number');
        CRUD::column('nombre_taureaux')->type('number');
        CRUD::column('nombre_vaches_taries')->type('number');
        CRUD::column('nombre_vaches_laitieres')->type('number');
        CRUD::column('nombre_genisses')->type('number');
        CRUD::column('nombre_veaux')->type('number');
        CRUD::column('nombre_anes')->type('number');
        CRUD::column('nombre_chevaux')->type('number');
        CRUD::column('nombre_moutons')->type('number');
        CRUD::column('nombre_chevres')->type('number');
        CRUD::column('nombre_porcs')->type('number');
        CRUD::column('nombre_poules')->type('number');
        CRUD::column('nombre_pintades')->type('number');
        CRUD::column('nombre_lapins')->type('number');
        CRUD::column('nombre_canards')->type('number');
        CRUD::column('nombre_pigeons')->type('number');
        CRUD::column('autre_animal');
        CRUD::column('nombre_autre_animal')->type('number');
        CRUD::column('info_text');

        CRUD::column('info_audio')
            ->type('url')
                ->wrapper(['href'=>function($crud, $column, $entry) {
                    if (!empty($entry->info_audio)) {
                        $media = $entry->getMedia()->where('file_name', $entry->info_audio)->first();
                        if ($media) {
                            return $media->getUrl();
                        } else {
                            return '';
                        }
                    }
                    return null;
                }]);
        CRUD::column('info_image')
            ->type('url')
                ->wrapper(['href'=>function($crud, $column, $entry) {
                    if (!empty($entry->info_image)) {
                        $media = $entry->getMedia()->where('file_name', $entry->info_image)->first();
                        if ($media) {
                            return $media->getUrl();
                        } else {
                            return '';
                        }
                    }
                    return null;
                }]);
        CRUD::column('info_video')
            ->type('url')
                ->wrapper(['href'=>function($crud, $column, $entry) {
                    if (!empty($entry->info_video)) {
                        $media = $entry->getMedia()->where('file_name', $entry->info_video)->first();
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

    protected function setupUpdateOperation()
    {
        CRUD::setValidation(FarmDetailRequest::class);

        CRUD::field('farm.code')->attributes(['disabled' => true]);
        CRUD::field('year');
        CRUD::field('phone_number');
        CRUD::field('chef_upa');
        CRUD::field('type')->label('Type');
        CRUD::field('village_id');
        CRUD::field('longitude');
        CRUD::field('latitude');
        CRUD::field('altitude');
        CRUD::field('accuracy');
        CRUD::field('chef_travaux');
        CRUD::field('neo_alphabete');
        CRUD::field('activite_primaire');
        CRUD::field('activite_secondaire');
        CRUD::field('cereales_favoris_1');
        CRUD::field('cereales_favoris_2');
        CRUD::field('cereales_favoris_3');
        CRUD::field('superficie_possede_upa');
        CRUD::field('superficie_cultive_upa');

        CRUD::field('nom_coop_coton_upa');
        CRUD::field('nom_coop_cereales_upa');
        CRUD::field('nom_union_cereales_upa');
        CRUD::field('upa_membres');
        CRUD::field('upa_actifs');
        CRUD::field('nombre_enfants');
        CRUD::field('nombre_adolescents');
        CRUD::field('nombre_femmes');
        CRUD::field('nombre_hommes');
        CRUD::field('nombre_femmes_agees');
        CRUD::field('nombre_hommes_ages');
        CRUD::field('nombre_charrues');
        CRUD::field('nombre_multiculteurs');
        CRUD::field('nombre_charrettes');
        CRUD::field('nombre_tracteur');
        CRUD::field('nombre_semoir');
        CRUD::field('nombre_motoculteurs');
        CRUD::field('nombre_pompe_traitement');
        CRUD::field('nombre_pulverisateurs');
        CRUD::field('nombre_corps_buteur');
        CRUD::field('autre_materiel');
        CRUD::field('nombre_autre_materiel');
        CRUD::field('nombre_boeuf_labour');
        CRUD::field('nombre_taureaux');
        CRUD::field('nombre_vaches_taries');
        CRUD::field('nombre_vaches_laitieres');
        CRUD::field('nombre_genisses');
        CRUD::field('nombre_veaux');
        CRUD::field('nombre_anes');
        CRUD::field('nombre_chevaux');
        CRUD::field('nombre_moutons');
        CRUD::field('nombre_chevres');
        CRUD::field('nombre_porcs');
        CRUD::field('nombre_poules');
        CRUD::field('nombre_pintades');
        CRUD::field('nombre_lapins');
        CRUD::field('nombre_canards');
        CRUD::field('nombre_pigeons');
        CRUD::field('autre_animal');
        CRUD::field('nombre_autre_animal');
        CRUD::field('info_text');
        CRUD::field('info_audio');
        CRUD::field('info_image');
        CRUD::field('info_videos');
        CRUD::field('observation_appreciation');
    }

    protected function setupShowOperation()
    {
        $this->setupListOperation();
    }
}
