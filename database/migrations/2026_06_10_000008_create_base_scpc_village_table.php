<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('base_scpc_village', function (Blueprint $table) {
            $table->foreignId('base_scpc_id')->constrained('base_scpcs')->cascadeOnDelete();
            $table->foreignId('village_id')->constrained('villages')->cascadeOnDelete();
            $table->primary(['base_scpc_id', 'village_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('base_scpc_village');
    }
};
