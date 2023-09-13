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
            $table->dropForeign(['planting_id']);
            $table->foreign('planting_id')->references('id')->on('plantings')->onDelete('cascade');
        });

        Schema::table('post_plantings_details', function (Blueprint $table) {
            $table->dropForeign(['post_planting_id']);
            $table->foreign('post_planting_id')->references('id')->on('post_plantings')->onDelete('cascade');
        });

        Schema::table('harvests_details', function (Blueprint $table) {
            $table->dropForeign(['harvest_id']);
            $table->foreign('harvest_id')->references('id')->on('harvests')->onDelete('cascade');
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
