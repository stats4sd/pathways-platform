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
        Schema::table('farms_details', function (Blueprint $table) {
            $table->decimal('ratio_membre_terre')->nullable();
            $table->decimal('ratio_actif_terre')->nullable();
            $table->decimal('ratio_boeuflabour_terre')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('farms_details', function (Blueprint $table) {
            //
        });
    }
};
