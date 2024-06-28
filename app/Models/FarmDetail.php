<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FarmDetail extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'farms_details';
    protected $guarded = [];

    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farm::class);
    }

}
