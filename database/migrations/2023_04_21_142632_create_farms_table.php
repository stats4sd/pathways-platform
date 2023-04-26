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
        Schema::create('farms', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('year', 4)->nullable();
            $table->text('chef_upa')->nullable();
            $table->text('chef_travaux')->nullable();
            $table->text('neo_alphabete')->nullable();
            $table->text('activite_primaire')->nullable();
            $table->text('activitie_primaire_other')->nullable();
            $table->text('activite_secondaire')->nullable();
            $table->text('activitie_secondaire_other')->nullable();
            $table->text('cereales_favoris_upa')->nullable();
            $table->integer('superficie_possede_upa')->nullable();
            $table->integer('superficie_cultive_upa')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farms');
    }
};
