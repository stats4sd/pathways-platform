<?php

namespace App\Services;

use App\Models\Crop;
use App\Models\Farm;
use App\Models\Harvest;
use App\Models\Planting;
use Illuminate\Support\Str;
use App\Models\PostPlanting;
use Illuminate\Http\Request;
use App\Models\HarvestDetail;
use App\Models\PlantingDetail;
use App\Http\Requests\CropRequest;
use App\Http\Requests\FarmRequest;
use App\Models\PostPlantingDetail;
use Stats4sd\OdkLink\Models\Xlsform;
use App\Http\Requests\HarvestRequest;
use App\Http\Requests\PlantingRequest;
use Stats4sd\OdkLink\Models\Submission;
use App\Http\Requests\PostPlantingRequest;
use App\Http\Requests\HarvestDetailRequest;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\PlantingDetailRequest;
use Stats4sd\OdkLink\Services\OdkLinkService;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\PostPlantingDetailRequest;

class DatamapService
{

    public function sectionEnregistrement(Submission $submission) : bool
    {
        try {

            $data = $this->prepareDataArray($submission);
            $data = $this->removeGroupNames($data);

            $data['code'] = $data['camera_scane'];
            
            $entries = [];

            if(isset($data['activite_secondaire_autre_1'])) {

                $data['activite_secondaire'] = str_replace('autre1', $data['activite_secondaire_autre_1'], $data['activite_secondaire']);
                
            }

            if(isset($data['activite_secondaire_autre_2'])) {

                $data['activite_secondaire'] = str_replace('autre2', $data['activite_secondaire_autre_2'], $data['activite_secondaire']);
                
            }

            $validatedFarm = $this->getValidated($data, $submission, (new FarmRequest));
            $farm = Farm::create($validatedFarm);
            $entries[Farm::class] = [$farm->id];


            /* At the end, you should update the $submission entry: */
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
            }
                                
            $validatedPlanting = $this->getValidated($data, $submission, (new PlantingRequest));
            $planting = Planting::create($validatedPlanting);
            $entries[Planting::class] = [$planting->id];

            if (isset($data['culture_repeat'])) {

                foreach ($data['culture_repeat'] as $cropData) {

                    if($cropData['culture_value']=='999' | $cropData['culture_value']=='998') {

                        $newCrop = [];
                        $newCrop['id'] = Str::snake(preg_replace('/[\d\.-]/', '', $cropData['culture_label']));
                        $newCrop['label_fr'] = $cropData['culture_label'];
                        $newCrop['label_bm'] =$cropData['culture_label'];
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

                    }
                    else {

                        $cropData = $this->removeGroupNames($cropData);
                        $cropData['planting_id'] = $planting->id;
                        $cropData['crop_id'] = $cropData['culture_value'];

                        $validatedOperation = $this->getValidated($cropData, $submission, (new PlantingDetailRequest));

                        $plantingDetail = PlantingDetail::create($validatedOperation);
                        $plantingDetails[] = $plantingDetail->id;

                    }
                }

                $entries[PlantingDetail::class] = $plantingDetails;
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


    public function sectionPostSemis(Submission $submission) : bool
    {
        try {

            $data = $this->prepareDataArray($submission);
            $data = $this->removeGroupNames($data);

            $entries = [];

            if(!isset($data['farm_id'])) {
                $data['farm_id'] = Farm::where('code', $data['camera_scane'])->pluck('id')->first();
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
            }
                                
            $validatedHarvest = $this->getValidated($data, $submission, (new HarvestRequest));
            $harvest = Harvest::create($validatedHarvest);
            $entries[Harvest::class] = [$harvest->id];

            if (isset($data['culture_repeat'])) {

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

                    }
                    else {

                        $cropData = $this->removeGroupNames($cropData);
                        $cropData['harvest_id'] = $harvest->id;
                        $cropData['crop_id'] = $cropData['culture_value'];

                        $validatedOperation = $this->getValidated($cropData, $submission, (new HarvestDetailRequest));
    
                        $harvestDetail = HarvestDetail::create($validatedOperation);
                        $harvestDetails[] = $harvestDetail->id;
                    }
                }

                $entries[HarvestDetail::class] = $harvestDetails;
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
