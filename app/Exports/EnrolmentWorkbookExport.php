<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class EnrolmentWorkbookExport implements WithMultipleSheets
{

    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new FarmExport();
        $sheets[] = new FarmDetailExport();

        return $sheets;
    }

}
