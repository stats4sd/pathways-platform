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
        $tables = [
            'animal_feeds',
            'farm_expenses',
            'human_cereal_needs',
            'organic_fertilisers',
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                if (Schema::hasColumn($table->getTable(), 'observation_text')) {
                    $table->renameColumn('observation_text', 'observation_texte');
                }
                if (Schema::hasColumn($table->getTable(), 'observation_video')) {
                    $table->renameColumn('observation_video', 'observation_videos');
                }
                if (Schema::hasColumn($table->getTable(), 'observation_vocal')) {
                    $table->renameColumn('observation_vocal', 'observation_audio');
                }
                if (Schema::hasColumn($table->getTable(), 'appreciation_observation')) {
                    $table->renameColumn('appreciation_observation', 'observation_appreciation');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
