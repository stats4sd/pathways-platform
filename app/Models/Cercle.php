<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cercle extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'cercles';
    protected $guarded = [];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }
    
    public function communes(): HasMany
    {
        return $this->hasMany(Commune::class);
    }
    
}
