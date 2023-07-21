<?php

namespace App\Exports;

use App\Models\HarvestDetail;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class HarvestDetailsExport implements FromQuery, WithTitle, WithHeadings, WithStrictNullComparison, WithMapping, WithStyles
{

    /**
    * By using WithMapping, maps the data that needs to be added as a row.
    * That means you can "construct" the data for a row
    */
    public function map($harvestDetails): array
    {
        return [
            $harvestDetails->id,
            $harvestDetails->harvest_id,
            $harvestDetails->harvest->farm->code,
            $harvestDetails->crop_id,
            $harvestDetails->superficie_recolte_prestation,
            $harvestDetails->cout_total_prestation_recolte,
            $harvestDetails->production,
            $harvestDetails->cout_total_battage,
            $harvestDetails->production_residu_culture,
            $harvestDetails->nombre_botte,
            $harvestDetails->cout,
            $harvestDetails->observation_texte,
        ];
    }


    public function query()
    {
        return HarvestDetail::query();
    }

    public function title(): string
    {
        return 'Récolte - Culture';
    }

    public function styles(Worksheet $sheet)
    {
        $h1 = [
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF00FFB6'],
            ],
        ];

        return [
            1 => $h1
        ];
    }

    public function headings(): array
    {
        return [
            'id',
            'recolte_id',
            'upa_code',
            'culture_id',
            'superficie_recolte_prestation',
            'cout_total_prestation_recolte',
            'production',
            'cout_total_battage',
            'production_residu_culture',
            'nombre_botte',
            'cout',
            'observation_texte',
        ];
    }

}
