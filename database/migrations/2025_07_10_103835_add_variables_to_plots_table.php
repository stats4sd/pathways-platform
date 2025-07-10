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
        Schema::table('plots', function (Blueprint $table) {
            $table->date('date_semence')->after('type_variete_culture')->nullable();
            $table->integer('quantite_semence')->after('date_semence')->nullable();
            $table->string('source_semence_culture')->after('quantite_semence')->nullable();
            $table->string('autre_source_semence_cutture')->after('source_semence_culture')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plots', function (Blueprint $table) {
            //
        });
    }
};
