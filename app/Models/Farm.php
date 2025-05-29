<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    // platform management
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    // collected data
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

    public function villages(): BelongsToMany
    {
        return $this->belongsToMany(Village::class);
    }

    public function farmDetails(): HasMany
    {
        return $this->hasMany(FarmDetail::class);
    }

    public function farmExpenses(): HasMany
    {
        return $this->hasMany(FarmExpense::class);
    }

    public function humanCerealNeeds(): HasMany
    {
        return $this->hasMany(HumanCerealNeed::class);
    }

    public function animalFeeds(): HasMany
    {
        return $this->hasMany(AnimalFeed::class);
    }

    public function organicFertilisers(): HasMany
    {
        return $this->hasMany(OrganicFertiliser::class);
    }
}
