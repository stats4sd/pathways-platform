<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    public function farms(): BelongsToMany
    {
        return $this->belongsToMany(Farm::class);
    }
    
}
