<?php

namespace App\Exports;

use App\Models\PostPlantingDetail;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithStyles;

class PostPlantingDetailsExport implements FromQuery, WithTitle, WithHeadings, WithStrictNullComparison, WithMapping, WithStyles
{

    /**
    * By using WithMapping, maps the data that needs to be added as a row.
    * That means you can "construct" the data for a row
    */
    public function map($postPlantingDetail): array
    {
        return [
            $postPlantingDetail->id,
            $postPlantingDetail->post_planting_id,
            $postPlantingDetail->postPlanting->farm->code,
            $postPlantingDetail->crop_id,
            $postPlantingDetail->superficie_sarclage,
            $postPlantingDetail->cout_sarclage,
            $postPlantingDetail->superficie_desherbage,
            $postPlantingDetail->cout_desherbage,
            $postPlantingDetail->quantite_npk,
            $postPlantingDetail->cout_npk,
            $postPlantingDetail->quantite_uree,
            $postPlantingDetail->cout_uree,
            $postPlantingDetail->quantite_herbicide,
            $postPlantingDetail->cout_herbicide,
            $postPlantingDetail->superficie_butee,
            $postPlantingDetail->cout_buttage,
            $postPlantingDetail->quantite_insecticide,
            $postPlantingDetail->cout_insecticide,
            $postPlantingDetail->cout,
            $postPlantingDetail->observation_texte,
        ];
    }


    public function query()
    {
        return PostPlantingDetail::query();
    }

    public function title(): string
    {
        return 'Post-Semis - Culture';
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
            'post_semis_id',
            'upa_code',
            'culture_id',
            'superficie_sarclage',
            'cout_sarclage',
            'superficie_desherbage',
            'cout_desherbage',
            'quantite_npk',
            'cout_npk',
            'quantite_uree',
            'cout_uree',
            'quantite_herbicide',
            'cout_herbicide',
            'superficie_butee',
            'cout_buttage',
            'quantite_insecticide',
            'cout_insecticide',
            'cout',
            'observation_texte',
        ];
    }

}
