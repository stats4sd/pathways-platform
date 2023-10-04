<?php

namespace App\Http\Controllers;

use App\Services\DatamapService;
use Illuminate\Support\Str;
use App\Models\Submission;
use Stats4sd\OdkLink\Models\Submission as OdkLinkSubmission;

class SubmissionController
{

    public static function process(Submission|OdkLinkSubmission $submission)
    {

        // make sure we're using the base package class:
        $submission = Submission::find($submission->id);

        // pick the DatamapService method based on the form title:
        $title = $submission->xlsformVersion->xlsform->xlsformTemplate->title;

        $method = Str::camel(preg_replace('/[\d\.-]/', '', $title));

        $datamapService = new DatamapService();

        // run the method from the service with the submission:

        $datamapService->$method($submission);
    }
}
