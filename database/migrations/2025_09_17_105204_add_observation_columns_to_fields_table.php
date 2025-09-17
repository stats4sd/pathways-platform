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
        Schema::table('fields', function (Blueprint $table) {
            $table->text('observation_audio')->after('superficie_total')->nullable();
            $table->text('observation_videos')->after('observation_audio')->nullable();
            $table->text('observation_texte')->after('observation_videos')->nullable();
            $table->text('observation_image')->after('observation_texte')->nullable();
            $table->text('observation_appreciation')->after('observation_image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fields', function (Blueprint $table) {
            //
        });
    }
};
