<?php

namespace App\Services;

use App\Models\Crop;
use App\Models\Farm;
use App\Models\Plot;
use App\Models\Field;
use App\Models\Harvest;
use App\Models\Planting;
use App\Models\AnimalFeed;
use App\Models\FarmDetail;
use App\Models\Submission;
use App\Models\FarmExpense;
use Illuminate\Support\Str;
use App\Models\PostPlanting;
use Illuminate\Http\Request;
use App\Models\HarvestDetail;
use App\Models\InterestPoint;
use App\Models\PlantingDetail;
use App\Models\HumanCerealNeed;
use App\Models\OrganicFertiliser;
use App\Http\Requests\CropRequest;
use App\Http\Requests\FarmRequest;
use App\Http\Requests\PlotRequest;
use App\Models\AnimalFeedCategory;
use App\Models\PostPlantingDetail;
use Stats4sd\OdkLink\Models\Media;
use App\Http\Requests\FieldRequest;
use Stats4sd\OdkLink\Models\Xlsform;
use App\Http\Requests\HarvestRequest;
use App\Http\Requests\PlantingRequest;
use App\Http\Requests\AnimalFeedRequest;
use App\Http\Requests\FarmDetailRequest;
use App\Http\Requests\FarmExpenseRequest;
use App\Http\Requests\PostPlantingRequest;
use App\Http\Requests\HarvestDetailRequest;
use App\Http\Requests\InterestPointRequest;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\PlantingDetailRequest;
use App\Http\Requests\HumanCerealNeedRequest;
use Stats4sd\OdkLink\Services\OdkLinkService;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\OrganicFertiliserRequest;
use App\Http\Requests\AnimalFeedCategoryRequest;
use App\Http\Requests\PostPlantingDetailRequest;

class DatamapService
{

    public function sectionEnregistrement(Submission $submission) : bool
    {
        try {

            $data = $this->prepareDataArray($submission);
            $data = $this->removeGroupNames($data);

            $data['code'] = $data['camera_scane'];
            $data['phone_number'] = $data['num_phone'];

            $entries = [];

            if($data['consentement_question']=='non') {

                $submission->consent = 0;
                $submission->processed = 1;
                $submission->save();

            }

            elseif($data['consentement_question']=='oui') {

                $data['code'] = $data['camera_scane'];

                if(isset($data['activite_secondaire_autre_1'])) {

                    $data['activite_secondaire'] = str_replace('autre1', $data['activite_secondaire_autre_1'], $data['activite_secondaire']);

                }

                if(isset($data['activite_secondaire_autre_2'])) {

                    $data['activite_secondaire'] = str_replace('autre2', $data['activite_secondaire_autre_2'], $data['activite_secondaire']);

                }

                $validatedFarm = $this->getValidated($data, $submission, (new FarmRequest));
                $farm = Farm::updateOrCreate(['code' => $data['code']], $validatedFarm);
                $data['farm_id'] = $farm->id;

                $validatedFarmDetail = $this->getValidated($data, $submission, (new FarmDetailRequest));
                $farmDetail = FarmDetail::create($validatedFarmDetail);
                $entries[FarmDetail::class] = [$farmDetail->id];

                $mediaEntries = Media::where('model_type', 'Stats4sd\OdkLink\Models\Submission')
                    ->where('model_id', $submission->id)
                    ->get();
                foreach($mediaEntries as $mediaEntry) {
                    $mediaEntry->copy($farmDetail, 'default', 'local');
                }

                /* At the end, you should update the $submission entry: */
                $submission->consent = 1;
                $submission->processed = 1;
                $submission->entries = $entries;
                $submission->save();

                // Update the csvs with new data by deploying draft and publishing live

                $forms = Xlsform::get();

                foreach($forms as $form) {

                    $service = new OdkLinkService(config('odk-link.odk.base_endpoint'));
                    $service->createDraftForm($form);

                    if($form->is_active) {
                        $service->publishForm($form);
                    }
                }

            }

            return true;

        } catch (\JsonException|ValidationException $e) {
            return false;
        }
    }

