<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BaseScpc extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'base_scpcs';
    protected $guarded = [];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function villages(): BelongsToMany
    {
        return $this->belongsToMany(Village::class, 'base_scpc_village');
    }

    public function farmDetails(): HasMany
    {
        return $this->hasMany(FarmDetail::class);
    }

}
