<?php

namespace App\Models;

use App\Models\Commune;
use App\Models\FarmDetail;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Village extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'villages';
    protected $guarded = [];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    
    public function commune(): BelongsTo
    {
        return $this->belongsTo(Commune::class);
    }

    public function farmDetails(): BelongsToMany
    {
        return $this->belongsToMany(FarmDetail::class);
    }
}
