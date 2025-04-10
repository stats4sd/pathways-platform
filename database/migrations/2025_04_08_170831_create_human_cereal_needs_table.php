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
        Schema::create('human_cereal_needs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farm_id')->constrained('farms');
            $table->string('year', 4)->nullable();
            $table->string('type_menage')->nullable();
            $table->integer('personnes_nourri')->nullable();
            $table->integer('besoin_cereale_exploitation')->nullable();
            $table->integer('sac_mais')->nullable();
            $table->integer('sac_mil')->nullable();
            $table->integer('sac_sorgho')->nullable();
            $table->integer('sac_cereales')->nullable();
            $table->integer('sac_cereales_diff')->nullable();
            $table->text('appreciation_observation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('human_cereal_needs');
    }
};
