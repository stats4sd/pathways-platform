<?php

namespace App\Exports;

use App\Models\Plot;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class PlotExport implements FromQuery, WithTitle, WithHeadings, WithStrictNullComparison, WithMapping, WithStyles
{

    /**
    * By using WithMapping, maps the data that needs to be added as a row.
    * That means you can "construct" the data for a row
    */
    public function map($plot): array
    {
        return [
            $plot->id,
            $plot->field->farm->code,
            $plot->numero_parcelle,
            $plot->nombre_arbre,
            $plot->fertilite,
            $plot->prev_crop_id,
            $plot->crop_id,
            $plot->nom_variete_culture,
            $plot->type_variete_culture,
            $plot->date_semence,
            $plot->quantite_semence,
            $plot->source_semence_culture,
            $plot->autre_source_semence_cutture,
            $plot->nom_arbres,
            $plot->cultures_associations,
            $plot->quantite_fumure_organique,
            $plot->type_fumure_organique,
            $plot->autre_type_fumure_organique,
            $plot->quantite_npk,
            $plot->quantite_uree,
            $plot->nom_autre_engrais,
            $plot->superficie_estimee,
            $plot->superficie_measuree,
            $plot->observation_audio,
            $plot->observation_image,
            $plot->trace_superficie,
        ];
    }


    public function query()
    {
        return Plot::query();
    }

    public function title(): string
    {
        return 'Parcelles';
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
            'numero_parcelle',
            'nombre_arbre',
            'fertilite',
            'prev_crop_id',
            'crop_id',
            'nom_variete_culture',
            'type_variete_culture',
            'date_semence',
            'quantite_semence',
            'source_semence_culture',
            'autre_source_semence_cutture',
            'nom_arbres',
            'cultures_associations',
            'quantite_fumure_organique',
            'type_fumure_organique',
            'autre_type_fumure_organique',
            'quantite_npk',
            'quantite_uree',
            'nom_autre_engrais',
            'superficie_estimee',
            'superficie_measuree',
            'observation_audio',
            'observation_image',
            'trace_superficie',
        ];
    }

}