<?php

namespace App\Http\Controllers;

use App\Models\Farm;
use App\Models\Plot;
use Illuminate\Support\Facades\Storage;

class FarmController extends Controller

{

    public function show(Farm $farm)
    {
        return view('farms.show', ['farm' => $farm]);
    }


    public static function getFarmCoords(Farm $farm)
    {
        # FARM CENTER

        $coords = [];

        foreach($farm->fields as $field){
            foreach($field->plots as $plot) {

                $points = explode(';', $plot->trace_superficie);

                foreach($points as $point){
                    $coordinate=explode(' ', $point);
                    $coords[]=['lat' => floatval($coordinate[0]), 'lng' => floatval($coordinate[1])];
                }
            }
        }

        foreach($farm->interestPoints as $interestPoint) {
            $coords[]=['lat' => floatval($interestPoint->latitude), 'lng' => floatval($interestPoint->longitude)];
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
            
            $farmCenter = array($lat * 180 / pi(), $lon * 180 / pi());
        }
        
        else {
            $farmCenter = [17.5739347, -3.9861092];
        }
        
        
        # PLOTS
        
        $field_ids = $farm->fields()->pluck('id');

        $plots = Plot::whereIn('field_id', $field_ids)->get();
        
        $plotCoords = $plots->map(function($plot) {

            $points = explode(';', $plot->trace_superficie);
            $latlngs = [];

            foreach($points as $point){
                $coordinate=explode(' ', $point);
                $latlngs[]=[floatval($coordinate[0]), floatval($coordinate[1])];
            }

            // remove duplicate points
            $latlngs_plot_unique = array_unique($latlngs, SORT_REGULAR);

            $plot->latlngs = $latlngs_plot_unique;
            
            # include field details
            $plot->load('field');

            return $plot;
        });

        # incldue field color
        $colors = ["#b877e6", "#41b782", '#77dbe6', '#e6ba77', '#8077e6', '#77e6cc', 
                    '#d9e677', '#e67777', '#7be677', '#e677dd', '#77b8e6', '#e67d77'];
        $field_colors = [];

        foreach($field_ids as $field_id=>$index) {
            $field_colors[$field_ids[$field_id]] = $colors[$field_id];
        }

        foreach($plotCoords as $plot) {
            $plot->field_color = $field_colors[$plot->field_id];
        }



        # INTEREST POINTS
        $interestPointCoords = $farm
                                ->interestPoints()
                                ->select('id', 'nom', 'longitude', 'latitude')
                                ->get();

        $interestPointCoords = $interestPointCoords->map(function($point) {
            $point->latlng = ['lat' => $point->latitude, 'lng' => $point->longitude];
            
            # include icon
            $point->icon = Storage::disk('public')->URL('images/'.strtolower(str_replace(' ', '_', $point->nom)).'.png');
            
            return $point;

        });



        return[
            "plotCoords" => $plotCoords,
            "interestPointCoords" => $interestPointCoords,
            "farmCenter" => $farmCenter,
        ];

    }

}
