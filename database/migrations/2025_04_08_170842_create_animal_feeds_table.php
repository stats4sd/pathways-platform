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

            $table->decimal('total_concentre')->nullable();
            $table->decimal('total_residu')->nullable();
            $table->decimal('total_fane')->nullable();
            $table->text('liste_cat_animales')->nullable();
            $table->decimal('quantite_son')->nullable();
            $table->decimal('quantite_tourteau')->nullable();
            $table->integer('concentre_produit')->nullable();
            $table->decimal('achat_son_quantite')->nullable();
            $table->integer('prix_sac_son')->nullable();
            $table->integer('cal_depense_son')->nullable();
            $table->decimal('prix_sac_tourteau')->nullable();
            $table->decimal('cal_depense_tourteau')->nullable();
            $table->decimal('cal_superficie')->nullable();
            $table->decimal('cal_depense_total')->nullable();
            $table->decimal('cal_depense_soins')->nullable();

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
        Schema::dropIfExists('animal_feeds');
    }
};
