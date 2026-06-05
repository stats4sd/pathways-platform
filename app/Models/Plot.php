<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Plot extends Model implements HasMedia, Auditable
{
    use CrudTrait;
    use HasFactory;
    use InteractsWithMedia;
    use AuditableTrait;

    protected $table = 'plots';
    protected $guarded = [];
    protected $casts = ['trace_superficie' => 'array'];

    protected $auditEvents = ['updated','deleted'];
    protected $auditExclude = ['created_at'];
    protected $auditInclude = [
                                'numero_parcelle',
                                'fertilite',
                                'prev_crop_id',
                                'crop_id',
                                'nom_variete_culture',
                                'type_variete_culture',
                                'date_semence',
                                'quantite_semence',
                                'source_semence_culture',
                                'autre_source_semence_cutture',
                                'nombre_arbre',
                                'nom_arbres',
                                'cultures_associations',
                                'quantite_fumure_organique',
                                'type_fumure_organique',
                                'autre_type_fumure_organique',
                                'quantite_npk',
                                'quantite_uree',
                                'nom_autre_engrais',
                                'superficie_estimee',
                                'superficie_measuree',
                            ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function field(): BelongsTo
    {
        return $this->belongsTo(Field::class);
    }

    public function crops(): HasMany
    {
        return $this->hasMany(Crop::class);
    }
}
