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

class FarmExpense extends Model implements HasMedia, Auditable
{
    use CrudTrait;
    use HasFactory;
    use InteractsWithMedia;
    use AuditableTrait;

    protected $table = 'farm_expenses';
    protected $guarded = [];

    protected $auditEvents = ['updated','deleted'];
    protected $auditExclude = ['created_at'];
    protected $auditInclude = [
                                'year',
                                'frais_condiment_jour',
                                'frais_condiment_annuel',
                                'nombre_personne_upa',
                                'frais_sante_annuel',
                                'frais_education_annuel',
                                'nom_autre_frais',
                                'montant_autre_frais',
                                'invest_maison',
                                'invest_mariage',
                                'invest_equipment',
                                'autre_invest',
                                'montant_autre_invest',
                                'depenses_recurrentes',
                                'depenses_investissements',
                                'depenes_total',
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