    public function sectionSemis(Submission $submission) : bool
    {
        try {

            $data = $this->prepareDataArray($submission);
            $data = $this->removeGroupNames($data);

            $entries = [];

            if(!isset($data['farm_id'])) {

                $data['farm_id'] = Farm::where('code', $data['camera_scane'])->pluck('id')->first();

                if(!isset($data['farm_id'])) {

                    $newFarm = [];
                    $newFarm['code'] = $data['camera_scane'];

                    $validatedFarm = $this->getValidated($newFarm, $submission, (new FarmRequest));
                    $farm = Farm::create($validatedFarm);
                    $data['farm_id'] = $farm->id;

                }

            }

            $validatedPlanting = $this->getValidated($data, $submission, (new PlantingRequest));
            $planting = Planting::create($validatedPlanting);
            $entries[Planting::class] = [$planting->id];

            if (isset($data['culture_repeat'])) {

                $crops = [];

                foreach ($data['culture_repeat'] as $cropData) {

                    if($cropData['culture_value']=='999' | $cropData['culture_value']=='998') {

                        $newCrop = [];
                        $newCrop['id'] = Str::snake(preg_replace('/[\d\.-]/', '', $cropData['culture_label']));
                        $newCrop['label_fr'] = $cropData['culture_label'];
                        $newCrop['label_bm'] =$cropData['culture_label'];
                        $newCrop['order'] = '999';
                        $newCrop['type'] = 'autre';
                        $newCrop['farm_id'] = $data['farm_id'];

                        $validatedOperation = $this->getValidated($newCrop, $submission, (new CropRequest));

                        Crop::create($validatedOperation);
                        $crops[] = $newCrop['id'];

                        $cropData = $this->removeGroupNames($cropData);
                        $cropData['planting_id'] = $planting->id;
                        $cropData['crop_id'] = $newCrop['id'];

                        $validatedOperation = $this->getValidated($cropData, $submission, (new PlantingDetailRequest));

                        $plantingDetail = PlantingDetail::create($validatedOperation);
                        $plantingDetails[] = $plantingDetail->id;

                        $mediaEntries = Media::where('model_type', 'Stats4sd\OdkLink\Models\Submission')
                                        ->where('model_id', $submission->id)
                                        ->get();
                        foreach($mediaEntries as $mediaEntry) {
                            $mediaEntry->copy($plantingDetail, 'default', 'local');
                        }
                    }
                    else {

                        $cropData = $this->removeGroupNames($cropData);
                        $cropData['planting_id'] = $planting->id;
                        $cropData['crop_id'] = $cropData['culture_value'];

                        $validatedOperation = $this->getValidated($cropData, $submission, (new PlantingDetailRequest));

                        $plantingDetail = PlantingDetail::create($validatedOperation);
                        $plantingDetails[] = $plantingDetail->id;

                        $mediaEntries = Media::where('model_type', 'Stats4sd\OdkLink\Models\Submission')
                                        ->where('model_id', $submission->id)
                                        ->get();
                        foreach($mediaEntries as $mediaEntry) {
                            $mediaEntry->copy($plantingDetail, 'default', 'local');
                        }

                    }
                }

                $entries[PlantingDetail::class] = $plantingDetails;

                if (!empty($crops)) {
                    $entries[Crop::class] = $crops;
                }

            }

            /* At the end, you should update the $submission entry: */
            $submission->processed = 1;
            $submission->entries = $entries;
            $submission->save();

            return true;

        } catch (\JsonException|ValidationException $e) {
            return false;
        }
    }

