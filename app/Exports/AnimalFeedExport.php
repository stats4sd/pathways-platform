<?php

namespace App\Exports;

use App\Models\AnimalFeed;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithStyles;

class AnimalFeedExport implements FromQuery, WithTitle, WithHeadings, WithStrictNullComparison, WithMapping, WithStyles
{

    /**
    * By using WithMapping, maps the data that needs to be added as a row.
    * That means you can "construct" the data for a row
    */
    public function map($animalFeed): array
    {
        return [
            $animalFeed->id,
            $animalFeed->farm->code,
            $animalFeed->year,

            $animalFeed->total_concentre,
            $animalFeed->total_residu,
            $animalFeed->total_fane,
            $animalFeed->liste_cat_animales,
            $animalFeed->quantite_son,
            $animalFeed->quantite_tourteau,
            $animalFeed->concentre_produit,
            $animalFeed->achat_son_quantite,
            $animalFeed->prix_sac_son,
            $animalFeed->cal_depense_son,
            $animalFeed->prix_sac_tourteau,
            $animalFeed->cal_depense_tourteau,
            $animalFeed->cal_superficie,
            $animalFeed->cal_depense_total,
            $animalFeed->cal_depense_soins,

            $animalFeed->observation_audio,
            $animalFeed->observation_videos,
            $animalFeed->observation_texte,
            $animalFeed->observation_image,
            $animalFeed->observation_appreciation,
        ];
    }

    public function query()
    {
        return AnimalFeed::query();
    }

    public function title(): string
    {
        return 'Alimentation Animaux';
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

            'total_concentre',
            'total_residu',
            'total_fane',
            'liste_cat_animales',
            'quantite_son',
            'quantite_tourteau',
            'concentre_produit',
            'achat_son_quantite',
            'prix_sac_son',
            'cal_depense_son',
            'prix_sac_tourteau',
            'cal_depense_tourteau',
            'cal_superficie',
            'cal_depense_total',
            'cal_depense_soins',

            'observation_audio',
            'observation_videos',
            'observation_texte',
            'observation_image',
            'observation_appreciation',
        ];
    }

}
