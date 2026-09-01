<?php

namespace App\Console\Commands;

use App\Models\Plot;
use Illuminate\Console\Command;

class FillTraceSuperficieOdk extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fill-trace-superficie-odk';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fills trace_superficie_odk (ODK geoshape format) for existing plots that do not have it yet, converting from their stored trace_superficie coordinates';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $total = Plot::count();
        $noTrace = Plot::whereNull('trace_superficie')->count();
        $alreadyFilled = Plot::whereNotNull('trace_superficie_odk')->count();

        $this->info("{$total} plots in total, {$noTrace} have no trace_superficie, {$alreadyFilled} already have the ODK format.");

        $plots = Plot::whereNotNull('trace_superficie')
            ->whereNull('trace_superficie_odk')
            ->get();

        $count = 0;

        foreach ($plots as $plot) {
            $odk = Plot::toOdkGeoshape($plot->trace_superficie);

            if ($odk === null) {
                continue;
            }

            $plot->timestamps = false;
            $plot->updateQuietly(['trace_superficie_odk' => $odk]);
            $count++;
        }

        $this->info("Converted {$count} plots.");
    }
}
