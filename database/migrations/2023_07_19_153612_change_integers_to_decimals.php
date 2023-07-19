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
            $table->decimal('quantite_semence')->change();
        });

        Schema::table('post_plantings_details', function (Blueprint $table) {
            $table->decimal('superficie_sarclage')->change();
            $table->decimal('superficie_desherbage')->change();
            $table->decimal('quantite_npk')->change();
            $table->decimal('quantite_uree')->change();
            $table->decimal('superficie_butee')->change();
        });

        Schema::table('harvests_details', function (Blueprint $table) {
            $table->decimal('production_residu_culture')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plantings_details', function (Blueprint $table) {
            $table->integer('quantite_semence')->change();
        });

        Schema::table('post_plantings_details', function (Blueprint $table) {
            $table->integer('superficie_sarclage')->change();
            $table->integer('superficie_desherbage')->change();
            $table->integer('quantite_npk')->change();
            $table->integer('quantite_uree')->change();
            $table->integer('superficie_butee')->change();
        });

        Schema::table('harvests_details', function (Blueprint $table) {
            $table->integer('production_residu_culture')->change();
        });
    }
};