    public function sectionPostSemis(Submission $submission) : bool
    {
        try {

            $data = $this->prepareDataArray($submission);
            $data = $this->removeGroupNames($data);

            $entries = [];

            if(!isset($data['farm_id'])) {

                $data['farm_id'] = Farm::where('code', $data['camera_scane'])->pluck('id')->first();

                if(!isset($data['farm_id'])) {

                    $newFarm = [];
                    $newFarm['code'] = $data['camera_scane'];

                    $validatedFarm = $this->getValidated($newFarm, $submission, (new FarmRequest));
                    $farm = Farm::create($validatedFarm);
                    $data['farm_id'] = $farm->id;

                }

            }

            $validatedPostPlanting = $this->getValidated($data, $submission, (new PostPlantingRequest));
            $postPlanting = PostPlanting::create($validatedPostPlanting);
            $entries[PostPlanting::class] = [$postPlanting->id];

            if (isset($data['culture_repeat'])) {

                foreach ($data['culture_repeat'] as $cropData) {

                    $cropData = $this->removeGroupNames($cropData);
                    $cropData['post_planting_id'] = $postPlanting->id;
                    $cropData['crop_id'] = $cropData['culture_value'];

                    $validatedOperation = $this->getValidated($cropData, $submission, (new PostPlantingDetailRequest));

                    $postPlantingDetail = PostPlantingDetail::create($validatedOperation);
                    $postPlantingDetails[] = $postPlantingDetail->id;

                    $mediaEntries = Media::where('model_type', 'Stats4sd\OdkLink\Models\Submission')
                                    ->where('model_id', $submission->id)
                                    ->get();
                    foreach($mediaEntries as $mediaEntry) {
                        $mediaEntry->copy($postPlantingDetail, 'default', 'local');
                    }
                }

                $entries[PostPlantingDetail::class] = $postPlantingDetails;
            }


            /* At the end, you should update the $submission entry: */
            $submission->processed = 1;
            $submission->entries = $entries;
            $submission->save();

            return true;

        } catch (\JsonException|ValidationException $e) {
            return false;
        }
    }

    public function sectionRecolte(Submission $submission) : bool
    {
        try {

            $data = $this->prepareDataArray($submission);
            $data = $this->removeGroupNames($data);

            $entries = [];

            if(!isset($data['farm_id'])) {

                $data['farm_id'] = Farm::where('code', $data['camera_scane'])->pluck('id')->first();

                if(!isset($data['farm_id'])) {

                    $newFarm = [];
                    $newFarm['code'] = $data['camera_scane'];

                    $validatedFarm = $this->getValidated($newFarm, $submission, (new FarmRequest));
                    $farm = Farm::create($validatedFarm);
                    $data['farm_id'] = $farm->id;

                }

            }

            $validatedHarvest = $this->getValidated($data, $submission, (new HarvestRequest));
            $harvest = Harvest::create($validatedHarvest);
            $entries[Harvest::class] = [$harvest->id];

            if (isset($data['culture_repeat'])) {

                $crops = [];

                foreach ($data['culture_repeat'] as $cropData) {

                    if($cropData['culture_value']=='999' | $cropData['culture_value']=='998') {

                        $newCrop = [];
                        $newCrop['id'] = Str::snake(preg_replace('/[\d\.-]/', '', $cropData['culture_label']));
                        $newCrop['label_fr'] = $cropData['culture_label'];
                        $newCrop['label_bm'] =$cropData['culture_label'];
                        $newCrop['order'] = '999';
                        $newCrop['type'] = 'autre';
                        $newCrop['farm_id'] = $data['farm_id'];

                        $validatedOperation = $this->getValidated($newCrop, $submission, (new CropRequest));

                        Crop::create($validatedOperation);
                        $crops[] = $newCrop['id'];

                        $cropData = $this->removeGroupNames($cropData);
                        $cropData['harvest_id'] = $harvest->id;
                        $cropData['crop_id'] = $newCrop['id'];

                        $validatedOperation = $this->getValidated($cropData, $submission, (new HarvestDetailRequest));

                        $harvestDetail = HarvestDetail::create($validatedOperation);
                        $harvestDetails[] = $harvestDetail->id;

                        $mediaEntries = Media::where('model_type', 'Stats4sd\OdkLink\Models\Submission')
                                        ->where('model_id', $submission->id)
                                        ->get();
                        foreach($mediaEntries as $mediaEntry) {
                            $mediaEntry->copy($harvestDetail, 'default', 'local');
                        }


                    }
                    else {

                        $cropData = $this->removeGroupNames($cropData);
                        $cropData['harvest_id'] = $harvest->id;
                        $cropData['crop_id'] = $cropData['culture_value'];

                        $validatedOperation = $this->getValidated($cropData, $submission, (new HarvestDetailRequest));

                        $harvestDetail = HarvestDetail::create($validatedOperation);
                        $harvestDetails[] = $harvestDetail->id;

                        $mediaEntries = Media::where('model_type', 'Stats4sd\OdkLink\Models\Submission')
                                        ->where('model_id', $submission->id)
                                        ->get();
                        foreach($mediaEntries as $mediaEntry) {
                            $mediaEntry->copy($harvestDetail, 'default', 'local');
                        }
                    }
                }

                $entries[HarvestDetail::class] = $harvestDetails;

                if (!empty($crops)) {
                    $entries[Crop::class] = $crops;
                }
            }


            /* At the end, you should update the $submission entry: */
            $submission->processed = 1;
            $submission->entries = $entries;
            $submission->save();

            return true;

        } catch (\JsonException|ValidationException $e) {
            return false;
        }
    }

