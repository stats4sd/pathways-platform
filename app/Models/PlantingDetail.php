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

class PlantingDetail extends Model implements HasMedia, Auditable
{
    use CrudTrait;
    use HasFactory;
    use InteractsWithMedia;
    use AuditableTrait;

    protected $table = 'plantings_details';
    protected $guarded = [];

    protected $auditEvents = ['updated','deleted'];
    protected $auditExclude = ['created_at'];
    protected $auditInclude = [
                                'crop_id',
                                'superficie_ha',
                                'culture_prev',
                                'quantite_fumure_organique',
                                'cout_transport',
                                'quantite_chaux_agricole',
                                'cout_chaux_agricole',
                                'quantite_pnt_png',
                                'cout_pnt_png',
                                'superficie_labouree',
                                'cout_superficie_labouree',
                                'date_semence',
                                'quantite_semence',
                                'quantite_semence_achetee',
                                'cout_semence_achetee',
                                'quantite_herbicide_prelevee',
                                'cout_herbicide_prelevee',
                                'cout',
                            ];


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function planting(): BelongsTo
    {
        return $this->belongsTo(Planting::class);
    }

}
