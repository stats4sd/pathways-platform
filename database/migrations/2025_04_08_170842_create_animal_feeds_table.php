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
        Schema::create('animal_feeds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farm_id')->constrained('farms');
            $table->string('year', 4)->nullable();
            $table->integer('concentre_produit')->nullable();
            $table->integer('achat_sac_con_quanti')->nullable();
            $table->decimal('note_quant_achat')->nullable();
            $table->integer('achat_sac_con_son')->nullable();
            $table->integer('quantite_stourteau')->nullable();
            $table->decimal('quantite_sac_tourteau')->nullable();
            $table->integer('prix_sac_son')->nullable();
            $table->integer('cal_depense_son')->nullable();
            $table->integer('prix_sac_tourteau')->nullable();
            $table->integer('cal_depense_tour')->nullable();
            $table->decimal('cal_superficie')->nullable();
            $table->integer('cal_depense_total')->nullable();
            $table->text('appreciation_observation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animal_feeds');
    }
};
