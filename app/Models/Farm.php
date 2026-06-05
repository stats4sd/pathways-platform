<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Farm extends Model implements Auditable
{
    use CrudTrait;
    use HasFactory;
    use AuditableTrait;

    protected $table = 'farms';
    protected $guarded = [];

    protected $auditEvents = ['updated','deleted'];
    protected $auditExclude = ['created_at'];
    protected $auditInclude = [
                                'type',
                                'phone_number',
                                'chef_upa'
                            ];

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
