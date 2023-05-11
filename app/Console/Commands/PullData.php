<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Stats4sd\OdkLink\Models\Xlsform;
use Stats4sd\OdkLink\Services\OdkLinkService;

class PullData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pulldata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pulls submissions from all active forms.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $forms = Xlsform::where('is_active', 1)->get();

        $service = new OdkLinkService(config('odk-link.odk.base_endpoint'));

        foreach ($forms as $form) {
            $service->getSubmissions($form);
        }

        return Command::SUCCESS;
    }
}