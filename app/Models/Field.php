<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Field extends Model implements HasMedia, Auditable
{
    use CrudTrait;
    use HasFactory;
    use InteractsWithMedia;
    use AuditableTrait;

    protected $table = 'fields';
    protected $guarded = [];
    protected $appends = ['center'];

    protected $auditEvents = ['updated','deleted'];
    protected $auditExclude = ['created_at'];
    protected $auditInclude = [
                                    'year',
                                    'nom',
                                    'type_sol',
                                    'pente',
                                    'superficie_total',
                                ];
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function plots(): HasMany
    {
        return $this->hasMany(Plot::class);
    }

    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farm::class);
    }
    
    public function getCenterAttribute()
    {
        $coords = [];

        foreach($this->plots as $plot) {

            foreach($plot->trace_superficie as $point){
                $coords[]=['lat' => $point[1], 'lng' => $point[0]];
            }
        }

        $count_coords = count($coords);
        $xcos=0.0;
        $ycos=0.0;
        $zsin=0.0;
            
        if($count_coords>0) {

            foreach ($coords as $lnglat)
            {
                $lat = $lnglat['lat'] * pi() / 180;
                $lon = $lnglat['lng'] * pi() / 180;
                
                $acos = cos($lat) * cos($lon);
                $bcos = cos($lat) * sin($lon);
                $csin = sin($lat);
                $xcos += $acos;
                $ycos += $bcos;
                $zsin += $csin;
            }
            
            $xcos /= $count_coords;
            $ycos /= $count_coords;
            $zsin /= $count_coords;
            $lon = atan2($ycos, $xcos);
            $sqrt = sqrt($xcos * $xcos + $ycos * $ycos);
            $lat = atan2($zsin, $sqrt);
            
            $center = array($lat * 180 / pi(), $lon * 180 / pi());

            return $center;
        }

        else {
            return [17.5739347, -3.9861092];
        }

    }
}
