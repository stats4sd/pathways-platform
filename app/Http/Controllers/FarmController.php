<?php

namespace App\Http\Controllers;

use App\Models\Crop;
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
                foreach($plot->trace_superficie as $point){
                    $coords[]=['lat' => $point[1], 'lng' => $point[0]];
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
            $noCoords = 0;

        }
        
        else {
            $farmCenter = [17.5739347, -3.9861092];
            $noCoords = 1;
        }
        
        
        # PLOTS
        
        $field_ids = $farm->fields()->pluck('id');

        $plots = Plot::whereIn('field_id', $field_ids)->get();
        
        $plotCoords = $plots->map(function($plot) {

            $latlngs = [];

            foreach($plot->trace_superficie as $point){
                $latlngs[]=[$point[1], $point[0]];
            }

            // remove duplicate points
            $latlngs_plot_unique = array_unique($latlngs, SORT_REGULAR);

            $plot->latlngs = $latlngs_plot_unique;
            
            // include field details
            $plot->load('field');

            // include main crop details
            $plot->main_crop_image = Crop::where('id', $plot->crop_id)->pluck('nom_fichier_image')->first();
            $plot->main_crop_bm = Crop::where('id', $plot->crop_id)->pluck('label_bm')->first();
            $plot->main_crop_fr = Crop::where('id', $plot->crop_id)->pluck('label_fr')->first();

            // include associated crop details
            $associated_crops = explode(' ', $plot->cultures_associations);
            $associated_crops_details = [];

            foreach($associated_crops as $associated_crop) {
                $crop_image = Crop::where('id', $associated_crop)->pluck('nom_fichier_image')->first();
                $crop_bm = Crop::where('id', $associated_crop)->pluck('label_bm')->first();
                $crop_fr = Crop::where('id', $associated_crop)->pluck('label_fr')->first();

                $associated_crops_details[]=['crop_image' => $crop_image, 'label_bm' => $crop_bm, 'label_fr' => $crop_fr];
            }

            $plot->associated_crops = $associated_crops_details;

            // inlcude plot fertility bm label
            if($plot->fertilite === 'pauvre') {$plot->fertilite_bm = 'Sɛngɛlen';}
            elseif($plot->fertilite === 'moyen') {$plot->fertilite_bm = 'Camancɛ';}
            elseif($plot->fertilite === 'fertile') {$plot->fertilite_bm = 'Fangama';}
            else {$plot->fertilite_bm = $plot->fertilite;}

            // inlcude field soil type bm label
            if($plot->field->type_sol === 'sable') {$plot->field->type_sol_bm = 'Cɛncɛn';}
            elseif($plot->field->type_sol === 'gravillon') {$plot->field->type_sol_bm = 'Bɛlɛ';}
            elseif($plot->field->type_sol === 'argile') {$plot->field->type_sol_bm = 'Bɔgɔ';}
            else {$plot->field->type_sol_bm = $plot->field->type_sol;}
            
            // inlcude field slope bm label
            if($plot->field->pente === 'plat') {$plot->field->pente_bm = 'Dalen';}
            elseif($plot->field->pente === 'incline') {$plot->field->pente_bm = 'Jɛgɛlen';}
            elseif($plot->field->pente === 'escarpe') {$plot->field->pente_bm = 'Jɔlen';}
            else {$plot->field->pente_bm = $plot->field->pente;}


            // add rounding to area
            $plot->superficie_measuree = round(floatval($plot->superficie_measuree),1);
            $plot->field->superficie_total = round(floatval($plot->field->superficie_total),1);

            return $plot;
        });


        // incldue field color
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
            
            // include icon
            $point->icon = Storage::disk('public')->URL('images/'.strtolower(str_replace(' ', '_', $point->nom)).'.png');
            
            return $point;

        });

        return[
            "plotCoords" => $plotCoords,
            "interestPointCoords" => $interestPointCoords,
            "farmCenter" => $farmCenter,
            "noCoords" => $noCoords,
        ];

    }

    public static function getFarmArea(Farm $farm)
    {
        $field_ids = $farm->fields()->pluck('id');
        $plots = Plot::whereIn('field_id', $field_ids)->get();
        
        # TOTAL AREA (SUPERFICIE) ALL CROPS

        $totalArea = $farm->fields->sum('superficie_total');

        # AREA PER PRIMARY CROP

        $primaryCrops = Crop::where('type', 'primaire')->select('id', 'label_bm', 'nom_fichier_image', 'order')->get()->sortBy('order');
        $primaryCropIds = $primaryCrops->pluck('id')->toArray();

        $plotAreas = [];

        foreach ($plots as $plot) {
            if(in_array($plot['crop_id'], $primaryCropIds)) {
                $plotAreas[$plot['crop_id']][]= $plot['superficie_measuree'];
            }
        }

        $plotAreas = array_map('array_sum', $plotAreas);

        foreach($primaryCrops as $key => $primaryCrop){
            if(in_array($primaryCrop->id, array_keys($plotAreas))) {
                $primaryCrop->area = $plotAreas[$primaryCrop->id];
            }
            else {
                unset($primaryCrops[$key]);
            }
        }

        # AREA PER SECONDARY CROP

        $secondaryCrops = Crop::where('type', 'secondaire')->select('id', 'label_bm', 'nom_fichier_image', 'order')->get()->sortBy('order');
        $secondaryCropIds = $secondaryCrops->pluck('id')->toArray();

        $plotAreas = [];

        foreach ($plots as $plot) {
            if(in_array($plot['crop_id'], $secondaryCropIds)) {
                $plotAreas[$plot['crop_id']][]= $plot['superficie_measuree'];
            }
        }

        $plotAreas = array_map('array_sum', $plotAreas);

        foreach($secondaryCrops as $key => $secondaryCrop){
            if(in_array($secondaryCrop->id, array_keys($plotAreas))) {
                $secondaryCrop->area = $plotAreas[$secondaryCrop->id];
            }
            else {
                unset($secondaryCrops[$key]);
            }
        }

        return[
            "totalArea" => $totalArea,
            "primaryArea" => $primaryCrops,
            "secondaryArea" => $secondaryCrops,
        ];

    }
    
    public static function getFarmCosts(Farm $farm)
    {
        # TOTAL COST
        $plantingTotalCost = $farm->plantings->sum('cout_total');
        $postPlantingTotalCost = $farm->postPlantings->sum('cout_total');
        $harvestTotalCost = $farm->harvests->sum('cout_total');

        $totalCost = $plantingTotalCost + $postPlantingTotalCost + $harvestTotalCost;


        # COST PER CROP

        $primaryCrops = Crop::where('type', 'primaire')->select('id', 'label_bm', 'nom_fichier_image', 'order')->get()->sortBy('order');
        $primaryCropIds = $primaryCrops->pluck('id')->toArray();

        $cropCosts = [];

        foreach($farm->plantings as $planting){
            foreach($planting->plantingDetails as $plantingDetail){
                if(in_array($plantingDetail['crop_id'], $primaryCropIds)) {
                    $cropCosts[$plantingDetail['crop_id']][]= $plantingDetail['cout'];
                }
            }
        }

        foreach($farm->postPlantings as $postPlanting){
            foreach($postPlanting->postPlantingDetails as $postPlantingDetail){
                if(in_array($postPlantingDetail['crop_id'], $primaryCropIds)) {
                    $cropCosts[$postPlantingDetail['crop_id']][] = $postPlantingDetail['cout'];
                }
            }
        }

        foreach($farm->harvests as $harvest){
            foreach($harvest->harvestDetails as $harvestDetail){
                if(in_array($harvestDetail['crop_id'], $primaryCropIds)) {
                    $cropCosts[$harvestDetail['crop_id']][]= $harvestDetail['cout'];
                }
            }
        }

        $cropCosts = array_map('array_sum', $cropCosts);
        
        foreach($primaryCrops as $key => $primaryCrop){
            if(in_array($primaryCrop->id, array_keys($cropCosts))) {
                $primaryCrop->cost = $cropCosts[$primaryCrop->id];
            }
            else {
                unset($primaryCrops[$key]);
            }
        }


        # CROP INDIVIDUAL COSTS

        $cropIndividualCosts = [];

        foreach($farm->plantings as $planting){
            foreach($planting->plantingDetails as $plantingDetail){
                if(in_array($plantingDetail['crop_id'], $primaryCropIds)) {
                    $cropIndividualCosts[$plantingDetail['crop_id']]['Tolinɔgɔ donisara'][] = $plantingDetail['cout_transport'];
                    $cropIndividualCosts[$plantingDetail['crop_id']]['Faranɔgɔ sɔngɔ'][] = $plantingDetail['cout_chaux_agricole'];
                    $cropIndividualCosts[$plantingDetail['crop_id']]['Burɛmunɔgɔ sɔngɔ'][] = $plantingDetail['cout_pnt_png'];
                    $cropIndividualCosts[$plantingDetail['crop_id']]['Laburu sara sɔngɔ'][] = $plantingDetail['cout_superficie_labouree'];
                    $cropIndividualCosts[$plantingDetail['crop_id']]['Dannisi sannen sɔngɔ'][] = $plantingDetail['cout_semence_achetee'];
                    $cropIndividualCosts[$plantingDetail['crop_id']]['Binnagasi kɔli donnen sɔngɔ'][] = $plantingDetail['cout_herbicide_prelevee'];
                }
            }
        }

        foreach($farm->postPlantings as $postPlanting){
            foreach($postPlanting->postPlantingDetails as $postPlantingDetail){
                if(in_array($postPlantingDetail['crop_id'], $primaryCropIds)) {
                    $cropIndividualCosts[$postPlantingDetail['crop_id']]['Coût total prestation sarclage'][] = $postPlantingDetail['cout_sarclage'];
                    $cropIndividualCosts[$postPlantingDetail['crop_id']]['Siɲɛli sarala sɔngɔ'][] = $postPlantingDetail['cout_desherbage'];
                    $cropIndividualCosts[$postPlantingDetail['crop_id']]['Nɔgɔfin mɔninkuru sɔngɔ'][] = $postPlantingDetail['cout_npk'];
                    $cropIndividualCosts[$postPlantingDetail['crop_id']]['Sɛgɛnin donnen sɔngɔ'][] = $postPlantingDetail['cout_uree'];
                    $cropIndividualCosts[$postPlantingDetail['crop_id']]['Binkɔrɔ fagalan donnen sɔngɔ'][] = $postPlantingDetail['cout_herbicide'];
                    $cropIndividualCosts[$postPlantingDetail['crop_id']]['Kɔrɔbarili kɛlen sara la sɔngɔ'][] = $postPlantingDetail['cout_buttage'];
                    $cropIndividualCosts[$postPlantingDetail['crop_id']]['Bagaji donnen sɔngɔ'][] = $postPlantingDetail['cout_insecticide'];
                }
            }
        }

        foreach($farm->harvests as $harvest){
            foreach($harvest->harvestDetails as $harvestDetail){
                if(in_array($harvestDetail['crop_id'], $primaryCropIds)) {
                    $cropIndividualCosts[$harvestDetail['crop_id']]['Bɔli wali tigɛli sara sɔngɔ'][]= $harvestDetail['cout_total_prestation_recolte'];
                    $cropIndividualCosts[$harvestDetail['crop_id']]['Ɲɔ gosi sara sɔngɔ'][]= $harvestDetail['cout_total_battage'];
                }
            }
        }

        $cropIndividualCostsSummed=[];

        foreach($cropIndividualCosts as $key => $crop) {
                $cost = array_map('array_sum', $crop);
                $cropIndividualCostsSummed[$key] = $cost;
        }

        foreach($primaryCrops as $key => $primaryCrop){
            if(in_array($primaryCrop->id, array_keys($cropIndividualCostsSummed))) {
                $primaryCrop->individual_costs = $cropIndividualCostsSummed[$primaryCrop->id];
            }
            else {
                unset($primaryCrops[$key]);
            }
        }

        return[
            "totalCost" => $totalCost,
            "cropCosts" => $primaryCrops
        ];

    }

    public static function getFarmProduction(Farm $farm)
    {
        # PRODUCTION PER CROP

        $primaryCrops = Crop::where('type', 'primaire')->select('id', 'label_bm', 'nom_fichier_image', 'order')->get()->sortBy('order');
        $primaryCropIds = $primaryCrops->pluck('id')->toArray();

        $cropProductions = [];

        foreach($farm->harvests as $harvest){
            foreach($harvest->harvestDetails as $harvestDetail){
                if(in_array($harvestDetail['crop_id'], $primaryCropIds)) {
                    $cropProductions[$harvestDetail['crop_id']][]= $harvestDetail['production'];
                }
            }
        }

        foreach($primaryCrops as $key => $primaryCrop){
            if(in_array($primaryCrop->id, array_keys($cropProductions))) {
                $primaryCrop->production = round($cropProductions[$primaryCrop->id][0],1);
            }
            else {
                unset($primaryCrops[$key]);
            }
        }

        return[
            "cropProductions" => $primaryCrops
        ];
        
    }

    public static function getFarmYield(Farm $farm)
    {
        # PRODUCTION

        $primaryCrops = Crop::where('type', 'primaire')->select('id', 'label_bm', 'nom_fichier_image', 'order')->get()->sortBy('order');
        $primaryCropIds = $primaryCrops->pluck('id')->toArray();

        $cropProductions = [];

        foreach($farm->harvests as $harvest){
            foreach($harvest->harvestDetails as $harvestDetail){
                if(in_array($harvestDetail['crop_id'], $primaryCropIds)) {
                    $cropProductions[$harvestDetail['crop_id']][]= $harvestDetail['production'];
                }
            }
        }

        foreach($primaryCrops as $key => $primaryCrop){
            if(in_array($primaryCrop->id, array_keys($cropProductions))) {
                $primaryCrop->production = floatval($cropProductions[$primaryCrop->id][0]);
            }
            else {
                unset($primaryCrops[$key]);
            }
        }


        # AREA

        $field_ids = $farm->fields()->pluck('id');
        $plots = Plot::whereIn('field_id', $field_ids)->get();

        $primaryCropIds = $primaryCrops->pluck('id')->toArray();

        $plotAreas = [];

        foreach ($plots as $plot) {
            if(in_array($plot['crop_id'], $primaryCropIds)) {
                $plotAreas[$plot['crop_id']][]= $plot['superficie_measuree'];
            }
        }

        $plotAreas = array_map('array_sum', $plotAreas);

        foreach($primaryCrops as $key => $primaryCrop){
            if(in_array($primaryCrop->id, array_keys($plotAreas))) {
                $primaryCrop->area = $plotAreas[$primaryCrop->id];
                $primaryCrop->yield = round($primaryCrop->production/$primaryCrop->area,1);
            }
            else {
                unset($primaryCrops[$key]);
            }
        }

        return[
            "cropYields" => $primaryCrops
        ];
    }


}
