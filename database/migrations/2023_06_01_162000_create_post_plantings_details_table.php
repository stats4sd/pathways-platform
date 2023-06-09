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
        Schema::create('post_plantings_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_planting_id')->constrained('post_plantings');
            $table->foreignId('crop_id')->constrained('crops');
            $table->integer('superficie_sarclage');
            $table->integer('cout_sarclage');
            $table->integer('superficie_desherbage');
            $table->integer('cout_desherbage');
            $table->integer('quantite_npk');
            $table->integer('cout_npk');
            $table->integer('quantite_uree');
            $table->integer('cout_uree');
            $table->integer('quantite_herbicide');
            $table->integer('cout_herbicide');
            $table->integer('superficie_butee');
            $table->integer('cout_buttage');
            $table->integer('quantite_insecticide');
            $table->integer('cout_insecticide');
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
        Schema::dropIfExists('post_plantings_details');
    }
};
