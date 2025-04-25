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
        Schema::create('animal_feed_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('animal_feed_id')->constrained('animal_feeds');
            $table->string('categorie')->nullable();
            $table->integer('nb_animaux')->nullable();
            $table->string('type_regime')->nullable();
            $table->decimal('comp_faible_con')->nullable();
            $table->decimal('comp_faible_resid')->nullable();
            $table->decimal('comp_faible_fane')->nullable();
            $table->decimal('comp_ameli_con')->nullable();
            $table->decimal('comp_ameli_resid')->nullable();
            $table->decimal('comp_ameli_fane')->nullable();
            $table->decimal('stabulation_con')->nullable();
            $table->decimal('stabulation_resid')->nullable();
            $table->decimal('stabulation_fane')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animal_feed_categories');
    }
};
