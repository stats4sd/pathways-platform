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

    protected static function booted()
    {
        static::creating(function (Farm $farm) {
            $user = User::create(['name' => $farm->chef_upa, 'email' => 'farm_'.$farm->id, 'email_verified_at' => now(), 'password' => bcrypt(rand(10000,99999))]);
            $user->addRole('Farmer');

            $farm->user_id = $user->id;
        });

    }

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

    public function communes(): BelongsToMany
    {
        return $this->belongsToMany(Commune::class);
    }

}
