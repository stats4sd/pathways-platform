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

    public static function getFarmYears(Farm $farm)
    {
        $fieldYears = $farm->fields()->pluck('year')->unique()->toArray();
        $interestPointYears = $farm->interestPoints()->pluck('year')->unique()->toArray();
        $plantingYears = $farm->plantings()->pluck('year')->unique()->toArray();
        $postPlantingYears = $farm->postPlantings()->pluck('year')->unique()->toArray();
        $harvestYears = $farm->harvests()->pluck('year')->unique()->toArray();

        $years = array_unique(array_merge($fieldYears, $interestPointYears, $plantingYears, $postPlantingYears, $harvestYears));

        rsort($years);

        return $years;
    }


    public static function getFarmCoords(Farm $farm, $year)
    {
        $coords = [];
        $noCoords = 0;

        # Get coords for fields and interest pts
        foreach ($farm->fields()->where('year', $year)->get() as $field) {
            foreach ($field->plots as $plot) {
                foreach ($plot->trace_superficie as $point) {
                    $coords[] = ['lat' => $point[1], 'lng' => $point[0]];
                }
            }
        }

        foreach ($farm->interestPoints()->where('year', $year)->get() as $interestPoint) {
            $coords[] = ['lat' => floatval($interestPoint->latitude), 'lng' => floatval($interestPoint->longitude)];
        }

        # Calculate farm center if coordinates are available
        if (!empty($coords)) {
            // Calculate center coordinates
            $latitudes = array_column($coords, 'lat');
            $longitudes = array_column($coords, 'lng');

            $avgLat = array_sum($latitudes) / count($latitudes);
            $avgLng = array_sum($longitudes) / count($longitudes);

            $farmCenter = [$avgLat, $avgLng];
        } else {
            // Set default farm center coordinates
            $farmCenter = [17.5739347, -3.9861092];
            $noCoords = 1;
        }


        # Get plots
        $field_ids = $farm->fields->pluck('id');
        $plots = Plot::whereIn('field_id', $field_ids)->with('field')->get();

        $plotCoords = $plots->map(function ($plot) {
            $latlngs = [];

            foreach ($plot->trace_superficie as $point) {
                $latlngs[] = [$point[1], $point[0]];
            }

            // Remove duplicate points
            $latlngs = collect($latlngs)->unique()->values()->toArray();

            $plot->latlngs = $latlngs;

            $plot->main_crop_image = Crop::where('id', $plot->crop_id)->pluck('nom_fichier_image')->first();
            $plot->main_crop_bm = Crop::where('id', $plot->crop_id)->pluck('label_bm')->first();
            $plot->main_crop_fr = Crop::where('id', $plot->crop_id)->pluck('label_fr')->first();

            // Include associated crop details
            $associated_crops = explode(' ', $plot->cultures_associations);
            $associated_crops_details = [];
            foreach ($associated_crops as $associated_crop) {
                $crop = Crop::find($associated_crop);
                if ($crop) {
                    $associated_crops_details[] = [
                        'crop_image' => $crop->nom_fichier_image,
                        'crop_bm' => $crop->label_bm,
                        'crop_fr' => $crop->label_fr,
                    ];
                }
            }
            $plot->associated_crops = $associated_crops_details;

            // Include plot fertility bm label
            $fertilityLabels = ['pauvre' => 'Sɛngɛlen', 'moyen' => 'Camancɛ', 'fertile' => 'Fangama'];
            $plot->fertilite_bm = $fertilityLabels[$plot->fertilite] ?? $plot->fertilite;

            // Include field soil type bm label
            $soilTypeLabels = ['sable' => 'Cɛncɛn', 'gravillon' => 'Bɛlɛ', 'argile' => 'Bɔgɔ'];
            $plot->field->type_sol_bm = $soilTypeLabels[$plot->field->type_sol] ?? $plot->field->type_sol;

            // Include field slope bm label
            $slopeLabels = ['plat' => 'Dalen', 'incline' => 'Jɛgɛlen', 'escarpe' => 'Jɔlen'];
            $plot->field->pente_bm = $slopeLabels[$plot->field->pente] ?? $plot->field->pente;

            // Round area values
            $plot->superficie_measuree = round(floatval($plot->superficie_measuree), 1);
            $plot->field->superficie_total = round(floatval($plot->field->superficie_total), 1);

            return $plot;
        });


        // Include field color
        $colors = ["#b877e6", "#41b782", '#77dbe6', '#e6ba77', '#8077e6', '#77e6cc',
            '#d9e677', '#e67777', '#7be677', '#e677dd', '#77b8e6', '#e67d77'];
        $field_colors = [];

        foreach ($field_ids as $field_id => $index) {
            $field_colors[$field_ids[$field_id]] = $colors[$field_id];
        }

        foreach ($plotCoords as $plot) {
            $plot->field_color = $field_colors[$plot->field_id];
        }

        # Get interest points
        $interestPointCoords = $farm
            ->interestPoints()
            ->where('year', $year)
            ->select('id', 'nom', 'longitude', 'latitude')
            ->get();

        $interestPointCoords = $interestPointCoords->map(function ($point) {
            $point->latlng = ['lat' => $point->latitude, 'lng' => $point->longitude];

            // include icon
            $point->icon = Storage::disk('public')->URL('images/' . strtolower(str_replace(' ', '_', $point->nom)) . '.png');

            return $point;

        });

        return [
            "plotCoords" => $plotCoords,
            "interestPointCoords" => $interestPointCoords,
            "farmCenter" => $farmCenter,
            "noCoords" => $noCoords,
        ];

    }

    public static function getFarmArea(Farm $farm, $year)
    {
        $field_ids = $farm->fields()->where('year', $year)->pluck('id');
        $plots = Plot::whereIn('field_id', $field_ids)->get();

        # TOTAL AREA (SUPERFICIE) ALL CROPS

        $totalArea = $farm->fields->where('year', $year)->sum('superficie_total');

        # AREA PER PRIMARY CROP

        $primaryCrops = Crop::where('type', 'primaire')->select('id', 'label_bm', 'nom_fichier_image', 'order')->get()->sortBy('order');
        $primaryCropIds = $primaryCrops->pluck('id')->toArray();

        $plotAreas = [];

        foreach ($plots as $plot) {
            if (in_array($plot['crop_id'], $primaryCropIds)) {
                $plotAreas[$plot['crop_id']][] = $plot['superficie_measuree'];
            }
        }

        $plotAreas = array_map('array_sum', $plotAreas);

        foreach ($primaryCrops as $key => $primaryCrop) {
            if (in_array($primaryCrop->id, array_keys($plotAreas))) {
                $primaryCrop->area = $plotAreas[$primaryCrop->id];
            } else {
                unset($primaryCrops[$key]);
            }
        }

        # AREA PER SECONDARY CROP

        $secondaryCrops = Crop::where('type', 'secondaire')->select('id', 'label_bm', 'nom_fichier_image', 'order')->get()->sortBy('order');
        $secondaryCropIds = $secondaryCrops->pluck('id')->toArray();

        $plotAreas = [];

        foreach ($plots as $plot) {
            if (in_array($plot['crop_id'], $secondaryCropIds)) {
                $plotAreas[$plot['crop_id']][] = $plot['superficie_measuree'];
            }
        }

        $plotAreas = array_map('array_sum', $plotAreas);

        foreach ($secondaryCrops as $key => $secondaryCrop) {
            if (in_array($secondaryCrop->id, array_keys($plotAreas))) {
                $secondaryCrop->area = $plotAreas[$secondaryCrop->id];
            } else {
                unset($secondaryCrops[$key]);
            }
        }

        return [
            "totalArea" => $totalArea,
            "primaryArea" => $primaryCrops,
            "secondaryArea" => $secondaryCrops,
        ];

    }

    public static function getFarmCosts(Farm $farm, $year)
    {
        # TOTAL COST
        $plantingTotalCost = $farm->plantings()->where('year', $year)->sum('cout_total');
        $postPlantingTotalCost = $farm->postPlantings()->where('year', $year)->sum('cout_total');
        $harvestTotalCost = $farm->harvests()->where('year', $year)->sum('cout_total');

        $totalCost = $plantingTotalCost + $postPlantingTotalCost + $harvestTotalCost;


        # COST PER CROP

        $primaryCrops = Crop::where('type', 'primaire')->select('id', 'label_bm', 'nom_fichier_image', 'order')->get()->sortBy('order');
        $primaryCropIds = $primaryCrops->pluck('id')->toArray();

        $cropCosts = [];

        foreach ($farm->plantings()->where('year', $year)->get() as $planting) {
            foreach ($planting->plantingDetails as $plantingDetail) {
                if (in_array($plantingDetail['crop_id'], $primaryCropIds)) {
                    $cropCosts[$plantingDetail['crop_id']][] = $plantingDetail['cout'];
                }
            }
        }

        foreach ($farm->postPlantings()->where('year', $year)->get() as $postPlanting) {
            foreach ($postPlanting->postPlantingDetails as $postPlantingDetail) {
                if (in_array($postPlantingDetail['crop_id'], $primaryCropIds)) {
                    $cropCosts[$postPlantingDetail['crop_id']][] = $postPlantingDetail['cout'];
                }
            }
        }

        foreach ($farm->harvests()->where('year', $year)->get() as $harvest) {
            foreach ($harvest->harvestDetails as $harvestDetail) {
                if (in_array($harvestDetail['crop_id'], $primaryCropIds)) {
                    $cropCosts[$harvestDetail['crop_id']][] = $harvestDetail['cout'];
                }
            }
        }

        $cropCosts = array_map('array_sum', $cropCosts);

        foreach ($primaryCrops as $key => $primaryCrop) {
            if (in_array($primaryCrop->id, array_keys($cropCosts))) {
                $primaryCrop->cost = $cropCosts[$primaryCrop->id];
            } else {
                unset($primaryCrops[$key]);
            }
        }


        # CROP INDIVIDUAL COSTS

        $cropIndividualCosts = [];

        foreach ($farm->plantings()->where('year', $year)->get() as $planting) {
            foreach ($planting->plantingDetails as $plantingDetail) {
                if (in_array($plantingDetail['crop_id'], $primaryCropIds)) {
                    $cropIndividualCosts[$plantingDetail['crop_id']]['Tolinɔgɔ donisara'][] = $plantingDetail['cout_transport'];
                    $cropIndividualCosts[$plantingDetail['crop_id']]['Faranɔgɔ sɔngɔ'][] = $plantingDetail['cout_chaux_agricole'];
                    $cropIndividualCosts[$plantingDetail['crop_id']]['Burɛmunɔgɔ sɔngɔ'][] = $plantingDetail['cout_pnt_png'];
                    $cropIndividualCosts[$plantingDetail['crop_id']]['Laburu sara sɔngɔ'][] = $plantingDetail['cout_superficie_labouree'];
                    $cropIndividualCosts[$plantingDetail['crop_id']]['Dannisi sannen sɔngɔ'][] = $plantingDetail['cout_semence_achetee'];
                    $cropIndividualCosts[$plantingDetail['crop_id']]['Binnagasi kɔli donnen sɔngɔ'][] = $plantingDetail['cout_herbicide_prelevee'];
                }
            }
        }

        foreach ($farm->postPlantings()->where('year', $year)->get() as $postPlanting) {
            foreach ($postPlanting->postPlantingDetails as $postPlantingDetail) {
                if (in_array($postPlantingDetail['crop_id'], $primaryCropIds)) {
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

        foreach ($farm->harvests()->where('year', $year)->get() as $harvest) {
            foreach ($harvest->harvestDetails as $harvestDetail) {
                if (in_array($harvestDetail['crop_id'], $primaryCropIds)) {
                    $cropIndividualCosts[$harvestDetail['crop_id']]['Bɔli wali tigɛli sara sɔngɔ'][] = $harvestDetail['cout_total_prestation_recolte'];
                    $cropIndividualCosts[$harvestDetail['crop_id']]['Ɲɔ gosi sara sɔngɔ'][] = $harvestDetail['cout_total_battage'];
                }
            }
        }

        $cropIndividualCostsSummed = [];

        foreach ($cropIndividualCosts as $key => $crop) {
            $cost = array_map('array_sum', $crop);
            $cropIndividualCostsSummed[$key] = $cost;
        }

        foreach ($primaryCrops as $key => $primaryCrop) {
            if (in_array($primaryCrop->id, array_keys($cropIndividualCostsSummed))) {
                $primaryCrop->individual_costs = $cropIndividualCostsSummed[$primaryCrop->id];
            } else {
                unset($primaryCrops[$key]);
            }
        }

        return [
            "totalCost" => $totalCost,
            "cropCosts" => $primaryCrops
        ];

    }

    public static function getFarmProduction(Farm $farm, $year)
    {
        # PRODUCTION PER CROP

        $primaryCrops = Crop::where('type', 'primaire')->select('id', 'label_bm', 'nom_fichier_image', 'order')->get()->sortBy('order');
        $primaryCropIds = $primaryCrops->pluck('id')->toArray();

        $cropProductions = [];

        foreach ($farm->harvests()->where('year', $year)->get() as $harvest) {
            foreach ($harvest->harvestDetails as $harvestDetail) {
                if (in_array($harvestDetail['crop_id'], $primaryCropIds)) {
                    $cropProductions[$harvestDetail['crop_id']][] = $harvestDetail['production'];
                }
            }
        }

        foreach ($primaryCrops as $key => $primaryCrop) {
            if (in_array($primaryCrop->id, array_keys($cropProductions))) {
                $primaryCrop->production = round($cropProductions[$primaryCrop->id][0], 1);
            } else {
                unset($primaryCrops[$key]);
            }
        }

        return [
            "cropProductions" => $primaryCrops
        ];

    }

    public static function getFarmYield(Farm $farm, $year)
    {
        # PRODUCTION

        $primaryCrops = Crop::where('type', 'primaire')->select('id', 'label_bm', 'nom_fichier_image', 'order')->get()->sortBy('order');
        $primaryCropIds = $primaryCrops->pluck('id')->toArray();

        $cropProductions = [];

        foreach ($farm->harvests()->where('year', $year)->get() as $harvest) {
            foreach ($harvest->harvestDetails as $harvestDetail) {
                if (in_array($harvestDetail['crop_id'], $primaryCropIds)) {
                    $cropProductions[$harvestDetail['crop_id']][] = $harvestDetail['production'];
                }
            }
        }

        foreach ($primaryCrops as $key => $primaryCrop) {
            if (in_array($primaryCrop->id, array_keys($cropProductions))) {
                $primaryCrop->production = floatval($cropProductions[$primaryCrop->id][0]);
            } else {
                unset($primaryCrops[$key]);
            }
        }


        # AREA

        $field_ids = $farm->fields()->where('year', $year)->pluck('id');
        $plots = Plot::whereIn('field_id', $field_ids)->get();

        $primaryCropIds = $primaryCrops->pluck('id')->toArray();

        $plotAreas = [];

        foreach ($plots as $plot) {
            if (in_array($plot['crop_id'], $primaryCropIds)) {
                $plotAreas[$plot['crop_id']][] = $plot['superficie_measuree'];
            }
        }

        $plotAreas = array_map('array_sum', $plotAreas);

        foreach ($primaryCrops as $key => $primaryCrop) {
            if (in_array($primaryCrop->id, array_keys($plotAreas))) {
                $primaryCrop->area = $plotAreas[$primaryCrop->id];
                $primaryCrop->yield = round($primaryCrop->production / $primaryCrop->area, 1);
            } else {
                unset($primaryCrops[$key]);
            }
        }

        return [
            "cropYields" => $primaryCrops
        ];
    }

    public static function getFarmObservations(Farm $farm, $year)
    {
        #Planting
        $plantingObs = [];

        $plantings = $farm->plantings()->where('year', $year)->with('plantingDetails')->get();

        if ($plantings->isNotEmpty()) {
            $cropIds = $plantings->flatMap(function ($planting) {
                return $planting->plantingDetails->pluck('crop_id');
            })->unique();

            $crops = Crop::whereIn('id', $cropIds)->get()->keyBy('id');

            foreach ($plantings as $planting) {
                foreach ($planting->plantingDetails as $plantingDetail) {
                    $crop = $crops->get($plantingDetail['crop_id']);
                    if ($crop) {
                        if ($plantingDetail->observation_audio !== null ||
                            $plantingDetail->observation_videos !== null ||
                            $plantingDetail->observation_texte !== null ||
                            $plantingDetail->observation_image !== null) {

                            $plantingObs[] = [
                                'id' => $crop->id,
                                'label_bm' => $crop->label_bm,
                                'nom_fichier_image' => $crop->nom_fichier_image,
                                'order' => $crop->order,
                                'observation_audio' => $plantingDetail->observation_audio ?
                                                        $plantingDetail->getMedia()->where('file_name', $plantingDetail->observation_audio)->first()->getUrl() : null,
                                'observation_image' => $plantingDetail->observation_image ?
                                                        $plantingDetail->getMedia()->where('file_name', $plantingDetail->observation_image)->first()->getUrl() : null,
                                'observation_video' => $plantingDetail->observation_videos ?
                                                        $plantingDetail->getMedia()->where('file_name', $plantingDetail->observation_videos)->first()->getUrl() : null,
                                'observation_texte' => $plantingDetail->observation_texte
                            ];
                        }
                    }
                }
            }
        }

        #Post Planting
        $postPlantingObs = [];

        $postPlantings = $farm->postPlantings()->where('year', $year)->with('postPlantingDetails')->get();

        if ($postPlantings->isNotEmpty()) {
            $cropIds = $postPlantings->flatMap(function ($postPlanting) {
                return $postPlanting->postPlantingDetails->pluck('crop_id');
            })->unique();

            $crops = Crop::whereIn('id', $cropIds)->get()->keyBy('id');

            foreach ($postPlantings as $postPlanting) {
                foreach ($postPlanting->postPlantingDetails as $postPlantingDetail) {
                    $crop = $crops->get($postPlantingDetail['crop_id']);
                    if ($crop) {
                        if ($postPlantingDetail->observation_audio !== null ||
                            $postPlantingDetail->observation_videos !== null ||
                            $postPlantingDetail->observation_texte !== null ||
                            $postPlantingDetail->observation_image !== null) {

                            $postPlantingObs[] = [
                                'id' => $crop->id,
                                'label_bm' => $crop->label_bm,
                                'nom_fichier_image' => $crop->nom_fichier_image,
                                'order' => $crop->order,
                                'observation_audio' => $postPlantingDetail->observation_audio ?
                                                        $postPlantingDetail->getMedia()->where('file_name', $postPlantingDetail->observation_audio)->first()->getUrl() : null,
                                'observation_image' => $postPlantingDetail->observation_image ?
                                                        $postPlantingDetail->getMedia()->where('file_name', $postPlantingDetail->observation_image)->first()->getUrl() : null,
                                'observation_video' => $postPlantingDetail->observation_videos ?
                                                        $postPlantingDetail->getMedia()->where('file_name', $postPlantingDetail->observation_videos)->first()->getUrl() : null,
                                'observation_texte' => $postPlantingDetail->observation_texte,
                            ];
                        }
                    }
                }
            }
        }

        # Harvest
        $harvestObs = [];

        $harvests = $farm->harvests()->where('year', $year)->with('harvestDetails')->get();

        if ($harvests->isNotEmpty()) {
            $cropIds = $harvests->flatMap(function ($harvest) {
                return $harvest->harvestDetails->pluck('crop_id');
            })->unique();

            $crops = Crop::whereIn('id', $cropIds)->get()->keyBy('id');

            foreach ($harvests as $harvest) {
                foreach ($harvest->harvestDetails as $harvestDetail) {
                    $crop = $crops->get($harvestDetail['crop_id']);
                    if ($crop) {
                        if ($harvestDetail->observation_audio !== null ||
                            $harvestDetail->observation_videos !== null ||
                            $harvestDetail->observation_texte !== null ||
                            $harvestDetail->observation_image !== null) {

                            $harvestObs[] = [
                                'id' => $crop->id,
                                'label_bm' => $crop->label_bm,
                                'nom_fichier_image' => $crop->nom_fichier_image,
                                'order' => $crop->order,
                                'observation_audio' => $harvestDetail->observation_audio ?
                                                        $harvestDetail->getMedia()->where('file_name', $harvestDetail->observation_audio)->first()->getUrl() : null,
                                'observation_image' => $harvestDetail->observation_image ?
                                                        $harvestDetail->getMedia()->where('file_name', $harvestDetail->observation_image)->first()->getUrl() : null,
                                'observation_video' => $harvestDetail->observation_videos ?
                                                        $harvestDetail->getMedia()->where('file_name', $harvestDetail->observation_videos)->first()->getUrl() : null,
                                'observation_texte' => $harvestDetail->observation_texte,
                            ];
                        }
                    }
                }
            }
        }

        return [
            "plantingObservations" => $plantingObs,
            "postPlantingObservations" => $postPlantingObs,
            "harvestObservations" => $harvestObs,
        ];
    }
}
