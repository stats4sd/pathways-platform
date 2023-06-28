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

            $table->decimal('superficie_ha')->nullable();;
            $table->string('culture_prev')->constrained('crops')->nullable();;

            $table->integer('quantite_fumure_organique')->nullable();;
            $table->integer('cout_transport')->nullable();;

            $table->integer('quantite_chaux_agricole')->nullable();;
            $table->integer('cout_chaux_agricole')->nullable();;

            $table->integer('quantite_pnt_png')->nullable();;
            $table->integer('cout_pnt_png')->nullable();;

            $table->decimal('superficie_labouree')->nullable();;
            $table->integer('cout_superficie_labouree')->nullable();;

            $table->date('date_semence')->nullable();;
            $table->integer('quantite_semence')->nullable();;
            $table->integer('cout_semence_achetee')->nullable();;

            $table->integer('quantite_herbicide_prelevee')->nullable();;
            $table->integer('cout_herbicide_prelevee')->nullable();;

            $table->integer('cout')->nullable();;

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
