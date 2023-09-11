<?php

namespace App\Models;

use DateTime;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Submission extends \Stats4sd\OdkLink\Models\Submission
{
    use CrudTrait;
    use HasFactory;

    public function getDurationAttribute()
    {
        $start = $this->content['starttime'];
        $end = $this->content['endtime'];

        $starttime = new DateTime($start);
        $endtime = new DateTime($end);

        $elapsed = $starttime->diff($endtime);

        $total_minutes = ($elapsed->days * 24 * 60);
        $total_minutes += ($elapsed->h * 60);
        $total_minutes += $elapsed->i;
        
        $duration = $elapsed->format($total_minutes.' minute(s) %s second(s)');

        return $duration;

    }
    
}
