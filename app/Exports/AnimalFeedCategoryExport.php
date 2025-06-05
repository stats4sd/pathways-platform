<?php

namespace App\Exports;

use App\Models\AnimalFeedCategory;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithStyles;

class AnimalFeedCategoryExport implements FromQuery, WithTitle, WithHeadings, WithStrictNullComparison, WithMapping, WithStyles
{

    /**
    * By using WithMapping, maps the data that needs to be added as a row.
    * That means you can "construct" the data for a row
    */
    public function map($animalFeedCategory): array
    {
        return [
            $animalFeedCategory->id,
            $animalFeedCategory->animal_feed_id,
            $animalFeedCategory->animalFeed->farm->code,
            $animalFeedCategory->categorie,
            $animalFeedCategory->nb_animaux,
            $animalFeedCategory->type_regime,
            $animalFeedCategory->comp_faible_con,
            $animalFeedCategory->comp_faible_resid,
            $animalFeedCategory->comp_faible_fane,
            $animalFeedCategory->comp_ameli_con,
            $animalFeedCategory->comp_ameli_resid,
            $animalFeedCategory->comp_ameli_fane,
            $animalFeedCategory->stabulation_con,
            $animalFeedCategory->stabulation_resid,
            $animalFeedCategory->stabulation_fane,
        ];
    }


    public function query()
    {
        return AnimalFeedCategory::query();
    }

    public function title(): string
    {
        return 'Alimentation Animaux - Catégorie';
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
            'animal_feed_id',
            'upa_code',
            'categorie',
            'nb_animaux',
            'type_regime',
            'comp_faible_con',
            'comp_faible_resid',
            'comp_faible_fane',
            'comp_ameli_con',
            'comp_ameli_resid',
            'comp_ameli_fane',
            'stabulation_con',
            'stabulation_resid',
            'stabulation_fane',
        ];
    }

}
