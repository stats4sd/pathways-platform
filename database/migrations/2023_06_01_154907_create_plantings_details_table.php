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
        Schema::create('plantings_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('planting_id')->constrained('plantings');
            $table->string('crop_id')->constrained('crops');

            $table->decimal('superficie_ha');
            $table->string('culture_prev')->constrained('crops');

            $table->integer('quantite_fumure_organique');
            $table->integer('cout_transport');

            $table->integer('quantite_chaux_agricole');
            $table->integer('cout_chaux_agricole');

            $table->integer('quantite_pnt_png');
            $table->integer('cout_pnt_png');

            $table->decimal('superficie_labouree');
            $table->integer('cout_superficie_labouree');

            $table->date('date_semence');
            $table->integer('quantite_semence');
            $table->integer('cout_semence_achetee');

            $table->integer('quantite_herbicide_prelevee');
            $table->integer('cout_herbicide_prelevee');

            $table->integer('cout');

            $table->text('observation_audio')->nullable();
            $table->text('observation_videos')->nullable();
            $table->text('observation_texte')->nullable();
            $table->text('observation_image')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plantings_details');
    }
};
