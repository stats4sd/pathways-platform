<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MonitoringWorkbookExport implements WithMultipleSheets
{

    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new FarmExport();
        $sheets[] = new PlantingExport();
        $sheets[] = new PlantingDetailsExport();
        $sheets[] = new PostPlantingExport();
        $sheets[] = new PostPlantingDetailsExport();
        $sheets[] = new HarvestExport();
        $sheets[] = new HarvestDetailsExport();

        return $sheets;
    }

}
