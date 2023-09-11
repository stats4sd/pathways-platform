<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Farm extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'farms';
    protected $guarded = [];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function plantings(): HasMany
    {
        return $this->hasMany(Planting::class);
    }

    public function postPlantings(): HasMany
    {
        return $this->hasMany(PostPlanting::class);
    }

    public function harvests(): HasMany
    {
        return $this->hasMany(Harvest::class);
    }

    public function crops(): HasMany
    {
        return $this->hasMany(Crop::class);
    }

    public function fields(): HasMany
    {
        return $this->hasMany(Field::class);
    }

    public function interestPoints(): HasMany
    {
        return $this->hasMany(InterestPoint::class);
    }

}
