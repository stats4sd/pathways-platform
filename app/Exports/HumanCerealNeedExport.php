<?php

namespace App\Exports;

use App\Models\HumanCerealNeed;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class HumanCerealNeedExport implements FromQuery, WithTitle, WithHeadings, WithStrictNullComparison, WithMapping, WithStyles
{

    /**
    * By using WithMapping, maps the data that needs to be added as a row.
    * That means you can "construct" the data for a row
    */
    public function map($humanCerealNeed): array
    {
        return [
            $humanCerealNeed->id,
            $humanCerealNeed->farm->code,
            $humanCerealNeed->year,

            $humanCerealNeed->type_menage,
            $humanCerealNeed->personnes_nourrir,
            $humanCerealNeed->besoin_cereale_exploitation,
            $humanCerealNeed->sac_mais,
            $humanCerealNeed->sac_mil,
            $humanCerealNeed->sac_sorgho,
            $humanCerealNeed->sac_cereales,
            $humanCerealNeed->sac_cereales_diff,
            $humanCerealNeed->rend_moyen_mais,
            $humanCerealNeed->rend_moyen_mil,
            $humanCerealNeed->rend_moyen_sorgho,
            $humanCerealNeed->superficie_mais,
            $humanCerealNeed->superficie_mil,
            $humanCerealNeed->superficie_sorgho,
            $humanCerealNeed->superficie_totale,

            $humanCerealNeed->observation_audio,
            $humanCerealNeed->observation_videos,
            $humanCerealNeed->observation_texte,
            $humanCerealNeed->observation_image,
            $humanCerealNeed->observation_appreciation,

        ];
    }


    public function query()
    {
        return HumanCerealNeed::query();
    }

    public function title(): string
    {
        return 'Besoins pour céréales humains';
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

            'type_menage',
            'personnes_nourrir',
            'besoin_cereale_exploitation',
            'sac_mais',
            'sac_mil',
            'sac_sorgho',
            'sac_cereales',
            'sac_cereales_diff',
            'rend_moyen_mais',
            'rend_moyen_mil',
            'rend_moyen_sorgho',
            'superficie_mais',
            'superficie_mil',
            'superficie_sorgho',
            'superficie_totale',

            'observation_audio',
            'observation_videos',
            'observation_texte',
            'observation_image',
            'observation_appreciation',
        ];
    }

}
