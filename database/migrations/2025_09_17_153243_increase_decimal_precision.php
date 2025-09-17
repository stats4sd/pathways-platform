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
        Schema::table('farm_expenses', function (Blueprint $table) {
            $table->decimal('frais_condiment_jour', 12, 2)->nullable()->change();
            $table->decimal('frais_condiment_annuel', 12, 2)->nullable()->change();
            $table->decimal('frais_sante_annuel', 12, 2)->nullable()->change();
            $table->decimal('frais_education_annuel', 12, 2)->nullable()->change();
            $table->decimal('montant_autre_frais', 12, 2)->nullable()->change();
            $table->decimal('invest_maison', 12, 2)->nullable()->change();
            $table->decimal('invest_mariage', 12, 2)->nullable()->change();
            $table->decimal('invest_equipment', 12, 2)->nullable()->change();
            $table->decimal('montant_autre_invest', 12, 2)->nullable()->change();
            $table->decimal('depenses_recurrentes', 12, 2)->nullable()->change();
            $table->decimal('depenses_investissements', 12, 2)->nullable()->change();
            $table->decimal('depenes_total', 12, 2)->nullable()->change();

            $table->integer('nombre_personne_upa')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
