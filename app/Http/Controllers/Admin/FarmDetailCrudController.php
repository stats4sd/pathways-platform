<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\FarmDetail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EnrolmentWorkbookExport;
use App\Http\Requests\FarmDetailRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Stats4sd\FileUtil\Http\Controllers\Operations\ExportOperation;

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
    use ExportOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\FarmDetail::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/farm_detail');
        CRUD::setEntityNameStrings('Détails UPA', 'Détails UPA');
        CRUD::set('export.exporter', EnrolmentWorkbookExport::class);
    }

    protected function setupListOperation()
    {
        CRUD::column('id')->label('ID');
        CRUD::column('farm.code')->label('UPA');
        CRUD::column('year');
        CRUD::column('phone_number');
        CRUD::column('chef_upa');
        CRUD::column('type');
        CRUD::column('ratio_membre_terre')->type('number')->decimals(2);
        CRUD::column('ratio_actif_terre')->type('number')->decimals(2);
        CRUD::column('ratio_boeuflabour_terre')->type('number')->decimals(2);
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
        
        $this->crud->getRequest()->request->set('id', $this->crud->getCurrentEntry()->id);
        $this->crud->getRequest()->request->set('farm_id', $this->crud->getCurrentEntry()->farm_id);

        CRUD::field('id')
            ->type('number')
            ->label('ID')
            ->attributes(['disabled' => 'disabled']);

        CRUD::field('farm.code')
            ->label('UPA')
            ->attributes(['disabled' => 'disabled']);

        CRUD::setValidation(FarmDetailRequest::class);

        CRUD::field('farm.code')->attributes(['disabled' => true])->label('UPA');
        CRUD::field('year')->type('number');
        CRUD::field('phone_number');
        CRUD::field('chef_upa');
        CRUD::field('type')->label('Type');
        CRUD::field('ratio_membre_terre')->type('number')->attributes(['step' => '0.01']);
        CRUD::field('ratio_actif_terre')->type('number')->attributes(['step' => '0.01']);
        CRUD::field('ratio_boeuflabour_terre')->type('number')->attributes(['step' => '0.01']);
        CRUD::field('village_id');
        CRUD::field('longitude')->type('number')->attributes(['step' => 'any']);
        CRUD::field('latitude')->type('number')->attributes(['step' => 'any']);
        CRUD::field('altitude')->type('number')->attributes(['step' => 'any']);
        CRUD::field('accuracy')->type('number')->attributes(['step' => 'any']);
        CRUD::field('chef_travaux');
        CRUD::field('neo_alphabete');
        CRUD::field('activite_primaire');
        CRUD::field('activite_secondaire');
        CRUD::field('cereales_favoris_1');
        CRUD::field('cereales_favoris_2');
        CRUD::field('cereales_favoris_3');
        CRUD::field('superficie_possede_upa')->type('number');
        CRUD::field('superficie_cultive_upa')->type('number');

        CRUD::field('nom_coop_coton_upa');
        CRUD::field('nom_coop_cereales_upa');
        CRUD::field('nom_union_cereales_upa');
        CRUD::field('upa_membres')->type('number');
        CRUD::field('upa_actifs')->type('number');
        CRUD::field('nombre_enfants')->type('number');
        CRUD::field('nombre_adolescents')->type('number');
        CRUD::field('nombre_femmes')->type('number');
        CRUD::field('nombre_hommes')->type('number');
        CRUD::field('nombre_femmes_agees')->type('number');
        CRUD::field('nombre_hommes_ages')->type('number');
        CRUD::field('nombre_charrues')->type('number');
        CRUD::field('nombre_multiculteurs')->type('number');
        CRUD::field('nombre_charrettes')->type('number');
        CRUD::field('nombre_tracteur')->type('number');
        CRUD::field('nombre_semoir')->type('number');
        CRUD::field('nombre_motoculteurs')->type('number');
        CRUD::field('nombre_pompe_traitement')->type('number');
        CRUD::field('nombre_pulverisateurs')->type('number');
        CRUD::field('nombre_corps_buteur')->type('number');
        CRUD::field('autre_materiel');
        CRUD::field('nombre_autre_materiel')->type('number');
        CRUD::field('nombre_boeuf_labour')->type('number');
        CRUD::field('nombre_taureaux')->type('number');
        CRUD::field('nombre_vaches_taries')->type('number');
        CRUD::field('nombre_vaches_laitieres')->type('number');
        CRUD::field('nombre_genisses')->type('number');
        CRUD::field('nombre_veaux')->type('number');
        CRUD::field('nombre_anes')->type('number');
        CRUD::field('nombre_chevaux')->type('number');
        CRUD::field('nombre_moutons')->type('number');
        CRUD::field('nombre_chevres')->type('number');
        CRUD::field('nombre_porcs')->type('number');
        CRUD::field('nombre_poules')->type('number');
        CRUD::field('nombre_pintades')->type('number');
        CRUD::field('nombre_lapins')->type('number');
        CRUD::field('nombre_canards')->type('number');
        CRUD::field('nombre_pigeons')->type('number');
        CRUD::field('autre_animal');
        CRUD::field('nombre_autre_animal')->type('number');
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

    public function export() 
    {
        return Excel::download(new EnrolmentWorkbookExport, 'donnees_de_UPA - '.Carbon::now()->format('Ymd_His').'.xlsx');
    }
}
