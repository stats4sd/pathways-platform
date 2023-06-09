<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostPlantingDetail extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'post_plantings_details';
    protected $guarded = [];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function postPlanting(): BelongsTo
    {
        return $this->belongsTo(PostPlanting::class);
    }

}