    public function superficieChamps(Submission $submission) : bool
    {
        try {

            $data = $this->prepareDataArray($submission);
            $data = $this->removeGroupNames($data);

            $entries = [];

            if(!isset($data['farm_id'])) {

                $data['farm_id'] = Farm::where('code', $data['camera_scane'])->pluck('id')->first();

                if(!isset($data['farm_id'])) {

                    $newFarm = [];
                    $newFarm['code'] = $data['camera_scane'];

                    $validatedFarm = $this->getValidated($newFarm, $submission, (new FarmRequest));
                    $farm = Farm::create($validatedFarm);
                    $data['farm_id'] = $farm->id;

                }

            }

            $data['nom'] = $data['champ'];
            $data['superficie_total'] = $data['superf_total'];

            $validatedField = $this->getValidated($data, $submission, (new FieldRequest));
            $field = Field::create($validatedField);
            $entries[Field::class] = [$field->id];

            if (isset($data['parcelles'])) {

                foreach ($data['parcelles'] as $plotData) {

                    if($plotData['culture']=='999') {

                        $newCrop = [];
                        $newCrop['id'] = Str::snake(preg_replace('/[\d\.-]/', '', $plotData['culture_label']));
                        $newCrop['label_fr'] = $plotData['culture_label'];
                        $newCrop['label_bm'] =$plotData['culture_label'];
                        $newCrop['order'] = '999';
                        $newCrop['type'] = 'autre';
                        $newCrop['farm_id'] = $data['farm_id'];

                        $validatedOperation = $this->getValidated($newCrop, $submission, (new CropRequest));

                        Crop::create($validatedOperation);
                        $crops[] = $newCrop['id'];

                        $plotData['crop_id'] = $newCrop['id'];

                    }
                    else {
                        $plotData['crop_id'] = $plotData['culture'];
                    }

                    if($plotData['culture_prev']=='999') {

                        $newCrop = [];
                        $newCrop['id'] = Str::snake(preg_replace('/[\d\.-]/', '', $plotData['autre_culture_prev']));
                        $newCrop['label_fr'] = $plotData['autre_culture_prev'];
                        $newCrop['label_bm'] =$plotData['autre_culture_prev'];
                        $newCrop['order'] = '999';
                        $newCrop['type'] = 'autre';
                        $newCrop['farm_id'] = $data['farm_id'];

                        $validatedOperation = $this->getValidated($newCrop, $submission, (new CropRequest));

                        Crop::create($validatedOperation);
                        $crops[] = $newCrop['id'];

                        $plotData['prev_crop_id'] = $newCrop['id'];

                    }
                    else {
                        $plotData['prev_crop_id'] = $plotData['culture_prev'];
                    }

                    $plotData['field_id'] = $field->id;
                    $plotData['superficie_estimee'] = $plotData['superficie'];
                    $plotData['superficie_measuree'] = $plotData['surface_h'];
                    $plotData['trace_superficie'] = $plotData['trace_superficie']['coordinates'][0];

                    if(isset($plotData['autre_cult_associe_1'])) {

                        $plotData['cultures_associations'] = str_replace('997', $plotData['autre_cult_associe_1'], $plotData['cultures_associations']);

                    }

                    if(isset($plotData['autre_cult_associe_2'])) {

                        $plotData['cultures_associations'] = str_replace('998', $plotData['autre_cult_associe_2'], $plotData['cultures_associations']);

                    }

                    $validatedOperation = $this->getValidated($plotData, $submission, (new PlotRequest));

                    $plot = Plot::create($validatedOperation);
                    $plots[] = $plot->id;

                    $mediaEntries = Media::where('model_type', 'Stats4sd\OdkLink\Models\Submission')
                                        ->where('model_id', $submission->id)
                                        ->get();
                    foreach($mediaEntries as $mediaEntry) {
                        $mediaEntry->copy($plot, 'default', 'local');
                    }
                }

            }

            $entries[Plot::class] = $plots;
            if (!empty($crops)) {
                $entries[Crop::class] = $crops;
            }

        /* At the end, you should update the $submission entry: */
        $submission->processed = 1;
        $submission->entries = $entries;
        $submission->save();

        return true;

        } catch (\JsonException|ValidationException $e) {
            return false;
        }
    }

