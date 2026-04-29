<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class PostPlanting extends Model implements Auditable
{
    use CrudTrait;
    use HasFactory;
    use AuditableTrait;
    use AuditableTrait;
    
    protected $table = 'post_plantings';
    protected $guarded = [];

    protected $auditInclude = ['*'];
    protected $auditEvents = ['updated','deleted'];
    protected $auditExclude = ['created_at'];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farm::class);
    }
    
    public function postPlantingDetails(): HasMany
    {
        return $this->hasMany(PostPlantingDetail::class);
    }

}
