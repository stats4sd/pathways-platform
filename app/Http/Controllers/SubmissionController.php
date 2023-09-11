<?php

namespace App\Http\Controllers;

use App\Services\DatamapService;
use Illuminate\Support\Str;
use App\Models\Submission;

class SubmissionController
{

    public static function process(Submission $submission)
    {


        // pick the DatamapService method based on the form title:
        $title = $submission->xlsformVersion->xlsform->xlsformTemplate->title;

        $method = Str::camel(preg_replace('/[\d\.-]/', '', $title));

        $datamapService = new DatamapService();

        // run the method from the service with the submission:

        $datamapService->$method($submission);
    }
}
