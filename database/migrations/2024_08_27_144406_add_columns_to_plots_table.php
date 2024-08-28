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
        Schema::table('plots', function (Blueprint $table) {
            $table->string('prev_crop_id')->after('fertilite')->constrained('crops')->nullable();
            $table->text('nom_variete_culture')->after('crop_id')->nullable();
            $table->text('type_variete_culture')->after('nom_variete_culture')->nullable();
            $table->text('nom_arbres')->after('type_variete_culture')->nullable();
            $table->integer('quantite_fumure_organique')->after('cultures_associations')->nullable();
            $table->text('type_fumure_organique')->after('quantite_fumure_organique')->nullable();
            $table->text('autre_type_fumure_organique')->after('type_fumure_organique')->nullable();
            $table->decimal('quantite_npk')->after('autre_type_fumure_organique')->nullable();
            $table->decimal('quantite_uree')->after('quantite_npk')->nullable();
            $table->text('nom_autre_engrais')->after('quantite_uree')->nullable();
            $table->text('observation_audio')->after('trace_superficie')->nullable();
            $table->text('observation_texte')->after('observation_audio')->nullable();
            $table->text('observation_image')->after('observation_texte')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plots', function (Blueprint $table) {
            //
        });
    }
};
