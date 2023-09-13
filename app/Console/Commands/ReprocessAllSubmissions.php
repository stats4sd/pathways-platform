<?php

namespace App\Console\Commands;

use App\Http\Controllers\SubmissionController;
use Illuminate\Console\Command;
use Stats4sd\OdkLink\Models\Xlsform;

class ReprocessAllSubmissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reprocess-all-submissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $xlsform_title = $this->choice('Which XLSForm would you like to reprocess?', Xlsform::all()->pluck('id', 'title')->toArray(), 0);

        $xlsform = Xlsform::firstWhere('title', $xlsform_title);

        $xlsform->submissions->each(function ($submission) {

            // Copied from SubmissionCrudController

            // delete any database entries created from the previous processing attempts:
            if (isset($submission->entries)) {
                foreach ($submission->entries as $model => $ids) {
                    $model::destroy($ids);
                }
            }

            // remove any validation error messages from previous processing attempts:
            $submission->errors = null;

            SubmissionController::process($submission);
        });

        $this->info('All submissions reprocessed');
    }
}
