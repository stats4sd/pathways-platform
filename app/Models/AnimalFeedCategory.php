<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnimalFeedCategory extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'animal_feed_categories';
    protected $guarded = [];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function animalFeed(): BelongsTo
    {
        return $this->belongsTo(AnimalFeed::class);
    }

}
