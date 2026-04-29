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

    public function animalFeedCategories(): HasMany
    {
        return $this->hasMany(AnimalFeedCategory::class);
    }

}
