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
        Schema::create('plots', function (Blueprint $table) {
            $table->id();
            $table->string('field_id')->constrained('fields');
            $table->string('numero_parcelle');
            $table->text('fertilite')->nullable();
            $table->integer('nombre_arbre')->nullable();
            $table->string('crop_id')->constrained('crops')->nullable();
            $table->text('associated_crops')->nullable();
            $table->decimal('superficie')->nullable();
            $table->string('trace_superficie')->nullable();
            $table->decimal('surface_m')->nullable();
            $table->decimal('surface_h')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plots');
    }
};
