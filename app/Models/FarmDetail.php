<?php

namespace App\Models;

use App\Models\Village;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class FarmDetail extends Model implements HasMedia, Auditable
{
    use CrudTrait;
    use HasFactory;
    use InteractsWithMedia;
    use AuditableTrait;

    protected $table = 'farms_details';
    protected $guarded = [];

    protected $auditEvents = ['updated','deleted'];
    protected $auditExclude = ['created_at'];
    protected $auditInclude = [
                                'year',
                                'phone_number',
                                'chef_upa',
                                'type',
                                'ratio_membre_terre',
                                'ratio_actif_terre',
                                'ratio_boeuflabour_terre',
                                'village_id',
                                'longitude',
                                'latitude',
                                'altitude',
                                'accuracy',
                                'chef_travaux',
                                'neo_alphabete',
                                'activite_primaire',
                                'activite_secondaire',
                                'cereales_favoris_1',
                                'cereales_favoris_2',
                                'cereales_favoris_3',
                                'superficie_possede_upa',
                                'superficie_cultive_upa',
                                'nom_coop_coton_upa',
                                'nom_coop_cereales_upa',
                                'nom_union_cereales_upa',
                                'upa_membres',
                                'upa_actifs',
                                'nombre_enfants',
                                'nombre_adolescents',
                                'nombre_femmes',
                                'nombre_hommes',
                                'nombre_femmes_agees',
                                'nombre_hommes_ages',
                                'nombre_charrues',
                                'nombre_multiculteurs',
                                'nombre_charrettes',
                                'nombre_tracteur',
                                'nombre_semoir',
                                'nombre_motoculteurs',
                                'nombre_pompe_traitement',
                                'nombre_pulverisateurs',
                                'nombre_corps_buteur',
                                'autre_materiel',
                                'nombre_autre_materiel',
                                'nombre_boeuf_labour',
                                'nombre_taureaux',
                                'nombre_vaches_taries',
                                'nombre_vaches_laitieres',
                                'nombre_genisses',
                                'nombre_veaux',
                                'nombre_anes',
                                'nombre_chevaux',
                                'nombre_moutons',
                                'nombre_chevres',
                                'nombre_porcs',
                                'nombre_poules',
                                'nombre_pintades',
                                'nombre_lapins',
                                'nombre_canards',
                                'nombre_pigeons',
                                'autre_animal',
                                'nombre_autre_animal',
                            ];

    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farm::class);
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    public function unionCereale(): BelongsTo
    {
        return $this->belongsTo(UnionCereale::class);
    }

    public function cooperativeCereale(): BelongsTo
    {
        return $this->belongsTo(CooperativeCereale::class);
    }

    public function federationScpc(): BelongsTo
    {
        return $this->belongsTo(FederationScpc::class);
    }

    public function unionScpc(): BelongsTo
    {
        return $this->belongsTo(UnionScpc::class);
    }

    public function baseScpc(): BelongsTo
    {
        return $this->belongsTo(BaseScpc::class);
    }

}
