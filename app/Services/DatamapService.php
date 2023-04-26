<?php

namespace App\Services;

use App\Models\Farm;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\FarmRequest;
use Stats4sd\OdkLink\Models\Submission;
use Illuminate\Foundation\Http\FormRequest;
use Stats4sd\OdkLink\Services\OdkLinkService;
use Illuminate\Validation\ValidationException;

class DatamapService
{

    public function sectionEnregistrement(Submission $submission) : bool
    {
        try {

            $data = $this->prepareDataArray($submission);
            $data = $this->removeGroupNames($data);

            $entries = [];
                                
            $validatedFarm = $this->getValidated($data, $submission, (new FarmRequest));
            $farm = Farm::create($validatedFarm);
            $entries[Farm::class] = [$farm->id];


            /* At the end, you should update the $submission entry: */
            $submission->processed = 1;
            $submission->entries = $entries;
            $submission->save();

            // Update the csvs with new data by deploying draft and publishing live
            $form = $submission->xlsformVersion->xlsform;

            $service = new OdkLinkService(config('odk-link.odk.base_endpoint'));
            $service->createDraftForm($form);
            $service->publishForm($form);

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