    public function pointDinteret(Submission $submission) : bool
    {
        try {

            $data = $this->prepareDataArray($submission);
            $data = $this->removeGroupNames($data);

            $entries = [];

            if(!isset($data['farm_id'])) {

                $data['farm_id'] = Farm::where('code', $data['camera_scane'])->pluck('id')->first();

                if(!isset($data['farm_id'])) {

                    $newFarm = [];
                    $newFarm['code'] = $data['camera_scane'];

                    $validatedFarm = $this->getValidated($newFarm, $submission, (new FarmRequest));
                    $farm = Farm::create($validatedFarm);

                    $data['farm_id'] = $farm->id;

                }

                if (isset($data['gps'])) {
                    $data = array_merge($data, $this->splitGps($data, 'gps'));
                }

            }

            $validatedInterestPoint = $this->getValidated($data, $submission, (new InterestPointRequest));
            $interestPoint = InterestPoint::create($validatedInterestPoint);
            $entries[InterestPoint::class] = [$interestPoint->id];

            $mediaEntries = Media::where('model_type', 'Stats4sd\OdkLink\Models\Submission')
                ->where('model_id', $submission->id)
                ->get();
            foreach($mediaEntries as $mediaEntry) {
                $mediaEntry->copy($interestPoint, 'default', 'local');
            }

        /* At the end, you should update the $submission entry: */
        $submission->processed = 1;
        $submission->entries = $entries;
        $submission->save();

        return true;

        } catch (\JsonException|ValidationException $e) {
            return false;
        }
    }

    public function sectionDepenses(Submission $submission) : bool
    {
        try {

            $data = $this->prepareDataArray($submission);
            $data = $this->removeGroupNames($data);

            $entries = [];

            if(!isset($data['farm_id'])) {

                $data['farm_id'] = Farm::where('code', $data['camera_scane'])->pluck('id')->first();

                if(!isset($data['farm_id'])) {

                    $newFarm = [];
                    $newFarm['code'] = $data['camera_scane'];

                    $validatedFarm = $this->getValidated($newFarm, $submission, (new FarmRequest));
                    $farm = Farm::create($validatedFarm);

                    $data['farm_id'] = $farm->id;

                }

            }

            $validatedFarmExpense = $this->getValidated($data, $submission, (new FarmExpenseRequest));
            $farmExpense = FarmExpense::create($validatedFarmExpense);
            $entries[FarmExpense::class] = [$farmExpense->id];

            $mediaEntries = Media::where('model_type', 'Stats4sd\OdkLink\Models\Submission')
                ->where('model_id', $submission->id)
                ->get();
            foreach($mediaEntries as $mediaEntry) {
                $mediaEntry->copy($farmExpense, 'default', 'local');
            }

        /* At the end, you should update the $submission entry: */
        $submission->processed = 1;
        $submission->entries = $entries;
        $submission->save();

        return true;

        } catch (\JsonException|ValidationException $e) {
            return false;
        }
    }

