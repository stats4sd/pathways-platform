<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class AnimalFeedCategory extends Model implements Auditable
{
    use CrudTrait;
    use HasFactory;
    use AuditableTrait;

    protected $table = 'animal_feed_categories';
    protected $guarded = [];

    protected $auditInclude = ['*'];
    protected $auditEvents = ['updated','deleted'];
    protected $auditExclude = ['created_at'];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function animalFeed(): BelongsTo
    {
        return $this->belongsTo(AnimalFeed::class);
    }

}
