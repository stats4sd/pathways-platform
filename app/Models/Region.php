<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Region extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'regions';
    protected $guarded = [];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function cercles(): HasMany
    {
        return $this->hasMany(Cercle::class);
    }

    public function federationScpcs(): BelongsToMany
    {
        return $this->belongsToMany(FederationScpc::class, 'federation_scpc_region');
    }

}
