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
        Schema::table('plantings_details', function (Blueprint $table) {
            $table->decimal('cout_transport')->change();
            $table->decimal('cout_chaux_agricole')->change();
            $table->decimal('cout_pnt_png')->change();
            $table->decimal('cout_superficie_labouree')->change();
            $table->decimal('cout_semence_achetee')->change();
            $table->decimal('cout_herbicide_prelevee')->change();
            $table->decimal('cout')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plantings_details', function (Blueprint $table) {
            //
        });
    }
};
