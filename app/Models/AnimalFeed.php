<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class AnimalFeed extends Model implements HasMedia, Auditable
{
    use CrudTrait;
    use HasFactory;
    use InteractsWithMedia;
    use AuditableTrait;

    protected $table = 'animal_feeds';
    protected $guarded = [];

    protected $auditEvents = ['updated','deleted'];
    protected $auditExclude = ['created_at'];
    protected $auditInclude = [
                                'year',
                                'total_concentre',
                                'total_residu',
                                'total_fane',
                                'liste_cat_animales',
                                'quantite_son',
                                'quantite_tourteau',
                                'concentre_produit',
                                'achat_son_quantite',
                                'prix_sac_son',
                                'cal_depense_son',
                                'prix_sac_tourteau',
                                'cal_depense_tourteau',
                                'cal_depense_tour',
                                'cal_superficie',
                                'cal_depense_total',
                                'cal_depense_soins',
                            ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farm::class);
    }

    public function animalFeedCategories(): HasMany
    {
        return $this->hasMany(AnimalFeedCategory::class);
    }

}
