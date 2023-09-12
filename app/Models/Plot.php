<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plot extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'plots';
    protected $guarded = [];

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
