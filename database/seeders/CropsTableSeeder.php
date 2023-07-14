<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CropsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('crops')->delete();

        \DB::table('crops')->insert(array (
            0 =>
            array (
                'created_at' => NULL,
                'id' => 'arachide',
                'label_bm' => 'Tiga',
                'label_fr' => 'Arachide',
                'nom_fichier_image' => 'arachide.jpg',
                'type' => 'primaire',
                'updated_at' => NULL,
            ),
            1 =>
            array (
                'created_at' => NULL,
                'id' => 'bissap',
                'label_bm' => 'Da',
                'label_fr' => 'Bissap',
                'nom_fichier_image' => 'bissap.jpg',
                'type' => 'secondaire',
                'updated_at' => NULL,
            ),
            2 =>
            array (
                'created_at' => NULL,
                'id' => 'coton',
                'label_bm' => 'Kɔɔri',
                'label_fr' => 'Coton',
                'nom_fichier_image' => 'coton.jpg',
                'type' => 'primaire',
                'updated_at' => NULL,
            ),
            3 =>
            array (
                'created_at' => NULL,
                'id' => 'fonio',
                'label_bm' => 'Fini',
                'label_fr' => 'Fonio',
                'nom_fichier_image' => 'fonio.jpg',
                'type' => 'secondaire',
                'updated_at' => NULL,
            ),
            4 =>
            array (
                'created_at' => NULL,
                'id' => 'fourrage',
                'label_bm' => 'Bagan balow',
                'label_fr' => 'Fourrage',
                'nom_fichier_image' => 'fourrage.jpg',
                'type' => 'primaire',
                'updated_at' => NULL,
            ),
            5 =>
            array (
                'created_at' => NULL,
                'id' => 'mais',
                'label_bm' => 'Kaba',
                'label_fr' => 'Maïs',
                'nom_fichier_image' => 'mais.jpg',
                'type' => 'primaire',
                'updated_at' => NULL,
            ),
            6 =>
            array (
                'created_at' => NULL,
                'id' => 'mil',
                'label_bm' => 'Sanŋɔ',
                'label_fr' => 'Mil',
                'nom_fichier_image' => 'mil.jpg',
                'type' => 'primaire',
                'updated_at' => NULL,
            ),
            7 =>
            array (
                'created_at' => NULL,
                'id' => 'patate_douce',
                'label_bm' => 'Woso',
                'label_fr' => 'Patate douce',
                'nom_fichier_image' => 'patate_douce.jpg',
                'type' => 'secondaire',
                'updated_at' => NULL,
            ),
            8 =>
            array (
                'created_at' => NULL,
                'id' => 'rice',
                'label_bm' => 'Malo',
                'label_fr' => 'Riz',
                'nom_fichier_image' => 'rice.jpg',
                'type' => 'secondaire',
                'updated_at' => NULL,
            ),
            9 =>
            array (
                'created_at' => NULL,
                'id' => 'sesame',
                'label_bm' => 'Bɛnɛ',
                'label_fr' => 'Sésame',
                'nom_fichier_image' => 'sesame.jpg',
                'type' => 'secondaire',
                'updated_at' => NULL,
            ),
            10 =>
            array (
                'created_at' => NULL,
                'id' => 'sorgho',
                'label_bm' => 'Keniŋe',
                'label_fr' => 'Sorgho',
                'nom_fichier_image' => 'sorgho.jpg',
                'type' => 'primaire',
                'updated_at' => NULL,
            ),
            11 =>
            array (
                'created_at' => NULL,
                'id' => 'wouandzou',
                'label_bm' => 'Tiga munikuru',
                'label_fr' => 'Wouandzou',
                'nom_fichier_image' => 'wouandzou.jpg',
                'type' => 'secondaire',
                'updated_at' => NULL,
            ),
        ));


    }
}
