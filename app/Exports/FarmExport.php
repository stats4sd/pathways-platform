<?php

namespace App\Exports;

use App\Models\Farm;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithStyles;

class FarmExport implements FromQuery, WithTitle, WithHeadings, WithStrictNullComparison, WithMapping, WithStyles
{

    /**
    * By using WithMapping, maps the data that needs to be added as a row.
    * That means you can "construct" the data for a row
    */
    public function map($farm): array
    {
        return [
            $farm->id,
            $farm->code,
            $farm->year,
            $farm->phone_number,
            $farm->chef_upa,
            $farm->chef_travaux,
            $farm->neo_alphabete,
            $farm->activite_primaire,
            $farm->activite_secondaire,
            $farm->cereales_favoris_1,
            $farm->cereales_favoris_2,
            $farm->cereales_favoris_3,
            $farm->superficie_possede_upa,
            $farm->superficie_cultive_upa,
        ];
    }


    public function query()
    {
        return Farm::query();
    }

    public function title(): string
    {
        return 'UPAs';
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
            'code',
            'year',
            'phone_number',
            'chef_upa',
            'chef_travaux',
            'neo_alphabete',
            'activite_primaire',
            'activite_secondaire',
            'cereales_favoris_1',
            'cereales_favoris_2',
            'cereales_favoris_3',
            'superficie_possede_upa',
            'superficie_cultive_upa'
        ];
    }

}
