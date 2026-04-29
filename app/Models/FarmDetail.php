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

    protected $auditInclude = ['*'];
    protected $auditEvents = ['updated','deleted'];
    protected $auditExclude = ['created_at'];

    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farm::class);
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

}
