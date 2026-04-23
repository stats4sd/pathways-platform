<?php

namespace App\Models;

use App\Models\Village;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class FarmDetail extends Model implements HasMedia
{
    use CrudTrait;
    use HasFactory;
    use InteractsWithMedia;

    protected $table = 'farms_details';
    protected $guarded = [];

    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farm::class);
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

}
