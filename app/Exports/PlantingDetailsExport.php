<?php

namespace App\Exports;

use App\Models\PlantingDetail;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class PlantingDetailsExport implements FromQuery, WithTitle, WithHeadings, WithStrictNullComparison, WithMapping, WithStyles
{

    /**
    * By using WithMapping, maps the data that needs to be added as a row.
    * That means you can "construct" the data for a row
    */
    public function map($plantingDetail): array
    {
        return [
            $plantingDetail->id,
            $plantingDetail->planting_id,
            $plantingDetail->planting->farm->code,
            $plantingDetail->crop_id,
            $plantingDetail->superficie_ha,
            $plantingDetail->culture_prev,
            $plantingDetail->quantite_fumure_organique,
            $plantingDetail->cout_transport,
            $plantingDetail->quantite_chaux_agricole,
            $plantingDetail->cout_chaux_agricole,
            $plantingDetail->quantite_pnt_png,
            $plantingDetail->cout_pnt_png,
            $plantingDetail->superficie_labouree,
            $plantingDetail->cout_superficie_labouree,
            $plantingDetail->date_semence,
            $plantingDetail->quantite_semence,
            $plantingDetail->cout_semence_achetee,
            $plantingDetail->quantite_herbicide_prelevee,
            $plantingDetail->cout_herbicide_prelevee,
            $plantingDetail->cout,
            $plantingDetail->observation_image,
            $plantingDetail->observation_audio,
            $plantingDetail->observation_videos,
            $plantingDetail->observation_texte,
        ];
    }


    public function query()
    {
        return PlantingDetail::query();
    }

    public function title(): string
    {
        return 'Semis - Culture';
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
            'semis_id',
            'upa_code',
            'culture_id',
            'superficie_ha',
            'culture_prev',
            'quantite_fumure_organique',
            'cout_transport',
            'quantite_chaux_agricole',
            'cout_chaux_agricole',
            'quantite_pnt_png',
            'cout_pnt_png',
            'superficie_labouree',
            'cout_superficie_labouree',
            'date_semence',
            'quantite_semence',
            'cout_semence_achetee',
            'quantite_herbicide_prelevee',
            'cout_herbicide_prelevee',
            'cout',
            'observation_image',
            'observation_audio',
            'observation_videos',
            'observation_texte',
        ];
    }

}
