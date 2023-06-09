<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HarvestDetail extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'harvests_details';
    protected $guarded = [];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function harvest(): BelongsTo
    {
        return $this->belongsTo(Harvest::class);
    }

}
