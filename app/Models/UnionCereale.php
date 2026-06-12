<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UnionCereale extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'union_cereales';
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

    public function farmDetails(): HasMany
    {
        return $this->hasMany(FarmDetail::class);
    }

}
