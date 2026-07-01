<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UnionScpc extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'union_scpcs';
    protected $guarded = [];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function commune(): BelongsTo
    {
        return $this->belongsTo(Commune::class);
    }

    public function farmDetails(): HasMany
    {
        return $this->hasMany(FarmDetail::class);
    }

}
