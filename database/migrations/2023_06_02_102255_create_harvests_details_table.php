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
        Schema::create('harvests_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('harvest_id')->constrained('harvests');
            $table->string('crop_id')->constrained('crops');

            $table->decimal('superficie_recolte_prestation')->nullable();
            $table->integer('cout_total_prestation_recolte')->nullable();

            $table->decimal('production')->nullable();
            $table->integer('cout_total_battage')->nullable();

            $table->integer('production_residu_culture')->nullable();
            $table->integer('nombre_botte')->nullable();

            $table->integer('cout')->nullable();

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
        Schema::dropIfExists('harvests_details');
    }
};
