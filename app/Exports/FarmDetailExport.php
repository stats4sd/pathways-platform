<?php

namespace App\Exports;

use App\Models\Farm;
use App\Models\FarmDetail;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class FarmDetailExport implements FromQuery, WithTitle, WithHeadings, WithStrictNullComparison, WithMapping, WithStyles
{

    /**
    * By using WithMapping, maps the data that needs to be added as a row.
    * That means you can "construct" the data for a row
    */
    public function map($farmDetails): array
    {
        return [
            $farmDetails->id,
            $farmDetails->farm->code,
            $farmDetails->year,
            $farmDetails->type,
            $farmDetails->phone_number,
            $farmDetails->chef_upa,
            $farmDetails->village_id,
            $farmDetails->longitude,
            $farmDetails->latitude,
            $farmDetails->altitude,
            $farmDetails->accuracy,
            $farmDetails->gender_chef,
            $farmDetails->age_chef,

            $farmDetails->ratio_membre_terre,
            $farmDetails->ratio_actif_terre,
            $farmDetails->ratio_boeuflabour_terre,

            $farmDetails->chef_travaux,
            $farmDetails->neo_alphabete,
            $farmDetails->activite_primaire,
            $farmDetails->activite_secondaire,
            $farmDetails->cereales_favoris_1,
            $farmDetails->cereales_favoris_2,
            $farmDetails->cereales_favoris_3,
            $farmDetails->superficie_possede_upa,
            $farmDetails->superficie_cultive_upa,

            $farmDetails->nom_coop_coton_upa,
            $farmDetails->nom_coop_cereales_upa,
            $farmDetails->nom_union_cereales_upa,

            $farmDetails->upa_membres,
            $farmDetails->upa_actifs,
            $farmDetails->nombre_enfants,
            $farmDetails->nombre_adolescents,
            $farmDetails->nombre_femmes,
            $farmDetails->nombre_hommes,
            $farmDetails->nombre_femmes_agees,
            $farmDetails->nombre_hommes_ages,

            $farmDetails->nombre_charrues,
            $farmDetails->nombre_multiculteurs,
            $farmDetails->nombre_charrettes,
            $farmDetails->nombre_tracteur,
            $farmDetails->nombre_semoir,
            $farmDetails->nombre_motoculteurs,

            $farmDetails->nombre_pompe_traitement,
            $farmDetails->nombre_pulverisateurs,
            $farmDetails->nombre_corps_buteur,
            $farmDetails->autre_materiel,
            $farmDetails->nombre_autre_materiel,

            $farmDetails->nombre_boeuf_labour,
            $farmDetails->nombre_taureaux,
            $farmDetails->nombre_vaches_taries,
            $farmDetails->nombre_vaches_laitieres,
            $farmDetails->nombre_genisses,
            $farmDetails->nombre_veaux,

            $farmDetails->nombre_anes,
            $farmDetails->nombre_chevaux,
            $farmDetails->nombre_moutons,
            $farmDetails->nombre_chevres,
            $farmDetails->nombre_porcs,

            $farmDetails->nombre_poules,
            $farmDetails->nombre_pintades,
            $farmDetails->nombre_lapins,
            $farmDetails->nombre_canards,
            $farmDetails->nombre_pigeons,
            $farmDetails->autre_animal,
            $farmDetails->nombre_autre_animal,

            $farmDetails->info_video,
            $farmDetails->info_audio,
            $farmDetails->info_image,
            $farmDetails->info_text,
        ];
    }


    public function query()
    {
        return FarmDetail::query();
    }

    public function title(): string
    {
        return 'UPA – Détails';
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
            'type',
            'phone_number',
            'chef_upa',
            'village_id',
            'longitude',
            'latitude',
            'altitude',
            'accuracy',
            'gender_chef',
            'age_chef',
            'ratio_membre_terre',
            'ratio_actif_terre',
            'ratio_boeuflabour_terre',
            'chef_travaux',
            'neo_alphabete',
            'activite_primaire',
            'activite_secondaire',
            'cereales_favoris_1',
            'cereales_favoris_2',
            'cereales_favoris_3',
            'superficie_possede_upa',
            'superficie_cultive_upa',
            'nom_coop_coton_upa',
            'nom_coop_cereales_upa',
            'nom_union_cereales_upa',
            'upa_membres',
            'upa_actifs',
            'nombre_enfants',
            'nombre_adolescents',
            'nombre_femmes',
            'nombre_hommes',
            'nombre_femmes_agees',
            'nombre_hommes_ages',
            'nombre_charrues',
            'nombre_multiculteurs',
            'nombre_charrettes',
            'nombre_tracteur',
            'nombre_semoir',
            'nombre_motoculteurs',
            'nombre_pompe_traitement',
            'nombre_pulverisateurs',
            'nombre_corps_buteur',
            'autre_materiel',
            'nombre_autre_materiel',
            'nombre_boeuf_labour',
            'nombre_taureaux',
            'nombre_vaches_taries',
            'nombre_vaches_laitieres',
            'nombre_genisses',
            'nombre_veaux',
            'nombre_anes',
            'nombre_chevaux',
            'nombre_moutons',
            'nombre_chevres',
            'nombre_porcs',
            'nombre_poules',
            'nombre_pintades',
            'nombre_lapins',
            'nombre_canards',
            'nombre_pigeons',
            'autre_animal',
            'nombre_autre_animal',
            'info_video',
            'info_audio',
            'info_image',
            'info_text',
        ];
    }

}
