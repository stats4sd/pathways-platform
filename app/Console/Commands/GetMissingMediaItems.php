<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Stats4sd\OdkLink\Models\Submission;
use Stats4sd\OdkLink\Services\OdkLinkService;

class GetMissingMediaItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-missing-media-items';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks all submissions within the platform to make sure all attached media items are downloaded from ODK Central';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // get all submissions
        $submissionsWithMedia = Submission::all()
            ->filter(function ($submission) {
                return $submission->content['__system']['attachmentsPresent'] > 0;
            });

        $submissionsWithMedia->each(function (Submission $submission) {

            // check what media *should* exist for the submission:
            $this->comment("checking media for submission {$submission->id}");


            $endPoint = config('odk-link.odk.base_endpoint');
            $odkLinkService = app()->make(OdkLinkService::class);

            $token = $odkLinkService->authenticate();

            $mediaPresent = Http::withToken($token)
                ->get("{$endPoint}/projects/{$submission->xlsformVersion->xlsform->owner->odkProject->id}/forms/{$submission->xlsformVersion->xlsform->odk_id}/submissions/{$submission->content['instanceID']}/attachments")
                ->throw()
                ->json();


            foreach ($mediaPresent as $mediaItem) {

                // if media is present, then don't re-download it
                $mediaCount = $submission->getMedia()
                    ->filter(fn(Media $media) => $media->file_name === $mediaItem['name'])
                    ->count();

                if($mediaCount) {
                    $this->info("{$mediaItem['name']} already present for submission {$submission->id}");
                    continue;
                }

                // if media is not present, then we need to download it:
                $this->comment("downloading media item {$mediaItem['name']}");

                // download the attachment
                $result = Http::withToken($token)
                    ->get("{$endPoint}/projects/{$submission->xlsformVersion->xlsform->owner->odkProject->id}/forms/{$submission->xlsformVersion->xlsform->odk_id}/submissions/{$submission->content['instanceID']}/attachments/{$mediaItem['name']}")
                    ->throw();

                // store the attachment locally
                Storage::disk(config('odk-link.storage.media'))
                    ->put($mediaItem['name'], $result->body());

                // link it to the submission via Media Library
                $submission->addMediaFromDisk($mediaItem['name'], config('odk-link.storage.media'))
                    ->toMediaLibrary();
            }
        });

        $this->info('Done!');
    }
}