    public function sectionFumureOrganique(Submission $submission) : bool
    {
        try {

            $data = $this->prepareDataArray($submission);
            $data = $this->removeGroupNames($data);

            $entries = [];

            if(!isset($data['farm_id'])) {

                $data['farm_id'] = Farm::where('code', $data['camera_scane'])->pluck('id')->first();

                if(!isset($data['farm_id'])) {

                    $newFarm = [];
                    $newFarm['code'] = $data['camera_scane'];

                    $validatedFarm = $this->getValidated($newFarm, $submission, (new FarmRequest));
                    $farm = Farm::create($validatedFarm);

                    $data['farm_id'] = $farm->id;

                }

            }

            $validatedOrganicFertiliser = $this->getValidated($data, $submission, (new OrganicFertiliserRequest));
            $organicFertiliser = OrganicFertiliser::create($validatedOrganicFertiliser);
            $entries[OrganicFertiliser::class] = [$organicFertiliser->id];

            $mediaEntries = Media::where('model_type', 'Stats4sd\OdkLink\Models\Submission')
                ->where('model_id', $submission->id)
                ->get();
            foreach($mediaEntries as $mediaEntry) {
                $mediaEntry->copy($organicFertiliser, 'default', 'local');
            }

        /* At the end, you should update the $submission entry: */
        $submission->processed = 1;
        $submission->entries = $entries;
        $submission->save();

        return true;

        } catch (\JsonException|ValidationException $e) {
            return false;
        }
    }
    
    public function sectionBesoinsCerealesHumain(Submission $submission) : bool
    {
        try {

            $data = $this->prepareDataArray($submission);
            $data = $this->removeGroupNames($data);

            $entries = [];

            if(!isset($data['farm_id'])) {

                $data['farm_id'] = Farm::where('code', $data['camera_scane'])->pluck('id')->first();

                if(!isset($data['farm_id'])) {

                    $newFarm = [];
                    $newFarm['code'] = $data['camera_scane'];

                    $validatedFarm = $this->getValidated($newFarm, $submission, (new FarmRequest));
                    $farm = Farm::create($validatedFarm);

                    $data['farm_id'] = $farm->id;

                }

            }

            $data['type_menage'] = $data['type_menage_id'];

            $validatedHumanCerealNeed = $this->getValidated($data, $submission, (new HumanCerealNeedRequest));
            $humanCerealNeed = HumanCerealNeed::create($validatedHumanCerealNeed);
            $entries[HumanCerealNeed::class] = [$humanCerealNeed->id];

            $mediaEntries = Media::where('model_type', 'Stats4sd\OdkLink\Models\Submission')
                ->where('model_id', $submission->id)
                ->get();
            foreach($mediaEntries as $mediaEntry) {
                $mediaEntry->copy($humanCerealNeed, 'default', 'local');
            }

        /* At the end, you should update the $submission entry: */
        $submission->processed = 1;
        $submission->entries = $entries;
        $submission->save();

        return true;

        } catch (\JsonException|ValidationException $e) {
            return false;
        }
    }

