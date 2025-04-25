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
        Schema::create('farm_expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farm_id')->constrained('farms');
            $table->string('year', 4)->nullable();

            $table->decimal('frais_condiment_jour')->nullable();
            $table->decimal('frais_condiment_annuel')->nullable();
            $table->decimal('nombre_personne_upa')->nullable();
            $table->decimal('frais_sante_annuel')->nullable();
            $table->decimal('frais_education_annuel')->nullable();
            $table->text('nom_autre_frais')->nullable();
            $table->decimal('montant_autre_frais')->nullable();
            $table->decimal('invest_maison')->nullable();
            $table->decimal('invest_mariage')->nullable();
            $table->decimal('invest_equipment')->nullable();
            $table->text('autre_invest')->nullable();
            $table->decimal('montant_autre_invest')->nullable();
            $table->decimal('depenses_recurrentes')->nullable();
            $table->decimal('depenses_investissements')->nullable();
            $table->decimal('depenes_total')->nullable();

            $table->text('observation_vocal')->nullable();
            $table->text('observation_video')->nullable();
            $table->text('observation_text')->nullable();
            $table->text('observation_image')->nullable();
            $table->text('appreciation_observation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farm_expenses');
    }
};
