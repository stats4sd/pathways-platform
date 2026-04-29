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

    protected $auditInclude = ['*'];
    protected $auditEvents = ['updated','deleted'];
    protected $auditExclude = ['created_at'];

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
