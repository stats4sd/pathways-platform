<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PlantingDetail extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'plantings_details';
    protected $guarded = [];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function planting(): BelongsTo
    {
        return $this->belongsTo(Planting::class);
    }

}
