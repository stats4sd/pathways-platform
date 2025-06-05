<?php

namespace App\Exports;

use App\Models\OrganicFertiliser;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithStyles;

class OrganicFertiliserExport implements FromQuery, WithTitle, WithHeadings, WithStrictNullComparison, WithMapping, WithStyles
{

    /**
    * By using WithMapping, maps the data that needs to be added as a row.
    * That means you can "construct" the data for a row
    */
    public function map($organicFertiliser): array
    {
        return [
            $organicFertiliser->id,
            $organicFertiliser->farm->code,
            $organicFertiliser->year,

            $organicFertiliser->quantite_fumure_organique,
            $organicFertiliser->superficie_exploitation,
            $organicFertiliser->protion_fertilisable,
            $organicFertiliser->superficie_rotation,
            $organicFertiliser->superficie_cycle,
            $organicFertiliser->gap_annuel,
            $organicFertiliser->gap_cycle,
            $organicFertiliser->gap_cycle_pour100,
            $organicFertiliser->nb_annee,

            $organicFertiliser->observation_audio,
            $organicFertiliser->observation_videos,
            $organicFertiliser->observation_texte,
            $organicFertiliser->observation_image,
            $organicFertiliser->observation_appreciation,
        ];
    }


    public function query()
    {
        return OrganicFertiliser::query();
    }

    public function title(): string
    {
        return 'Fumure Organique';
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
            'upa_code',
            'year',

            'quantite_fumure_organique',
            'superficie_exploitation',
            'protion_fertilisable',
            'superficie_rotation',
            'superficie_cycle',
            'gap_annuel',
            'gap_cycle',
            'gap_cycle_pour100',
            'nb_annee',

            'observation_audio',
            'observation_videos',
            'observation_texte',
            'observation_image',
            'observation_appreciation',
        ];
    }

}
