<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FederationScpc extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'federation_scpcs';
    protected $guarded = [];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function regions(): BelongsToMany
    {
        return $this->belongsToMany(Region::class, 'federation_scpc_region');
    }

    public function farmDetails(): HasMany
    {
        return $this->hasMany(FarmDetail::class);
    }

}
