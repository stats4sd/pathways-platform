<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Crop extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'crops';
    protected $guarded = [];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function plantingDetails(): HasMany
    {
        return $this->hasMany(PlantingDetail::class);
    }

    public function postPlantingDetails(): HasMany
    {
        return $this->hasMany(PostPlantingDetail::class);
    }

    public function harvestDetails(): HasMany
    {
        return $this->hasMany(HarvestDetail::class);
    }
    
}
