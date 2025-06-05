<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PlanningWorkbookExport implements WithMultipleSheets
{

    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new FarmExport();
        $sheets[] = new FarmExpenseExport();
        $sheets[] = new OrganicFertiliserExport();
        $sheets[] = new HumanCerealNeedExport();
        $sheets[] = new AnimalFeedExport();
        $sheets[] = new AnimalFeedCategoryExport();

        return $sheets;
    }

}
