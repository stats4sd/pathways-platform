<?php

namespace App\Exports;

use App\Models\Field;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class FieldExport implements FromQuery, WithTitle, WithHeadings, WithStrictNullComparison, WithMapping, WithStyles
{

    /**
    * By using WithMapping, maps the data that needs to be added as a row.
    * That means you can "construct" the data for a row
    */
    public function map($field): array
    {
        return [
            $field->id,
            $field->farm->code,
            $field->year,
            $field->nom,
            $field->type_sol,
            $field->pente,
            $field->superficie_total
        ];
    }


    public function query()
    {
        return Field::query();
    }

    public function title(): string
    {
        return 'Champs';
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
            'nom',
            'type_sol',
            'pente',
            'superficie_total'
        ];
    }

}
