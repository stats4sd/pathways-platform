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
        Schema::create('organic_fertilisers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farm_id')->constrained('farms');
            $table->string('year', 4)->nullable();
            $table->decimal('superficie_exploitation')->nullable();
            $table->decimal('protion_fertilisable')->nullable();
            $table->decimal('superficie_rotation')->nullable();
            $table->decimal('superficie_cycle')->nullable();
            $table->decimal('gap_annuel')->nullable();
            $table->decimal('gap_cycle')->nullable();
            $table->integer('nb_annee')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organic_fertilisers');
    }
};
