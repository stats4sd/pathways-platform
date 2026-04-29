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

class PostPlantingDetail extends Model implements HasMedia, Auditable
{
    use CrudTrait;
    use HasFactory;
    use InteractsWithMedia;
    use AuditableTrait;

    protected $table = 'post_plantings_details';
    protected $guarded = [];

    protected $auditEvents = ['updated','deleted'];
    protected $auditExclude = ['created_at'];
    protected $auditInclude = [
                                'crop_id',
                                'superficie_sarclage',
                                'cout_sarclage',
                                'superficie_desherbage',
                                'cout_desherbage',
                                'quantite_npk',
                                'cout_npk',
                                'quantite_uree',
                                'cout_uree',
                                'quantite_herbicide',
                                'cout_herbicide',
                                'superficie_butee',
                                'cout_buttage',
                                'quantite_insecticide',
                                'cout_insecticide',
                                'cout',
                            ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function postPlanting(): BelongsTo
    {
        return $this->belongsTo(PostPlanting::class);
    }

}
