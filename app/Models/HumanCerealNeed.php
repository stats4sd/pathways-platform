<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class HumanCerealNeed extends Model implements HasMedia, Auditable
{
    use CrudTrait;
    use HasFactory;
    use InteractsWithMedia;
    use AuditableTrait;

    protected $table = 'human_cereal_needs';
    protected $guarded = [];

    protected $auditEvents = ['updated','deleted'];
    protected $auditExclude = ['created_at'];
    protected $auditInclude = [
                                'year',
                                'type_menage',
                                'personnes_nourrir',
                                'besoin_cereale_exploitation',
                                'sac_mais',
                                'sac_mil',
                                'sac_sorgho',
                                'sac_cereales',
                                'sac_cereales_diff',
                                'rend_moyen_mais',
                                'rend_moyen_mil',
                                'rend_moyen_sorgho',
                                'superficie_mais',
                                'superficie_mil',
                                'superficie_sorgho',
                                'superficie_totale',
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

}
