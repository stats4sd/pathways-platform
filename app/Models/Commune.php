<?php

namespace App\Models;

use App\Models\Cercle;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commune extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'communes';
    protected $guarded = [];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function cercle(): BelongsTo
    {
        return $this->belongsTo(Cercle::class);
    }
    
    public function villages(): HasMany
    {
        return $this->hasMany(Village::class);
    }

    public function unionScpcs(): HasMany
    {
        return $this->hasMany(UnionScpc::class);
    }

}
