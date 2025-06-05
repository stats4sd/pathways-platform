<?php

namespace App\Exports;

use App\Models\Farm;
use App\Models\FarmExpense;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class FarmExpenseExport implements FromQuery, WithTitle, WithHeadings, WithStrictNullComparison, WithMapping, WithStyles
{

    /**
    * By using WithMapping, maps the data that needs to be added as a row.
    * That means you can "construct" the data for a row
    */
    public function map($farmExpense): array
    {
        return [
            $farmExpense->id,
            $farmExpense->farm->code,
            $farmExpense->year,

            $farmExpense->frais_condiment_jour,
            $farmExpense->frais_condiment_annuel,
            $farmExpense->nombre_personne_upa,
            $farmExpense->frais_sante_annuel,
            $farmExpense->frais_education_annuel,
            $farmExpense->nom_autre_frais,
            $farmExpense->montant_autre_frais,
            $farmExpense->invest_maison,
            $farmExpense->invest_mariage,
            $farmExpense->invest_equipment,
            $farmExpense->autre_invest,
            $farmExpense->montant_autre_invest,
            $farmExpense->depenses_recurrentes,
            $farmExpense->depenses_investissements,
            $farmExpense->depenes_total,

            $farmExpense->observation_audio,
            $farmExpense->observation_videos,
            $farmExpense->observation_texte,
            $farmExpense->observation_image,
            $farmExpense->observation_appreciation,

        ];
    }


    public function query()
    {
        return FarmExpense::query();
    }

    public function title(): string
    {
        return 'Dépenses UPA';
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

            'frais_condiment_jour',
            'frais_condiment_annuel',
            'nombre_personne_upa',
            'frais_sante_annuel',
            'frais_education_annuel',
            'nom_autre_frais',
            'montant_autre_frais',
            'invest_maison',
            'invest_mariage',
            'invest_equipment',
            'autre_invest',
            'montant_autre_invest',
            'depenses_recurrentes',
            'depenses_investissements',
            'depenes_total',

            'observation_audio',
            'observation_videos',
            'observation_texte',
            'observation_image',
            'observation_appreciation',
        ];
    }

}
