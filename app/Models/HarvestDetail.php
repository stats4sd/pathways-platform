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

class HarvestDetail extends Model implements HasMedia, Auditable
{
    use CrudTrait;
    use HasFactory;
    use InteractsWithMedia;
    use AuditableTrait;

    protected $table = 'harvests_details';
    protected $guarded = [];

    protected $auditEvents = ['updated','deleted'];
    protected $auditExclude = ['created_at'];
    protected $auditInclude = [
                                'crop_id',
                                'superficie_recolte_prestation',
                                'cout_total_prestation_recolte',
                                'production',
                                'cout_total_battage',
                                'production_residu_culture',
                                'nombre_botte',
                                'cout',
                            ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function harvest(): BelongsTo
    {
        return $this->belongsTo(Harvest::class);
    }

}
