<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('farms_details', function (Blueprint $table) {
            $table->string('type_upa')->after('phone_number')->nullable();
            $table->unsignedBigInteger('village_id')->after('type_upa')->nullable();
            $table->foreign('village_id')->references('id')->on('villages')->nullOnDelete();
            $table->decimal('longitude', 25,20)->after('village_id')->nullable();
            $table->decimal('latitude', 25,20)->after('longitude')->nullable();
            $table->decimal('altitude', 25,20)->after('latitude')->nullable();
            $table->decimal('accuracy', 25,20)->after('altitude')->nullable();
            $table->string('gender_chef')->after('chef_upa')->nullable();
            $table->string('age_chef')->after('gender_chef')->nullable();

            $table->text('nom_coop_coton_upa')->nullable();
            $table->text('nom_coop_cereales_upa')->nullable();
            $table->text('nom_union_cereales_upa')->nullable();

            $table->integer('upa_membres')->nullable();
            $table->integer('upa_actifs')->nullable();
            $table->integer('nombre_enfants')->nullable();
            $table->integer('nombre_adolescents')->nullable();
            $table->integer('nombre_femmes')->nullable();
            $table->integer('nombre_hommes')->nullable();
            $table->integer('nombre_femmes_agees')->nullable();
            $table->integer('nombre_hommes_ages')->nullable();

            $table->integer('nombre_charrues')->nullable();
            $table->integer('nombre_multiculteurs')->nullable();
            $table->integer('nombre_charrettes')->nullable();
            $table->integer('nombre_tracteur')->nullable();
            $table->integer('nombre_semoir')->nullable();
            $table->integer('nombre_motoculteurs')->nullable();

            $table->integer('nombre_pompe_traitement')->nullable();
            $table->integer('nombre_pulverisateurs')->nullable();
            $table->integer('nombre_corps_buteur')->nullable();
            $table->text('autre_materiel')->nullable();
            $table->integer('nombre_autre_materiel')->nullable();

            $table->integer('nombre_boeuf_labour')->nullable();
            $table->integer('nombre_taureaux')->nullable();
            $table->integer('nombre_vaches_taries')->nullable();
            $table->integer('nombre_vaches_laitieres')->nullable();
            $table->integer('nombre_genisses')->nullable();
            $table->integer('nombre_veaux')->nullable();

            $table->integer('nombre_anes')->nullable();
            $table->integer('nombre_chevaux')->nullable();
            $table->integer('nombre_moutons')->nullable();
            $table->integer('nombre_chevres')->nullable();
            $table->integer('nombre_porcs')->nullable();

            $table->integer('nombre_poules')->nullable();
            $table->integer('nombre_pintades')->nullable();
            $table->integer('nombre_lapins')->nullable();
            $table->integer('nombre_canards')->nullable();
            $table->integer('nombre_pigeons')->nullable();
            $table->text('autre_animal')->nullable();
            $table->integer('nombre_autre_animal')->nullable();

            $table->text('info_video')->nullable();
            $table->text('info_audio')->nullable();
            $table->text('info_image')->nullable();
            $table->text('info_text')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('farms_details', function (Blueprint $table) {
            //
        });
    }
};