    public function sectionAlimentationAnimaux(Submission $submission) : bool
    {
        try {

            $data = $this->prepareDataArray($submission);
            $data = $this->removeGroupNames($data);

            $entries = [];

            if(!isset($data['farm_id'])) {

                $data['farm_id'] = Farm::where('code', $data['camera_scane'])->pluck('id')->first();

                if(!isset($data['farm_id'])) {

                    $newFarm = [];
                    $newFarm['code'] = $data['camera_scane'];

                    $validatedFarm = $this->getValidated($newFarm, $submission, (new FarmRequest));
                    $farm = Farm::create($validatedFarm);

                    $data['farm_id'] = $farm->id;
                }
            }

            $validatedAnimalFeed = $this->getValidated($data, $submission, (new AnimalFeedRequest));
            $animalFeed = AnimalFeed::create($validatedAnimalFeed);
            $entries[AnimalFeed::class] = [$animalFeed->id];

            if (isset($data['categories'])) {

                $categories = [];

                foreach ($data['categories'] as $categorieData) {

                    $categorieData = $this->removeGroupNames($categorieData);
                    $categorieData['animal_feed_id'] = $animalFeed->id;
                    $categorieData['categorie'] = $categorieData['cat_value'];

                    $validatedOperation = $this->getValidated($categorieData, $submission, (new AnimalFeedCategoryRequest));

                    $animalFeedCategory = AnimalFeedCategory::create($validatedOperation);
                    $animalFeedCategories[] = $animalFeedCategory->id;
 
                }

                $entries[AnimalFeedCategory::class] = $animalFeedCategory;

            }

            $mediaEntries = Media::where('model_type', 'Stats4sd\OdkLink\Models\Submission')
                ->where('model_id', $submission->id)
                ->get();
            foreach($mediaEntries as $mediaEntry) {
                $mediaEntry->copy($animalFeed, 'default', 'local');
            }

        /* At the end, you should update the $submission entry: */
        $submission->processed = 1;
        $submission->entries = $entries;
        $submission->save();

        return true;

        } catch (\JsonException|ValidationException $e) {
            return false;
        }
    }

    /*****************************************************************************/
    /******************************** HELPER METHODS *****************************/


    /**
     * @param Submission $submission
     * @return array
     * @throws \JsonException
     */
    protected function prepareDataArray(Submission $submission): array
    {

        try {
            $data = is_array($submission->content) ? $submission->content : json_decode($submission->content, true, 512, JSON_THROW_ON_ERROR);
            return $this->removeGroupNames($data);
        } catch (\JsonException $e) {
            $submission->errors = [
                'content' => ['malformed json array as content: ' . $e->getMessage(),]
            ];
            $submission->save();
            throw $e;
        }
    }

    /**
     * @param array $data (the data before gps split)
     * @param string $varName (the variable containing the GPS data as a space-separated string)
     * @return array (the data)
     */
    public function splitGps(array $data, string $varName): array
    {
        // some gps variables may be optional;
        if (isset($data[$varName])) {
            $gps = is_array($data[$varName]['coordinates']) ? $data[$varName]['coordinates'] : explode(' ', $data[$varName]['coordinates']);
            $gpsData=[];
            $gpsData['latitude'] = $gps[0] ?? null;
            $gpsData['longitude'] = $gps[1] ?? null;
            $gpsData['altitude'] = $gps[2] ?? null;
            $gpsData['accuracy'] = $data[$varName]['properties']['accuracy'] ?? null;

        }

        return $gpsData;
    }

    /**
     * @param array $data
     * @param Submission $submission
     * @param FormRequest $formRequest
     * @return array
     * @throws ValidationException
     */

    protected function getValidated(array $data, Submission $submission, FormRequest $formRequest): array
    {
        $rules = $formRequest->rules();
        $request = (new Request($data));
        try {
            $validated = $request->validate($rules);
        } catch (ValidationException $e) {
            $submission->errors = $e->errors();
            $submission->save();
            throw $e;
        }

        return $validated;
    }

    public function removeGroupNames(array $record): array
    {
        // go through record variables and remove any group names
        foreach ($record as $key => $value) {

            // Keep this as it forms part of the media download url
            if ($key === 'formhub/uuid') {
                continue;
            }

            if (Str::contains($key, '/')) {
                // e.g. replace $record['groupname/subgroup/name'] with $record['name']
                unset($record[$key]);
                $key = explode('/', $key);
                $key = end($key);
                $record[$key] = $value;
            }
        }

        return $record;
    }
}
